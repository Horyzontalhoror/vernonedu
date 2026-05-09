<?php

namespace App\Models;

use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    // =========================
    // FIELD
    // =========================
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

    // auto eager load
    protected $with = ['logUser'];

    // accessor otomatis
    protected $appends = [
        'nama',
        'email',
        'no_telepon',
    ];

    // =========================
    // GUARD
    // =========================
    protected static function booted()
    {
        static::creating(function ($model) {

            if (!$model->log_user_id) {

                throw new \Exception(
                    'Peserta harus punya log_user_id'
                );

            }
        });
    }

    // =========================
    // RELASI
    // =========================

    public function logUser(): BelongsTo
    {
        return $this->belongsTo(
            LogUser::class,
            'log_user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MANY TO MANY COURSE
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
    | PROGRESS MATERI
    |--------------------------------------------------------------------------
    */

    public function materis(): BelongsToMany
    {
        return $this->belongsToMany(
            Materi::class,
            'progresses'
        )
        ->withPivot('status', 'tanggal')
        ->withTimestamps();
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    // =========================
    // ACCESSOR
    // =========================

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

    // =========================
    // PROGRESS
    // =========================

    public function getProgressBySubProgram($subProgramId)
    {
        $total = Materi::where(
            'sub_program_id',
            $subProgramId
        )->count();

        $selesai = $this->materis()
            ->where(
                'sub_program_id',
                $subProgramId
            )
            ->wherePivot(
                'status',
                'selesai'
            )
            ->count();

        return $total > 0
            ? round(($selesai / $total) * 100)
            : 0;
    }

    public function isSubProgramCompleted($subProgramId)
    {
        $total = Materi::where(
            'sub_program_id',
            $subProgramId
        )->count();

        $selesai = $this->materis()
            ->where(
                'sub_program_id',
                $subProgramId
            )
            ->wherePivot(
                'status',
                'selesai'
            )
            ->count();

        return $total > 0 &&
               $total === $selesai;
    }
}
