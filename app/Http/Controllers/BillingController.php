<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BillingController extends Controller
{
    /**
     * Display the billing dashboard.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        
        // Get all payments for this user through their orders
        $paymentsQuery = Payment::where('payable_type', 'order')
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->with(['order.items.product']);
        
        // Add search functionality
        if ($search = $request->get('search')) {
            $paymentsQuery->where(function ($query) use ($search) {
                $query->where('reference', 'like', "%{$search}%")
                      ->orWhere('method', 'like', "%{$search}%")
                      ->orWhere('id', 'like', "%{$search}%");
            });
        }
        
        // Add status filter
        if ($status = $request->get('status')) {
            $paymentsQuery->where('status', $status);
        }
        
        $payments = $paymentsQuery->orderBy('created_at', 'desc')->paginate(15);
        
        // Calculate billing statistics
        $allUserPayments = Payment::where('payable_type', 'order')
            ->whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->where('status', 'captured')->get();
        
        $billingStats = [
            'total_payments' => $allUserPayments->count(),
            'total_spent' => $allUserPayments->sum('amount'),
            'successful_payments' => $allUserPayments->where('status', 'captured')->count(),
            'this_month_spent' => $allUserPayments->where('captured_at', '>=', now()->startOfMonth())->sum('amount'),
        ];
        
        return view('billing.index', compact('payments', 'billingStats'));
    }
    
    /**
     * Display a specific payment.
     */
    public function show(Payment $payment): View
    {
        $user = Auth::user();
        
        // Ensure the payment belongs to the authenticated user
        $payment->load(['order.items.product', 'order.user']);
        
        // Check if this is an order payment and belongs to the user
        if ($payment->payable_type !== 'order' || $payment->order->user_id !== $user->id) {
            abort(403, 'You do not have permission to view this payment.');
        }
        
        // Get payment attempts for this payment's order
        $paymentAttempts = \App\Models\PaymentAttempt::where('payable_type', 'order')
                                                     ->where('payable_id', $payment->order->id)
                                                     ->orderBy('created_at', 'desc')
                                                     ->get();
        
        return view('billing.show', compact('payment', 'paymentAttempts'));
    }
}