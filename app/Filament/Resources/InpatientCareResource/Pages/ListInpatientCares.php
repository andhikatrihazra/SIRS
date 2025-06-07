<?php

namespace App\Filament\Resources\InpatientCareResource\Pages;

use App\Filament\Resources\InpatientCareResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInpatientCares extends ListRecords
{
    protected static string $resource = InpatientCareResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
