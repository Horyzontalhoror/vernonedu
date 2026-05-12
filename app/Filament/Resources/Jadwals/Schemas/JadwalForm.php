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

                        TextInput::make('jumlah_pertemuan')
                            ->numeric()
                            ->default(16)
                            ->required(),

                        Select::make('repeat_type')
                            ->options([
                                'daily' => 'Setiap Hari',
                                'weekly' => 'Mingguan',
                            ])
                            ->default('weekly')
                            ->required(),

                        Select::make('hari')
                            ->multiple()
                            ->options([
                                'monday' => 'Senin',
                                'tuesday' => 'Selasa',
                                'wednesday' => 'Rabu',
                                'thursday' => 'Kamis',
                                'friday' => 'Jumat',
                                'saturday' => 'Sabtu',
                                'sunday' => 'Minggu',
                            ])
                            ->visible(fn ($get) =>
                                $get('repeat_type') === 'weekly'
                            ),

                        Select::make('exclude_days')
                            ->label('Hari Libur')
                            ->multiple()
                            ->options([
                                'monday' => 'Senin',
                                'tuesday' => 'Selasa',
                                'wednesday' => 'Rabu',
                                'thursday' => 'Kamis',
                                'friday' => 'Jumat',
                                'saturday' => 'Sabtu',
                                'sunday' => 'Minggu',
                            ])
                            ->default([
                                'saturday',
                                'sunday',
                            ])
                            ->helperText(
                                'Hari yang akan dilewati saat generate jadwal'
                            ),

                    ])
                    ->columns(2),
            ]);
    }
}
