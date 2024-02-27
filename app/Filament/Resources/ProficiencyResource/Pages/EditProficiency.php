<?php

namespace App\Filament\Resources\ProficiencyResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\ProficiencyResource;

class EditProficiency extends EditRecord
{
    protected static string $resource = ProficiencyResource::class;
    
    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    public function getTitle(): string | Htmlable
    {
        return __('Tahun');
    }
}
