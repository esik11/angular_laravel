<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Notification extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',  // User who the notification belongs to
        'post_id',  // Optional post associated with the notification
        'type',     // Type of notification (e.g., 'post', 'like', 'comment')
        'is_read',  // Indicates whether the notification has been read
        'data',     // Additional data for the notification
    ];
}
