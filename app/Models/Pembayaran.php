<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = [
        'peserta_id',
        'sub_program_id',
        'jumlah',
        'status',
        'tanggal',
        'metode'
    ];
    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }
}
