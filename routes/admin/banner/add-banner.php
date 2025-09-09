<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Banner\AddBannerController;

Route::controller(AddBannerController::class)->name('banner.')->prefix('banner')->group(function() {
    Route::get('new', 'index')->name('add.index');
    Route::post('/', 'add')->name('add.new');
});

