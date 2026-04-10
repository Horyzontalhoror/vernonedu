<?php

namespace App\Filament\Resources\SubPrograms\Pages;

use App\Filament\Resources\SubPrograms\SubProgramResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSubProgram extends EditRecord
{
    protected static string $resource = SubProgramResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
