<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Certificate extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'certificates';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'peserta_id',

        'sub_program_id',

        'file_path',

        'file_url',

        'status',

        'issued_at',

    ];

    /*
    |--------------------------------------------------------------------------
    | CASTS
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'issued_at' => 'datetime',

    ];

    /*
    |--------------------------------------------------------------------------
    | DEFAULT ATTRIBUTE
    |--------------------------------------------------------------------------
    */

    protected $attributes = [

        'status' => 'draft',

    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function peserta(): BelongsTo
    {
        return $this->belongsTo(
            Peserta::class
        );
    }

    public function subProgram(): BelongsTo
    {
        return $this->belongsTo(
            SubProgram::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getCertificateUrlAttribute(): ?string
    {
        return $this->file_url
            ?: ($this->file_path
                ? asset('storage/' . $this->file_path)
                : null);
    }
}
