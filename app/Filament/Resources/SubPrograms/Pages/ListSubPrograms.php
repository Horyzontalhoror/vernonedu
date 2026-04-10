<?php

namespace App\Filament\Resources\SubPrograms\Pages;

use App\Filament\Resources\SubPrograms\SubProgramResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSubPrograms extends ListRecords
{
    protected static string $resource = SubProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
