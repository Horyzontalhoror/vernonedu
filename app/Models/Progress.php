<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    protected $table = 'progresses';

    protected $fillable = [
        'peserta_id',
        'materi_id',
        'status',
        'tanggal',
    ];

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }
}
