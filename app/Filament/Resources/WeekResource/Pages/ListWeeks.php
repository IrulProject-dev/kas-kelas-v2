<?php

namespace App\Filament\Resources\WeekResource\Pages;

use App\Filament\Resources\WeekResource;
use App\Models\Member;
use App\Models\Week;
use App\Models\TransactionMember;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Filament\Forms\Components\TextInput;
use Carbon\Carbon;

class ListWeeks extends ListRecords
{
    protected static string $resource = WeekResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),

            // TOMBOL AUTO GENERATE
            Actions\Action::make('generate')
                ->label('Generate 1 Tahun')
                ->color('success')
                ->icon('heroicon-o-calendar-days')
                ->form([
                    TextInput::make('year')
                        ->label('Tahun')
                        ->numeric()
                        ->default(now()->year)
                        ->minValue(1970)
                        ->maxValue(now()->year + 5)
                        ->required()
                        ->helperText('Tahun yang valid antara 1970 hingga ' . (now()->year + 5)),
                    TextInput::make('nominal')
                        ->label('Default Nominal Tagihan')
                        ->numeric()
                        ->minValue(0)
                        ->default(5000) // Default 5000 sesuai request
                        ->required()
                        ->helperText('Nominal default untuk setiap minggu'),
                ])
                ->action(function (array $data) {
                    $year = (int) $data['year'];
                    $nominal = (int) $data['nominal'];

                    // Validasi tahun
                    if ($year < 1970 || $year > now()->year + 5) {
                        Notification::make()
                            ->title('Tahun tidak valid')
                            ->body('Tahun harus antara 1970 dan ' . (now()->year + 5))
                            ->danger()
                            ->send();
                        return;
                    }

                    // Tentukan jumlah minggu dalam tahun tersebut berdasarkan ISO 8601
                    // Dalam ISO 8601, tahun bisa memiliki 52 atau 53 minggu
                    // Tahun memiliki 53 minggu jika tahun sebelumnya dimulai dengan Kamis,
                    // atau jika tahun kabisat dimulai dengan Rabu
                    $jan1 = Carbon::create($year, 1, 1)->dayOfWeek;
                    $isLeapYear = Carbon::create($year, 1, 1)->isLeapYear();

                    // Dalam ISO 8601, tahun memiliki 53 minggu jika:
                    // - 1 Januari adalah Kamis (Thursday = 4), ATAU
                    // - 1 Januari adalah Rabu (Wednesday = 3) DAN tahun tersebut kabisat
                    $weeksInYear = ($jan1 == Carbon::THURSDAY || ($jan1 == Carbon::WEDNESDAY && $isLeapYear)) ? 53 : 52;

                    // Mulai dari minggu pertama tahun tersebut berdasarkan ISO 8601
                    // Minggu ISO pertama adalah minggu yang berisi tanggal 4 Januari
                    // atau minggu yang berisi Kamis pertama tahun itu
                    $startDate = Carbon::create($year, 1, 4)->startOfWeek(); // Mulai Senin minggu pertama ISO tahun itu

                    // Jika minggu pertama sebagian besar ada di tahun sebelumnya,
                    // maka minggu pertama tahun ini adalah minggu berikutnya
                    if ($startDate->isoWeekYear() != $year) {
                        $startDate->addWeek();
                    }

                    $createdCount = 0;
                    $updatedCount = 0;

                    // Loop sesuai jumlah minggu dalam tahun tersebut
                    for ($i = 1; $i <= $weeksInYear; $i++) {
                        // Buat tanggal mulai minggu ini
                        $weekStartDate = clone $startDate;

                        // Cek apakah minggu ini masih dalam tahun yang sama
                        // Jika minggu terakhir tahun ini melampaui tahun berikutnya, hentikan
                        if ($weekStartDate->year > $year) {
                            break;
                        }

                        // Buat minggu atau update jika sudah ada
                        $week = Week::firstOrCreate(
                            [
                                'name' => "M$i ($year)", // Contoh: M1 (2025)
                                'start_date' => $weekStartDate->format('Y-m-d'),
                            ],
                            [
                                'nominal' => $nominal
                            ]
                        );

                        if ($week->wasRecentlyCreated) {
                            $createdCount++;
                        } else {
                            $updatedCount++;
                        }

                        // Buat Slot Kosong untuk SEMUA Member (Agar muncul di Matrix)
                        $members = Member::all();
                        foreach ($members as $member) {
                            TransactionMember::firstOrCreate(
                                [
                                    'member_id' => $member->id,
                                    'week_id' => $week->id,
                                ],
                                ['amount' => 0] // Default belum bayar
                            );
                        }

                        $startDate->addWeek(); // Lanjut minggu depan
                    }

                    Notification::make()
                        ->title("Berhasil generate minggu untuk tahun $year")
                        ->body("Dibuat: $createdCount minggu, Diperbarui: $updatedCount minggu, Total: $weeksInYear minggu yang seharusnya")
                        ->success()
                        ->send();
                }),
        ];
    }
}
