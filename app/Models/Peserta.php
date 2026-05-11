<?php

namespace App\Models;

use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    /*
    |--------------------------------------------------------------------------
    | FIELD
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'log_user_id',
        'status',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO LOAD
    |--------------------------------------------------------------------------
    */

    protected $with = [
        'logUser',
    ];

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR APPEND
    |--------------------------------------------------------------------------
    */

    protected $appends = [
        'nama',
        'email',
        'no_telepon',
    ];

    /*
    |--------------------------------------------------------------------------
    | GUARD
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::creating(function ($model) {

            if (! $model->log_user_id) {

                throw new \Exception(
                    'Peserta harus punya log_user_id'
                );

            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : USER
    |--------------------------------------------------------------------------
    */

    public function logUser(): BelongsTo
    {
        return $this->belongsTo(
            LogUser::class,
            'log_user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : COURSE
    |--------------------------------------------------------------------------
    */

    public function subPrograms(): BelongsToMany
    {
        return $this->belongsToMany(
            SubProgram::class,
            'enrollments'
        )->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : PROGRESS MATERI
    |--------------------------------------------------------------------------
    */

    public function materis(): BelongsToMany
    {
        return $this->belongsToMany(
            Materi::class,
            'progresses',
            'peserta_id',
            'materi_id'
        )
        ->withPivot([
            'status',
            'tanggal',
        ])
        ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION : CERTIFICATE
    |--------------------------------------------------------------------------
    */

    public function certificates(): HasMany
    {
        return $this->hasMany(
            Certificate::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getNamaAttribute(): ?string
    {
        return $this->logUser?->nama;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->logUser?->email;
    }

    public function getNoTeleponAttribute(): ?string
    {
        return $this->logUser?->no_telepon;
    }

    /*
    |--------------------------------------------------------------------------
    | HITUNG PROGRESS COURSE
    |--------------------------------------------------------------------------
    */

    public function getProgressBySubProgram(
        $subProgramId
    ) {

        $totalMateri = Materi::where(
            'sub_program_id',
            $subProgramId
        )->count();

        if ($totalMateri === 0) {

            return 0;

        }

        $materiSelesai = $this->materis()

            ->whereHas(
                'subProgram',
                fn ($q) =>
                    $q->where(
                        'id',
                        $subProgramId
                    )
            )

            ->wherePivot(
                'status',
                'selesai'
            )

            ->count();

        return round(
            ($materiSelesai / $totalMateri) * 100
        );
    }

    /*
    |--------------------------------------------------------------------------
    | COURSE COMPLETED
    |--------------------------------------------------------------------------
    */

    public function isSubProgramCompleted(
        $subProgramId
    ) {

        return $this->getProgressBySubProgram(
            $subProgramId
        ) >= 100;
    }
}
