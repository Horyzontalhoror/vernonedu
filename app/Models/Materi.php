<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubProgram;

class Materi extends Model
{
    protected $fillable = [
        'sub_program_id',
        'judul',
        'deskripsi',
        'urutan'
    ];
    public function pesertas()
    {
        return $this->belongsToMany(Peserta::class, 'progresses')
            ->withPivot('status', 'tanggal')
            ->withTimestamps();
    }
    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

}
