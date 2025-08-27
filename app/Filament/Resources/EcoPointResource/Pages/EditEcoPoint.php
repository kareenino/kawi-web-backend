<?php

namespace App\Filament\Resources\EcoPointResource\Pages;

use App\Filament\Resources\EcoPointResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditEcoPoint extends EditRecord
{
    protected static string $resource = EcoPointResource::class;

    protected function getHeaderActions(): array
    {
        return [ Actions\DeleteAction::make() ];
    }
}