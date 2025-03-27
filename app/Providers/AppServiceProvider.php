<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider; 
use App\Models\Province;
use App\Models\Regency;
use App\Observers\ProvinceObserver;
use App\Observers\RegencyObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Province::observe(ProvinceObserver::class);
        Regency::observe(RegencyObserver::class);
    }
}
