<?php

namespace App\Filament\Resources\Jadwals\Pages;

use App\Models\Jadwal;

use Carbon\Carbon;

use Illuminate\Support\Facades\DB;

use Filament\Resources\Pages\CreateRecord;

use App\Filament\Resources\Jadwals\JadwalResource;

class CreateJadwal extends CreateRecord
{
    protected static string $resource =
        JadwalResource::class;

    protected function handleRecordCreation(
        array $data
    ): Jadwal {

        DB::beginTransaction();

        try {

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
            | PREPARE INSERT
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
                    $repeatType === 'daily'
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
                | INSERT
                |--------------------------------------------------------------------------
                */

                if ($shouldCreate) {

                    $rows[] = [

                        ...$data,

                        'tanggal' =>

                            $tanggal
                                ->copy()
                                ->format('Y-m-d'),

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

            DB::commit();

            return Jadwal::latest()->first();

        } catch (\Throwable $e) {

            DB::rollBack();

            throw $e;
        }
    }
}
