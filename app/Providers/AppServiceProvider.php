<?php

namespace App\Providers;

// use App\View\Components\Alert;
// use App\View\Components\Tags;
// use App\View\Components\Updated;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        Blade::component('package-alert', Alert::class);
        Blade::component('package-updated', Updated::class);
        Blade::component('package-tags', Tags::class);
    }
}
