<?php

use App\Http\Controllers\Admin\Product\ProductDetailController;
use Illuminate\Support\Facades\Route;

Route::controller(ProductDetailController::class)->name('product.detail.')->prefix('product/detail')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('add', 'add')->name('add');
        Route::post('status', 'status')->name('status');
        Route::put('edit', 'edit')->name('edit');
        Route::delete('delete', 'delete')->name('delete');
});