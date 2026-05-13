<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Carbon\Carbon;

class JadwalAvailableNotification extends Notification
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
            'title' => 'Jadwal kelas tersedia',

            'message' =>
                'Jadwal untuk kelas ' .
                $this->jadwal->subProgram?->name .
                ' sudah tersedia pada ' .
                Carbon::parse($this->jadwal->tanggal)
                    ->format('d M Y'),

            'type' => 'jadwal',

            'jadwal_id' => $this->jadwal->id,

            'action_url' => '/dashboard/calendar',
        ];
    }
}
