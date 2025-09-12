<?php

namespace App\Http\Controllers;

use App\Models\SavedPaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class SavedPaymentMethodController extends Controller
{
    public function index()
    {
        $paymentMethods = Auth::user()->savedPaymentMethods()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('billing.payment-methods.index', compact('paymentMethods'));
    }

    public function select()
    {
        $paymentMethods = Auth::user()->savedPaymentMethods()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('billing.payment-methods.select', compact('paymentMethods'));
    }

    public function create()
    {
        return view('billing.payment-methods.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'card_number' => 'required|string|size:19',
            'cardholder_name' => 'required|string|max:255',
            'expiry_month' => 'required|string|size:2',
            'expiry_year' => 'required|string|size:2',
        ]);

        // Clean card number
        $cleanCardNumber = preg_replace('/\D+/', '', $request->card_number);

        // Validate card number length
        if (strlen($cleanCardNumber) < 13 || strlen($cleanCardNumber) > 19) {
            return back()->withErrors(['card_number' => 'Invalid card number length.']);
        }

        // Check if this card already exists for the user
        $existingCard = Auth::user()->savedPaymentMethods()
            ->where('card_last4', substr($cleanCardNumber, -4))
            ->first();

        if ($existingCard) {
            return back()->withErrors(['card_number' => 'This card is already saved.']);
        }

        // Set as default if this is the user's first card
        $isDefault = Auth::user()->savedPaymentMethods()->count() === 0;

        Auth::user()->savedPaymentMethods()->create([
            'label' => $request->label,
            'card_number' => $cleanCardNumber,
            'cardholder_name' => $request->cardholder_name,
            'exp_month' => $request->expiry_month,
            'exp_year' => $request->expiry_year,
            'is_default' => $isDefault,
        ]);

        return redirect()->route('billing.payment-methods.index')
            ->with('success', 'Payment method saved successfully.');
    }

    public function destroy(SavedPaymentMethod $savedPaymentMethod)
    {
        if ($savedPaymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        $savedPaymentMethod->delete();

        return redirect()->route('billing.payment-methods.index')
            ->with('success', 'Payment method deleted successfully.');
    }

    public function setDefault(SavedPaymentMethod $savedPaymentMethod)
    {
        if ($savedPaymentMethod->user_id !== Auth::id()) {
            abort(403);
        }

        Auth::user()->savedPaymentMethods()->update(['is_default' => false]);
        $savedPaymentMethod->update(['is_default' => true]);

        return redirect()->route('billing.payment-methods.index')
            ->with('success', 'Default payment method updated.');
    }
}
