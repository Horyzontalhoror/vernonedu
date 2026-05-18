<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Carbon\Carbon;

class JadwalAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(
        public $jadwal
    ) {}

    public function via($notifiable)
    {
        return [

            'database',

            'mail',

        ];
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


    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject(
                'Jadwal Kelas Tersedia'
            )

            ->greeting(
                'Halo ' .
                $notifiable->nama
            )

            ->line(
                'Jadwal untuk kelas ' .
                $this->jadwal->subProgram?->name .
                ' sudah tersedia.'
            )

            ->action(
                'Lihat Jadwal',
                url('/dashboard/calendar')
            );
    }

}
