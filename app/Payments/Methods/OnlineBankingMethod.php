<?php

namespace App\Payments\Methods;

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;

final class OnlineBankingMethod implements PaymentMethod
{
    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult
    {
        $bank = $payload['provider'] ?? null;
        if (!$bank) {
            return PaymentResult::failed('Please select a bank', 'missing_bank');
        }

        // Simple mock: always succeed
        $reference = sprintf('FPX-%s-%s', strtoupper($bank), now()->format('YmdHis'));

        return PaymentResult::succeeded(
            paymentId: '',
            attemptId: null,
            reference: $reference,
            meta: [
                'method' => 'online_banking',
                'bank'   => $bank,
            ]
        );
    }

    public function label(): string
    {
        return 'FPX / Online Banking';
    }
}
