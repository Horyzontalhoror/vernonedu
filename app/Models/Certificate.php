<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;
use App\Models\SubProgram;

class Certificate extends Model
{
    //
    protected $fillable = [
        'peserta_id',
        'sub_program_id',
        'file_path',
        'file_url',
        'status',
        'issued_at',
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
