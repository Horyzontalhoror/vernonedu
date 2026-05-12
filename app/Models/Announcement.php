<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\LogUser;

use App\Notifications\AnnouncementNotification;

class Announcement extends Model
{
    protected $fillable = [

        'title',

        'message',

        'highlight',

    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO NOTIFICATION
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::created(function (
            $announcement
        ) {

            $users =
                LogUser::all();

            foreach (
                $users as $user
            ) {

                $user->notify(

                    new AnnouncementNotification(
                        $announcement
                    )

                );
            }
        });
    }
}
