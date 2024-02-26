<?php

namespace App\Filament\Resources\ProficiencyUserResource\Pages;

use App\Filament\Resources\ProficiencyUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProficiencyUsers extends ListRecords
{
    protected static string $resource = ProficiencyUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
