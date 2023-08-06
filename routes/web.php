<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\PicController::class, 'index']);

Route::resource('/pics', \App\Http\Controllers\PicController::class);
Route::resource('/projects', \App\Http\Controllers\ProjectController::class);