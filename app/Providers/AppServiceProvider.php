<?php

namespace App\Providers;
use App\Models\Sponsor;
use App\Observers\SponsorObserver;
use Illuminate\Support\ServiceProvider;

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
        Sponsor::observe(SponsorObserver::class);
    }
}
