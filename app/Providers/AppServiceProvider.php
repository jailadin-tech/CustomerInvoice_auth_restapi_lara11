<?php

namespace App\Providers;

use App\Interfaces\PaymentProcessor;
use App\Services\Paypal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* $this->app->singleton(PaymentProcessor::class, function (Application $app) {
            $app->make(Paypal::class, ['config' => []]);
        }); */
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
