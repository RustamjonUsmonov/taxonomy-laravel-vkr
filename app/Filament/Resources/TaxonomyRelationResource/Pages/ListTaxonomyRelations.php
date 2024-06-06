<?php

namespace App\Filament\Resources\TaxonomyRelationResource\Pages;

use App\Filament\Resources\TaxonomyRelationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxonomyRelations extends ListRecords
{
    protected static string $resource = TaxonomyRelationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
