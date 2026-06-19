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

        // Eager load materis to perform all computations in-memory (solving N+1 queries)
        $peserta->load('materis');

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
                | MATERI SELESAI & PROGRESS (In-Memory)
                |--------------------------------------------------------------------------
                */

                $materiSelesai = $peserta->materis
                    ->where('sub_program_id', $subProgram->id)
                    ->where('pivot.status', 'selesai')
                    ->count();

                $progress = $totalMateri > 0
                    ? round(($materiSelesai / $totalMateri) * 100)
                    : 0;

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

        // Eager load materis to perform all status checks in-memory (solving N+1 queries)
        $peserta->load('materis');

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

                $progress = $peserta->materis->firstWhere('id', $materi->id);

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
        | PROGRESS (In-Memory)
        |--------------------------------------------------------------------------
        */

        $progress = $totalMateri > 0
            ? round(($materiSelesai / $totalMateri) * 100)
            : 0;

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
