<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProficiencyUserResource\Pages;
use App\Filament\Resources\ProficiencyUserResource\RelationManagers;
use App\Filament\Resources\ProficiencyUserResource\RelationManagers\ProficiencyUserCommodityRelationManager;
use App\Models\Client;
use App\Models\Commodity;
use App\Models\CommodityPackage;
use App\Models\Proficiency;
use App\Models\ProficiencyUser;
use App\Models\ProficiencyUserPackage;
use App\Models\User;
use Closure;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class ProficiencyUserResource extends Resource
{
    protected static ?string $model = ProficiencyUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                        ->columns([
                            'sm' => 1,
                            'xl' => 3,
                        ])
                    ->schema([
                        Select::make('proficiency_id')
                        ->options(Proficiency::pluck('years', 'id')->toArray())
                        ->default(function() {
                            $proficiencies = Proficiency::all();
                            foreach ($proficiencies as $proficiency) {
                                if ($proficiency['years'] == date('Y')) {
                                    return $proficiency['id'];
                                }
                            }
                            return '';
                        })
                        ->disabled()
                        ->dehydrated()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ])
                        ->label('Proficiencies'),
                        Select::make('user_id')
                        ->options(User::pluck('name', 'id')->toArray())
                        ->default(function() {
                            if (!auth()->user()->hasRole('super_admin')) {
                                return Auth::id();
                            }
                            
                        })
                        ->disabled(function() {
                            if (!auth()->user()->hasRole('super_admin')) {
                                return true;
                                }else{
                                    return false;
                                }
                            })
                        ->dehydrated()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ])
                        ->label('User'),
                        Select::make('client_id')
                        ->options(Client::pluck('name', 'id')->toArray())
                        ->default(function(Get $get) {
                            if (!auth()->user()->hasRole('super_admin')) {
                                $client = Client::where('user_id',$get('user_id'))->pluck('id')->first();
                                return $client;
                            }
                        })
                        ->disabled(function() {
                            if (!auth()->user()->hasRole('super_admin')) {
                                return true;
                                }else{
                                    return false;
                                }
                            })
                        ->dehydrated()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ])
                        ->label('Client') 
                        ]),
                    Section::make()
                        ->columns([
                            'sm' => 1,
                            'xl' => 1,
                        ])
                        
                    ->visibleOn('create')
                    ->schema([
                        Repeater::make('profiency_items')
                        ->schema([
                            Select::make('commodity_id')    
                            ->options(Commodity::pluck('name', 'id')->toArray())
                            ->required()
                            ->label('Commodity')
                            ->live(onBlur:true)
                            ->afterStateUpdated(function(Get $get, Set $set){
                                $set('package_id', '');
                                $set('package_price',  '');
                            })
                            ->searchable(),
                            Select::make('package_id')
                            ->options(function(Get $get){
                               return CommodityPackage::where('commodity_id',$get('commodity_id'))->pluck('name', 'id')->toArray();                                
                            })
                            
                            ->required()
                            // ->rules([
                            //     function () {
                            //         return function (string $attribute, $value, Closure $fail) {
                            //             if (in_array($value,$value)) {
                            //                 $fail("The value must not be negative");
                            //             }
                            //             dd($value[]);
                            //         };
                            //     },
                            // ])
                            ->live(onBlur:true)
                            ->afterStateUpdated(function(Get $get, Set $set){                               
                                $package =  CommodityPackage::where('id',$get('package_id'))->first();  
                                $package_price = number_format($package->price, 0, '.', '.');                        
                                $set('package_price',  $package_price);
                            })
                            ->label('Package')
                            ->searchable(),
                            TextInput::make('package_price')
                            ->readOnly()
                            ->label('Package Price'),        
                            ])
                            
                        ->columns(3),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('Proficiency.years'),
               ViewColumn::make('client_report')
               ->label('Client Report')
               ->view('tables.columns.client_report'),
               ViewColumn::make('client_sertificate')
               ->label('Client Certificate')
               ->view('tables.columns.client_sertificate'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->visible(function ($record) {
                    if (!auth()->user()->hasRole('super_admin')) {
                        $proficiency_id = $record->proficiency_id;
                        $proficiency = Proficiency::find($proficiency_id);
                        if ($proficiency && $proficiency['years'] == date('Y')) {
                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return true;
                    }
                }),
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at','desc');
    }

    public static function getRelations(): array
    {
        return [
            ProficiencyUserCommodityRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProficiencyUsers::route('/'),
            'create' => Pages\CreateProficiencyUser::route('/create'),
            'edit' => Pages\EditProficiencyUser::route('/{record}/edit'),
        ];
    }

    public static function getRecurring(Get $get, Set $set): void
    {
        if($get('profiency_items_tools') == 1){
            dd('oke');
        }
    }
}
