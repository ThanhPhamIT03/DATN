<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Home\HomeController;

Route::controller(HomeController::class)->name('home.')->group(function() {
    Route::get('/', 'index')->name('index');
});
