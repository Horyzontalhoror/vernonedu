<?php

namespace App\Filament\Resources\Materis\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;

class MateriForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Materi')
                    ->schema([
                        Select::make('sub_program_id')
                            ->label('Sub Program')
                            ->relationship('subProgram', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->hidden(fn ($livewire) => $livewire instanceof \Filament\Resources\RelationManagers\RelationManager),
                        TextInput::make('urutan')
                            ->label('Pertemuan Ke')
                            ->numeric()
                            ->required(),

                        TextInput::make('judul')
                            ->label('Judul Materi')
                            ->required(),

                        Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
