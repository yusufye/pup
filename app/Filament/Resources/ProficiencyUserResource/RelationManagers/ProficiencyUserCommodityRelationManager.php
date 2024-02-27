<?php

namespace App\Filament\Resources\ProficiencyUserResource\RelationManagers;

use App\Models\Commodity;
use App\Models\CommodityPackage;
use App\Models\ProficiencyUser;
use App\Models\ProficiencyUserCommodity;
use App\Models\ProficiencyUserPackage;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Unique;

class ProficiencyUserCommodityRelationManager extends RelationManager
{
    protected static string $relationship = 'ProficiencyUserCommodity';

    public function form(Form $form): Form
    {
        $model = $form->model;

        $options = [];
        if($model instanceof \Illuminate\Database\Eloquent\Model){       
            $att = $model->getAttributes();
            if ($att && isset($att['commodity_id'])) {
                $options =  CommodityPackage::where('commodity_id', $att['commodity_id'])->pluck('name', 'id')->toArray();                                
            }
        }


        return $form
            ->schema([ 
                Section::make()
                        ->schema([                     
                        Select::make('commodity_id')    
                        ->options(Commodity::pluck('name', 'id')->toArray())
                        ->required()
                        ->label('Commodity')
                        ->live(onBlur:true)
                        ->afterStateUpdated(function(Get $get, Set $set){
                            $set('package_id', '');
                            $set('price',  '');                      
                            
                        })
                        ->visibleOn('create')
                        ->searchable(),
                        FileUpload::make('client_document')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'])
                        ->hiddenOn('create')
                        ->visible(auth()->user()->hasRole('client'))
                        ->label('Document')
                        ->directory('proficiency_user_commodity/client_document/')
                        ->label('Client Document')
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ]),
                        ]),
                        Hidden::make('commodity_id')->visibleOn('edit'),
                        Section::make()
                        ->hiddenOn('create')
                        ->schema([                            
                        Repeater::make('proficienty_items')                         
                            ->relationship('ProficiencyUserPackage')
                            ->schema([
                                Select::make('package_id')
                                ->options($options)                                
                                // ->disableOptionWhen(function($value) {
                                //     $existingPackageIds = ProficiencyUserPackage::where('proficiency_user_commodity_id', $this->ownerRecord->id)
                                //         ->pluck('package_id')
                                //         ->toArray();
                                //     return in_array($value, $existingPackageIds);
                                // })
                                
                                ->required()
                                ->live(onBlur:true)
                                ->afterStateUpdated(function(Get $get, Set $set,$record){ 
                                    $package =  CommodityPackage::where('id',$get('package_id'))->first();
                                    $package_price = number_format($package->price, 0, '.', '.');                        
                                    $set('package_price',  $package_price);
                                })
                                // ->unique(ProficiencyUserPackage::class, 'package_id', ignoreRecord: true, 
                                // modifyRuleUsing: function (Unique $rule, string $context, ?Model $record,Get $get) {
                                //     $array_id = [];
                                //     $array_id = array_merge(
                                //         ProficiencyUserPackage::where('proficiency_user_commodity_id', $record->proficiency_user_commodity_id)
                                //             ->pluck('package_id')->toArray(),
                                //         [$record->package_id]
                                //     );
                                       
                                //     if ($this->ownerRecord !== null) {
                                //         if (isset($record->package_id) && isset($record->proficiency_user_commodity_id)) {
                                //             return $rule
                                //                 ->where('package_id', $record->package_id)
                                //                 ->where('proficiency_user_commodity_id', $record->proficiency_user_commodity_id);
                                //         }
                                //     }
                                //     return $rule;
                                // })
                                
                                
                                // ->rules([
                                //     function () {
                                //     return function ($attribute, $value, Closure $fail) {
                                //         dd($value);

                                //         $existingPackageIds = ProficiencyUserPackage::where('proficiency_user_commodity_id', $this->ownerRecord->id)
                                //             ->pluck('package_id')
                                //             ->toArray();

                                //                 if (in_array($value, $existingPackageIds)) {
                                //                     $fail('Package ID harus unik.');
                                                

                                //             }
                                //     };
                                //     },
                                // ])
                                
                                
                                // ->unique(column: 'package_id',ignoreRecord: false)
                                // ->unique('package_id', ignoreRecord:true)
                                ->label('Package')
                                ->columnSpan([
                                    'sm' => 6,
                                    'xl' => 6,
                                ])
                                ->hiddenOn('create')
                                ->searchable(),
                                TextInput::make('package_price')
                                ->placeholder(function(Get $get, Set $set){ 
                                    if( $get('package_id')){
                                        $price = CommodityPackage::where('id', $get('package_id'))->first();  
                                        $package_price = number_format($price->price, 0, '.', '.');           
                                        $set('package_price',$package_price); 

                                    }
                                })
                                ->dehydrated(false)
                                ->label('Price')
                                ->columnSpan([
                                    'sm' => 6,
                                    'xl' => 6,
                                ]),
                                // TextInput::make('proficiency_user_id')
                                // ->default($this->ownerRecord->id)
                                // ->columnSpan([
                                //     'sm' => 6,
                                //     'xl' => 6,
                                // ]),
                            ])->columns(12)


                            
                        ]),
                        
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('proficiency_user_id')
            ->columns([
                TextColumn::make('Commodity.name'),
                ViewColumn::make('client_document')
                ->view('tables.columns.client-document')
                ->label('Document'),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
