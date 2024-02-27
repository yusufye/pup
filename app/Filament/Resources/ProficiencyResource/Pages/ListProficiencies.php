<?php

namespace App\Filament\Resources\ProficiencyResource\Pages;

use Filament\Actions;
use App\Models\Proficiency;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\ProficiencyResource;

class ListProficiencies extends ListRecords
{
    protected static string $resource = ProficiencyResource::class;

    protected function getHeaderActions(): array
    {
        $check_tahun=Proficiency::where('years',date('Y'))->get();

        return [
            // ($check_tahun->isEmpty())?Actions\CreateAction::make()->label('Tambah Tahun'):'',
            Actions\CreateAction::make()->label('Tambah')->visible($check_tahun->isEmpty()),
        
        ];
    }
}
