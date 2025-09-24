<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADmin\Account\StaffAccountController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(StaffAccountController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('account.staff.')
    ->prefix('account/staff')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
        Route::post('remove', 'remove')->name('remove');
    });