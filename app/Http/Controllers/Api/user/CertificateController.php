<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Certificate;
use App\Models\Peserta;

class CertificateController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MY CERTIFICATES
    |--------------------------------------------------------------------------
    */

    public function myCertificates(Request $request)
    {
        $user = $request->user();

        $peserta = Peserta::where(
            'log_user_id',
            $user->id
        )->first();

        if (!$peserta) {
            return response()->json([]);
        }

        $certificates = Certificate::with([
                'subProgram'
            ])

            ->where('peserta_id', $peserta->id)

            ->where('status', 'published')

            ->latest()

            ->get()

            ->map(function ($certificate) {

                return [

                    'id' =>
                        $certificate->id,

                    'title' =>
                        $certificate->subProgram?->name,

                    'slug' =>
                        $certificate->subProgram?->slug,

                    'status' =>
                        $certificate->status,

                    'file_url' =>
                        $certificate->file_url,

                    'issued_at' =>
                        $certificate->issued_at,

                    'sub_program' =>
                        $certificate->subProgram,

                ];

            });

        return response()->json(
            $certificates
        );
    }

    /*
    |--------------------------------------------------------------------------
    | CERTIFICATE DETAIL
    |--------------------------------------------------------------------------
    */

    public function show($slug)
    {
        $certificate = Certificate::with([
                'subProgram.materis'
            ])

            ->whereHas('subProgram', function ($query) use ($slug) {

                $query->where(
                    'slug',
                    $slug
                );

            })

            ->where('status', 'published')

            ->firstOrFail();

        return response()->json([

            'id' =>
                $certificate->id,

            'title' =>
                $certificate->subProgram?->name,

            'slug' =>
                $certificate->subProgram?->slug,

            'description' =>
                $certificate->subProgram?->description,

            'image_url' =>
                $certificate->subProgram?->image_url,

            'file_url' =>
                $certificate->file_url,

            'issued_at' =>
                $certificate->issued_at,

            'skills' =>
                $certificate->subProgram
                    ?->materis
                    ?->pluck('judul'),

        ]);
    }
}
