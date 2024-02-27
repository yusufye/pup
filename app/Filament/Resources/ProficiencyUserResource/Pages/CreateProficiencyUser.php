<?php

namespace App\Filament\Resources\ProficiencyUserResource\Pages;

use App\Filament\Resources\ProficiencyUserResource;
use App\Models\ProficiencyUserCommodity;
use App\Models\ProficiencyUserPackage;
use Filament\Actions;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class CreateProficiencyUser extends CreateRecord
{
    protected static string $resource = ProficiencyUserResource::class;

//     protected function handleRecordCreation(array $data): Model
// {
//     $fillableAttributes = [
//         'proficiency_id',
//         'client_id',
//         'user_id',
//     ];

//     $filteredData = Arr::only($data, $fillableAttributes);

//     $record = static::getModel()::create($filteredData);

//     $profiency_items = $data['profiency_items'];

//     if ($profiency_items) {
//         $existingRecords = []; 

//         foreach ($profiency_items as $pi) {
//             $key = $pi['commodity_id'] . '-' . $pi['package_id'];

//             if (isset($existingRecords[$key])) {
//                 // Notification::make()
//                 //     ->title('Data with the same proficiency and package already exists')
//                 //     ->send();
//             } else {
//                 $existingRecords[$key] = true;
                
//                 $ProficiencyUserCommodity = ProficiencyUserCommodity::create([
//                     'proficiency_user_id' => $record->id,
//                     'commodity_id' => $pi['commodity_id']
//                 ]);
//                 $ProficiencyUserPackage = ProficiencyUserPackage::create([
//                     'proficiency_user_commodity_id' => $ProficiencyUserCommodity->id,
//                     'package_id' => $pi['package_id']
//                 ]);
//             }
//         }
//     }

//     return $record;
// }

    
}
