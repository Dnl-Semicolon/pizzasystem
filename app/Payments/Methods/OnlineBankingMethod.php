<?php

namespace App\Payments\Methods;

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;
use Illuminate\Support\Facades\Cache;

final class OnlineBankingMethod implements PaymentMethod
{
    public function pay(Payable $payable, array $payload, string $idempotencyKey): PaymentResult
    {
        $bank = $payload['provider'] ?? null;
        if (!$bank) {
            return PaymentResult::failed('Please select a bank', 'missing_bank');
        }

        // Generate reference for tracking
        $reference = sprintf('FPX-%s-%s', strtoupper($bank), now()->format('YmdHis'));

        // Store payment state in cache for simulation flow
        $paymentState = [
            'payable_id' => $payable->payableId(),
            'payable_type' => 'order',
            'amount' => $payable->amountDue(),
            'currency' => $payable->currency(),
            'bank' => $bank,
            'bank_label' => $this->getBankLabel($bank),
            'idempotency_key' => $idempotencyKey,
            'reference' => $reference,
            'created_at' => now()->toISOString(),
            'step' => 'redirect',
            'status' => 'pending'
        ];

        // Cache for 15 minutes
        Cache::put("online_banking_payment_{$idempotencyKey}", $paymentState, now()->addMinutes(15));

        // Return requires_action to trigger redirect flow
        return PaymentResult::requiresAction(
            meta: [
                'method' => 'online_banking',
                'bank' => $bank,
                'bank_label' => $this->getBankLabel($bank),
                'redirect_url' => route('payment.online-banking.redirect', ['key' => $idempotencyKey]),
                'reference' => $reference,
                'idempotency_key' => $idempotencyKey
            ],
            message: 'Redirecting to bank for authentication'
        );
    }

    public function label(): string
    {
        return 'FPX / Online Banking';
    }

    private function getBankLabel(string $bankCode): string
    {
        return match ($bankCode) {
            'maybank' => 'Maybank',
            'cimb' => 'CIMB Bank',
            'public_bank' => 'Public Bank',
            'rhb' => 'RHB Bank',
            'hong_leong' => 'Hong Leong Bank',
            'bsn' => 'Bank Simpanan Nasional',
            'ambank' => 'AmBank',
            'uob' => 'United Overseas Bank',
            'ocbc' => 'OCBC Bank',
            'agrobank' => 'Agrobank',
            default => ucwords(str_replace('_', ' ', $bankCode))
        };
    }

    public function requiresRedirect(): bool
    {
        return true;
    }
}
