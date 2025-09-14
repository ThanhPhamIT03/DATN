<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Cart\CartController;

Route::controller(CartController::class)->name('web.cart.')
        ->prefix('/cart')
        ->group(function() {
            Route::get('/', 'index')->name('index');
            Route::post('add', 'add')->middleware('auth')->name('add');
            Route::delete('delete', 'delete')->name('delete');
            Route::post('add-quantity', 'addQuantity')->name('add.quantity');
            Route::post('minus-quantity', 'minusQuantity')->name('minus.quantity');
            Route::post('collect', 'collect')->name('collect');
});