<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalController extends Controller
{
    // GET /api/jadwals
    public function index(Request $request)
    {
        $query = Jadwal::with([
            'subProgram:id,name',
            'instruktur:id,nama'
        ]);

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $jadwals = $query
            ->orderBy('tanggal')
            ->orderBy('waktu_mulai')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'tanggal' => Carbon::parse($item->tanggal)->format('Y-m-d'),
                    'waktu_mulai' => $item->waktu_mulai,
                    'waktu_selesai' => $item->waktu_selesai,
                    'lokasi' => $item->lokasi,
                    'status' => $item->status,
                    'keterangan' => $item->keterangan,
                    'sub_program' => [
                        'id' => $item->subProgram?->id,
                        'name' => $item->subProgram?->name,
                    ],
                    'instruktur' => [
                        'id' => $item->instruktur?->id,
                        'nama' => $item->instruktur?->nama,
                    ],
                ];
            });

        return response()->json($jadwals);
    }

    // GET /api/jadwals/calendar
    public function calendar()
    {
        $events = Jadwal::with(['subProgram:id,name'])
            ->get()
            ->map(function ($item) {

                $tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');

                return [
                    'id' => $item->id,
                    'title' => $item->subProgram?->name ?? 'Kelas',
                    'start' => $tanggal . 'T' . $item->waktu_mulai,
                    'end' => $tanggal . 'T' . $item->waktu_selesai,
                    'extendedProps' => [
                        'status' => $item->status,
                        'lokasi' => $item->lokasi,
                        'tanggal' => $tanggal,
                    ],
                ];
            });

        return response()->json($events);
    }
}
