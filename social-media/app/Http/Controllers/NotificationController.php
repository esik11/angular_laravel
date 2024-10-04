<?php

// NotificationController.php
namespace App\Http\Controllers;

use App\Models\Notification; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Fire the NotificationSent event (you should implement this)
        event(new NotificationSent($notification));
        
        return response()->json(['message' => 'Notification sent!']);
    }
}
