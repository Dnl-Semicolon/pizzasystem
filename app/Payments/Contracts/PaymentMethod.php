<?php

namespace App\Payments\Contracts;

use App\Payments\DTOs\PaymentResult;

interface PaymentMethod
{
    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult;
    public function label(): string;
}
