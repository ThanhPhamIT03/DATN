<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use App\Http\Middleware\RoleMiddleware;

// Admin
$routeAdmin = File::allFiles(__DIR__ . '/admin');

Route::middleware(['auth', RoleMiddleware::class . ':admin,sadmin'])->prefix('admin')->name('admin.')->group(function() use ($routeAdmin) {
    foreach ($routeAdmin as $route) {
        if ($route->getExtension() === 'php') {
            require_once $route->getPathname();
        }
    }
});

// Web
$routeWeb = File::allFiles(__DIR__ . '/web');

Route::middleware(['web'])->group(function () use ($routeWeb) {
    foreach ($routeWeb as $route) {
        if ($route->getExtension() === 'php') {
            require_once $route->getPathname();
        }
    }
});