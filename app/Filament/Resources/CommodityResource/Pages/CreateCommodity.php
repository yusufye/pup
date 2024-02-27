<?php

namespace App\Filament\Resources\CommodityResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use App\Filament\Resources\CommodityResource;

class CreateCommodity extends CreateRecord
{
    protected static string $resource = CommodityResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('Komoditas');
    }
}
