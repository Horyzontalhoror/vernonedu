<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Peserta;
use App\Models\SubProgram;
use App\Models\LogUser;
use App\Models\Transaction;

class Pembayaran extends Model
{
    protected $fillable = [
        'peserta_id',
        'sub_program_id',
        'jumlah',
        'status',
        'tanggal',
        'metode',
        'keterangan'
    ];

    // =========================
    // RELATIONS
    // =========================

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    public function logUser()
    {
        return $this->hasOneThrough(
            LogUser::class,
            Peserta::class,
            'id',
            'id',
            'peserta_id',
            'log_user_id'
        );
    }

    // =========================
    // 🔥 RELASI KE TRANSACTION (LEBIH AMAN)
    // =========================

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'sub_program_id', 'sub_program_id');
    }

    public function getLatestTransactionAttribute()
    {
        $userId = $this->peserta?->log_user_id;

        if (!$userId) {
            return null;
        }

        return $this->transactions()
            ->where('user_id', $userId)
            ->latest()
            ->first();
    }

    // =========================
    // 🔥 ACCESSOR (UNTUK FILAMENT)
    // =========================

    public function getMetodeAttribute()
    {
        return $this->latestTransaction?->payment_type ?? '-';
    }

    public function getStatusAttribute()
    {
        return $this->latestTransaction?->transaction_status ?? 'pending';
    }

    public function getJumlahAttribute()
    {
        return $this->latestTransaction?->amount ?? 0;
    }

    public function getTanggalAttribute()
    {
        return $this->latestTransaction?->created_at ?? null;
    }
}
