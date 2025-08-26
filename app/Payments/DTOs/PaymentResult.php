<?php

namespace App\Payments\DTOs;

final class PaymentResult
{
    public function __construct(
        public readonly bool $success,
        public readonly string $status,
        public readonly ?string $message = null,
        public readonly ?string $paymentId = null,
        public readonly ?string $attemptId = null,
        public readonly ?string $reference = null,
        public readonly ?string $errorCode = null,
        public readonly array $meta = [],
    ) {}

    public static function succeeded(string $paymentId, ?string $attemptId = null, ?string $reference = null, array $meta = []): self
    {
        return new self(true, 'succeeded', null, $paymentId, $attemptId, $reference, null, $meta);
    }

    public static function requiresAction(array $meta, ?string $attemptId = null, ?string $message = 'Additional action required'): self
    {
        return new self(false, 'requires_action', $message, null, $attemptId, null, null, $meta);
    }

    public static function pending(?string $attemptId = null, array $meta = [], ?string $message = 'Pending'): self
    {
        return new self(false, 'pending', $message, null, $attemptId, null, null, $meta);
    }

    public static function failed(string $message, ?string $errorCode = null, ?string $attemptId = null, array $meta = []): self
    {
        return new self(false, 'failed', $message, null, $attemptId, null, $errorCode, $meta);
    }

    public function isSucceeded(): bool { return $this->success && $this->status === 'succeeded'; }
    public function isRequiresAction(): bool { return $this->status === 'requires_action'; }
}
