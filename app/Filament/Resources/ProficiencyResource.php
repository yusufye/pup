<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Proficiency;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProficiencyResource\Pages;
use App\Filament\Resources\ProficiencyResource\RelationManagers;

class ProficiencyResource extends Resource
{
    protected static ?string $model = Proficiency::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('years')->default(date('Y'))->label('Year')->readonly(),
                DatePicker::make('show_report') ->format('d-m-Y')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('years')->label('Year'),
                TextColumn::make('show_report')->label('Show Report'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CommodityRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProficiencies::route('/'),
            'create' => Pages\CreateProficiency::route('/create'),
            'edit' => Pages\EditProficiency::route('/{record}/edit'),
        ];
    }
}
