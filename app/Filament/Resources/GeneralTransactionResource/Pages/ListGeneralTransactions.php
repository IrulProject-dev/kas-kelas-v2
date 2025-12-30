<?php

namespace App\Filament\Resources\GeneralTransactionResource\Pages;

use App\Filament\Resources\GeneralTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeneralTransactions extends ListRecords
{
    protected static string $resource = GeneralTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
