<?php

namespace App\Providers;

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
        //
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
