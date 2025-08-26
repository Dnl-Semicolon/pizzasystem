<?php

namespace App\Domain\Orders\Payment;

use App\Payments\Contracts\Payable;
use App\Models\Order;

final class OrderPayable implements Payable
{
    public function __construct(private Order $order)
    {

    }

    public function payableId(): int
    {
        return $this->order->id;
    }

    public function currency(): string
    {
        return 'MYR';
    }

    public function amountDue(): int
    {
        return (int) round($this->order->getAmountDueCentsAttribute());
    }

    public function description(): string
    {
        return "Order #{$this->order->id}";
    }

    public function customerId(): ?int
    {
        return $this->order->customer_name;
    }
}
