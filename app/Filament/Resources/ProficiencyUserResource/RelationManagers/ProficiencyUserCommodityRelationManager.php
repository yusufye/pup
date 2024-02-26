<?php

namespace App\Filament\Resources\ProficiencyUserResource\RelationManagers;

use App\Models\Commodity;
use App\Models\CommodityPackage;
use App\Models\ProficiencyUserCommodity;
use App\Models\ProficiencyUserPackage;
use Filament\Forms;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                        ->searchable(),
                        ])->visibleOn('create'),
                        Section::make()
                        ->visibleOn('edit')
                        ->schema([                            
                        Repeater::make('proficienty_items')                         
                            ->relationship('ProficiencyUserPackage')
                            ->schema([
                                Select::make('package_id')
                                ->options($options)
                                ->required()
                                ->live(onBlur:true)
                                ->afterStateUpdated(function(Get $get, Set $set){                 
                                    $package =  CommodityPackage::where('id',$get('package_id'))->first();
                                    $package_price = number_format($package->price, 0, '.', '.');                        
                                    $set('package_price',  $package_price);
                                })
                                ->unique(column: 'package_id',ignoreRecord: true)
                                ->label('Package')
                                ->columnSpan([
                                    'sm' => 6,
                                    'xl' => 6,
                                ])
                                ->visibleOn('edit')
                                ->searchable(),
                                Select::make('package_id')
                                    ->options(function(Get $get,Set $set, $record) {   
                                        dd($get('commodity_id'));
                                        if(!$record){

                                           return CommodityPackage::pluck('name', 'id')->toArray();        
                                        }else{
                                            $paket = ProficiencyUserPackage::where('proficiency_user_packages.id', $record->id)
                                            ->join('proficiency_user_commodities', 'proficiency_user_packages.proficiency_user_commodity_id', 'proficiency_user_commodities.id')
                                            ->get();       
                                              $commodityIds = $paket->pluck('commodity_id')->toArray(); 

                                         return CommodityPackage::whereIn('commodity_id', $commodityIds)->pluck('name', 'id')->toArray();                                
                                            
                                        }
                                    
                                    
                                    })
                                ->required()
                                ->unique(column: 'package_id',ignoreRecord: true)
                                ->live(onBlur:true)
                                ->afterStateUpdated(function(Get $get, Set $set){                 
                                    $package =  CommodityPackage::where('id',$get('package_id'))->first();  
                                    $package_price = number_format($package->price, 0, '.', '.');                        
                                    $set('package_price',  $package_price);
                                })
                                ->label('Package')
                                ->columnSpan([
                                    'sm' => 6,
                                    'xl' => 6,
                                ])
                                ->visibleOn('create')
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
