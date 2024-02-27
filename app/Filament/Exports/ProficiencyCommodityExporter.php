<?php

namespace App\Filament\Exports;

use App\Models\ProficiencyCommodity;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ProficiencyCommodityExporter extends Exporter
{
    protected static ?string $model = ProficiencyCommodity::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')->label('Nama'),
            ExportColumn::make('description')->label('Catatan'), 
            ExportColumn::make('proficiencies.years')->label('Tahun')
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your proficiency commodity export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
