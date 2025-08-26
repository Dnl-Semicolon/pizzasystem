<?php

namespace App\Http\Controllers;

use App\Domain\Orders\Payment\OrderPayable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PizzaOrderItemDetail;
use App\Models\PizzaOrderItemTopping;
use App\Models\Pizza;
use App\Helpers\CartHelper;
use App\Payments\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Display the payment page.
     */
    public function index()
    {
        if (CartHelper::isCartEmpty()) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty.');
        }

        $hydratedCart = CartHelper::getHydratedCart();

        return view('payment.index', ['cart' => $hydratedCart]);
    }

    /**
     * Process the payment and create order.
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,fpx,cod',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty.');
        }

        // Calculate total amount
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['unit_price'] ?? $item['total_price'] ?? 0) * ($item['quantity'] ?? 1);
        }
        $deliveryFee = 5.00;
        $grandTotal = $subtotal + $deliveryFee;

        // Create order
        $order = Order::create([
            'customer_name' => Auth::user()->name ?? 'Guest',
            'total_amount' => $grandTotal,
            'status' => 'processing',
            'payment_method' => $request->payment_method,
        ]);

        // Create order items
        foreach ($cart as $item) {
            $pizza = null;
            $productId = null;

            if ($item['type'] === 'pizza') {
                $pizza = Pizza::with('product')->find($item['pizza_id']);
                $productId = $pizza?->product_id ?? null;
            } elseif ($item['type'] === 'product') {
                $productId = $item['product_id'];
            }

            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
                'final_price' => $item['total_price'],
            ]);
            $orderItem->save();

            // Add pizza details if applicable
            if ($item['type'] === 'pizza') {
                PizzaOrderItemDetail::create([
                    'order_item_id' => $orderItem->id,
                    'pizza_size_id' => $item['size_id'],
                    'crust_id' => $item['crust_id'],
                    'base_price' => $item['base_price'],
                    'crust_addition' => $item['add_on'],
                    'toppings_total' => $item['toppings_total'],
                ]);

                // Add toppings
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

        // Clear cart
        session()->forget('cart');
        session()->forget('checkout');

        return redirect()->route('payment.confirm', $order->id)
            ->with('success', 'Payment processed successfully!');
    }

    /**
     * Display order confirmation page.
     */
    public function confirm(Order $order): View
    {
        $order->load([
            'items.product',
            'items.pizzaDetails.size',
            'items.pizzaDetails.crust',
            'items.toppings.topping'
        ]);

        return view('payment.confirm', compact('order'));
    }

    public function collect(Order $order, Request $request, PaymentService $service)
    {
        $request->validate([
            'method' => 'required|in:cash,card,ewallet,online_banking',
        ]);

        $payable = new OrderPayable($order);
        $payload = $request->only(['card_last4','approval_code','ewallet_txnid']);
        $key = hash('sha256', "{$order->id}|{$request->user()?->id}|{$request->string('method')}|{$order->updated_at}");

        $result = $service->collect(method: $request->string('method'), payable: $payable, payload: $payload, key: $key);

        if ($result->isSucceeded()) {
            return to_route('orders.receipt', $order);
        }
        if ($result->isRequiresAction()) {
            return view('payment.qr_or_redirect', ['result' => $result, 'order' => $order]);
        }

        return back()->withErrors(['payment' => $result->message]);
    }
}
