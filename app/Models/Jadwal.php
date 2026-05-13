<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    //
    protected $fillable = [
        'sub_program_id',
        'instruktur_id',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'lokasi',
        'status',
        'keterangan'
    ];
    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class);
    }
}
