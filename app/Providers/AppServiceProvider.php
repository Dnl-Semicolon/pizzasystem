<?php

namespace App\Providers;

use App\Payments\PaymentRegistry;
use App\Payments\Methods\CashMethod;
use App\Payments\Methods\CardMethod;
use App\Payments\Methods\EwalletMethod;
use App\Payments\Methods\OnlineBankingMethod;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PaymentRegistry::class, function ($app) {
            return (new PaymentRegistry)
                ->register('cash', $app->make(CashMethod::class))
                ->register('card', $app->make(CardMethod::class))
                ->register('ewallet', $app->make(EwalletMethod::class))
                ->register('online_banking', $app->make(OnlineBankingMethod::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Set a custom redirect callback
        Authenticate::redirectUsing(function (Request $request) {
            // Optionally flash a message
            session()->flash('status', 'Please log in to submit your order.');

            return route('login');
        });
    }
}
