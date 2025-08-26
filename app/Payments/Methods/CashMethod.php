<?php

namespace App\Payments\Methods;

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;

final class CashMethod implements PaymentMethod
{

    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult
    {
        $amount = $payable->amountDue();
        if ($amount <= 0) {
            return PaymentResult::failed('Nothing to collect (amount <= 0).');
        }

        // For cash, capture is immediate. We return a success PaymentResult;
        // PaymentService will create the payments row and fire the event.
        $reference = 'CASH-' . now()->format('Ymd-His');

        // paymentId is filled by the service after it creates the Payment row,
        // so we pass null here and just return succeeded semantics.
        return PaymentResult::succeeded(paymentId: '', attemptId: null, reference: $reference, meta: []);
    }

    public function label(): string
    {
        return 'Cash';
    }
}
