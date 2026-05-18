<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;

use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Messages\MailMessage;

class AdminValidationNotification
    extends Notification
{
    use Queueable;

    public function __construct(

        public string $title,

        public string $message,

        public string $url = '/admin',

    ) {}

    /*
    |--------------------------------------------------------------------------
    | CHANNEL
    |--------------------------------------------------------------------------
    */

    public function via($notifiable)
    {
        return [

            'database',

            'mail',

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | DATABASE
    |--------------------------------------------------------------------------
    */

    public function toDatabase($notifiable)
    {
        return [

            'title' =>

                $this->title,

            'message' =>

                $this->message,

            'type' =>

                'admin',

            'action_url' =>

                $this->url,

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | MAIL
    |--------------------------------------------------------------------------
    */

    public function toMail($notifiable)
    {
        return (new MailMessage)

            ->subject(
                $this->title
            )

            ->greeting(
                'Halo Admin'
            )

            ->line(
                $this->message
            )

            ->action(
                'Buka Dashboard',
                url($this->url)
            );
    }
}
