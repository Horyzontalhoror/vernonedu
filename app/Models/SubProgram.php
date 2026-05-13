<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubProgram extends Model
{
    /*
    |--------------------------------------------------------------------------
    | FILLABLE
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'program_id',
        'name',
        'slug',
        'description',
        'usia',
        'harga',
        'image_url',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function program(): BelongsTo
    {
        return $this->belongsTo(
            Program::class
        );
    }

    public function pesertas(): BelongsToMany
    {
        return $this->belongsToMany(
            Peserta::class,
            'enrollments'
        )->withTimestamps();
    }

    public function materis(): HasMany
    {
        return $this->hasMany(
            Materi::class
        );
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(
            Certificate::class
        );
    }

    public function jadwals()
    {
        return $this->hasMany(
            Jadwal::class
        );
    }
}
