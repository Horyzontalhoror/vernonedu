<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
        'tipe',
        'status'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // 🔥 auto filter hanya publish
    protected static function booted()
    {
        static::addGlobalScope('publish', function ($query) {
            $query->where('status', 'publish');
        });
    }
}
