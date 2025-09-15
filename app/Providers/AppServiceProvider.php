<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        Paginator::useBootstrapFive();

        // Menggunakan View Composer secara langsung tanpa membuat class khusus
        View::composer('*', function ($view) {
            // Bagikan data ke semua
            // $view->with('noback', false);
            // $view->with('withError', true);
        });
    }
}
