<?php

namespace App\Filament\Resources\ProficiencyUserResource\RelationManagers;

use App\Models\ProficiencyQuestionnaire;
use App\Models\ProficiencyUserQuestionnaire;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProficiencyUserQuestionnaireRelationManager extends RelationManager
{
    protected static string $relationship = 'ProficiencyUserQuestionnaire';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                ->hiddenOn('create')
                        ->columns([
                            'sm' => 1,
                            'xl' => 1,
                        ])
                    ->schema([
                        Select::make('value')
                        ->options([
                            1 => 1,
                            2 => 2,
                            3 => 3,
                            4 => 4,
                        ])
                        ->label('Value')
                        ->searchable()
                        ->columnSpan([
                            'sm' => 2,
                            'xl' => 1,
                        ])
                      
            ]),

            // repeater

            // Section::make()
            // ->columns([
            //     'sm' => 1,
            //     'xl' => 1,
            // ])
            
            //     ->visibleOn('create')
            //     ->schema([
            //         Repeater::make('kuisoner_items')
            //         // ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array  {
            //         //     return $data;
            //         // })
            //          ->schema(
            //             self::getItems()
            //              )
            //         ->columns(2),
            //         ]
            //         ),

                ]);
            }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ProficiencyQuestionnaires.item')
                ->label('Item'),
                TextColumn::make('value')
                ->label('Item'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
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

    public static function getItems(){
        $proficiencyQuestionnaires = ProficiencyQuestionnaire::get();
                
        $components = [];

        foreach ($proficiencyQuestionnaires as $questionnaire) {
            $components[] = TextInput::make('proficiency_questionnaire_id_' . $questionnaire->id)
                ->default($questionnaire->id);
        }

        return $components;
    }
}
