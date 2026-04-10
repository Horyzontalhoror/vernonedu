<?php

namespace App\Filament\Resources\SubPrograms\Pages;

use App\Filament\Resources\SubPrograms\SubProgramResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSubProgram extends ViewRecord
{
    protected static string $resource = SubProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
