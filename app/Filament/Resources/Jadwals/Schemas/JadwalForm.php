<?php

namespace App\Filament\Resources\Jadwals\Schemas;

use App\Filament\Resources\SubPrograms\RelationManagers\JadwalsRelationManager;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

use Filament\Schemas\Schema;

class JadwalForm
{
    public static function configure(
        Schema $schema
    ): Schema {

        return $schema
            ->components([

                Section::make('Jadwal Kelas')

                    ->description(
                        'Buat jadwal kelas tunggal atau generate batch pertemuan otomatis.'
                    )

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | SUB PROGRAM
                        |--------------------------------------------------------------------------
                        */

                        Select::make('sub_program_id')

                            ->label('Sub Program')

                            ->relationship(
                                'subProgram',
                                'name'
                            )

                            ->searchable()

                            ->preload()

                            ->required()
                            ->hiddenOn(
                                JadwalsRelationManager::class
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | INSTRUKTUR
                        |--------------------------------------------------------------------------
                        */

                        Select::make('instruktur_id')

                            ->label('Instruktur')

                            ->relationship(
                                'instruktur',
                                'nama'
                            )

                            ->searchable()

                            ->preload()

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | TANGGAL
                        |--------------------------------------------------------------------------
                        */

                        DatePicker::make('tanggal')

                            ->label('Tanggal Mulai')

                            ->native(false)

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | WAKTU
                        |--------------------------------------------------------------------------
                        */

                        TimePicker::make('waktu_mulai')

                            ->label('Waktu Mulai')

                            ->seconds(false)

                            ->required(),

                        TimePicker::make('waktu_selesai')

                            ->label('Waktu Selesai')

                            ->seconds(false)

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | LOKASI
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make('lokasi')

                            ->placeholder(
                                'Zoom / Google Meet / Ruang A'
                            )

                            ->maxLength(255),

                        /*
                        |--------------------------------------------------------------------------
                        | STATUS
                        |--------------------------------------------------------------------------
                        */

                        Select::make('status')

                            ->label('Status Jadwal')

                            ->options([

                                'jadwal' =>
                                    'Terjadwal',

                                'selesai' =>
                                    'Selesai',

                                'batal' =>
                                    'Dibatalkan',

                            ])

                            ->default('jadwal')

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | KETERANGAN
                        |--------------------------------------------------------------------------
                        */

                        Textarea::make('keterangan')

                            ->label('Keterangan')

                            ->rows(4)

                            ->columnSpanFull(),

                    ])

                    ->columns(2),

                /*
                |--------------------------------------------------------------------------
                | GENERATOR
                |--------------------------------------------------------------------------
                */

                Section::make('Generate Pertemuan')

                    ->description(
                        'Generate otomatis banyak jadwal sekaligus.'
                    )

                    ->visibleOn('create')

                    ->schema([

                        /*
                        |--------------------------------------------------------------------------
                        | TOTAL
                        |--------------------------------------------------------------------------
                        */

                        TextInput::make(
                            'jumlah_pertemuan'
                        )

                            ->label(
                                'Jumlah Pertemuan'
                            )

                            ->numeric()

                            ->default(16)

                            ->minValue(1)

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | REPEAT TYPE
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'repeat_type'
                        )

                            ->label(
                                'Tipe Pengulangan'
                            )

                            ->options([

                                'daily' =>
                                    'Setiap Hari',

                                'weekly' =>
                                    'Mingguan',

                            ])

                            ->default('weekly')

                            ->live()

                            ->required(),

                        /*
                        |--------------------------------------------------------------------------
                        | HARI BELAJAR
                        |--------------------------------------------------------------------------
                        */

                        Select::make('hari')

                            ->label(
                                'Hari Belajar'
                            )

                            ->multiple()

                            ->options([

                                'monday' =>
                                    'Senin',

                                'tuesday' =>
                                    'Selasa',

                                'wednesday' =>
                                    'Rabu',

                                'thursday' =>
                                    'Kamis',

                                'friday' =>
                                    'Jumat',

                                'saturday' =>
                                    'Sabtu',

                                'sunday' =>
                                    'Minggu',

                            ])

                            ->visible(
                                fn ($get) =>

                                $get(
                                    'repeat_type'
                                ) === 'weekly'
                            )

                            ->required(
                                fn ($get) =>

                                $get(
                                    'repeat_type'
                                ) === 'weekly'
                            )

                            ->helperText(
                                'Pilih hari pertemuan kelas.'
                            ),

                        /*
                        |--------------------------------------------------------------------------
                        | EXCLUDE DAYS
                        |--------------------------------------------------------------------------
                        */

                        Select::make(
                            'exclude_days'
                        )

                            ->label(
                                'Hari Libur'
                            )

                            ->multiple()

                            ->options([

                                'monday' =>
                                    'Senin',

                                'tuesday' =>
                                    'Selasa',

                                'wednesday' =>
                                    'Rabu',

                                'thursday' =>
                                    'Kamis',

                                'friday' =>
                                    'Jumat',

                                'saturday' =>
                                    'Sabtu',

                                'sunday' =>
                                    'Minggu',

                            ])

                            ->default([

                                'saturday',

                                'sunday',

                            ])

                            ->helperText(
                                'Hari yang dilewati saat generate jadwal.'
                            )

                            ->visible(
                                fn ($get) =>

                                filled(
                                    $get(
                                        'repeat_type'
                                    )
                                )
                            ),

                    ])

                    ->columns(2),

            ]);
    }
}
