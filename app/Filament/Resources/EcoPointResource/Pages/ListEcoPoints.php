<?php

namespace App\Filament\Resources\EcoPointResource\Pages;

use App\Filament\Resources\EcoPointResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListEcoPoints extends ListRecords
{
    protected static string $resource = EcoPointResource::class;

    protected function getHeaderActions(): array
    {
        return [ Actions\CreateAction::make() ];
    }
}