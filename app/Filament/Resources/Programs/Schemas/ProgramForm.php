<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Section::make('Program')
                    ->schema([
                        TextInput::make('nama')
                            ->required(),

                        Textarea::make('deskripsi')
                            ->rows(5)
                            ->columnSpanFull(),
                    ])
            ]);
    }
}
