<?php

namespace App\Filament\Resources\LogUsers\Pages;

use App\Filament\Resources\LogUsers\LogUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditLogUser extends EditRecord
{
    protected static string $resource = LogUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
