<?php

namespace App\Filament\Resources\NofifyResource\Pages;

use App\Filament\Resources\NofifyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNofifies extends ListRecords
{
    protected static string $resource = NofifyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
