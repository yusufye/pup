<?php

namespace App\Filament\Resources\ProficiencyResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class CommodityRelationManager extends RelationManager
{
    protected static string $relationship = 'Commodity';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('proficiency_id')->options(function ($record) {
                    if (empty($record)) {
                        return DB::table('proficiencies')
                        ->where('years',date('Y'))
                        ->pluck('years','id');                       
                    }
                    $recordCommodity = $record->getAttributes();
                    $proficiency = $recordCommodity['proficiency_id'];
                    return DB::table('proficiencies')
                        ->where('id',$proficiency)
                        ->pluck('years','id');
                })->selectablePlaceholder(false)->required(),
                TextInput::make('name') ->maxLength(100) ->label('Name'),
                Textarea::make('description')->label('Description'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('description'),
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
