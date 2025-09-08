<?php

// app/Http/Controllers/PaymentController.php - Integrated payment module with proper order creation logic

namespace App\Http\Controllers;

use App\Domain\Orders\Payment\OrderPayable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PizzaOrderItemDetail;
use App\Models\PizzaOrderItemTopping;
use App\Models\Pizza;
use App\Helpers\CartHelper;
use App\Payments\PaymentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function choose(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:cash,card,ewallet,online_banking',
        ]);
        session(['payment.method' => $request->string('payment_method')]);
        return redirect()->route('payment.method', $request->string('payment_method'));
    }

    public function method(string $method)
    {
        if (!in_array($method, ['cash','card','ewallet','online_banking'], true)) {
            return redirect()->route('payment.index')->with('error', 'Invalid payment method.');
        }

        if (CartHelper::isCartEmpty()) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty.');
        }

        if (!session()->has('checkout')) {
            return redirect()->route('orders.create')->with('error', 'Please complete checkout first.');
        }

        $hydratedCart = CartHelper::getHydratedCart();
        $subtotal = CartHelper::getCartTotal();
        $deliveryFee = 5.00;
        $grandTotal = $subtotal + $deliveryFee;

        return view("payment.methods.$method", [
            'cart' => $hydratedCart,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'grandTotal' => $grandTotal,
        ]);
    }

    public function process(Request $request, string $method, PaymentService $payments)
    {
        // Ensure cart and checkout exist
        $cart = session()->get('cart', []);
        $checkout = session()->get('checkout', []);

        if (empty($cart)) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty.');
        }

        if (empty($checkout)) {
            return redirect()->route('orders.create')->with('error', 'Please complete checkout first.');
        }

        // Validate payment method
        if (!in_array($method, ['cash','card','ewallet','online_banking'], true)) {
            return redirect()->route('payment.index')->with('error', 'Invalid payment method.');
        }

        // Validate payment form data
        $payload = $this->buildPayload($request, $method);
        if ($payload instanceof RedirectResponse) {
            return $payload; // validation failed
        }

        // Create order with proper structure (similar to OrderController)
        $subtotal = CartHelper::getCartTotal();
        $deliveryFee = 5.00;
        $grandTotal = $subtotal + $deliveryFee;

        $subtotalCents = (int) round($subtotal * 100);
        $deliveryFeeCents = 500; // 5.00 * 100
        $grandTotalCents = $subtotalCents + $deliveryFeeCents;

        $order = Order::create([
            'user_id' => auth()->id(),
            'customer_name' => auth()->user()->name,
            'subtotal_cents' => $subtotalCents,
            'discount_cents' => 0,
            'tax_cents' => 0,
            'delivery_cents' => $deliveryFeeCents,
            'rounding_cents' => 0,
            'grand_total_cents' => $grandTotalCents,
            'paid_total_cents' => 0,
            'status' => 'pending_payment',
            'previous_status' => null,
            'paid_at' => null,
        ]);

        // Create order items with proper structure (like OrderController)
        foreach ($cart as $item) {
            $pizza = null;
            $productId = null;

            if ($item['type'] === 'pizza') {
                $pizza = Pizza::with('product')->find($item['pizza_id']);
                $productId = $pizza?->product_id ?? null;
            } elseif ($item['type'] === 'product') {
                $productId = $item['product_id'];
            }

            // Create Order Item
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'final_price' => $item['total_price'],
            ]);
            $orderItem->save();

            // If it's a pizza, add detail + toppings
            if ($item['type'] === 'pizza') {
                PizzaOrderItemDetail::create([
                    'order_item_id' => $orderItem->id,
                    'pizza_size_id' => $item['size_id'],
                    'crust_id' => $item['crust_id'],
                    'base_price' => $item['base_price'],
                    'crust_addition' => $item['add_on'],
                    'toppings_total' => $item['toppings_total'],
                ]);

                if (!empty($item['toppings'])) {
                    foreach ($item['toppings'] as $toppingString) {
                        [$toppingId, $toppingPrice] = explode('-', $toppingString);
                        PizzaOrderItemTopping::create([
                            'order_item_id' => $orderItem->id,
                            'topping_id' => $toppingId,
                            'topping_price' => $toppingPrice,
                        ]);
                    }
                }
            }
        }

        // Attempt payment
        $payable = new OrderPayable($order);
        $key = hash('sha256', "{$order->id}|{$request->ip()}|".auth()->id()."|{$method}|{$order->updated_at}");

        $result = $payments->collect($method, $payable, $payload, $key);

        if ($result->isSucceeded()) {
            // Payment successful - clear sessions and redirect to receipt
            session()->forget(['cart', 'checkout', 'payment.method']);
            return redirect()->route('payments.receipt', $order)->with('success', 'Payment successful!');
        }

        if ($result->isRequiresAction()) {
            // Payment requires additional action (e.g., redirect to bank)
            if (isset($result->meta['redirect_url'])) {
                // Store order ID in session for later completion
                session(['pending_payment_order_id' => $order->id]);
                return redirect($result->meta['redirect_url']);
            }
            return back()->withErrors(['payment' => $result->message ?? 'Additional action required.'])->withInput();
        }

        // Payment failed - order remains for retry, but show error
        return back()->withErrors(['payment' => $result->message ?? 'Payment failed. Please try again.'])->withInput();
    }

    private function buildPayload(Request $req, string $method): array|RedirectResponse
    {
        switch ($method) {
            case 'cash':
                // No extra fields; delivery/contact already captured in checkout.
                return [];

            case 'card':
                // Minimal, fake validation (never store PAN/CVV)
                $req->validate([
                    'card_name'   => 'required|string|max:80',
                    'card_number' => 'required|string',
                    'exp'         => 'required|string',
                    'cvv'         => 'required|string|max:4',
                ]);

                $panRaw = preg_replace('/\D+/', '', (string)$req->input('card_number'));
//                if (!$this->luhnOk($panRaw)) {
//                    return back()->withErrors(['payment' => 'Card number is invalid.'])->withInput();
//                }
                if (!preg_match('/^(0[1-9]|1[0-2])\/(\d{2})$/', $req->string('exp'))) {
                    return back()->withErrors(['payment' => 'Expiry must be MM/YY.'])->withInput();
                }

                return [
                    'card_last4' => substr($panRaw, -4),
                    'brand'      => $this->guessBrand($panRaw),
                    'card_name'  => $req->string('card_name'),
                    'note'       => $req->string('note'),
                ];

            case 'ewallet':
            case 'online_banking':
                $req->validate([
                    // example: bank selection or wallet provider, keep it minimal
                    'provider' => 'nullable|string|max:50',
                ]);
                return ['provider' => $req->string('provider')];

            default:
                return back()->withErrors(['payment' => 'Unsupported method.']);
        }
    }

    // --- helpers ---
    private function luhnOk(string $pan): bool
    {
        $sum = 0; $alt = false;
        for ($i = strlen($pan)-1; $i >= 0; $i--) {
            $n = (int)$pan[$i];
            if ($alt) { $n *= 2; if ($n > 9) $n -= 9; }
            $sum += $n; $alt = !$alt;
        }
        return $sum % 10 === 0;
    }

    private function guessBrand(string $pan): string
    {
        return match (true) {
            preg_match('/^4\d{12,18}$/', $pan)   => 'VISA',
            preg_match('/^5[1-5]\d{14}$/', $pan) => 'MASTERCARD',
            preg_match('/^3[47]\d{13}$/', $pan)  => 'AMEX',
            default                              => 'CARD',
        };
    }

    public function receipt(Order $order)
    {
        // Load latest payment for method/reference display if you want
        $order->load(['payments' => fn($q) => $q->latest()]);
        return view('payment.receipt', compact('order'));
    }

    /**
     * Display the payment page.
     */
    public function index()
    {
        if (CartHelper::isCartEmpty()) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty. Please add items first.');
        }

        if (!session()->has('checkout')) {
            return redirect()->route('orders.create')
                ->with('error', 'Please complete checkout form first.');
        }

        $hydratedCart = CartHelper::getHydratedCart();
        $subtotal = CartHelper::getCartTotal();
        $deliveryFee = 5.00;
        $grandTotal = $subtotal + $deliveryFee;

        return view('payment.index', [
            'cart' => $hydratedCart,
            'subtotal' => $subtotal,
            'deliveryFee' => $deliveryFee,
            'grandTotal' => $grandTotal,
        ]);
    }
}
