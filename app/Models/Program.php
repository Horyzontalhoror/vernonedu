<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    protected $fillable = [
        'nama',
        'deskripsi',
        'image_url'
    ];
    public function subPrograms()
    {
        return $this->hasMany(SubProgram::class);
    }

    protected static function boot()
    {
        parent::boot();

        // Hapus cache program dan subprogram ketika data Program disimpan atau dihapus
        static::saved(function () {
            \Illuminate\Support\Facades\Cache::forget('programs_with_subprograms');
        });

        static::deleted(function () {
            \Illuminate\Support\Facades\Cache::forget('programs_with_subprograms');
        });
    }
}
