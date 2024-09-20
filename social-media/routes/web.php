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
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth;

// Route for the home page
Route::get('/', function () {
    return view('welcome');
});

// Route for the dashboard, using DashboardController
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Post routes (view, create, and store)
Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/profile', function () {
    return view('profile', compact('posts'));
})->middleware(['auth'])->name('profile');
});

// Include routes for authentication
require __DIR__.'/auth.php';
