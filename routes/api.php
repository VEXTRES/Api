<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('client')->group(function () {
    Route::resource('users', UserController::class);
});

Route::get('/register', [RegisterController::class, 'register']);
Route::get('/login', [RegisterController::class, 'login']);
