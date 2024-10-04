<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    // Posts Routes
    Route::get('/posts', [PostController::class, 'index']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{post}', [PostController::class, 'update']);
    Route::post('/posts/{post}/like', [PostController::class, 'like']);
    Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'show']);    // Fetch user profile
    Route::post('/profile', [ProfileController::class, 'update']);  // Update user profile

    // User Route
    Route::get('/user', [UserController::class, 'getUser']);  // Get logged-in user
});