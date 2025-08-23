<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Success State -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900/30 mb-4">
                    <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">Payment Received!</h1>
                <p class="text-gray-600 dark:text-gray-400">Thank you for your order. We're preparing your delicious meal now.</p>
            </div>

            <!-- Order Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>
                
                @php
                    $cart = session('cart', []);
                    $subtotal = 0;
                    $orderNumber = 'ORD-' . strtoupper(uniqid());
                @endphp
                
                <!-- Order Number -->
                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-900 rounded-md">
                    <div class="text-sm text-gray-600 dark:text-gray-400">Order Number</div>
                    <div class="font-mono text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $orderNumber }}</div>
                </div>
                
                <!-- Order Items -->
                @if(!empty($cart))
                    <div class="space-y-4 mb-6">
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
                                        Quantity: {{ $item['quantity'] ?? 1 }}
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
                @else
                    <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                        <p>No order details available</p>
                    </div>
                @endif
                
                @php
                    $deliveryFee = 5.00;
                    $grandTotal = $subtotal + $deliveryFee;
                @endphp
                
                <!-- Order Totals -->
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
                    <div class="flex justify-between text-lg font-semibold">
                        <span class="text-gray-900 dark:text-gray-100">Total Paid</span>
                        <span class="text-green-600 dark:text-green-400">RM {{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Delivery Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Delivery Information</h3>
                
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
                    
                    $estimatedDelivery = now()->addMinutes(rand(30, 60));
                @endphp
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Delivery Address -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Delivery Address</h4>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <div class="font-medium">{{ $address['full_name'] ?? 'John Doe' }}</div>
                            <div>{{ $address['address_line_1'] ?? '123 Main Street' }}</div>
                            @if(!empty($address['address_line_2']))
                                <div>{{ $address['address_line_2'] }}</div>
                            @endif
                            <div>{{ $address['postcode'] ?? '50200' }} {{ $address['city'] ?? 'Kuala Lumpur' }}, {{ $address['state'] ?? 'Kuala Lumpur' }}</div>
                            <div class="mt-1">{{ $address['phone'] ?? '+60123456789' }}</div>
                        </div>
                    </div>
                    
                    <!-- Estimated Delivery -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Estimated Delivery</h4>
                        <div class="text-sm text-gray-600 dark:text-gray-400">
                            <div class="font-medium text-green-600 dark:text-green-400">
                                {{ $estimatedDelivery->format('g:i A') }}
                            </div>
                            <div>{{ $estimatedDelivery->format('l, M j') }}</div>
                            <div class="mt-2 text-xs">
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-200">
                                    <span class="w-2 h-2 bg-yellow-400 rounded-full mr-1 animate-pulse"></span>
                                    Preparing
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Contact Information -->
                <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-2">Contact Information</h4>
                    <div class="text-sm text-gray-600 dark:text-gray-400">
                        <div>Email: {{ $contact['email'] ?? 'john@example.com' }}</div>
                        <div>Phone: {{ $contact['phone'] ?? '+60123456789' }}</div>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6 mb-8">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">What's Next?</h3>
                <div class="space-y-2 text-sm text-blue-800 dark:text-blue-200">
                    <div class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Order confirmation has been sent to your email</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>You'll receive SMS updates on your order status</span>
                    </div>
                    <div class="flex items-start">
                        <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                        <span>Our delivery driver will call when they're nearby</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('orders.show', ['order' => '__TEMP__']) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    View Order Details
                </a>
                
                <a href="{{ route('orders.create') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Continue Shopping
                </a>
            </div>

            <!-- Customer Support -->
            <div class="text-center mt-8 text-sm text-gray-600 dark:text-gray-400">
                <p>Need help with your order?</p>
                <p class="mt-1">
                    Call us at <a href="tel:+60123456789" class="text-green-600 hover:text-green-700 font-medium">+60 12-345 6789</a> 
                    or email <a href="mailto:support@pizzaplace.com" class="text-green-600 hover:text-green-700 font-medium">support@pizzaplace.com</a>
                </p>
            </div>

        </div>
    </div>

</x-app-layout>

<!-- TODO: on real flow, create Order + OrderItems server-side, clear cart session, and use real order id here; TODO: flash success message -->