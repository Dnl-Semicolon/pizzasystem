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
            return PaymentResult::failed('Nothing to collect (amount <= 0).', 'no_amount');
        }

        // Immediate capture. Service will create the payments row.
        $reference = 'CASH-' . now()->format('YmdHis');

        return PaymentResult::succeeded(
            paymentId: '',                 // let PaymentService set real id
            attemptId: null,
            reference: $reference,
            meta: [
                'method' => 'cash',
                'note'   => $payload['note'] ?? null,
            ],
        );
    }

    public function label(): string
    {
        return 'Cash';
    }
}
