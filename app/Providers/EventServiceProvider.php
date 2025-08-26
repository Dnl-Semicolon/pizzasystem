<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Payments\Events\PaymentCaptured;
use App\Payments\Listeners\UpdateOrderOnPaymentCaptured;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PaymentCaptured::class => [
            UpdateOrderOnPaymentCaptured::class,
        ],
    ];
}
