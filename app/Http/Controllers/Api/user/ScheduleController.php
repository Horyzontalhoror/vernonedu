<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Peserta;

class ScheduleController extends Controller
{
    public function mySchedule(Request $request)
    {
        $user = $request->user();

        $peserta = Peserta::where('log_user_id', $user->id)->first();

        if (!$peserta) {
            return response()->json([]);
        }

        // 🔥 ambil jadwal hanya dari course yang diikuti
        $jadwals = \App\Models\Jadwal::whereHas('subProgram.pesertas', function ($q) use ($peserta) {
            $q->where('peserta_id', $peserta->id);
        })
        ->with('subProgram')
        ->get();

        return response()->json($jadwals);
    }
}
