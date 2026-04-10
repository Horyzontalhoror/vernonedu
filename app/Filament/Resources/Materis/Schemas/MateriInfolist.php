<?php

namespace App\Filament\Resources\Materis\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MateriInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Materi')
                    ->schema([
                        TextEntry::make('subProgram.name')
                            ->label('Sub Program'),

                        TextEntry::make('urutan')
                            ->label('Pertemuan'),

                        TextEntry::make('judul'),

                        TextEntry::make('deskripsi')
                            ->columnSpanFull()
                            ->wrap(),
                    ])
                    ->columns(2),
            ]);
    }
}
