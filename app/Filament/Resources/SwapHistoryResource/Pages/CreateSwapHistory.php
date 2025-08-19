<?php

namespace App\Filament\Resources\SwapHistoryResource\Pages;

use App\Filament\Resources\SwapHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSwapHistory extends CreateRecord
{
    protected static string $resource = SwapHistoryResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
