<?php

namespace App\Filament\Resources\SubPrograms\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Set as ComponentSet;
use Illuminate\Support\Str;

class SubProgramForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
                Select::make('program_id')
                    ->label('Program')
                    ->relationship('program', 'nama')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('name')
                    ->label('Nama Sub Program')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (ComponentSet $set, ?string $state) => $set('slug', Str::slug($state))),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                Textarea::make('description')
                    ->columnSpanFull(),

                TextInput::make('usia')
                    ->label('Target Usia')
            ]);
    }
}
