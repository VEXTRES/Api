<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('client')->group(function () {
    Route::resource('users', UserController::class);
});

/* Route::middleware('auth:api')->group(function () {
    Route::resource('users-login', UserController::class);
}); */

Route::controller(RegisterController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::put('update/{id}', 'update');
    Route::delete('destroy/{id}', 'destroy'); // Esta es la ruta correcta
});
