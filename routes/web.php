<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\FatSecretController;
use App\Http\Controllers\RegisterController;
use App\Livewire\UserController as LivewireUserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('pdf', [UserController::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::prefix('fat-secret')->group(function () {
    Route::get('recipes', [FatSecretController::class, 'recipes']);
    Route::get('foods', [FatSecretController::class, 'foods']);
});

Route::get('users', LivewireUserController::class)->name('users');
