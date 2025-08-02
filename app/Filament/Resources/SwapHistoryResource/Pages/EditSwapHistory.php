<?php

namespace App\Filament\Resources\SwapHistoryResource\Pages;

use App\Filament\Resources\SwapHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSwapHistory extends EditRecord
{
    protected static string $resource = SwapHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
