<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UsersResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewUsersResource extends ViewRecord
{
    protected static string $resource = UsersResource::class;
}
