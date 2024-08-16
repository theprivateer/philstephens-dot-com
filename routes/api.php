<?php

use App\Http\Controllers\Api\NotesController;
use Illuminate\Support\Facades\Route;

Route::post('/note', NotesController::class)->middleware('auth:sanctum');
