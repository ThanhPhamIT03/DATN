<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Notify\NotifyController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(NotifyController::class)
    ->middleware(RoleMiddleware::class . ':admin,sadmin')
    ->name('notify.')
    ->prefix('notify')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('read', 'read')->name('read');
        Route::post('mark-all-read', 'markAllRead')->name('markAllRead');
    });