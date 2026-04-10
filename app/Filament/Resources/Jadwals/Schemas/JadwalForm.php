<?php

namespace App\Filament\Resources\Jadwals\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class JadwalForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Jadwal Kelas')
                    ->schema([
                        Select::make('sub_program_id')
                            ->label('Sub Program')
                            ->relationship('subProgram', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('instruktur_id')
                            ->label('Instruktur')
                            ->relationship('instruktur', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        DatePicker::make('tanggal')
                            ->required(),

                        TimePicker::make('waktu_mulai')
                            ->required(),

                        TimePicker::make('waktu_selesai')
                            ->required(),

                        TextInput::make('lokasi')
                            ->placeholder('Online / Offline / Ruang A'),

                        Select::make('status')
                            ->options([
                                'jadwal' => 'Terjadwal',
                                'selesai' => 'Selesai',
                                'batal' => 'Dibatalkan',
                            ])
                            ->default('jadwal')
                            ->required(),

                        Textarea::make('keterangan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
