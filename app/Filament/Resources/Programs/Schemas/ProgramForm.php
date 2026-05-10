<?php

namespace App\Filament\Resources\Programs\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            ->components([

                Section::make('Program')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | NAMA
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('nama')

                            ->label('Nama Program')

                            ->required()

                            ->maxLength(255),

                        /*
                        |--------------------------------------------------------------------------
                        | IMAGE URL
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('image_url')

                            ->label('Link Gambar')

                            ->url()

                            ->placeholder(
                                'https://example.com/image.jpg'
                            )

                            ->columnSpanFull(),

                        /*
                        |--------------------------------------------------------------------------
                        | DESKRIPSI
                        |--------------------------------------------------------------------------
                        */

                        Textarea::make('deskripsi')

                            ->label('Deskripsi')

                            ->rows(5)

                            ->columnSpanFull(),

                    ])

                    ->columns(2),

            ]);
    }
}
