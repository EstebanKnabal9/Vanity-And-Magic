<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Observers\IngresoObserver;
use App\Observers\EgresoObserver;

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
        Ingreso::observe(IngresoObserver::class);
        Egreso::observe(EgresoObserver::class);
    }
}
