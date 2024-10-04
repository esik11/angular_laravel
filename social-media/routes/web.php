<?php

// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\PostController;
// use App\Http\Controllers\ProfileController;

// // Route for the home page
// Route::get('/', function () {
//     return view('welcome');
// });

// // Route for the dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

// // Route to view and create posts
// Route::get('/posts', function () {
//     return view('posts'); // Ensure 'posts' view exists
// })->middleware(['auth'])->name('posts');

// Route::post('/posts', [PostController::class, 'store'])->middleware(['auth']);
// // routes from dashboard to create post(index.html)
// Route::get('/posts/index', [PostController::class, 'create'])->name('posts.create');



// // Profile routes
// Route::middleware(['auth'])->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
// });

// // Include routes for authentication
// require __DIR__.'/auth.php';
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Pusher\Pusher;
use App\Http\Controllers\PusherTestController;
use Illuminate\Support\Facades\Auth;



// Route for the home page
Route::get('/', function () {
    return view('welcome');
});
Route::get('/posts', function () {
    return view('index');
});
// Route::get('/test-pusher', [PusherTestController::class, 'testPusher']);
// Route for the dashboard, using DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Post routes (view, create, and store)
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile'); // Route for showing the profile
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit'); // Route for editing the profile
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update'); // Route for updating the profile
});
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// Include routes for authentication
require __DIR__.'/auth.php';
