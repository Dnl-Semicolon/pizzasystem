<?php

namespace App\Payments\Listeners;

// pizzasystem/app/Payments/Listeners/UpdateOrderOnPaymentCaptured.php

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
            $order->previous_status = $order->status;
            $order->status = 'paid';
            $order->paid_at = now();
        } else {
            $order->status = 'pending_payment';
        }

        $result = $order->save();

        \Log::info('Order updated after payment', [
            'order_id' => $order->id,
            'status' => $order->status,
            'paid_total_cents' => $order->paid_total_cents,
            'save_result' => $result
        ]);
    }
}
