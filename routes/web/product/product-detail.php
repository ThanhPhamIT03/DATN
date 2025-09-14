<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Product\ProductController;

Route::controller(ProductController::class)->name('web.product.')
    ->prefix('/product')
    ->group(function() {
    Route::get('/{id}', 'index')->name('index');
});