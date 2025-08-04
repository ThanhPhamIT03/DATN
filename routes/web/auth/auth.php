<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\LoginController;
use App\Http\Controllers\Web\Auth\RegisterController;

Route::controller(LoginController::class)->name('auth.login.')
        ->prefix('auth/login')
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'login')->name('login');
});

Route::controller(RegisterController::class)->name('auth.register.')
        ->prefix('auth/register')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'register')->name('register');
});