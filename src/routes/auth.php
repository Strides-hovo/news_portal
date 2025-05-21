<?php

use App\Http\Controllers\Auth\AuthUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthUserController::class, 'create'])->name('login');

    Route::post('login', [AuthUserController::class, 'store']);

    Route::get('verify', [AuthUserController::class, 'verification'])->name('verification.create');

    Route::post('verification/{id}', [AuthUserController::class, 'verificationUser'])->name('verification');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthUserController::class, 'logout'])
        ->name('logout');
});
