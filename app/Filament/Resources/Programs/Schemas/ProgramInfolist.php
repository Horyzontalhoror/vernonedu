<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\RepeatableEntry;

class ProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Program')
                    ->schema([
                        TextEntry::make('nama')
                            ->label('Nama Program'),

                        TextEntry::make('deskripsi')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->wrap(),
                    ])
                    ->columns(2),

                Section::make('Sub Program')
                    ->schema([
                        RepeatableEntry::make('subPrograms')
                            ->label('Kelas')
                            ->schema([
                                TextEntry::make('name')
                                    ->hiddenLabel()
                                    ->columnSpanFull()
                                    ->wrap(),
                            ])
                            ->columns(2),
                    ]),
            ]);
    }
}
