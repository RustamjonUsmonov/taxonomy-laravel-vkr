<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxonomyResource\Pages;
use App\Filament\Resources\TaxonomyResource\RelationManagers;
use App\Models\Taxonomy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class TaxonomyResource extends Resource
{
    protected static ?string $model = Taxonomy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('dictionaries')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('dictionaries')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(100),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('exportAsJson')
                ->label(__('Export'))
                ->action(function ($record) {
                    $name = Str::slug($record->name, '_');
                    return response()->streamDownload(function () use ($record) {
                        $return = $record->attributesToArray();
                        echo json_encode($return, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
                    }, $name . '.json');
                })
                ->tooltip(__('Export'))
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary'),
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
            'index' => Pages\ListTaxonomies::route('/'),
            'edit' => Pages\EditTaxonomy::route('/{record}/edit'),
        ];
    }
}
