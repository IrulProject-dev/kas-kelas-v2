<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeneralTransactionResource\Pages;
use App\Filament\Resources\GeneralTransactionResource\RelationManagers;
use App\Models\GeneralTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Section;

class GeneralTransactionResource extends Resource
{
    protected static ?string $model = GeneralTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Section::make('Detail Transaksi')
                ->schema([
                    TextInput::make('title')
                        ->label('Judul Transaksi')
                        ->placeholder('Contoh: Beli Alat Kebersihan')
                        ->required()
                        ->maxLength(255),

                    Select::make('type')
                        ->label('Jenis')
                        ->options([
                            'income' => 'Pemasukan Tambahan',
                            'expense' => 'Pengeluaran',
                        ])
                        ->required()
                        ->native(false),

                    TextInput::make('amount')
                        ->label('Nominal')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),

                    DatePicker::make('transaction_date')
                        ->label('Tanggal')
                        ->default(now())
                        ->required(),

                    Textarea::make('description')
                        ->label('Keterangan (Opsional)')
                        ->columnSpanFull(),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('transaction_date')
                ->label('Tanggal')
                ->date('d M Y')
                ->sortable(),

            TextColumn::make('title')
                ->label('Keterangan')
                ->searchable()
                ->description(fn ($record) => $record->description), // Deskripsi muncul kecil di bawah judul

            TextColumn::make('type')
                ->label('Jenis')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'income' => 'success', // Hijau
                    'expense' => 'danger', // Merah
                })
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'income' => 'Pemasukan',
                    'expense' => 'Pengeluaran',
                }),

            TextColumn::make('amount')
                ->label('Nominal')
                ->money('IDR')
                ->sortable()
                ->weight('bold')
                ->color(fn ($record) => $record->type === 'expense' ? 'danger' : 'success'), // Angka merah jika keluar
        ])
        ->defaultSort('transaction_date', 'desc')
        ->filters([
            // Filter biar admin bisa lihat Pemasukan saja atau Pengeluaran saja
            SelectFilter::make('type')
                ->label('Jenis Transaksi')
                ->options([
                    'income' => 'Pemasukan',
                    'expense' => 'Pengeluaran',
                ]),

            // Filter Rentang Tanggal (Optional, tapi sangat berguna)
            Filter::make('transaction_date')
                ->form([
                    DatePicker::make('from')->label('Dari Tanggal'),
                    DatePicker::make('until')->label('Sampai Tanggal'),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when($data['from'], fn ($query, $date) => $query->whereDate('transaction_date', '>=', $date))
                        ->when($data['until'], fn ($query, $date) => $query->whereDate('transaction_date', '<=', $date));
                })
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeneralTransactions::route('/'),
            'create' => Pages\CreateGeneralTransaction::route('/create'),
            'edit' => Pages\EditGeneralTransaction::route('/{record}/edit'),
        ];
    }
}
