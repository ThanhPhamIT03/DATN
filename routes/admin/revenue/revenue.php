<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Revenue\RevenueController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(RevenueController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('revenue.')
    ->prefix('revenue')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::get('export', 'export')->name('export');
    });