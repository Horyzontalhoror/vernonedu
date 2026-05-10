<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([

                /*
                |--------------------------------------------------------------------------
                | PROGRAM
                |--------------------------------------------------------------------------
                */

                Section::make('Program')

                    ->schema([

                        ImageEntry::make('image_url')

                            ->label('Gambar')

                            ->height(200),

                        TextEntry::make('nama')

                            ->label('Nama Program'),

                        TextEntry::make('deskripsi')

                            ->label('Deskripsi')

                            ->columnSpanFull()

                            ->wrap(),

                    ])

                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | SUB PROGRAM
                |--------------------------------------------------------------------------
                */

                Section::make('Sub Program')

                    ->schema([

                        RepeatableEntry::make('subPrograms')

                            ->label('Kelas')

                            ->schema([

                                TextEntry::make('name')

                                    ->label('Nama'),

                                TextEntry::make('usia')

                                    ->label('Usia'),

                            ])

                            ->columns(2),

                    ]),

            ]);
    }
}
