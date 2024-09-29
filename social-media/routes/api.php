<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController; // Add this line

// Protected routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    // Get all posts
    Route::get('/posts', [PostController::class, 'index']);

    // Create a new post
    Route::post('/posts', [PostController::class, 'store']);

    // Edit a post
    Route::put('/posts/{post}', [PostController::class, 'update']);

    // Like a post
    Route::post('/posts/{post}/like', [PostController::class, 'like']);

    // Add a comment to a post
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);

    // User profile routes
Route::get('/profile', [ProfileController::class, 'show']); // Fetch user profile
Route::put('/profile', [ProfileController::class, 'update']); // Update user profile

    
    // Get current logged-in user
    Route::get('/user', [UserController::class, 'getUser']); // Add this line
});
