<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LogUser;
use App\Models\SubProgram;
use App\Models\Peserta;
use App\Models\Jadwal;
use App\Models\User;

use App\Notifications\PaymentSuccessNotification;
use App\Notifications\JadwalAvailableNotification;
use App\Notifications\AdminValidationNotification;

use App\Events\NewNotificationEvent;

class Transaction extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'snap_token',
        'payment_type',
        'transaction_status',
        'user_id',
        'sub_program_id',
    ];

    //user
    public function user()
    {
        return $this->belongsTo(LogUser::class, 'user_id');
    }

    //sub program
    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    //helper nama
    public function getNamaAttribute()
    {
        return $this->user?->nama ?? '-';
    }

    //auto process
    protected static function booted()
    {
        //notif admin pembayaran baru
        static::created(function ($transaction) {

            $admins = User::all();

            foreach ($admins as $admin) {

                $admin->notify(

                    new AdminValidationNotification(

                        title: 'Pembayaran Baru',

                        message:
                            'Peserta ' .
                            $transaction->user?->nama .
                            ' melakukan pembayaran kelas ' .
                            $transaction->subProgram?->name .
                            '.',

                        url: '/admin/transactions'

                    )

                );
            }
        });

        //payment success
        static::updated(function ($transaction) {

            //cek status
            if (
                ! $transaction->wasChanged('transaction_status') ||
                ! in_array($transaction->transaction_status, ['settlement', 'capture']) ||
                in_array($transaction->getOriginal('transaction_status'), ['settlement', 'capture'])
            ) {
                return;
            }

            //user
            $user = $transaction->user;

            if (! $user) {
                return;
            }

            //peserta
            $peserta = Peserta::firstOrCreate(
                [
                    'log_user_id' => $transaction->user_id,
                ],
                [
                    'status' => 'active',
                ]
            );

            //enroll
            $peserta->subPrograms()->syncWithoutDetaching([
                $transaction->sub_program_id
            ]);

            //jadwal
            $jadwals = Jadwal::where(
                'sub_program_id',
                $transaction->sub_program_id
            )->get();

            //notif jadwal sekali saja
            if ($jadwals->count() > 0) {

                $user->notify(
                    new JadwalAvailableNotification(
                        $jadwals->first()
                    )
                );
            }

            //sub program
            $subProgram = SubProgram::with('materis')->find(
                $transaction->sub_program_id
            );

            if (! $subProgram) {
                return;
            }

            //progress
            foreach ($subProgram->materis as $materi) {

                $exists = $peserta
                    ->materis()
                    ->where('materi_id', $materi->id)
                    ->exists();

                if (! $exists) {

                    $peserta->materis()->attach(
                        $materi->id,
                        [
                            'status' => 'proses',
                            'tanggal' => now(),
                        ]
                    );
                }
            }

            //notif payment
            $user->notify(
                new PaymentSuccessNotification($transaction)
            );

            //last notif
            $notification = $user
                ->notifications()
                ->latest()
                ->first();

            //realtime
            if ($notification) {

                event(
                    new NewNotificationEvent(
                        $notification,
                        $user->id
                    )
                );
            }
        });
    }
}
