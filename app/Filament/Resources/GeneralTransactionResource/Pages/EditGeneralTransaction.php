<?php

namespace App\Filament\Resources\GeneralTransactionResource\Pages;

use App\Filament\Resources\GeneralTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeneralTransaction extends EditRecord
{
    protected static string $resource = GeneralTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
