<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class NotificationController
    extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request
    ) {

        $notifications = $request

            ->user()

            ->notifications()

            ->latest()

            ->take(20)

            ->get()

            ->map(function ($notif) {

                return [

                    'id' =>
                        $notif->id,

                    'title' =>
                        $notif->data['title'] ?? '',

                    'message' =>
                        $notif->data['message'] ?? '',

                    'type' =>
                        $notif->data['type'] ?? 'default',

                    'read_at' =>
                        $notif->read_at,

                    'created_at' =>
                        $notif->created_at,

                ];
            });

        return response()->json(
            $notifications
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MARK AS READ
    |--------------------------------------------------------------------------
    */

    public function markAsRead(
        Request $request,
        $id
    ) {

        $notification = $request

            ->user()

            ->notifications()

            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([

            'message' => 'OK'

        ]);
    }
}
