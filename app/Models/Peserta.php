<?php

namespace App\Models;

use App\Models\Materi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class Peserta extends Model
{
    // =========================
    // 🔥 FIELD YANG BOLEH DIISI
    // =========================
    protected $fillable = [
        'log_user_id',
        'user_id',           // optional (kalau masih dipakai)
        'sub_program_id',    // 🔥 WAJIB (fix utama)
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
    // 🔥 GUARD (ANTI DATA KOSONG)
    // =========================
    protected static function booted()
    {
        static::creating(function ($model) {

            if (!$model->log_user_id || !$model->sub_program_id) {
                throw new \Exception('Peserta harus punya log_user_id & sub_program_id');
            }

            // debug siapa yang create (opsional, bisa dihapus nanti)
            Log::info('CREATE PESERTA', [
                'data' => $model->toArray(),
            ]);
        });
    }

    // =========================
    // RELASI
    // =========================

    public function logUser(): BelongsTo
    {
        return $this->belongsTo(LogUser::class, 'log_user_id');
    }

    public function subProgram(): BelongsTo
    {
        return $this->belongsTo(SubProgram::class);
    }

    public function subPrograms(): BelongsToMany
    {
        return $this->belongsToMany(SubProgram::class, 'enrollments')
            ->withTimestamps();
    }

    public function materis(): BelongsToMany
    {
        return $this->belongsToMany(Materi::class, 'progresses')
            ->withPivot('status', 'tanggal')
            ->withTimestamps();
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    // =========================
    // 🔥 ACCESSOR
    // =========================

    public function getNamaAttribute(): ?string
    {
        return $this->logUser->nama ?? null;
    }

    public function getEmailAttribute(): ?string
    {
        return $this->logUser?->email;
    }

    public function getNoTeleponAttribute(): ?string
    {
        return $this->logUser->no_telepon ?? null;
    }

    // =========================
    // 🔥 PROGRESS
    // =========================

    public function getProgressBySubProgram($subProgramId)
    {
        $total = Materi::where('sub_program_id', $subProgramId)->count();

        $selesai = $this->materis()
            ->where('sub_program_id', $subProgramId)
            ->wherePivot('status', 'selesai')
            ->count();

        return $total > 0 ? round(($selesai / $total) * 100) : 0;
    }

    public function isSubProgramCompleted($subProgramId)
    {
        $total = Materi::where('sub_program_id', $subProgramId)->count();

        $selesai = $this->materis()
            ->where('sub_program_id', $subProgramId)
            ->wherePivot('status', 'selesai')
            ->count();

        return $total > 0 && $total === $selesai;
    }
}
