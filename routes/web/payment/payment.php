<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Payment\PaymentController;

Route::middleware('auth')->controller(PaymentController::class)->name('web.payment.')->prefix('payment')
    ->group(function() {
        Route::get('', 'index')->name('index');
        Route::post('cod', 'cod')->name('cod');

        // Payment online
        Route::post('online', 'online')->name('online');
        Route::post('momo-ipn', 'momoIPN')->name('momo.ipn');
});