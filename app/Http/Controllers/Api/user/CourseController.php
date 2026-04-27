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

        // ambil peserta dari user login
        $peserta = Peserta::where('log_user_id', $user->id)->first();

        if (!$peserta) {
            return response()->json([]);
        }

        // ambil kelas yang diikuti
        $subPrograms = $peserta->subPrograms()->with('materis')->get();

        $result = $subPrograms->map(function ($subProgram) use ($peserta) {

            // total materi
            $total = $subProgram->materis->count();

            // materi selesai
            $selesai = $peserta->materis()
                ->where('sub_program_id', $subProgram->id)
                ->wherePivot('status', 'selesai')
                ->count();

            $progress = $total > 0
                ? round(($selesai / $total) * 100)
                : 0;

            return [
                'title' => $subProgram->name,
                'progress' => $progress,
            ];
        });

        return response()->json($result);
    }
}
