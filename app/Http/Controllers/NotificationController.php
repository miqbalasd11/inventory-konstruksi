<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where(
            'user_id',
            Auth::id()
        )
        ->latest()
        ->get();

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    public function read($id)
    {
        $notif = Notification::findOrFail($id);

        if ($notif->user_id == Auth::id()) {

            $notif->update([
                'is_read' => true
            ]);
        }

        return back();
    }
}