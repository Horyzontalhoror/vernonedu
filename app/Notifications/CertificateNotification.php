<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CertificateNotification
    extends Notification
{
    use Queueable;

    public function __construct(
        public $certificate
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

            'title' =>

                'Sertifikat Tersedia',

            'message' =>

                'Sertifikat untuk kelas '

                . $this->certificate
                    ->subProgram
                    ?->name

                . ' sudah tersedia.',

            'type' =>

                'certificate',

            'certificate_id' =>

                $this->certificate->id,

        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject(
                'Sertifikat Tersedia'
            )

            ->greeting(
                'Halo ' .
                $notifiable->nama
            )

            ->line(
                'Sertifikat untuk kelas ' .
                $this->certificate->subProgram?->name .
                ' sudah tersedia.'
            )

            ->action(
                'Lihat Sertifikat',
                url('/dashboard/certificate')
            );
    }

}
