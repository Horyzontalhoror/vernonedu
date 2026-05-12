<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\LogUser;
use App\Models\SubProgram;
use App\Models\Peserta;
use App\Notifications\PaymentSuccessNotification;
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

    // 🔥 user dari log_users
    public function user()
    {
        return $this->belongsTo(LogUser::class, 'user_id');
    }

    // 🔥 relasi ke program
    public function subProgram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    // 🔥 helper nama
    public function getNamaAttribute()
    {
        return $this->user?->nama ?? '-';
    }

    protected static function booted()
    {
        static::updated(function ($transaction) {

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

            )
            {

                /*
                |--------------------------------------------------------------------------
                | PESERTA
                |--------------------------------------------------------------------------
                */

                $peserta = Peserta::firstOrCreate( [ 'log_user_id' => $transaction->user_id, ], [ 'status' => 'active', ] );

                /*
                |--------------------------------------------------------------------------
                | ENROLL COURSE
                |--------------------------------------------------------------------------
                */

                $peserta ->subPrograms() ->syncWithoutDetaching([ $transaction->sub_program_id ]);

                /*
                |--------------------------------------------------------------------------
                | SUB PROGRAM
                |--------------------------------------------------------------------------
                */

                $subProgram = SubProgram::with([ 'materis' ])->find( $transaction->sub_program_id ); if (! $subProgram) { return; }

                /*
                |--------------------------------------------------------------------------
                | AUTO CREATE PROGRESS
                |--------------------------------------------------------------------------
                */

                foreach ( $subProgram->materis as $materi ) {

                    if ( ! $peserta ->materis() ->where( 'materi_id', $materi->id ) ->exists() )
                        {

                        $peserta ->materis() ->attach( $materi->id, [ 'status' => 'proses', 'tanggal' => now(), ] );
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | NOTIFICATION
                |--------------------------------------------------------------------------
                */

                $transaction->user->notify(

                    new PaymentSuccessNotification(
                        $transaction
                    )

                );

                $notification = $user

                    ->notifications()

                    ->latest()

                    ->first();

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
