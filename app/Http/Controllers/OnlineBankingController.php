<?php

namespace App\Http\Controllers;

use App\Domain\Orders\Payment\OrderPayable;
use App\Models\Order;
use App\Payments\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class OnlineBankingController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function redirect(string $key)
    {
        $paymentState = Cache::get("online_banking_payment_{$key}");
        
        if (!$paymentState) {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Payment session expired. Please try again.']);
        }

        // Update step to loading
        $paymentState['step'] = 'loading';
        Cache::put("online_banking_payment_{$key}", $paymentState, now()->addMinutes(15));

        return view('payment.online-banking.loading', [
            'key' => $key,
            'bankLabel' => $paymentState['bank_label'],
            'amount' => $paymentState['amount']
        ]);
    }

    public function gateway(string $key)
    {
        $paymentState = Cache::get("online_banking_payment_{$key}");
        
        if (!$paymentState || $paymentState['step'] !== 'loading') {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Invalid payment session.']);
        }

        // Update step to gateway
        $paymentState['step'] = 'gateway';
        Cache::put("online_banking_payment_{$key}", $paymentState, now()->addMinutes(15));

        return view('payment.online-banking.gateway', [
            'key' => $key,
            'bankLabel' => $paymentState['bank_label'],
            'amount' => $paymentState['amount'],
            'currency' => $paymentState['currency']
        ]);
    }

    public function authenticate(Request $request, string $key)
    {
        $request->validate([
            'username' => 'required|string|min:3|max:50',
            'password' => 'required|string|min:3|max:50',
        ]);

        $paymentState = Cache::get("online_banking_payment_{$key}");
        
        if (!$paymentState || $paymentState['step'] !== 'gateway') {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Invalid payment session.']);
        }

        // Validate session timeout (15 minutes max)
        $createdAt = new \DateTime($paymentState['created_at']);
        $now = new \DateTime();
        $diffInMinutes = $now->diff($createdAt)->i + ($now->diff($createdAt)->h * 60);
        
        if ($diffInMinutes > 15) {
            Cache::forget("online_banking_payment_{$key}");
            return redirect()->route('payment.index')->withErrors(['payment' => 'Payment session expired. Please start over.']);
        }

        // Basic rate limiting (prevent rapid submissions)
        $rateLimitKey = "banking_auth_" . request()->ip() . "_" . $key;
        if (Cache::has($rateLimitKey)) {
            return back()->withErrors(['payment' => 'Please wait before trying again.']);
        }
        Cache::put($rateLimitKey, true, now()->addSeconds(3));

        // Simulate authentication delay (2-3 seconds)
        sleep(2);

        // Update step to authentication
        $paymentState['step'] = 'authentication';
        $paymentState['username'] = Str::mask($request->username, '*', 2); // Mask username for security
        $paymentState['authenticated_at'] = now()->toISOString();
        Cache::put("online_banking_payment_{$key}", $paymentState, now()->addMinutes(10)); // Reduce timeout after auth

        return redirect()->route('payment.online-banking.processing', ['key' => $key]);
    }

    public function processing(string $key)
    {
        $paymentState = Cache::get("online_banking_payment_{$key}");
        
        if (!$paymentState || $paymentState['step'] !== 'authentication') {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Invalid payment session.']);
        }

        // Update step to processing
        $paymentState['step'] = 'processing';
        Cache::put("online_banking_payment_{$key}", $paymentState, now()->addMinutes(15));

        return view('payment.online-banking.processing', [
            'key' => $key,
            'bankLabel' => $paymentState['bank_label'],
            'amount' => $paymentState['amount'],
            'currency' => $paymentState['currency']
        ]);
    }

    public function complete(Request $request, string $key)
    {
        $paymentState = Cache::get("online_banking_payment_{$key}");
        
        if (!$paymentState || $paymentState['step'] !== 'processing') {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Invalid payment session.']);
        }

        // Additional security: Verify user owns this payment session
        $orderId = session('pending_payment_order_id');
        if (!$orderId) {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Order not found.']);
        }

        $order = Order::find($orderId);
        if (!$order || $order->user_id !== auth()->id()) {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Unauthorized access.']);
        }

        // Prevent duplicate processing
        $completionKey = "banking_completion_{$key}";
        if (Cache::has($completionKey)) {
            return redirect()->route('payment.index')->withErrors(['payment' => 'Payment already processed.']);
        }
        Cache::put($completionKey, true, now()->addMinutes(5));

        // Validate that order is still pending payment
        if ($order->status !== 'pending_payment') {
            Cache::forget("online_banking_payment_{$key}");
            return redirect()->route('payments.receipt', $order)->with('info', 'Payment already completed.');
        }

        // Simulate final processing delay
        sleep(1);

        try {
            // Use the stored reference or generate a new one
            $reference = $paymentState['reference'] ?? sprintf('FPX-%s-%s', strtoupper($paymentState['bank']), now()->format('YmdHis'));
            
            // Complete the payment using PaymentService
            $completionData = [
                'currency' => $paymentState['currency'],
                'reference' => $reference,
                'meta' => [
                    'method' => 'online_banking',
                    'bank' => $paymentState['bank'],
                    'bank_label' => $paymentState['bank_label'],
                    'simulation' => true,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'completed_at' => now()->toISOString()
                ]
            ];

            $result = $this->paymentService->completePendingPayment($paymentState['idempotency_key'], $completionData);

            if (!$result->isSucceeded()) {
                // Clean up on failure
                Cache::forget("online_banking_payment_{$key}");
                Cache::forget($completionKey);
                
                return redirect()->route('payment.index')->withErrors([
                    'payment' => $result->message ?? 'Payment completion failed. Please try again.'
                ]);
            }

            // Clean up on success
            Cache::forget("online_banking_payment_{$key}");
            Cache::forget($completionKey);
            session()->forget(['cart', 'checkout', 'payment.method', 'pending_payment_order_id']);

            return view('payment.online-banking.success', [
                'bankLabel' => $paymentState['bank_label'],
                'amount' => $paymentState['amount'],
                'currency' => $paymentState['currency'],
                'reference' => $reference,
                'orderId' => $order->id
            ]);

        } catch (\Exception $e) {
            // Clean up on failure
            Cache::forget("online_banking_payment_{$key}");
            Cache::forget($completionKey);
            
            return redirect()->route('payment.index')->withErrors([
                'payment' => 'Payment processing failed: ' . $e->getMessage()
            ]);
        }
    }
}