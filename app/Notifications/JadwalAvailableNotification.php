<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Contracts\Queue\ShouldQueue;

use Illuminate\Notifications\Notification;

class JadwalAvailableNotification
    extends Notification
    // implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public $jadwal
    ) {}

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [

            'title' =>

                'Jadwal kelas tersedia',

            'message' =>

                'Jadwal untuk kelas ' .

                $this->jadwal
                    ->subProgram
                    ?->name .

                ' sudah tersedia pada ' .

                $this->jadwal
                    ->tanggal
                    ?->format('d M Y'),

            'type' =>

                'jadwal',

            'jadwal_id' =>

                $this->jadwal->id,

            'action_url' =>

                '/dashboard/calendar',

        ];
    }
}
