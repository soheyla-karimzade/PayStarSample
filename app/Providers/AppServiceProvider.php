<?php

namespace App\Providers;

use App\Services\Payment\PayStarPayment;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        App::bind('PayStarPayment',PayStarPayment::class);
//        $this->app->bind(App\Services\PayStarPayment::class, 'SomethingThatDoesntExist');

    }
}
