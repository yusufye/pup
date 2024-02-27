<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Commodity;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CommodityResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Exports\ProficiencyCommodityExporter;
use App\Filament\Resources\CommodityResource\RelationManagers;

class CommodityResource extends Resource
{
    protected static ?string $model = Commodity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Master Profisiensi';
    protected static ?string $pluralModelLabel = 'Komoditas';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('proficiency_id')->relationship(
                    name:'proficiency',
                    titleAttribute:'years',
                    modifyQueryUsing: fn (Builder $query) => $query->where('years',date('Y'))
                )->selectablePlaceholder(false)->required()->label('Tahun'),
                TextInput::make('name') ->maxLength(100) ->label('Nama'),
                Textarea::make('description')->label('Catatan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name') ->searchable() ->label('Nama'),
                TextColumn::make('description') ->searchable() ->label('Catatan'),
            ])
            ->filters([
                SelectFilter::make('proficiencies')->relationship('proficiency', 'years')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(ProficiencyCommodityExporter::class)
            ]);;
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\PackageRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCommodities::route('/'),
            'create' => Pages\CreateCommodity::route('/create'),
            'edit' => Pages\EditCommodity::route('/{record}/edit'),
        ];
    }
}
