<?php

namespace App\Filament\Resources\TaxonomyElementResource\Pages;

use App\Filament\Resources\TaxonomyElementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxonomyElement extends EditRecord
{
    protected static string $resource = TaxonomyElementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
