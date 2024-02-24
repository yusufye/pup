<?php

namespace App\Filament\Resources\CommodityPackageResource\Pages;

use App\Filament\Resources\CommodityPackageResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCommodityPackages extends ListRecords
{
    protected static string $resource = CommodityPackageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
