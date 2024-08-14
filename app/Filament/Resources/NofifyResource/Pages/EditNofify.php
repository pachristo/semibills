<?php

namespace App\Filament\Resources\NofifyResource\Pages;

use App\Filament\Resources\NofifyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNofify extends EditRecord
{
    protected static string $resource = NofifyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
