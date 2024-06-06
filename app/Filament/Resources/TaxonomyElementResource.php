<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxonomyElementResource\Pages;
use App\Filament\Resources\TaxonomyElementResource\RelationManagers;
use App\Models\TaxonomyElement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Grouping\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxonomyElementResource extends Resource
{
    protected static ?string $model = TaxonomyElement::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('element')
                    ->columnSpanFull(),
                Forms\Components\Select::make('object')
                    ->relationship('object', 'name')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->groups([
                Group::make('object.name')
                    ->collapsible(),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('object.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('element')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxonomyElements::route('/'),
            'create' => Pages\CreateTaxonomyElement::route('/create'),
            'edit' => Pages\EditTaxonomyElement::route('/{record}/edit'),
        ];
    }
}
