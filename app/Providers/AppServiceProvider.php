<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('admin.layouts.header', function($view) {
            $notifications = [];

            if(Auth::check()) {
                $notifications = Notification::orderBy('created_at', 'desc')
                            ->latest()
                            ->take(5)
                            ->get();
                $view->with('notifications', $notifications);
            }

        });

        Paginator::useBootstrapFive();
    }
}
