<?php

namespace App\Filament\Resources\SubPrograms\Schemas;

use Filament\Infolists\Components\ImageEntry;
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

                        /*
                        |--------------------------------------------------------------------------
                        | IMAGE
                        |--------------------------------------------------------------------------
                        */

                        ImageEntry::make('image_url')

                            ->label('Gambar')

                            ->height(220),

                        /*
                        |--------------------------------------------------------------------------
                        | PROGRAM
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('program.nama')

                            ->label('Program'),

                        /*
                        |--------------------------------------------------------------------------
                        | NAME
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('name')

                            ->label('Nama Sub Program'),

                        /*
                        |--------------------------------------------------------------------------
                        | USIA
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('usia')

                            ->label('Target Usia'),

                        /*
                        |--------------------------------------------------------------------------
                        | HARGA
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('harga')

                            ->label('Harga')

                            ->money('IDR'),

                        /*
                        |--------------------------------------------------------------------------
                        | DESCRIPTION
                        |--------------------------------------------------------------------------
                        */

                        TextEntry::make('description')

                            ->label('Deskripsi')

                            ->columnSpanFull()

                            ->wrap(),

                    ])

                    ->columns(2),

            ]);
    }
}
