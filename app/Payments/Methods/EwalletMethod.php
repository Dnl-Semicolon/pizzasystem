<?php

namespace App\Payments\Methods;

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;

final class EwalletMethod implements PaymentMethod
{

    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult
    {
        // TODO: Implement pay() method.
    }

    public function label(): string
    {
        return 'E-Wallet';
    }
}
