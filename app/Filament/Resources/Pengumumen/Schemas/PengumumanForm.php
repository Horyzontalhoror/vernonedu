<?php

namespace App\Filament\Resources\Pengumumen\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PengumumanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pengumuman')
                    ->schema([
                        TextInput::make('judul')
                            ->label('Judul')
                            ->required(),

                        Select::make('tipe')
                            ->options([
                                'info' => 'Informasi',
                                'penting' => 'Penting',
                                'event' => 'Event',
                            ])
                            ->required(),

                        DatePicker::make('tanggal')
                            ->required(),

                        Textarea::make('isi')
                            ->label('Isi Pengumuman')
                            ->rows(5)
                            ->columnSpanFull(),

                        Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'publish' => 'Publish',
                            ])
                            ->default('draft')
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
