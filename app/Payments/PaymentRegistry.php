<?php

namespace App\Payments;

use App\Payments\Contracts\PaymentMethod;
use InvalidArgumentException;

final class PaymentRegistry
{
    /** @var array<string, PaymentMethod> */
    private array $map = [];

    public function register(string $key, PaymentMethod $method): self
    {
        $this->map[$key] = $method;
        return $this;
    }

    public function get(string $key): PaymentMethod
    {
        if (!isset($this->map[$key])) {
            throw new InvalidArgumentException("Unknown payment method [$key]");
        }
        return $this->map[$key];
    }

    public function keys(): array
    {
        return array_keys($this->map);
    }
}
