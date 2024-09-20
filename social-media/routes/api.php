<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;


// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->group(function () {
    // Route::post('/posts', [PostController::class, 'store']);
    // Route::get('/posts', [PostController::class, 'index']);
    // Get all posts
Route::get('/posts', [PostController::class, 'index']);

// Create a new post
Route::post('/posts', [PostController::class, 'store']);

// Like a post
Route::post('/posts/{post}/like', [PostController::class, 'like']);

// Add a comment to a post
Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);
});