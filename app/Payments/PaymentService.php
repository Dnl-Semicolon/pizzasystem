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

    /**
     * Complete a pending payment that was started with requiresAction
     */
    public function completePendingPayment(string $idempotencyKey, array $completionData): PaymentResult
    {
        // Find the existing payment attempt
        $attempt = PaymentAttempt::where('idempotency_key', $idempotencyKey)->first();
        
        if (!$attempt) {
            return PaymentResult::failed('Payment attempt not found', 'attempt_not_found');
        }

        if ($attempt->status !== 'pending') {
            return PaymentResult::failed('Payment attempt is not pending', 'invalid_status');
        }

        try {
            // Update the attempt as successful
            $attempt->update([
                'status' => 'success',
                'raw' => json_encode($completionData)
            ]);

            // Create the successful payment
            $payment = Payment::create([
                'payable_type' => $attempt->payable_type,
                'payable_id' => $attempt->payable_id,
                'currency' => $completionData['currency'] ?? 'MYR',
                'amount' => $attempt->amount,
                'method' => $attempt->method,
                'status' => 'captured',
                'captured_at' => now(),
                'reference' => $completionData['reference'] ?? null,
                'meta' => json_encode($completionData['meta'] ?? []),
            ]);

            // Fire the payment captured event
            event(new PaymentCaptured($payment));

            // Explicitly trigger listener as fallback
            $listener = app(UpdateOrderOnPaymentCaptured::class);
            $listener->handle(new PaymentCaptured($payment));

            return PaymentResult::succeeded(
                paymentId: (string) $payment->id,
                attemptId: (string) $attempt->id,
                reference: $payment->reference,
                meta: $completionData['meta'] ?? []
            );

        } catch (\Exception $e) {
            // Update attempt as failed
            $attempt->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
                'raw' => json_encode(['error' => $e->getMessage()])
            ]);

            return PaymentResult::failed(
                'Payment completion failed: ' . $e->getMessage(),
                'completion_failed',
                (string) $attempt->id
            );
        }
    }
}
