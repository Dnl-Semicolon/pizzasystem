<?php

namespace App\Payments\Methods;

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;

final class EwalletMethod implements PaymentMethod
{
    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult
    {
        // Option A: one-shot success (simple)
        $reference = 'EWALLET-' . strtoupper(dechex(crc32($idempotencyKey))).'-'.now()->format('His');

        return PaymentResult::succeeded(
            paymentId: '',
            attemptId: null,
            reference: $reference,
            meta: [
                'method'   => 'ewallet',
                'provider' => $payload['provider'] ?? 'mock_wallet',
            ]
        );

        // Option B (advanced): return requiresAction([... 'qr_svg' => ..., 'poll_token' => ... ])
        // and complete later — skip for assignment simplicity.
    }

    public function label(): string
    {
        return 'E-Wallet';
    }
}
