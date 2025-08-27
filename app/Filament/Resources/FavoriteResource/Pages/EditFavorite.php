<?php

namespace App\Filament\Resources\FavoriteResource\Pages;

use App\Filament\Resources\FavoriteResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditFavorite extends EditRecord
{
    protected static string $resource = FavoriteResource::class;

    protected function getHeaderActions(): array
    {
        return [ Actions\DeleteAction::make() ];
    }
}