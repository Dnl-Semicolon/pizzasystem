<?php

namespace App\Payments;

// pizzasystem/app/Payments/PaymentService.php

use App\Payments\Contracts\Payable;
use App\Payments\Contracts\PaymentMethod;
use App\Payments\DTOs\PaymentResult;
use App\Models\PaymentAttempt;
use App\Models\Payment;
use App\Payments\Events\PaymentCaptured;
use App\Payments\Listeners\UpdateOrderOnPaymentCaptured;

final class PaymentService
{
    public function __construct(private PaymentRegistry $registry) {}

    public function collect(string $method, Payable $payable, array $payload, string $key): PaymentResult
    {
        // 1) record attempt
        $attempt = PaymentAttempt::firstOrCreate(
            ['idempotency_key' => $key],
            [
                'payable_type' => 'order',
                'payable_id' => $payable->payableId(),
                'method' => $method,
                'status' => 'pending',
                'amount' => $payable->amountDue(),
            ]
        );

        // 2) run strategy
        $handler = $this->registry->get($method);
        $result = $handler->pay($payable, $payload, $key);

        // 3) persist results
        $attempt->update([
            'status' => $result->status,
            'error_code' => $result->errorCode,
            'error_message' => $result->message,
            'raw' => json_encode($result->meta),
        ]);

        if ($result->isSucceeded()) {
            $payment = Payment::create([
                'payable_type' => 'order',
                'payable_id' => $payable->payableId(),
                'currency' => $payable->currency(),
                'amount' => $payable->amountDue(),
                'method' => $method,
                'status' => 'captured',
                'captured_at' => now(),
                'reference' => $result->reference,
                'meta' => json_encode($result->meta),
            ]);

            // bump order & fire event (listener updates paid_total/status)
            event(new PaymentCaptured($payment));

            // Explicitly trigger listener as fallback for event system issues
            $listener = app(UpdateOrderOnPaymentCaptured::class);
            $listener->handle(new PaymentCaptured($payment));
        }

        return $result;
    }
}
