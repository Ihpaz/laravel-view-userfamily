<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\UserController::class, 'index']);

Route::resource('/pics', \App\Http\Controllers\PicController::class);
Route::resource('/users', \App\Http\Controllers\UserController::class);