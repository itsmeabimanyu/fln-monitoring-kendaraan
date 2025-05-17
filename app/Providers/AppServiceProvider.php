<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Kendaraan;
use App\Observers\KendaraanObserver;

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
        //
        Kendaraan::observe(KendaraanObserver::class);
    }
}
