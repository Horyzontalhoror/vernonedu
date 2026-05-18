<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class PaymentSuccessNotification
    extends Notification
{
    use Queueable;

    public function __construct(
        public $transaction
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
                'Pembayaran Berhasil',

            'message' =>

                'Pembayaran untuk kelas ' .
                $this->transaction->subProgram?->name .
                ' berhasil dikonfirmasi. Kelas sudah tersedia di menu My Course.',

            'type' =>
                'payment',

            'transaction_id' =>
                $this->transaction->id,

        ];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject(
                'Pembayaran Berhasil'
            )

            ->greeting(
                'Halo ' .
                $notifiable->nama
            )

            ->line(
                'Pembayaran untuk kelas ' .
                $this->transaction->subProgram?->name .
                ' berhasil dikonfirmasi.'
            )

            ->action(
                'Lihat Course',
                url('/dashboard')
            );
    }

}
