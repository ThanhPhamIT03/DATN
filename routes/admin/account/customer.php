<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ADmin\Account\CustomerAccountController;
use App\Http\Middleware\RoleMiddleware;

Route::controller(CustomerAccountController::class)
    ->middleware(RoleMiddleware::class . ':sadmin')
    ->name('account.customer.')
    ->prefix('account/customer')
    ->group(function() {
        Route::get('', 'index')->name('index');
    });