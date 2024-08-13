<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LinksController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\AlbumsController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\HomepageController;

Route::get('/', HomepageController::class);
Route::feeds();
Route::get('/posts', [PostsController::class, 'index'])->name('posts');
Route::get('/post/{slug}', [PostsController::class, 'show'])->name('post.show');
Route::get('/notes', NotesController::class)->name('notes');
Route::get('/links', LinksController::class)->name('links');
Route::get('/albums', [AlbumsController::class, 'index'])->name('albums');
Route::get('/album/{slug}', [AlbumsController::class, 'show'])->name('album.show');
// Deprecated
Route::get('/blog', [ArticlesController::class, 'index']);
Route::get('/blog/{slug}', [ArticlesController::class, 'show'])->name('article.show');
// Wildcard
Route::get('/{slug}', PagesController::class);
