<?php

namespace App\Filament\Resources\Instrukturs\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InstrukturForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Instruktur')
                    ->description('Isi data lengkap instruktur')
                    ->schema([
                        TextInput::make('nama')
                            ->label('Nama Instruktur')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('jabatan')
                            ->label('Jabatan')
                            ->maxLength(255),

                        TextInput::make('no_telepon')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->required(),

                        Textarea::make('alamat')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
