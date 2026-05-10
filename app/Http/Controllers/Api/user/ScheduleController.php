<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Transaction;

class ScheduleController extends Controller
{
    public function mySchedule(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | AMBIL SUB PROGRAM DARI TRANSACTION SUKSES
        |--------------------------------------------------------------------------
        */

        $subProgramIds = Transaction::where(
                'user_id',
                $user->id
            )

            ->whereIn('transaction_status', [
                'settlement',
                'capture',
            ])

            ->pluck('sub_program_id')

            ->unique();

        /*
        |--------------------------------------------------------------------------
        | JIKA BELUM ADA COURSE
        |--------------------------------------------------------------------------
        */

        if ($subProgramIds->isEmpty()) {

            return response()->json([]);

        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL JADWAL
        |--------------------------------------------------------------------------
        */

        $jadwals = Jadwal::with([
                'subProgram:id,name,slug,image_url'
            ])

            ->whereIn(
                'sub_program_id',
                $subProgramIds
            )

            ->orderBy('tanggal')

            ->orderBy('waktu_mulai')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | FORMAT RESPONSE
        |--------------------------------------------------------------------------
        */

        $result = $jadwals->map(function ($jadwal) {

            return [

                'id' =>
                    $jadwal->id,

                'tanggal' =>
                    $jadwal->tanggal,

                'waktu_mulai' =>
                    $jadwal->waktu_mulai,

                'waktu_selesai' =>
                    $jadwal->waktu_selesai,

                'lokasi' =>
                    $jadwal->lokasi,

                'sub_program' => [

                    'id' =>
                        $jadwal->subProgram?->id,

                    'name' =>
                        $jadwal->subProgram?->name,

                    'slug' =>
                        $jadwal->subProgram?->slug,

                    'image_url' =>
                        $jadwal->subProgram?->image_url,

                ],

            ];

        });

        return response()->json(
            $result
        );
    }
}
