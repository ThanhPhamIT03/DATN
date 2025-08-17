<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Cart\CartController;

Route::controller(CartController::class)->name('web.cart.')
        ->prefix('/cart')
        ->group(function() {
            Route::get('/', 'index')->name('index');
        });