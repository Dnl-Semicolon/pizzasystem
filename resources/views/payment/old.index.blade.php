@extends('layouts.payment')

@section('title', 'Choose Payment Method')

@section('content')
<div class="grid lg:grid-cols-3 gap-8">
    <!-- Order Summary -->
    <div class="lg:col-span-1">
        <div class="bg-white/80 payment-card rounded-2xl p-6 shadow-lg border border-white/50 sticky top-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <span class="bg-orange-100 p-2 rounded-full mr-3">📄</span>
                Order Summary
            </h2>

            <div class="space-y-3 mb-6">
                @php
                    $subtotal = 0;
                    $deliveryFee = 5.00;
                @endphp

                @foreach($cart as $item)
                    @php
                        $itemTotal = ($item->unit_price ?? $item->total_price ?? 0) * ($item->quantity ?? 1);
                        $subtotal += $itemTotal;
                    @endphp
                    <div class="flex justify-between items-start pb-3 border-b border-gray-100">
                        <div class="flex-1">
                            <p class="font-medium text-gray-900 text-sm">
                                @if($item->type === 'pizza')
                                    {{ $item->product_name ?? 'Custom Pizza' }}
                                @else
                                    {{ $item->product_name ?? 'Product' }}
                                @endif
                            </p>
                            @if($item->type === 'pizza')
                                <p class="text-xs text-gray-500">
                                    {{ $item->size->name ?? '' }} | {{ $item->crust->name ?? '' }}
                                </p>
                            @endif
                            <p class="text-xs text-gray-600">Qty: {{ $item->quantity ?? 1 }}</p>
                        </div>
                        <span class="font-semibold text-gray-900 ml-2">RM{{ number_format($item->total_price, 2) }}</span>
                    </div>
                @endforeach
            </div>

            <div class="space-y-2 pt-4 border-t border-gray-200">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">RM{{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Delivery Fee</span>
                    <span class="font-medium">RM{{ number_format($deliveryFee, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-900 pt-2 border-t">
                    <span>Total</span>
                    <span class="text-orange-600">RM{{ number_format($subtotal + $deliveryFee, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods -->
    <div class="lg:col-span-2">
        <div class="bg-white/80 payment-card rounded-2xl p-8 shadow-lg border border-white/50">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
                <span class="bg-green-100 p-3 rounded-full mr-4">💳</span>
                Choose Payment Method
            </h2>

            <form method="POST" action="{{ route('payment.prepare') }}" id="payment-form">
                @csrf

                <div class="grid md:grid-cols-2 gap-4 mb-8">
                    <!-- Cash Payment -->
                    <div class="payment-method-card bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-xl p-6 cursor-pointer hover:shadow-lg"
                         onclick="selectPaymentMethod('cash')">
                        <input type="radio" name="method" value="cash" id="cash" class="sr-only">
                        <div class="text-center">
                            <div class="bg-green-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl">💵</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Cash on Delivery</h3>
                            <p class="text-sm text-gray-600">Pay when your order arrives</p>
                            <div class="mt-4 flex items-center justify-center">
                                <span class="text-xs bg-green-600 text-white px-3 py-1 rounded-full">Free</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Payment -->
                    <div class="payment-method-card bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-xl p-6 cursor-pointer hover:shadow-lg"
                         onclick="selectPaymentMethod('card')">
                        <input type="radio" name="method" value="card" id="card" class="sr-only">
                        <div class="text-center">
                            <div class="bg-blue-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl">💳</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Credit/Debit Card</h3>
                            <p class="text-sm text-gray-600">Visa, Mastercard accepted</p>
                            <div class="mt-4 flex items-center justify-center">
                                <span class="text-xs bg-blue-600 text-white px-3 py-1 rounded-full">Secure</span>
                            </div>
                        </div>
                    </div>

                    <!-- E-Wallet -->
                    <div class="payment-method-card bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-xl p-6 cursor-pointer hover:shadow-lg"
                         onclick="selectPaymentMethod('ewallet')">
                        <input type="radio" name="method" value="ewallet" id="ewallet" class="sr-only">
                        <div class="text-center">
                            <div class="bg-purple-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl">📱</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">E-Wallet</h3>
                            <p class="text-sm text-gray-600">GrabPay, TNG eWallet</p>
                            <div class="mt-4 flex items-center justify-center">
                                <span class="text-xs bg-purple-600 text-white px-3 py-1 rounded-full">Instant</span>
                            </div>
                        </div>
                    </div>

                    <!-- Online Banking -->
                    <div class="payment-method-card bg-gradient-to-br from-orange-50 to-orange-100 border-2 border-orange-200 rounded-xl p-6 cursor-pointer hover:shadow-lg"
                         onclick="selectPaymentMethod('online_banking')">
                        <input type="radio" name="method" value="online_banking" id="online_banking" class="sr-only">
                        <div class="text-center">
                            <div class="bg-orange-200 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="text-2xl">🏦</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Online Banking</h3>
                            <p class="text-sm text-gray-600">Maybank, CIMB, Public Bank</p>
                            <div class="mt-4 flex items-center justify-center">
                                <span class="text-xs bg-orange-600 text-white px-3 py-1 rounded-full">Direct</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Details Section (Hidden by default) -->
                <div id="payment-details" class="hidden mb-8">
                    <!-- Card Details -->
                    <div id="card-details" class="hidden space-y-4">
                        <h4 class="font-semibold text-gray-900">Card Information</h4>
                        <div class="grid md:grid-cols-2 gap-4">
                            <input type="text" name="card_last4" placeholder="Last 4 digits" maxlength="4"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <input type="text" name="approval_code" placeholder="Approval Code"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- E-Wallet Details -->
                    <div id="ewallet-details" class="hidden space-y-4">
                        <h4 class="font-semibold text-gray-900">E-Wallet Transaction</h4>
                        <input type="text" name="ewallet_txnid" placeholder="Transaction ID (optional)"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    </div>
                </div>

                @if($errors->has('payment'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <span class="text-red-500 mr-2">⚠️</span>
                            <p class="text-red-700 text-sm">{{ $errors->first('payment') }}</p>
                        </div>
                    </div>
                @endif

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" id="pay-button"
                            class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-4 rounded-xl font-semibold text-lg hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed"
                            disabled>
                        <span class="flex items-center">
                            <span class="mr-2">🚀</span>
                            Complete Payment
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function selectPaymentMethod(method) {
    // Clear all selections
    document.querySelectorAll('.payment-method-card').forEach(card => {
        card.classList.remove('ring-4', 'ring-offset-2');
        card.classList.remove('ring-green-400', 'ring-blue-400', 'ring-purple-400', 'ring-orange-400');
    });

    // Clear all radio buttons
    document.querySelectorAll('input[name="method"]').forEach(radio => {
        radio.checked = false;
    });

    // Select the clicked method
    const selectedCard = document.querySelector(`input[value="${method}"]`).closest('.payment-method-card');
    const radio = document.getElementById(method);
    radio.checked = true;

    // Add visual selection
    const colorMap = {
        'cash': 'ring-green-400',
        'card': 'ring-blue-400',
        'ewallet': 'ring-purple-400',
        'online_banking': 'ring-orange-400'
    };

    selectedCard.classList.add('ring-4', 'ring-offset-2', colorMap[method]);

    // Show/hide payment details
    const detailsSection = document.getElementById('payment-details');
    const cardDetails = document.getElementById('card-details');
    const ewalletDetails = document.getElementById('ewallet-details');

    // Hide all details first
    detailsSection.classList.add('hidden');
    cardDetails.classList.add('hidden');
    ewalletDetails.classList.add('hidden');

    // Show relevant details
    if (method === 'card') {
        detailsSection.classList.remove('hidden');
        cardDetails.classList.remove('hidden');
    } else if (method === 'ewallet') {
        detailsSection.classList.remove('hidden');
        ewalletDetails.classList.remove('hidden');
    }

    // Enable submit button
    document.getElementById('pay-button').disabled = false;
}

// Form validation
document.getElementById('payment-form').addEventListener('submit', function(e) {
    const selectedMethod = document.querySelector('input[name="method"]:checked');
    if (!selectedMethod) {
        e.preventDefault();
        alert('Please select a payment method');
        return false;
    }

    // Additional validation for card payments
    if (selectedMethod.value === 'card') {
        const last4 = document.querySelector('input[name="card_last4"]').value;
        const approvalCode = document.querySelector('input[name="approval_code"]').value;

        if (!last4 || last4.length !== 4) {
            e.preventDefault();
            alert('Please enter the last 4 digits of your card');
            return false;
        }

        if (!approvalCode) {
            e.preventDefault();
            alert('Please enter the approval code');
            return false;
        }
    }
});
</script>
@endpush
