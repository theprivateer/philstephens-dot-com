<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\HomepageController;

Route::get('/', HomepageController::class);
Route::feeds();
Route::get('/blog', [PostsController::class, 'index']);
Route::get('/blog/{slug}', [PostsController::class, 'show'])->name('post.show');
Route::get('/albums', [AlbumsController::class, 'index']);
Route::get('/album/{slug}', [AlbumsController::class, 'show'])->name('album.show');
Route::get('/{slug}', PagesController::class);
