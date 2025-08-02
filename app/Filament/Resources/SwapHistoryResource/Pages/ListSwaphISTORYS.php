<?php

namespace App\Filament\Resources\SwaphISTORYResource\Pages;

use App\Filament\Resources\SwaphISTORYResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSwaphISTORYS extends ListRecords
{
    protected static string $resource = SwaphISTORYResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
