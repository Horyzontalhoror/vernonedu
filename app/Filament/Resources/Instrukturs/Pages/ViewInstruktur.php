<?php

namespace App\Filament\Resources\Instrukturs\Pages;

use App\Filament\Resources\Instrukturs\InstrukturResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewInstruktur extends ViewRecord
{
    protected static string $resource = InstrukturResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
