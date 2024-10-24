<?php

// NotificationController.php
namespace App\Http\Controllers;

use App\Models\Notification; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
class NotificationController extends Controller
{
    // Fetch notifications for the logged-in user
    public function fetchNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())->get();
        return response()->json($notifications);
    }

    // Clear notifications for the logged-in user
    public function clearNotifications()
    {
        Notification::where('user_id', Auth::id())->delete();
        return response()->json(['message' => 'Notifications cleared']);
    }

    // Send a new notification
    public function sendNotification(Request $request)
    {
        // Ensure to validate the request
        $request->validate([
            'user_id' => 'required|exists:users,id', // Check if user exists
            'post_id' => 'nullable|exists:posts,id', // Check if post exists
            'type' => 'required|string',
            'data' => 'required|string', // Notification data
        ]);

        // Create the notification
        $notification = Notification::create([
            'user_id' => $request->user_id,
            'post_id' => $request->post_id,
            'type' => $request->type,
            'is_read' => false,
            'data' => $request->data,
        ]);
        $options = array(
            'cluster' => 'ap1',
            'useTLS' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $data = ['from' => $request->user_id, 'data' => $request->data];  // Including more data
        $pusher->trigger('my-channel', 'my-event', $data);


        // Fire the NotificationSent event (you should implement this)
        event(new NotificationSent($notification));
        
        return response()->json(['message' => 'Notification sent!']);
    }
    public function markAsRead($id)
{
    $notification = Notification::where('id', $id)->where('user_id', Auth::id())->first();
    if ($notification) {
        $notification->is_read = true;
        $notification->save();
    }
    return response()->json(['message' => 'Notification marked as read']);
}
}
