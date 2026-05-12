<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Peserta;

class LogUser extends Model
{
    use HasFactory;
    use HasApiTokens;
    use Notifiable;

    protected $fillable = [
        'nama',
        'email',
        'no_telepon',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    // protected static function booted(): void
    // {
    //     static::created(function (LogUser $logUser) {
    //         $logUser->syncPesertaFromStatus();
    //     });

    //     static::updated(function (LogUser $logUser) {
    //         if ($logUser->isDirty('status')) {
    //             $logUser->syncPesertaFromStatus();
    //         }
    //     });
    // }

    protected function syncPesertaFromStatus(): void
    {
        if ($this->status === 'pending') {
            Peserta::firstOrCreate(
                ['log_user_id' => $this->id],
                [
                    'email' => null,
                    'jenis_kelamin' => null,
                    'tanggal_lahir' => null,
                    'alamat' => null,
                ]
            );
        }
    }

    public function peserta(): HasOne
    {
        return $this->hasOne(Peserta::class);
    }
}
