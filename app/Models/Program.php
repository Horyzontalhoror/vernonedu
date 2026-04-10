<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
    ];
    public function subPrograms()
    {
        return $this->hasMany(SubProgram::class);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            $slug = Str::slug($program->nama);
            $count = \App\Models\Program::where('slug', 'LIKE', "$slug%")->count();

            $program->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }
}
