<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $fillable = [
        'sub_program_id',
        'judul',
        'deskripsi',
        'urutan',
    ];

    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    /*
    |--------------------------------------------------------------------------
    | PROGRESS PESERTA
    |--------------------------------------------------------------------------
    */

    public function pesertas()
    {
        return $this->belongsToMany( Peserta::class, 'progresses', 'materi_id', 'peserta_id' )
        ->withPivot([
            'status',
            'tanggal',
        ])
        ->withTimestamps();
    }
}
