<?php

namespace App\Filament\Resources\CommodityPackageResource\Pages;

use App\Filament\Resources\CommodityPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCommodityPackage extends EditRecord
{
    protected static string $resource = CommodityPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
