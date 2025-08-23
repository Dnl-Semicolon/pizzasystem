<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-6 pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Order Summary -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>
                        
                        @php
                            $cart = session('cart', []);
                            $subtotal = 0;
                        @endphp
                        
                        @if(empty($cart))
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p>Your cart is empty</p>
                                <a href="{{ route('orders.create') }}" class="text-green-600 hover:text-green-700 text-sm">Continue shopping</a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($cart as $item)
                                    @php
                                        $itemTotal = ($item['unit_price'] ?? $item['price'] ?? 0) * ($item['quantity'] ?? 1);
                                        $subtotal += $itemTotal;
                                    @endphp
                                    <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $item['name'] ?? $item['product_name'] ?? 'Item' }}
                                            </h4>
                                            @if(isset($item['size']) || isset($item['crust']))
                                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    @if(isset($item['size']))
                                                        <span>{{ $item['size'] }}</span>
                                                    @endif
                                                    @if(isset($item['crust']))
                                                        <span>• {{ $item['crust'] }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            @if(isset($item['toppings']) && !empty($item['toppings']))
                                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                                    Toppings: {{ is_array($item['toppings']) ? implode(', ', $item['toppings']) : $item['toppings'] }}
                                                </div>
                                            @endif
                                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Qty: {{ $item['quantity'] ?? 1 }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                RM {{ number_format($itemTotal, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Delivery Address -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Delivery Address</h3>
                        <x-address-book :useDefault="false" :addresses="[]" />
                    </div>

                    <!-- Contact Details -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Details</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email Address *
                                </label>
                                <input type="email" id="contact_email" name="contact_email" required
                                       value="{{ Auth::check() ? Auth::user()->email : '' }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="your@email.com">
                            </div>
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone Number *
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" required
                                       value="{{ Auth::check() ? (Auth::user()->phone ?? '') : '' }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="+60123456789">
                            </div>
                        </div>
                    </div>
                    
                </div>

                <!-- Order Total Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Total</h3>
                        
                        @php
                            $deliveryFee = 5.00; // Placeholder delivery fee
                            $grandTotal = $subtotal + $deliveryFee;
                        @endphp
                        
                        <div class="space-y-3 text-sm">
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
                        
                        <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
                            <p>* Delivery fee may vary based on location</p>
                            <p>* GST included where applicable</p>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Sticky Bottom Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-4 shadow-lg z-50">
        <div class="max-w-4xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('orders.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Cart
                </a>
                <div class="hidden sm:block text-sm text-gray-600 dark:text-gray-400">
                    Total: <span class="font-semibold text-gray-900 dark:text-gray-100">RM {{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>
            
            <form action="{{ route('payment.index') }}" method="GET" id="checkout-form" class="w-full sm:w-auto">
                <button type="submit" 
                        class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                    Continue to Payment
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <!-- Mobile Order Total (visible on mobile) -->
    <div class="sm:hidden block mb-4">
        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                <span>Subtotal</span>
                <span>RM {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                <span>Delivery</span>
                <span>RM {{ number_format($deliveryFee, 2) }}</span>
            </div>
            <div class="flex justify-between font-semibold text-gray-900 dark:text-gray-100">
                <span>Total</span>
                <span>RM {{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitButton = form.querySelector('button[type="submit"]');
    
    // Basic form validation
    function validateForm() {
        const requiredFields = document.querySelectorAll('input[required], select[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
            }
        });
        
        submitButton.disabled = !isValid;
        return isValid;
    }
    
    // Listen for input changes
    document.addEventListener('input', validateForm);
    document.addEventListener('change', validateForm);
    
    // Initial validation
    validateForm();
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Please fill in all required fields before continuing.');
            return;
        }
        
        // TODO: Collect and store form data in session before redirecting
        // This would include address, contact details, etc.
    });
});
</script>

<!-- TODO: persist chosen/entered address & contact to session for payment step; TODO: load user's real default address if exists -->