<?php

namespace App\Payments\Methods;

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;

final class CardMethod implements PaymentMethod
{
    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult
    {
        // Expect reduced payload: card_last4, brand, card_name, note
        $last4 = $payload['card_last4'] ?? null;
        $brand = $payload['brand'] ?? 'CARD';

        if (!$last4) {
            return PaymentResult::failed('Missing card data', 'missing_fields');
        }

        // Simple mock decline rule:
        if ($last4 === '0000') {
            return PaymentResult::failed('Mock decline: last4 cannot be 0000', 'mock_decline');
        }

        $reference = sprintf('%s-%s-%s', $brand, $last4, now()->format('YmdHis'));

        return PaymentResult::succeeded(
            paymentId: '',
            attemptId: null,
            reference: $reference,
            meta: [
                'method' => 'card',
                'brand'  => $brand,
                'last4'  => $last4,
                'name'   => $payload['card_name'] ?? null,
                'note'   => $payload['note'] ?? null,
                'mode'   => 'mock',
            ]
        );
    }

    public function label(): string
    {
        return 'Card (Mock Online)';
    }
}
