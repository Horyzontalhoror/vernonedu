<?php

namespace App\Filament\Resources\LogUsers\Pages;

use App\Filament\Resources\LogUsers\LogUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLogUsers extends ListRecords
{
    protected static string $resource = LogUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
