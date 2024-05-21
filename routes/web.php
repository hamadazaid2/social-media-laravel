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
    // auth
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // categories 
    Route::resource('/categories', CategoryLookupController::class)
        ->except('show');

    // posts
    Route::resource('/posts', PostController::class)
        ->except('show');
    Route::get('/my-posts', [PostController::class, 'myPosts'])
        ->name('posts.my-posts');

    // comments
    Route::resource('/comments', CommentController::class)
        ->only(['store', 'edit', 'update', 'destroy']);

    // reaction
    Route::post('/react', [ReactionController::class, 'likeOrUnlike'])
        ->name('reaction');

    // followers
    Route::resource('followers', FollowerController::class)
        ->only([
            'index',
            'store',
            'destroy',
        ]);
    Route::delete('followers/{follower_user_id}', [FollowerController::class, 'destroy'])
        ->name('followers.custom_destroy');
});

require __DIR__ . '/auth.php';
