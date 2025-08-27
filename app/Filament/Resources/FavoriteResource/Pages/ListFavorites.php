<?php

namespace App\Filament\Resources\FavoriteResource\Pages;

use App\Filament\Resources\FavoriteResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;

class ListFavorites extends ListRecords
{
    protected static string $resource = FavoriteResource::class;

    protected function getHeaderActions(): array
    {
        return [ Actions\CreateAction::make() ];
    }
}