<?php

namespace App\Http\Controllers;

use App\Helpers\CartHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        if (CartHelper::isCartEmpty()) {
            return redirect()->route('orders.create')->with('error', 'Your cart is empty.');
        }

        $cart = CartHelper::getHydratedCart();
        $subtotal = CartHelper::getCartTotal();
        $deliveryFee = 5.00;
        $grandTotal = $subtotal + $deliveryFee;

        // Load user addresses if authenticated
        $addresses = [];
        $defaultAddress = null;
        if (Auth::check()) {
            $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
            $defaultAddress = Auth::user()->defaultAddress();
        }

        return view('order.checkout', compact('cart', 'subtotal', 'deliveryFee', 'grandTotal', 'addresses', 'defaultAddress'));
    }

    /**
     * Store checkout data in session.
     */
    public function store(Request $request)
    {
        $request->validate([
            'contact_name' => 'required|string',
            'contact_phone' => 'required',
            'contact_email' => 'nullable|email',
            'delivery_mode' => 'nullable|string',
            'addr1' => 'required|string',
            'addr2' => 'nullable|string',
            'postcode' => 'required|string|size:5',
            'city' => 'required|string',
            'state' => 'required|string',
            'delivery_notes' => 'nullable|string',
        ]);

        $checkoutData = [
            'contact_name' => $request->contact_name,
            'contact_phone' => $request->contact_phone,
            'contact_email' => $request->contact_email,
            'delivery_mode' => $request->delivery_mode,
            'addr1' => $request->addr1,
            'addr2' => $request->addr2,
            'postcode' => $request->postcode,
            'city' => $request->city,
            'state' => $request->state,
            'delivery_notes' => $request->delivery_notes,
        ];

        session(['checkout' => $checkoutData]);

        return redirect()->route('payment.index');
    }
}
