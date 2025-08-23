<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += ($item['unit_price'] ?? $item['total_price'] ?? 0) * ($item['quantity'] ?? 1);
        }

        $deliveryFee = 5.00;
        $grandTotal = $subtotal + $deliveryFee;

        return view('order.checkout', compact('cart', 'subtotal', 'deliveryFee', 'grandTotal'));
    }
}
