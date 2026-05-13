<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LogUser;
use App\Models\SubProgram;
use App\Models\Peserta;

use App\Notifications\PaymentSuccessNotification;
use App\Notifications\JadwalAvailableNotification;

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

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            LogUser::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SUB PROGRAM
    |--------------------------------------------------------------------------
    */

    public function subProgram()
    {
        return $this->belongsTo(
            SubProgram::class
        );
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER NAMA
    |--------------------------------------------------------------------------
    */

    public function getNamaAttribute()
    {
        return $this->user?->nama ?? '-';
    }

    /*
    |--------------------------------------------------------------------------
    | AUTO PROCESS
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::updated(function (
            $transaction
        ) {

            /*
            |--------------------------------------------------------------------------
            | STATUS BERHASIL
            |--------------------------------------------------------------------------
            */

            if (

                $transaction->wasChanged(
                    'transaction_status'
                )

                &&

                in_array(
                    $transaction->transaction_status,
                    [
                        'settlement',
                        'capture',
                    ]
                )

                &&

                ! in_array(
                    $transaction->getOriginal(
                        'transaction_status'
                    ),
                    [
                        'settlement',
                        'capture',
                    ]
                )

            ) {

                /*
                |--------------------------------------------------------------------------
                | USER
                |--------------------------------------------------------------------------
                */

                $user =
                    $transaction->user;

                if (! $user) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | PESERTA
                |--------------------------------------------------------------------------
                */

                $peserta =
                    Peserta::firstOrCreate(

                        [
                            'log_user_id' =>
                                $transaction->user_id,
                        ],

                        [
                            'status' =>
                                'active',
                        ]

                    );

                /*
                |--------------------------------------------------------------------------
                | ENROLL COURSE
                |--------------------------------------------------------------------------
                */

                $peserta
                    ->subPrograms()
                    ->syncWithoutDetaching([

                        $transaction
                            ->sub_program_id

                    ]);

                /*
                |--------------------------------------------------------------------------
                | EXISTING SCHEDULE
                |--------------------------------------------------------------------------
                */

                $jadwals =
                    \App\Models\Jadwal::where(

                        'sub_program_id',

                        $transaction
                            ->sub_program_id

                    )

                    ->get();

                foreach (
                    $jadwals as $jadwal
                ) {

                    $user->notify(

                        new JadwalAvailableNotification(
                            $jadwal
                        )

                    );
                }

                /*
                |--------------------------------------------------------------------------
                | SUB PROGRAM
                |--------------------------------------------------------------------------
                */

                $subProgram =
                    SubProgram::with([
                        'materis'
                    ])

                    ->find(
                        $transaction
                            ->sub_program_id
                    );

                if (! $subProgram) {
                    return;
                }

                /*
                |--------------------------------------------------------------------------
                | AUTO CREATE PROGRESS
                |--------------------------------------------------------------------------
                */

                foreach (
                    $subProgram->materis
                    as $materi
                ) {

                    if (

                        ! $peserta

                            ->materis()

                            ->where(
                                'materi_id',
                                $materi->id
                            )

                            ->exists()

                    ) {

                        $peserta
                            ->materis()
                            ->attach(

                                $materi->id,

                                [

                                    'status' =>
                                        'proses',

                                    'tanggal' =>
                                        now(),

                                ]

                            );
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | PAYMENT NOTIFICATION
                |--------------------------------------------------------------------------
                */

                $user->notify(

                    new PaymentSuccessNotification(
                        $transaction
                    )

                );

                /*
                |--------------------------------------------------------------------------
                | LAST NOTIFICATION
                |--------------------------------------------------------------------------
                */

                $notification =

                    $user

                        ->notifications()

                        ->latest()

                        ->first();

                /*
                |--------------------------------------------------------------------------
                | REALTIME EVENT
                |--------------------------------------------------------------------------
                */

                if ($notification) {

                    event(

                        new NewNotificationEvent(

                            $notification,

                            $user->id

                        )

                    );
                }
            }
        });
    }
}
