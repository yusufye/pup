<?php

namespace App\Filament\Resources\ProficiencyUserResource\Pages;

use App\Filament\Resources\ProficiencyUserResource;
use App\Models\ProficiencyUserCommodity;
use App\Models\ProficiencyUserPackage;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class EditProficiencyUser extends EditRecord
{
    protected static string $resource = ProficiencyUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // protected function mutateFormDataBeforeFill(array $data): array
    // {

  
        
    //     $profiency_items = ProficiencyUserCommodity::where('proficiency_user_id',$data['id'])->get()->toArray();
    
    //     foreach ($profiency_items as $item) {
    //     }
    //     $data['profiency_items'] = $profiency_items;
    
    //     return $data;
    // }

//     protected function handleRecordUpdate(Model $record, array $data): Model
// {
//     $fillableAttributes = [
//         'proficiency_id',
//         'client_id',
//         'user_id',
//     ];

//     $filteredData = Arr::only($data, $fillableAttributes);
//     $record->update($filteredData);
//     $ProficiencyUserCommodity = ProficiencyUserCommodity::where('proficiency_user_id', $record->id)->get();

//     $profiency_items = $data['profiency_items'] ?? [];

//     foreach ($profiency_items as $pi) {
//         $item = $ProficiencyUserCommodity->where('commodity_id', $pi['commodity_id'])->first();

//         if ($item) {
//             $item->update([
//                 'proficiency_user_id' => $record->id,
//                 'commodity_id' => $pi['commodity_id']
//             ]);
//         } else {
//             ProficiencyUserCommodity::create([
//                 'proficiency_user_id' => $record->id,
//                 'commodity_id' => $pi['commodity_id']
//             ]);
//         }
//     }

//     return $record;
// }


}
