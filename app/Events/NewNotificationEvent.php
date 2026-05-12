<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;

use Illuminate\Broadcasting\InteractsWithSockets;

use Illuminate\Broadcasting\PrivateChannel;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

use Illuminate\Foundation\Events\Dispatchable;

use Illuminate\Queue\SerializesModels;

class NewNotificationEvent
    implements ShouldBroadcastNow
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public function __construct(
        public $notification,
        public $userId
    ) {}

    /*
    |--------------------------------------------------------------------------
    | CHANNEL
    |--------------------------------------------------------------------------
    */

    public function broadcastOn(): array
    {
        return [

            new Channel(
                'notifications.' .
                $this->userId
            ),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | EVENT NAME
    |--------------------------------------------------------------------------
    */

    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    /*
    |--------------------------------------------------------------------------
    | DATA
    |--------------------------------------------------------------------------
    */

    public function broadcastWith(): array
    {
        return [

            'id' =>
                $this->notification->id,

            'title' =>
                $this->notification->data['title'],

            'message' =>
                $this->notification->data['message'],

            'type' =>
                $this->notification->data['type'],

            'created_at' =>
                $this->notification->created_at,

        ];
    }
}
