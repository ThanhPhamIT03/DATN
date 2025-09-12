<?php

use App\Http\Controllers\Admin\Product\ListProductController;
use Illuminate\Support\Facades\Route;

Route::controller(ListProductController::class)->name('product.list.')->prefix('product/list')
    ->group(function() {
        Route::get('list', 'index')->name('index');
        Route::post('status', 'status')->name('status');
        Route::put('edit', 'edit')->name('edit');
        Route::delete('delete', 'delete')->name('delete');
});