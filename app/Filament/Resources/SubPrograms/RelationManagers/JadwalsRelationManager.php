<?php

namespace App\Filament\Resources\SubPrograms\RelationManagers;

use App\Models\Jadwal;
use App\Models\Peserta;

use Carbon\Carbon;

use Filament\Tables\Table;

use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

use Filament\Resources\RelationManagers\RelationManager;

use App\Filament\Resources\Jadwals\Schemas\JadwalForm;

use App\Notifications\JadwalAvailableNotification;

use Filament\Schemas\Schema;

use Filament\Tables\Columns\TextColumn;

class JadwalsRelationManager
    extends RelationManager
{
    protected static string $relationship =
        'jadwals';

    protected static ?string $title =
        'Jadwal Kelas';

    /*
    |--------------------------------------------------------------------------
    | FORM
    |--------------------------------------------------------------------------
    */

    public function form(
        Schema $schema
    ): Schema {

        return JadwalForm::configure(
            $schema
        );
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    public function table(
        Table $table
    ): Table {

        return $table

            ->recordTitleAttribute(
                'tanggal'
            )

            ->columns([

                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'tanggal'
                )

                    ->label('Tanggal')

                    ->date('d M Y')

                    ->sortable(),

                /*
                |--------------------------------------------------------------------------
                | WAKTU
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'waktu_mulai'
                )

                    ->label('Mulai')

                    ->time('H:i'),

                TextColumn::make(
                    'waktu_selesai'
                )

                    ->label('Selesai')

                    ->time('H:i'),

                /*
                |--------------------------------------------------------------------------
                | LOKASI
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'lokasi'
                )

                    ->label('Lokasi')

                    ->limit(25)

                    ->placeholder('-'),

                /*
                |--------------------------------------------------------------------------
                | STATUS
                |--------------------------------------------------------------------------
                */

                TextColumn::make(
                    'status'
                )

                    ->badge()

                    ->color(
                        fn (string $state): string => match ($state) {

                            'jadwal' => 'info',

                            'selesai' => 'success',

                            'batal' => 'danger',

                            default => 'gray',
                        }
                    ),

            ])

            /*
            |--------------------------------------------------------------------------
            | HEADER ACTIONS
            |--------------------------------------------------------------------------
            */

            ->headerActions([

                CreateAction::make()

                    ->label(
                        'Tambah Jadwal'
                    )

                    ->using(function (
                        array $data,
                        $livewire
                    ) {

                        /*
                        |--------------------------------------------------------------------------
                        | CONFIG
                        |--------------------------------------------------------------------------
                        */

                        $jumlahPertemuan =
                            (int) $data['jumlah_pertemuan'];

                        $repeatType =
                            $data['repeat_type'];

                        $hariDipilih =
                            $data['hari'] ?? [];

                        $excludeDays =
                            $data['exclude_days']
                            ?? [];

                        $tanggal =
                            Carbon::parse(
                                $data['tanggal']
                            );

                        /*
                        |--------------------------------------------------------------------------
                        | AUTO SUB PROGRAM
                        |--------------------------------------------------------------------------
                        */

                        $data['sub_program_id'] =

                            $livewire
                                ->ownerRecord
                                ->id;

                        /*
                        |--------------------------------------------------------------------------
                        | REMOVE CUSTOM FIELD
                        |--------------------------------------------------------------------------
                        */

                        unset(

                            $data['jumlah_pertemuan'],

                            $data['repeat_type'],

                            $data['hari'],

                            $data['exclude_days'],

                        );

                        /*
                        |--------------------------------------------------------------------------
                        | GENERATE
                        |--------------------------------------------------------------------------
                        */

                        $rows = [];

                        $created = 0;

                        while (
                            $created <
                            $jumlahPertemuan
                        ) {

                            $dayName = strtolower(
                                $tanggal->format('l')
                            );

                            $shouldCreate = false;

                            /*
                            |--------------------------------------------------------------------------
                            | DAILY
                            |--------------------------------------------------------------------------
                            */

                            if (
                                $repeatType ===
                                'daily'
                            ) {

                                $shouldCreate =

                                    ! in_array(
                                        $dayName,
                                        $excludeDays
                                    );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | WEEKLY
                            |--------------------------------------------------------------------------
                            */

                            else {

                                $shouldCreate =

                                    in_array(
                                        $dayName,
                                        $hariDipilih
                                    )

                                    &&

                                    ! in_array(
                                        $dayName,
                                        $excludeDays
                                    );
                            }

                            /*
                            |--------------------------------------------------------------------------
                            | INSERT DATA
                            |--------------------------------------------------------------------------
                            */

                            if ($shouldCreate) {

                                $rows[] = [

                                    ...$data,

                                    'tanggal' =>

                                        $tanggal
                                            ->copy()
                                            ->format(
                                                'Y-m-d'
                                            ),

                                    'created_at' =>
                                        now(),

                                    'updated_at' =>
                                        now(),

                                ];

                                $created++;
                            }

                            $tanggal->addDay();
                        }

                        /*
                        |--------------------------------------------------------------------------
                        | BULK INSERT
                        |--------------------------------------------------------------------------
                        */

                        Jadwal::insert($rows);

                        /*
                        |--------------------------------------------------------------------------
                        | GET CREATED SCHEDULE
                        |--------------------------------------------------------------------------
                        */

                        $jadwals = Jadwal::where(

                            'sub_program_id',

                            $data['sub_program_id']

                        )

                        ->latest()

                        ->take($jumlahPertemuan)

                        ->get();

                        /*
                        |--------------------------------------------------------------------------
                        | PESERTA
                        |--------------------------------------------------------------------------
                        */

                        $pesertas = Peserta::whereHas(

                            'subPrograms',

                            function ($q) use ($data) {

                                $q->where(
                                    'sub_program_id',
                                    $data['sub_program_id']
                                );
                            }

                        )

                        ->with('logUser')

                        ->get();

                        /*
                        |--------------------------------------------------------------------------
                        | SEND NOTIFICATION
                        |--------------------------------------------------------------------------
                        */

                        foreach (
                            $pesertas as $peserta
                        ) {

                            if (
                                ! $peserta->logUser
                            ) {

                                continue;
                            }

                            foreach (
                                $jadwals as $jadwal
                            ) {

                                $peserta
                                    ->logUser
                                    ->notify(

                                        new JadwalAvailableNotification(
                                            $jadwal
                                        )

                                    );
                            }
                        }

                        return Jadwal::latest()->first();
                    }),

            ])

            /*
            |--------------------------------------------------------------------------
            | RECORD ACTIONS
            |--------------------------------------------------------------------------
            */

            ->recordActions([

                EditAction::make(),

                DeleteAction::make(),

            ]);
    }
}
