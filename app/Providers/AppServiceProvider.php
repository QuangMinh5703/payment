<?php

namespace App\Providers;

use App\Command\RechargeOrderCommand;
use App\TransferPay;
use App\Payment;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerComponents();
        if ($this->app->runningInConsole()) {
            $this->commands([
                RechargeOrderCommand::class
            ]);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    private function registerComponents()
    {
        // Register the main class to use with the facade
        $this->app->singleton(Payment::class, fn () => new Payment());
        $this->app->singleton(TransferPay::class, fn () => new TransferPay());

        $this->app->alias(Payment::class, 'kg.payment');
        $this->app->alias(TransferPay::class, 'kg.payment.transfer');
    }
}
