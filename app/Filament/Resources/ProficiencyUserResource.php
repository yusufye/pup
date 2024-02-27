<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProficiencyUserResource\Pages;
use App\Filament\Resources\ProficiencyUserResource\RelationManagers;
use App\Filament\Resources\ProficiencyUserResource\RelationManagers\ProficiencyUserCommodityRelationManager;
use App\Filament\Resources\ProficiencyUserResource\RelationManagers\ProficiencyUserQuestionnaireRelationManager;
use App\Models\Client;
use App\Models\Commodity;
use App\Models\CommodityPackage;
use App\Models\Proficiency;
use App\Models\ProficiencyQuestionnaire;
use App\Models\ProficiencyUser;
use App\Models\ProficiencyUserPackage;
use App\Models\User;
use Closure;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\SelectFilter;
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
                        ->label('Client'),
                        Select::make('status')
                        ->options([
                            "ACTIVE" => "ACTIVE",
                            "REJECT" => "REJECT"
                        ])
                        ->dehydrated()
                        ->visible(auth()->user()->hasRole('super_admin'))
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ])
                        ->label('Status'),
                        
                        FileUpload::make('client_report')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'])
                        ->hiddenOn('create')
                        ->visible(auth()->user()->hasRole('super_admin'))
                        ->label('Document')
                        ->directory('proficiency_user/client_report/')
                        ->label('Client Report')
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ]),
                        FileUpload::make('client_sertificate')
                        ->maxSize(2048)
                        ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/msword'])
                        ->hiddenOn('create')
                        ->visible(auth()->user()->hasRole('super_admin'))
                        ->directory('proficiency_user/client_sertificate/')
                        ->label('Client Certificate')
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ])
                        ]),
     
                    Section::make()
                        ->columns([
                            'sm' => 1,
                            'xl' => 1,
                        ])
                        
                    ->visibleOn('create')
                    ->schema([
                        Repeater::make('profiency_items')
                        ->relationship('ProficiencyUserCommodity')
                        ->schema([
                            Select::make('commodity_id')    
                            ->options(Commodity::pluck('name', 'id')->toArray())
                            ->required()
                            ->label('Commodity')
                            // ->live(onBlur:true)
                            // ->afterStateUpdated(function(Get $get, Set $set){
                            //     $set('package_id', '');
                            //     $set('package_price',  '');
                            // })
                            ->searchable(),
                            // Select::make('package_id')
                            // ->options(function(Get $get){
                            //    return CommodityPackage::where('commodity_id',$get('commodity_id'))->pluck('name', 'id')->toArray();                                
                            // })
                            
                            // ->required()
                            // ->live(onBlur:true)
                            // ->afterStateUpdated(function(Get $get, Set $set){                               
                            //     $package =  CommodityPackage::where('id',$get('package_id'))->first();  
                            //     $package_price = number_format($package->price, 0, '.', '.');                        
                            //     $set('package_price',  $package_price);
                            // })
                            // ->label('Package')
                            // ->searchable(),
                            // TextInput::make('package_price')
                            // ->readOnly()
                            // ->label('Package Price'),        
                            ])
                            
                        ->columns(1),
                            ]),
               
                    Section::make()
                        ->columns([
                            'sm' => 1,
                            'xl' => 1,
                        ])
                        
                    ->visibleOn('edit')
                    ->schema([
                        
                        Toggle::make('is_kuisoner')
                        ->live(onBlur:true)
                        ->afterStateUpdated(function (Get $get, Set $set) {
                            self::getItems($get,$set);
                          }),
                        Repeater::make('kuisoner_items')
                        ->visible(fn ($get): bool => $get('is_kuisoner'))
                        ->relationship('ProficiencyUserQuestionnaire')      
                        ->schema([
                            Hidden::make('proficiency_questionnaire_id'),
                            TextInput::make('proficiency_questionnaire_id_items')
                            ->readOnly()
                            ->label('Items'),

                            // Select::make('proficiency_questionnaire_id')    
                            // ->options(ProficiencyQuestionnaire::pluck('item', 'id')->toArray())
                            // ->options(function() {
                            //     $options = [];
                            //     $proficiencyQuestionnaires = ProficiencyQuestionnaire::pluck('item', 'id')->toArray();
                        
                            //     foreach ($proficiencyQuestionnaires as $id => $item) {
                            //         $options[$id] = $item;
                            //     }
                        

                            //     dd($options);
                            //     return $options; 
                            // })
                            // ->required()
                            // ->label('Questionnaire')
                            // ->searchable(),     
                            Select::make('value')    
                            ->options([
                                1 => 1,
                                2 => 2,
                                3 => 3,
                                4 => 4,
                            ])
                            ->label('Value')
                            ->searchable(),     
                            ])
                            ->live()
                            ->addable(false)
                            ->deletable(false)     
                            ->defaultItems(0)
                        ->columns(2),
                        ]),

                    ]);


          

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               TextColumn::make('Proficiency.years')
               ->label('Tahun')
               ->searchable(),
               TextColumn::make('Clients.name')
               ->label('Client')
               ->searchable(),
               ViewColumn::make('client_report')
               ->label('Client Report')
               ->view('tables.columns.client_report'),
               ViewColumn::make('client_sertificate')
               ->label('Client Certificate')
               ->view('tables.columns.client_sertificate'),
            ])
            ->filters([
                SelectFilter::make('proficiencies')->relationship('proficiency', 'years'),
                SelectFilter::make('client')->relationship('clients', 'name')
                ->visible(auth()->user()->hasRole('super_admin'))
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
                Tables\Actions\ViewAction::make(),
                
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
            ProficiencyUserQuestionnaireRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProficiencyUsers::route('/'),
            'create' => Pages\CreateProficiencyUser::route('/create'),
            'edit' => Pages\EditProficiencyUser::route('/{record}/edit'),
            'view' => Pages\ViewProficiencyUser::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $hasSuperAdminRole = auth()->user()->hasRole('super_admin');
        $hasClientRole = auth()->user()->hasRole('client');
        
        if ($hasSuperAdminRole) {
            return parent::getEloquentQuery();
        } else {
            $userId = Auth::id();
            $brandIds = parent::getEloquentQuery()->pluck('user_id')->toArray();
            return parent::getEloquentQuery()->where('user_id', $userId);

        }
    }

   public static function getItems(Get $get, Set $set): void
    {
        $kuisoner_items = $get('kuisoner_items');
        
        $proficiencyQuestionnaires = ProficiencyQuestionnaire::get();
        
        $reccuring_tools = [];
        
        foreach ($proficiencyQuestionnaires as $questionnaire) {
            $reccuring_tools[] = [
                'proficiency_questionnaire_id' => $questionnaire->id,
                'proficiency_questionnaire_id_items' => $questionnaire->item,
                'value' => []
            ];
        }
        
        $set('kuisoner_items', $reccuring_tools);
    }
}
