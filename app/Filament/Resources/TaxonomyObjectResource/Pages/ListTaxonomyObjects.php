<?php

namespace App\Filament\Resources\TaxonomyObjectResource\Pages;

use App\Filament\Resources\TaxonomyObjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxonomyObjects extends ListRecords
{
    protected static string $resource = TaxonomyObjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
