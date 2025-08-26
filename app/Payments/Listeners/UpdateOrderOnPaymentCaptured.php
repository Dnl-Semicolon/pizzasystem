<?php

namespace App\Payments\Listeners;

use App\Payments\Events\PaymentCaptured;
use App\Models\Order;
use App\Models\Payment;

final class UpdateOrderOnPaymentCaptured
{
    public function handle(PaymentCaptured $event): void
    {
        $p = $event->payment;

        // We only handle order payments (polymorphic support left intact).
        if ($p->payable_type !== 'order') {
            return;
        }

        $order = Order::find($p->payable_id);
        if (!$order) {
            return;
        }

        // Increment paid_total_cents and update status
        $order->paid_total_cents = (int) ($order->paid_total_cents ?? 0) + (int) $p->amount;

        if ($order->paid_total_cents >= (int) $order->grand_total_cents) {
            $order->status = 'paid';
            $order->paid_at = now();
        } else {
            $order->status = 'pending_payment';
        }

        $order->save();
    }
}
//'customer_name',
//'user_id',
//'total_amount',
//'subtotal_cents',
//'discount_cents',
//'tax_cents',
//'delivery_cents',
//'rounding_cents',
//'grand_total_cents',
//'paid_total_cents',
//'status',
//'paid_at',
