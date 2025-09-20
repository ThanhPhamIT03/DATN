<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;

Route::middleware('guest')->group(function () {
    Route::controller(LoginController::class)->name('auth.login.')
        ->prefix('auth/login')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'login')->name('login');
        });

    Route::controller(RegisterController::class)->name('auth.register.')
        ->prefix('auth/register')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/store', 'store')->name('store');
        });
});

Route::middleware('auth')->controller(LoginController::class)->name('auth.logout.')
    ->prefix('auth/logout')
    ->group(function () {
        Route::post('/', 'logout')->name('logout');
    });

Route::middleware('guest')->controller(LoginController::class)
    ->group(function () {

        Route::get('auth/google', 'redirectToGoogle')->name('google.login');
        Route::get('auth/google/callback', 'googleCallback');
});
