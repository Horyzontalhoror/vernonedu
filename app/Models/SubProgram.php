<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubProgram extends Model
{
    //filable
    protected $fillable = [
        'program_id',
        'name',
        'slug',
        'description',
        'usia',
        'slug',
    ];
    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function pesertas()
    {
        return $this->belongsToMany(Peserta::class, 'enrollments')
            ->withTimestamps();
    }
    public function materis()
    {
        return $this->hasMany(Materi::class);
    }
    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }
}
