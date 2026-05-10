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
        | AMBIL TRANSAKSI SUKSES
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
        | FORMAT RESPONSE
        |--------------------------------------------------------------------------
        */

        $courses = $transactions

            ->filter(fn ($trx) => $trx->subProgram)

            ->map(function ($trx) {

                $subProgram =
                    $trx->subProgram;

                $totalMateri =
                    $subProgram->materis->count();

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

                    /*
                    |--------------------------------------------------------------------------
                    | STATIC SEMENTARA
                    |--------------------------------------------------------------------------
                    */

                    'materi_selesai' => 0,

                    'progress' => 0,

                    'created_at' =>
                        $trx->created_at,

                ];

            })

            /*
            |--------------------------------------------------------------------------
            | HILANGKAN DUPLIKAT
            |--------------------------------------------------------------------------
            */

            ->unique('id')

            ->values();

        return response()->json($courses);
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

        $peserta = Peserta::where(
            'log_user_id',
            $user->id
        )->first();

        if (! $peserta) {

            return response()->json([
                'message' => 'Peserta tidak ditemukan'
            ], 404);
        }

        $subProgram = $peserta
            ->subPrograms()
            ->where('slug', $slug)
            ->with('materis')
            ->first();

        if (! $subProgram) {

            return response()->json([
                'message' => 'Course tidak ditemukan'
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | MATERI + PROGRESS
        |--------------------------------------------------------------------------
        */

        $materis = $subProgram->materis->map(function (
            $materi
        ) use ($peserta) {

            $progress = $peserta
                ->materis()
                ->where('materi_id', $materi->id)
                ->first();

            return [

                'id' => $materi->id,

                'judul' => $materi->judul,

                'deskripsi' => $materi->deskripsi,

                'status' =>
                    $progress?->pivot?->status
                    ?? 'proses',

                'tanggal' =>
                    $progress?->pivot?->tanggal,

            ];
        });

        /*
        |--------------------------------------------------------------------------
        | HITUNG PROGRESS
        |--------------------------------------------------------------------------
        */

        $totalMateri =
            $subProgram->materis->count();

        $materiSelesai =
            $materis
                ->where('status', 'selesai')
                ->count();

        $progress = $totalMateri > 0
            ? round(
                ($materiSelesai / $totalMateri) * 100
              )
            : 0;

        /*
        |--------------------------------------------------------------------------
        | RESPONSE
        |--------------------------------------------------------------------------
        */

        return response()->json([

            'id' => $subProgram->id,

            'title' => $subProgram->name,

            'slug' => $subProgram->slug,

            'description' => $subProgram->description,

            'usia' => $subProgram->usia,

            'harga' => $subProgram->harga,

            'image_url' => $subProgram->image_url,

            'progress' => $progress,

            'total_materi' => $totalMateri,

            'materi_selesai' => $materiSelesai,

            'materis' => $materis,

        ]);
    }
}
