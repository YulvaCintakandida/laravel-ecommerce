<?php

namespace App\Filament\Resources\FlavourResource\Pages;

use App\Filament\Resources\FlavourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFlavours extends ListRecords
{
    protected static string $resource = FlavourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
