<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Peserta extends Model
{
    protected $fillable = [
        'log_user_id',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
    ];

    protected $with = ['logUser'];

    protected $appends = [
        'nama',
        'email',
        'no_telepon',
    ];

    public function logUser(): BelongsTo
    {
        return $this->belongsTo(LogUser::class);
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
