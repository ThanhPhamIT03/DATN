<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(DashboardController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('dashboard.')->prefix('dashboard')->group(function() {
        Route::get('/', 'index')->name('index');
});