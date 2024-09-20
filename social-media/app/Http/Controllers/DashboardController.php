<?php

// In app/Http/Controllers/DashboardController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch all posts, eager load the user relationship
        $posts = Post::with('user')->latest()->get();

        return view('dashboard', compact('posts'));
    }
}

