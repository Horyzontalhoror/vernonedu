<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\Peserta;

class CourseController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MY COURSES
    |--------------------------------------------------------------------------
    */

    public function myCourses(Request $request)
    {
        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | PESERTA
        |--------------------------------------------------------------------------
        */

        $peserta = Peserta::where(
            'log_user_id',
            $user->id
        )->first();

        if (! $peserta) {

            return response()->json([]);

        }

        /*
        |--------------------------------------------------------------------------
        | TRANSACTION SUCCESS
        |--------------------------------------------------------------------------
        */

        $transactions = Transaction::with([
                'subProgram.materis'
            ])

            ->where('user_id', $user->id)

            ->whereIn('transaction_status', [
                'settlement',
                'capture',
            ])

            ->latest()

            ->get();

        /*
        |--------------------------------------------------------------------------
        | FORMAT
        |--------------------------------------------------------------------------
        */

        $courses = $transactions

            ->filter(fn ($trx) =>
                $trx->subProgram
            )

            ->map(function ($trx) use ($peserta) {

                $subProgram =
                    $trx->subProgram;

                /*
                |--------------------------------------------------------------------------
                | TOTAL MATERI
                |--------------------------------------------------------------------------
                */

                $totalMateri =
                    $subProgram
                        ->materis
                        ->count();

                /*
                |--------------------------------------------------------------------------
                | PROGRESS
                |--------------------------------------------------------------------------
                */

                $progress = $peserta
                    ->getProgressBySubProgram(
                        $subProgram->id
                    );

                /*
                |--------------------------------------------------------------------------
                | MATERI SELESAI
                |--------------------------------------------------------------------------
                */

                $materiSelesai = $peserta
                    ->materis()

                    ->whereHas(
                        'subProgram',
                        fn ($q) =>
                            $q->where(
                                'id',
                                $subProgram->id
                            )
                    )

                    ->wherePivot(
                        'status',
                        'selesai'
                    )

                    ->count();

                return [

                    'transaction_id' =>
                        $trx->id,

                    'id' =>
                        $subProgram->id,

                    'title' =>
                        $subProgram->name,

                    'slug' =>
                        $subProgram->slug,

                    'description' =>
                        $subProgram->description,

                    'usia' =>
                        $subProgram->usia,

                    'harga' =>
                        $subProgram->harga,

                    'image_url' =>
                        $subProgram->image_url,

                    'payment_type' =>
                        $trx->payment_type,

                    'transaction_status' =>
                        $trx->transaction_status,

                    'total_materi' =>
                        $totalMateri,

                    'materi_selesai' =>
                        $materiSelesai,

                    'progress' =>
                        $progress,

                    'created_at' =>
                        $trx->created_at,

                ];

            })

            /*
            |--------------------------------------------------------------------------
            | UNIQUE COURSE
            |--------------------------------------------------------------------------
            */

            ->unique('id')

            ->values();

        return response()->json(
            $courses
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL COURSE
    |--------------------------------------------------------------------------
    */

    public function showMyCourse(
        Request $request,
        $slug
    ) {

        $user = $request->user();

        /*
        |--------------------------------------------------------------------------
        | PESERTA
        |--------------------------------------------------------------------------
        */

        $peserta = Peserta::where(
            'log_user_id',
            $user->id
        )->first();

        if (! $peserta) {

            return response()->json([
                'message' =>
                    'Peserta tidak ditemukan'
            ], 404);

        }

        /*
        |--------------------------------------------------------------------------
        | COURSE
        |--------------------------------------------------------------------------
        */

        $subProgram = $peserta

            ->subPrograms()

            ->where(
                'slug',
                $slug
            )

            ->with([
                'materis'
            ])

            ->first();

        if (! $subProgram) {

            return response()->json([
                'message' =>
                    'Course tidak ditemukan'
            ], 404);

        }

        /*
        |--------------------------------------------------------------------------
        | MATERI + STATUS
        |--------------------------------------------------------------------------
        */

        $materis = $subProgram
            ->materis

            ->sortBy('urutan')

            ->values()

            ->map(function (
                $materi
            ) use ($peserta) {

                $progress = $peserta

                    ->materis()

                    ->where(
                        'materi_id',
                        $materi->id
                    )

                    ->first();

                return [

                    'id' =>
                        $materi->id,

                    'judul' =>
                        $materi->judul,

                    'deskripsi' =>
                        $materi->deskripsi,

                    'urutan' =>
                        $materi->urutan,

                    'status' =>
                        $progress?->pivot?->status
                        ?? 'proses',

                    'tanggal' =>
                        $progress?->pivot?->tanggal,

                ];

            });

        /*
        |--------------------------------------------------------------------------
        | TOTAL
        |--------------------------------------------------------------------------
        */

        $totalMateri =
            $subProgram
                ->materis
                ->count();

        /*
        |--------------------------------------------------------------------------
        | PROGRESS
        |--------------------------------------------------------------------------
        */

        $progress = $peserta
            ->getProgressBySubProgram(
                $subProgram->id
            );

        /*
        |--------------------------------------------------------------------------
        | MATERI SELESAI
        |--------------------------------------------------------------------------
        */

        $materiSelesai =
            $materis
                ->where(
                    'status',
                    'selesai'
                )
                ->count();

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'id' =>
                $subProgram->id,

            'title' =>
                $subProgram->name,

            'slug' =>
                $subProgram->slug,

            'description' =>
                $subProgram->description,

            'usia' =>
                $subProgram->usia,

            'harga' =>
                $subProgram->harga,

            'image_url' =>
                $subProgram->image_url,

            'progress' =>
                $progress,

            'total_materi' =>
                $totalMateri,

            'materi_selesai' =>
                $materiSelesai,

            'materis' =>
                $materis,

        ]);
    }
}
