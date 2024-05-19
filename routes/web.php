<?php

use App\Http\Controllers\CategoryLookupController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostContoller;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->get('', fn() => to_route('posts.index'));

Route::get('/dashboard', function () {
    // return view('dashboard');
    return to_route('posts.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/categories', CategoryLookupController::class);
    Route::resource('/posts', PostContoller::class);
    Route::resource('/comments', CommentController::class);
    Route::post('/react', [ReactionController::class, 'likeOrUnlike'])->name('reaction');
});

require __DIR__ . '/auth.php';
