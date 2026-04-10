<?php

namespace App\Filament\Resources\SubPrograms\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SubProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Sub Program')
                    ->schema([
                        TextEntry::make('program.nama')
                            ->label('Program'),

                        TextEntry::make('name')
                            ->label('Nama Sub Program'),

                        TextEntry::make('usia')
                            ->label('Target Usia'),

                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->wrap(),
                    ])
                    ->columns(2),
            ]);
    }
}
