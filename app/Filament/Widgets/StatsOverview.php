<?php

namespace App\Filament\Widgets;

use App\Models\GeneralTransaction; // Model transaksi umum
use App\Models\TransactionMember;  // Model uang kas mingguan
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        $now = Carbon::now();

        // --- 1. HITUNG TOTAL PEMASUKAN (INCOME) ---
        // Sumber A: Dari Pembayaran Mingguan Member
        $incomeMembers = TransactionMember::sum('amount');
        // Sumber B: Dari Pemasukan Umum (jika ada)
        $incomeGeneral = GeneralTransaction::where('type', 'income')->sum('amount');

        $totalPemasukan = $incomeMembers + $incomeGeneral;

        // Pemasukan Bulan Ini (Member + General)
        $incomeMembersMonth = TransactionMember::whereMonth('created_at', $now->month)->sum('amount');
        $incomeGeneralMonth = GeneralTransaction::where('type', 'income')
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');
        $pemasukanBulanIni = $incomeMembersMonth + $incomeGeneralMonth;


        // --- 2. HITUNG TOTAL PENGELUARAN (EXPENSE) ---
        // Diambil dari general_transactions yang type-nya 'expense'
        $totalPengeluaran = GeneralTransaction::where('type', 'expense')->sum('amount');

        $pengeluaranBulanIni = GeneralTransaction::where('type', 'expense')
            ->whereMonth('transaction_date', $now->month)
            ->sum('amount');


        // --- 3. SALDO BERSIH ---
        $saldo = $totalPemasukan - $totalPengeluaran;


        // --- 4. DATA GRAFIK (7 Hari Terakhir) ---
        // Grafik Pemasukan (Kita ambil trend dari pembayaran member saja agar grafik lebih aktif)
        $chartIncome = $this->getChartData(TransactionMember::class, 'created_at');

        // Grafik Pengeluaran (Dari general_transactions type expense)
        $chartExpense = $this->getChartData(GeneralTransaction::class, 'transaction_date', 'expense');

        return [
            // KARTU 1: SALDO KAS
            Stat::make('Sisa Saldo Kas', 'Rp ' . number_format($saldo, 0, ',', '.'))
                ->description('Total Uang Saat Ini')
                ->descriptionIcon('heroicon-m-wallet')
                ->chart($chartIncome)
                ->color('primary'), // Biru

            // KARTU 2: PEMASUKAN BULAN INI
            Stat::make('Pemasukan Bulan Ini', 'Rp ' . number_format($pemasukanBulanIni, 0, ',', '.'))
                ->description('Dari Member & Lainnya')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart($chartIncome)
                ->color('success'), // Hijau

            // KARTU 3: PENGELUARAN BULAN INI
            Stat::make('Pengeluaran Bulan Ini', 'Rp ' . number_format($pengeluaranBulanIni, 0, ',', '.'))
                ->description('Total Keluar ' . $now->format('F'))
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart($chartExpense)
                ->color('danger'), // Merah
        ];
    }

    /**
     * Helper function untuk bikin grafik
     */
    protected function getChartData(string $model, string $dateCol, ?string $type = null): array
    {
        $data = [];
        $now = Carbon::now();

        for ($i = 6; $i >= 0; $i--) {
            $date = $now->copy()->subDays($i);

            $query = $model::whereDate($dateCol, $date);

            // Jika modelnya GeneralTransaction, kita filter type-nya
            if ($type && $model === GeneralTransaction::class) {
                $query->where('type', $type);
            }

            $data[] = $query->sum('amount');
        }

        return $data;
    }
}
