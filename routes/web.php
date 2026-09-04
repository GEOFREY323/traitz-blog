<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

Route::get('/', function () {
    return redirect()->route('posts.index');
});

Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');
    
Route::get('/tags/{tag:slug}', [TagController::class, 'show'])
    ->name('tags.show');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');

    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');

    Route::put('/posts/{post}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{post}', [PostController::class, 'destroy'])
        ->name('posts.destroy');
        
    Route::get('/trash', [PostController::class, 'trash'])
    ->name('posts.trash');

    Route::patch('/trash/{post}/restore', [PostController::class, 'restore'])
        ->name('posts.restore');

    Route::delete('/trash/{post}/force-delete', [PostController::class, 'forceDelete'])
        ->name('posts.forceDelete');
});

Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');

Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

Route::get('/dashboard', function () {
    $myPosts = auth()->user()
        ->posts()
        ->with('tags')
        ->latest()
        ->get();

    $commentsReceived = \App\Models\Comment::whereIn(
        'post_id',
        $myPosts->pluck('id')
    )->count();

    return view('dashboard', compact(
        'myPosts',
        'commentsReceived'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');
require __DIR__.'/auth.php';
