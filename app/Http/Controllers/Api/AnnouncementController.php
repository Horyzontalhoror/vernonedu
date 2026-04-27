<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class AnnouncementController extends Controller
{
    public function index()
    {
        $data = Pengumuman::where('status', 'publish')
            ->orderBy('tanggal', 'desc')
            ->get();

        return response()->json($data);
    }
}
