<?php

use App\Http\Controllers\Admin\Product\ListProductController;
use Illuminate\Support\Facades\Route;

Route::controller(ListProductController::class)->name('product.')->prefix('product')
    ->group(function() {
        Route::get('list', 'index')->name('list.index');
        Route::post('/status', 'status')->name('list.status');
        Route::put('/edit', 'edit')->name('list.edit');
        Route::delete('/delete', 'delete')->name('list.delete');
});