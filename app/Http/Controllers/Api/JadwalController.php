<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * 🔹 Endpoint: /api/jadwals
     * Digunakan untuk ScheduleList (data lengkap + filter tanggal)
     */
    public function index(Request $request)
    {
        $query = Jadwal::with([
            'subProgram:id,name',
            'instruktur:id,nama'
        ]);

        // Filter berdasarkan tanggal (optional)
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        // Optional: urutkan
        $query->orderBy('tanggal')
              ->orderBy('waktu_mulai');

        return response()->json($query->get());
    }

    /**
     * 🔹 Endpoint: /api/jadwals/calendar
     * Digunakan untuk FullCalendar
     */
    public function calendar()
    {
        $jadwals = Jadwal::with(['subProgram:id,name'])->get();

        $events = $jadwals->map(function ($item) {
            return [
                'id' => $item->id,

                // Judul event
                'title' => $item->subProgram->name ?? 'Kelas',

                // Format wajib FullCalendar
                'start' => $item->tanggal . 'T' . $item->waktu_mulai,
                'end' => $item->tanggal . 'T' . $item->waktu_selesai,

                // Data tambahan untuk React
                'extendedProps' => [
                    'status' => $item->status,
                    'lokasi' => $item->lokasi,
                    'tanggal' => $item->tanggal,
                ],
            ];
        });

        return response()->json($events);
    }
}
