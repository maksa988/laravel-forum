<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserNotificationsController extends Controller
{
    /**
     * UserNotificationsController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        return auth()->user()->unreadNotifications;
    }

    /**
     * @param User $user
     * @param $notificationId
     * @return false|string
     */
    public function destroy(User $user, $notificationId)
    {
        $notification = auth()->user()->notifications()->findOrFail($notificationId);

        $notification->markAsRead();

        return json_encode(
            $notification->data
        );
    }
}
