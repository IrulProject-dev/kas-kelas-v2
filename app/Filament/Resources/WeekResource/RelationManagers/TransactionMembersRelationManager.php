<?php

namespace App\Filament\Resources\WeekResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'transaction_members';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
{
    return $table
        ->recordTitleAttribute('id')
        ->columns([
            // Nama Member
            Tables\Columns\TextColumn::make('member.name')
                ->label('Mahasiswa')
                ->searchable()
                ->sortable(),

            // Status (Warna Warni)
            Tables\Columns\TextColumn::make('amount')
                ->label('Status Bayar')
                ->badge()
                ->formatStateUsing(function ($state, $record) {
                    // Ambil nominal target dari Week induknya
                    $target = $this->getOwnerRecord()->nominal;

                    if ($state >= $target) return 'LUNAS';
                    if ($state > 0) return 'NYICIL';
                    return 'BELUM BAYAR';
                })
                ->color(fn (string $state): string => match ($state) {
                    'LUNAS' => 'success', // Hijau
                    'NYICIL' => 'warning', // Kuning
                    'BELUM BAYAR' => 'danger', // Merah
                }),

            // Nominal Angka
            Tables\Columns\TextColumn::make('amount')
                ->label('Jumlah Masuk')
                ->money('IDR'),
        ])
        ->filters([
            // Filter biar admin gampang cari yg nunggak
            Tables\Filters\SelectFilter::make('status')
                ->options([
                    'lunas' => 'Lunas',
                    'belum' => 'Belum Lunas',
                ])
                ->query(function ($query, array $data) {
                    if ($data['value'] === 'lunas') {
                        $query->where('amount', '>=', 5000); // Logic sederhana (bisa diperbaiki ambil nominal dinamis)
                    } elseif ($data['value'] === 'belum') {
                        $query->where('amount', '<', 5000);
                    }
                }),
        ]);
}}
