<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LogUser;

use App\Notifications\AnnouncementNotification;

class Pengumuman extends Model
{
    protected $table =
        'pengumumen';

    protected $fillable = [

        'judul',

        'isi',

        'tanggal',

        'tipe',

        'status',

    ];

    protected $casts = [

        'tanggal' => 'date',

    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO NOTIFICATION
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        /*
        |--------------------------------------------------------------------------
        | CREATE
        |--------------------------------------------------------------------------
        */

        static::created(function (
            $pengumuman
        ) {

            if (
                $pengumuman->status !==
                'publish'
            ) {

                return;
            }

            static::sendNotification(
                $pengumuman
            );
        });

        /*
        |--------------------------------------------------------------------------
        | UPDATE DRAFT → PUBLISH
        |--------------------------------------------------------------------------
        */

        static::updated(function (
            $pengumuman
        ) {

            if (

                $pengumuman->wasChanged(
                    'status'
                )

                &&

                $pengumuman->status ===
                    'publish'

            ) {

                static::sendNotification(
                    $pengumuman
                );
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | SEND NOTIFICATION
    |--------------------------------------------------------------------------
    */

    protected static function sendNotification(
        $pengumuman
    ) {

        $users =
            LogUser::all();

        foreach (
            $users as $user
        ) {

            $user->notify(

                new AnnouncementNotification(
                    $pengumuman
                )

            );

        }
    }
}
