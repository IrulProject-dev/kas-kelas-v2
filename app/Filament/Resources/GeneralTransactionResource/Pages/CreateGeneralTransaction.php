<?php

namespace App\Filament\Resources\GeneralTransactionResource\Pages;

use App\Filament\Resources\GeneralTransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateGeneralTransaction extends CreateRecord
{
    protected static string $resource = GeneralTransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
