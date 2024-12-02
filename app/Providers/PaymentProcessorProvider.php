<?php

namespace App\Providers;

use App\Interfaces\PaymentProcessor;
use App\Services\Paypal;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class PaymentProcessorProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        dump(1);
        $this->app->singleton(PaymentProcessor::class, function (Application $app) {
            return $app->make(Paypal::class, ['config' => []]);
        });
    }

    public function provides()
    {
        return [PaymentProcessor::class];
    }

    /**
     * Bootstrap services.
     */

    /*  public function boot(): void
    {
        //
    } */
}
