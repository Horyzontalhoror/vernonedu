<?php

namespace App\Filament\Resources\SubPrograms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

use Filament\Schemas\Components\Utilities\Set as ComponentSet;
use Filament\Schemas\Schema;

use Illuminate\Support\Str;

class SubProgramForm
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

                Select::make('program_id')

                    ->label('Program')

                    ->relationship('program', 'nama')

                    ->searchable()

                    ->preload()

                    ->required(),

                /*
                |--------------------------------------------------------------------------
                | NAME
                |--------------------------------------------------------------------------
                */

                TextInput::make('name')

                    ->label('Nama Sub Program')

                    ->required()

                    ->live(onBlur: true)

                    ->afterStateUpdated(
                        fn (ComponentSet $set, ?string $state) =>
                            $set('slug', Str::slug($state))
                    ),

                /*
                |--------------------------------------------------------------------------
                | SLUG
                |--------------------------------------------------------------------------
                */

                TextInput::make('slug')

                    ->label('Slug')

                    ->required()

                    ->unique(ignoreRecord: true)

                    ->maxLength(255),

                /*
                |--------------------------------------------------------------------------
                | HARGA
                |--------------------------------------------------------------------------
                */

                TextInput::make('harga')

                    ->label('Harga')

                    ->numeric()

                    ->prefix('Rp')

                    ->required(),

                /*
                |--------------------------------------------------------------------------
                | USIA
                |--------------------------------------------------------------------------
                */

                TextInput::make('usia')

                    ->label('Target Usia')

                    ->placeholder('Contoh: 7-9 tahun'),

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
                | DESCRIPTION
                |--------------------------------------------------------------------------
                */

                Textarea::make('description')

                    ->label('Deskripsi')

                    ->rows(5)

                    ->columnSpanFull(),

            ])

            ->columns(2);
    }
}
