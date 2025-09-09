<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Banner\ListBannerController;

Route::controller(ListBannerController::class)->name('banner.')->prefix('banner')->group(function() {
    Route::get('list', 'index')->name('list.index');
    Route::post('status', 'status')->name('list.status');
    Route::put('', 'edit')->name('list.update');
    Route::delete('', 'delete')->name('list.delete');
});