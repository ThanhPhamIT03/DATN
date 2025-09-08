<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::controller(DashboardController::class)->name('dashboard.')->prefix('dashboard')->group(function() {
    Route::get('/', 'index')->name('index');
});