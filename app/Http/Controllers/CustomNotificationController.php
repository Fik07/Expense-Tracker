<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomNotification;
use Illuminate\Support\Facades\Auth;

class CustomNotificationController extends Controller
{
    public function index()
    {
        $notifications = CustomNotification::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('notification', compact('notifications'));
    }

    public function markAsRead($id)
    {
        $notification = CustomNotification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->update(['is_read' => true]);

        return redirect()->back()->with('status', 'Notification marked as read.');
    }
}
