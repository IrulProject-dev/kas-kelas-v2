<?php

namespace App\Filament\Pages;

use App\Models\Member;
use App\Models\Week;
use App\Models\TransactionMember;
use Filament\Pages\Page;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Carbon\Carbon;

class KasRekap extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-table-cells';
    protected static ?string $navigationLabel = 'Input Kas (Excel)';
    protected static ?string $title = 'Rekap Kas Mingguan';
    protected static string $view = 'filament.pages.kas-rekap';

    // Variabel Data View
    public $weeks;
    public $members;
    public $groupedWeeks = [];

    // Variabel Penyimpanan Sementara (STATE)
    // Ini solusi agar ID tidak NULL saat disimpan
    public $selectedMemberId;
    public $selectedWeekId;

    public function mount()
    {
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->members = Member::with('transaction_members')->orderBy('nim')->get();
        $this->weeks = Week::orderBy('start_date')->get();

        $this->groupedWeeks = [];
        foreach ($this->weeks as $week) {
            $month = Carbon::parse($week->start_date)->translatedFormat('F Y');
            $this->groupedWeeks[$month][] = $week;
        }
    }

    // Fungsi Popup Input Bayar
    public function openInput($memberId, $weekId, $currentAmount, $weekNominal)
    {
        // 1. Simpan ID ke variabel public dulu (agar aman)
        $this->selectedMemberId = $memberId;
        $this->selectedWeekId = $weekId;

        // 2. Buka Modal & Isi Form Nominal
        $this->mountAction('inputBayar', [
            'amount' => $currentAmount == 0 ? $weekNominal : $currentAmount,
        ]);
    }

    protected function getActions(): array
    {
        return [
            Action::make('inputBayar')
                ->label('Input Pembayaran')
                ->modalWidth('sm')
                ->form([
                    // HAPUS Hidden field member_id & week_id dari sini
                    // Kita pakai variabel public saja biar tidak error

                    TextInput::make('amount')
                        ->label('Nominal (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->autofocus(),
                ])
                ->action(function (array $data) {
                    // Gunakan variabel public ($this->selectedMemberId)
                    TransactionMember::updateOrCreate(
                        [
                            'member_id' => $this->selectedMemberId,
                            'week_id' => $this->selectedWeekId,
                        ],
                        ['amount' => $data['amount']]
                    );

                    Notification::make()->title('Data Disimpan')->success()->send();

                    // Reset variabel biar bersih
                    $this->selectedMemberId = null;
                    $this->selectedWeekId = null;

                    $this->refreshData();
                }),
        ];
    }
}
