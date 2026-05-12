<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CertificateNotification
    extends Notification
{
    use Queueable;

    public function __construct(
        public $certificate
    ) {}

    public function via($notifiable)
    {
        return ['database'];
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
}
