<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementNotification
    extends Notification
{
    use Queueable;

    public function __construct(
        public $pengumuman
    ) {}

    public function via($notifiable)
    {
        return [

            'database',

            'mail',

        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject(
                'Pengumuman'
            )

            ->line(
                'Pengumuman terbaru.'
            );
    }

    public function toDatabase($notifiable)
    {
        return [

            'title' =>

                $this->pengumuman
                    ->judul,

            'message' =>

                $this->pengumuman
                    ->isi,

            'type' =>

                'announcement',

            'announcement_id' =>

                $this->pengumuman
                    ->id,

            'action_url' =>

                '/dashboard/announcement',

        ];
    }
}
