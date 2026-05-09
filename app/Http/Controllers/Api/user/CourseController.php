<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Transaction;

class CourseController extends Controller
{
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
                    | SEMENTARA STATIC
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
            | HILANGKAN DUPLIKAT COURSE
            |--------------------------------------------------------------------------
            */

            ->unique('id')

            ->values();

        return response()->json($courses);
    }
}
