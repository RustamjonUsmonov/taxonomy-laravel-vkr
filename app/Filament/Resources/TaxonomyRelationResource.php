<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxonomyRelationResource\Pages;
use App\Filament\Resources\TaxonomyRelationResource\RelationManagers;
use App\Models\TaxonomyElement;
use App\Models\TaxonomyRelation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TaxonomyRelationResource extends Resource
{
    protected static ?string $model = TaxonomyRelation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('first.element')
                    ->sortable(),
                Tables\Columns\TextColumn::make('second.element')
                    ->sortable(),

                Tables\Columns\TextColumn::make('similarity')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('Search tags')
                    ->options(fn() => TaxonomyElement::all()->pluck('element', 'id'))
                    ->modifyQueryUsing(function (Builder $query, $state) {
                        if (!$state['value']) {
                            return $query;
                        }
                        $ids = TaxonomyElement::where('id', $state['value'])->pluck('id')->toArray();
                        $ids = array_unique($ids);
                        return $query->whereIn('word_1_id', $ids)->orWhereIn('word_2_id', $ids);
                    }),
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
            'index' => Pages\ListTaxonomyRelations::route('/'),
            'create' => Pages\CreateTaxonomyRelation::route('/create'),
            'edit' => Pages\EditTaxonomyRelation::route('/{record}/edit'),
        ];
    }
}
