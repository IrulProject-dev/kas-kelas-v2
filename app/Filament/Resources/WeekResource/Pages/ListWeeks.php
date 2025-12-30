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
                        ->required(),
                    TextInput::make('nominal')
                        ->label('Default Nominal Tagihan')
                        ->numeric()
                        ->default(5000) // Default 5000 sesuai request
                        ->required(),
                ])
                ->action(function (array $data) {
                    $year = $data['year'];
                    $nominal = $data['nominal'];
                    $startDate = Carbon::create($year, 1, 1)->startOfWeek(); // Mulai Senin pertama tahun itu

                    // Loop 52 Minggu
                    for ($i = 1; $i <= 52; $i++) {
                        // 1. Buat Minggu
                        $week = Week::firstOrCreate(
                            [
                                'name' => "M$i ($year)", // Contoh: M1 (2025)
                                'start_date' => $startDate->format('Y-m-d'),
                            ],
                            ['nominal' => $nominal]
                        );

                        // 2. Buat Slot Kosong untuk SEMUA Member (Agar muncul di Matrix)
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

                    Notification::make()->title("Berhasil generate 52 minggu untuk tahun $year")->success()->send();
                }),
        ];
    }
}
