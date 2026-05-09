<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta;

class CourseController extends Controller
{
    public function myCourses(Request $request)
    {
        $user = $request->user();

        // ambil peserta login
        $peserta = Peserta::where(
            'log_user_id',
            $user->id
        )->first();

        if (!$peserta) {
            return response()->json([]);
        }

        // ambil course yang diikuti
        $subPrograms = $peserta
            ->subPrograms()
            ->with('materis')
            ->get();

        $result = $subPrograms->map(function (
            $subProgram
        ) use ($peserta) {

            // total materi
            $totalMateri =
                $subProgram->materis->count();

            // materi selesai
            $materiSelesai = $peserta
                ->materis()
                ->where(
                    'sub_program_id',
                    $subProgram->id
                )
                ->wherePivot(
                    'status',
                    'selesai'
                )
                ->count();

            // progress
            $progress = $totalMateri > 0
                ? round(
                    ($materiSelesai / $totalMateri) * 100
                  )
                : 0;

            return [

                'id' => $subProgram->id,

                'title' => $subProgram->name,

                'slug' => $subProgram->slug,

                'description' =>
                    $subProgram->description,

                'usia' => $subProgram->usia,

                'harga' => $subProgram->harga,

                'progress' => $progress,

                'total_materi' => $totalMateri,

                'materi_selesai' => $materiSelesai,

                'created_at' =>
                    $subProgram->created_at,
            ];
        });

        return response()->json($result);
    }
}
