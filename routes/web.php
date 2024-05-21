<?php

use App\Http\Controllers\CategoryLookupController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
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
    Route::resource('/posts', PostController::class);
    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('posts.my-posts');

    Route::resource('/comments', CommentController::class);
    Route::post('/react', [ReactionController::class, 'likeOrUnlike'])->name('reaction');

    Route::resource('followers', FollowerController::class);
    Route::delete('followers/{follower_user_id}', [FollowerController::class, 'destroy'])->name('followers.custom_destroy');

    // Route::post('/follow/{follower_user_id}', [FollowerController::class, 'follow'])->name('follow');
    // Route::delete('/unfollow/{follower_user_id}', [ReactionController::class, 'unfollow'])->name('unfollow');
});

require __DIR__ . '/auth.php';
