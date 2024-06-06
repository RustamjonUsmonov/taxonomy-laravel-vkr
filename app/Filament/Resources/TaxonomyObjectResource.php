<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxonomyObjectResource\Pages;
use App\Filament\Resources\TaxonomyObjectResource\RelationManagers;
use App\Models\TaxonomyObject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxonomyObjectResource extends Resource
{
    protected static ?string $model = TaxonomyObject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('name')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('elements_count')
                    ->counts('elements')
                    ->sortable()
                    ->badge(),
                Tables\Columns\TextColumn::make('elements.element')
                    ->sortable()
                    ->searchable()
                    ->toggleable()
                    ->badge(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxonomyObjects::route('/'),
            'create' => Pages\CreateTaxonomyObject::route('/create'),
            'view' => Pages\ViewTaxonomyObject::route('/{record}'),
            'edit' => Pages\EditTaxonomyObject::route('/{record}/edit'),
        ];
    }
}
