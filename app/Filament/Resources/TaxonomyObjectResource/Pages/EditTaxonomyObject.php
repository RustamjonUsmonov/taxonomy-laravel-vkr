<?php

namespace App\Filament\Resources\TaxonomyObjectResource\Pages;

use App\Filament\Resources\TaxonomyObjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxonomyObject extends EditRecord
{
    protected static string $resource = TaxonomyObjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
