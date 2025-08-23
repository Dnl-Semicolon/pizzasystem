<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Payment') }}
        </h2>
    </x-slot>

    <div class="py-6 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Review & Pay Panel -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Review & Pay</h3>
                            <a href="{{ route('checkout.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                Edit
                            </a>
                        </div>
                        
                        <!-- Address Summary -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Delivery Address</h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900 p-3 rounded-md">
                                @php
                                    // Placeholder data - would come from session in real implementation
                                    $address = session('checkout_address', [
                                        'full_name' => 'John Doe',
                                        'phone' => '+60123456789',
                                        'address_line_1' => '123 Main Street',
                                        'address_line_2' => 'Apartment 4B',
                                        'city' => 'Kuala Lumpur',
                                        'postcode' => '50200',
                                        'state' => 'Kuala Lumpur'
                                    ]);
                                    
                                    $contact = session('checkout_contact', [
                                        'email' => 'john@example.com',
                                        'phone' => '+60123456789'
                                    ]);
                                @endphp
                                
                                <div class="font-medium">{{ $address['full_name'] ?? 'John Doe' }}</div>
                                <div>{{ $address['address_line_1'] ?? '123 Main Street' }}</div>
                                @if(!empty($address['address_line_2']))
                                    <div>{{ $address['address_line_2'] }}</div>
                                @endif
                                <div>{{ $address['postcode'] ?? '50200' }} {{ $address['city'] ?? 'Kuala Lumpur' }}, {{ $address['state'] ?? 'Kuala Lumpur' }}</div>
                                <div class="mt-1">Phone: {{ $address['phone'] ?? '+60123456789' }}</div>
                            </div>
                        </div>
                        
                        <!-- Contact Summary -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Contact Details</h4>
                            <div class="text-sm text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-900 p-3 rounded-md">
                                <div>Email: {{ $contact['email'] ?? 'john@example.com' }}</div>
                                <div>Phone: {{ $contact['phone'] ?? '+60123456789' }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Payment Method</h3>
                        
                        <form id="payment-form" action="{{ route('payment.process') }}" method="POST" class="space-y-6">
                            @csrf
                            
                            <!-- Payment Method Selection -->
                            <div class="space-y-4">
                                <div class="flex items-center">
                                    <input type="radio" id="payment-card" name="payment_method" value="card" checked
                                           class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                                    <label for="payment-card" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Credit/Debit Card
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="radio" id="payment-fpx" name="payment_method" value="fpx"
                                           class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                                    <label for="payment-fpx" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        FPX Online Banking
                                    </label>
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="radio" id="payment-cod" name="payment_method" value="cod"
                                           class="h-4 w-4 text-green-600 border-gray-300 focus:ring-green-500">
                                    <label for="payment-cod" class="ml-3 text-sm font-medium text-gray-700 dark:text-gray-300">
                                        Cash on Delivery
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Card Payment Form -->
                            <div id="card-form" class="space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div>
                                    <label for="cardholder_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Cardholder Name *
                                    </label>
                                    <input type="text" id="cardholder_name" name="cardholder_name" required
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                           placeholder="Name as it appears on card">
                                </div>
                                
                                <div>
                                    <label for="card_number" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Card Number *
                                    </label>
                                    <input type="text" id="card_number" name="card_number" required maxlength="19"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                           placeholder="1234 5678 9012 3456">
                                    <div class="text-xs text-gray-500 mt-1">16-digit card number</div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="expiry_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Expiry Date *
                                        </label>
                                        <input type="text" id="expiry_date" name="expiry_date" required maxlength="5"
                                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                               placeholder="MM/YY">
                                    </div>
                                    
                                    <div>
                                        <label for="cvc" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            CVC *
                                        </label>
                                        <input type="text" id="cvc" name="cvc" required maxlength="4"
                                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                               placeholder="123">
                                        <div class="text-xs text-gray-500 mt-1">3-4 digit security code</div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- FPX Bank Selection -->
                            <div id="fpx-form" class="hidden space-y-4 border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div>
                                    <label for="bank_selection" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Select Your Bank *
                                    </label>
                                    <select id="bank_selection" name="bank_selection"
                                            class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">Choose your bank</option>
                                        <option value="maybank">Maybank</option>
                                        <option value="cimb">CIMB Bank</option>
                                        <option value="public_bank">Public Bank</option>
                                        <option value="rhb">RHB Bank</option>
                                        <option value="hong_leong">Hong Leong Bank</option>
                                        <option value="ambank">AmBank</option>
                                        <option value="uob">UOB Bank</option>
                                        <option value="ocbc">OCBC Bank</option>
                                        <option value="hsbc">HSBC Bank</option>
                                        <option value="standard_chartered">Standard Chartered</option>
                                    </select>
                                    <div class="text-xs text-gray-500 mt-1">You'll be redirected to your bank's secure login page</div>
                                </div>
                            </div>
                            
                            <!-- COD Information -->
                            <div id="cod-info" class="hidden border-t border-gray-200 dark:border-gray-700 pt-6">
                                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                                                Cash on Delivery
                                            </h3>
                                            <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                                                <ul class="list-disc pl-5 space-y-1">
                                                    <li>Pay with cash when your order is delivered</li>
                                                    <li>Please have exact change ready</li>
                                                    <li>Delivery fee still applies</li>
                                                    <li>Order confirmation will be sent via SMS/email</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </form>
                    </div>
                    
                </div>

                <!-- Order Summary Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>
                        
                        @php
                            $cart = session('cart', []);
                            $subtotal = 0;
                        @endphp
                        
                        <!-- Order Items -->
                        <div class="space-y-3 mb-4 max-h-48 overflow-y-auto">
                            @forelse($cart as $item)
                                @php
                                    $itemTotal = ($item['unit_price'] ?? $item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                    $subtotal += $itemTotal;
                                @endphp
                                <div class="flex justify-between text-sm">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $item['name'] ?? $item['product_name'] ?? 'Item' }}
                                        </div>
                                        <div class="text-gray-500 dark:text-gray-400">
                                            Qty: {{ $item['quantity'] ?? 1 }}
                                        </div>
                                    </div>
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        RM {{ number_format($itemTotal, 2) }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-sm text-gray-500 dark:text-gray-400">No items in cart</div>
                            @endforelse
                        </div>
                        
                        @php
                            $deliveryFee = 5.00;
                            $grandTotal = $subtotal + $deliveryFee;
                        @endphp
                        
                        <!-- Totals -->
                        <div class="space-y-3 text-sm border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Delivery Fee</span>
                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($deliveryFee, 2) }}</span>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between text-base font-semibold">
                                <span class="text-gray-900 dark:text-gray-100">Total</span>
                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Sticky Bottom Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-4 shadow-lg z-50">
        <div class="max-w-4xl mx-auto flex items-center justify-center">
            <button type="submit" form="payment-form" id="pay-now-btn" disabled
                    class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                </svg>
                Pay Now - RM {{ number_format($grandTotal, 2) }}
            </button>
        </div>
    </div>

</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethodRadios = document.querySelectorAll('input[name="payment_method"]');
    const cardForm = document.getElementById('card-form');
    const fpxForm = document.getElementById('fpx-form');
    const codInfo = document.getElementById('cod-info');
    const payNowBtn = document.getElementById('pay-now-btn');
    const form = document.getElementById('payment-form');
    
    // Handle payment method changes
    function handlePaymentMethodChange() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        
        // Hide all forms
        cardForm.classList.add('hidden');
        fpxForm.classList.add('hidden');
        codInfo.classList.add('hidden');
        
        // Show relevant form
        if (selectedMethod === 'card') {
            cardForm.classList.remove('hidden');
        } else if (selectedMethod === 'fpx') {
            fpxForm.classList.remove('hidden');
        } else if (selectedMethod === 'cod') {
            codInfo.classList.remove('hidden');
        }
        
        validateForm();
    }
    
    // Form validation
    function validateForm() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        let isValid = true;
        
        if (selectedMethod === 'card') {
            const cardFields = ['cardholder_name', 'card_number', 'expiry_date', 'cvc'];
            cardFields.forEach(fieldName => {
                const field = document.getElementById(fieldName);
                if (!field.value.trim()) {
                    isValid = false;
                }
            });
        } else if (selectedMethod === 'fpx') {
            const bankSelect = document.getElementById('bank_selection');
            if (!bankSelect.value) {
                isValid = false;
            }
        }
        // COD doesn't require additional validation
        
        payNowBtn.disabled = !isValid;
        return isValid;
    }
    
    // Format card number input
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        if (formattedValue !== e.target.value) {
            e.target.value = formattedValue;
        }
        validateForm();
    });
    
    // Format expiry date input
    document.getElementById('expiry_date').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
        validateForm();
    });
    
    // Format CVC input
    document.getElementById('cvc').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
        validateForm();
    });
    
    // Event listeners
    paymentMethodRadios.forEach(radio => {
        radio.addEventListener('change', handlePaymentMethodChange);
    });
    
    // Listen for input changes on card form
    cardForm.addEventListener('input', validateForm);
    fpxForm.addEventListener('change', validateForm);
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (!validateForm()) {
            alert('Please fill in all required fields.');
            return;
        }
        
        // Simulate payment processing
        payNowBtn.innerHTML = '<svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Processing...';
        payNowBtn.disabled = true;
        
        // Submit the form normally
        form.submit();
    });
    
    // Initial setup
    handlePaymentMethodChange();
});
</script>

<!-- TODO: integrate Strategy pattern later; TODO: basic client-side validation; TODO: on submit, simulate success and redirect to order confirmation -->