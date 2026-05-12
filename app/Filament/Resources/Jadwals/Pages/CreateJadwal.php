<?php

namespace App\Filament\Resources\Jadwals\Pages;

use App\Models\Jadwal;

use Carbon\Carbon;

use Filament\Resources\Pages\CreateRecord;

use App\Filament\Resources\Jadwals\JadwalResource;

class CreateJadwal extends CreateRecord
{
    protected static string $resource =
        JadwalResource::class;

    protected function handleRecordCreation(
        array $data
    ): Jadwal {

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
        | DAILY
        |--------------------------------------------------------------------------
        */

        if ($repeatType === 'daily') {

            $created = 0;

            while (
                $created <
                $jumlahPertemuan
            ) {

                $dayName = strtolower(
                    $tanggal->format('l')
                );

                /*
                |--------------------------------------------------------------------------
                | SKIP EXCLUDED DAY
                |--------------------------------------------------------------------------
                */

                if (
                    ! in_array(
                        $dayName,
                        $excludeDays
                    )
                ) {

                    Jadwal::create([

                        ...$data,

                        'tanggal' =>
                            $tanggal
                                ->copy(),

                    ]);

                    $created++;
                }

                $tanggal->addDay();
            }
        }

        /*
        |--------------------------------------------------------------------------
        | WEEKLY
        |--------------------------------------------------------------------------
        */

        else {

            $created = 0;

            while (
                $created <
                $jumlahPertemuan
            ) {

                $dayName = strtolower(
                    $tanggal->format('l')
                );

                /*
                |--------------------------------------------------------------------------
                | MATCH DAY
                |--------------------------------------------------------------------------
                */

                if (

                    in_array(
                        $dayName,
                        $hariDipilih
                    )

                    &&

                    ! in_array(
                        $dayName,
                        $excludeDays
                    )

                ) {

                    Jadwal::create([

                        ...$data,

                        'tanggal' =>
                            $tanggal
                                ->copy(),

                    ]);

                    $created++;
                }

                $tanggal->addDay();
            }
        }

        return Jadwal::latest()->first();
    }
}
