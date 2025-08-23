<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order Confirmation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <!-- Success Message -->
                    <div class="mb-8 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-medium text-green-800 dark:text-green-200">
                                    Order Confirmed!
                                </h3>
                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">
                                    Thank you for your order. We've received your payment and are preparing your food.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        
                        <!-- Order Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Information</h3>
                            <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4 space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Order Number:</span>
                                    <span class="font-semibold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Customer:</span>
                                    <span class="font-semibold">{{ $order->customer_name }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Status:</span>
                                    <span class="px-2 py-1 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-md text-sm">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Payment Method:</span>
                                    <span class="font-semibold">
                                        @switch($order->payment_method)
                                            @case('card')
                                                Credit/Debit Card
                                                @break
                                            @case('fpx')
                                                FPX Online Banking
                                                @break
                                            @case('cod')
                                                Cash on Delivery
                                                @break
                                            @default
                                                {{ ucfirst($order->payment_method) }}
                                        @endswitch
                                    </span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600 dark:text-gray-400">Order Date:</span>
                                    <span class="font-semibold">{{ $order->created_at->format('M d, Y h:i A') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Items -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Items</h3>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                    <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $item->product->name }}
                                                </h4>
                                                
                                                @if($item->pizzaDetails)
                                                    <div class="text-sm text-gray-600 dark:text-gray-400 mt-1 space-y-1">
                                                        <div><strong>Size:</strong> {{ $item->pizzaDetails->size->name }}</div>
                                                        <div><strong>Crust:</strong> {{ $item->pizzaDetails->crust->name }}</div>
                                                        @if($item->toppings->count() > 0)
                                                            <div>
                                                                <strong>Toppings:</strong>
                                                                {{ $item->toppings->pluck('topping.name')->join(', ') }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endif
                                                
                                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    Quantity: {{ $item->quantity }}
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                                    RM {{ number_format($item->final_price, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Order Total -->
                    @php
                        $subtotal = $order->items->sum('final_price');
                        $deliveryFee = 5.00; // Same as used in other views
                        $calculatedTotal = $subtotal + $deliveryFee;
                    @endphp
                    
                    <div class="mt-8 bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>
                        <div class="space-y-2">
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
                                <span class="text-gray-900 dark:text-gray-100">Total</span>
                                <span class="text-green-600 dark:text-green-400">RM {{ number_format($order->total_amount, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('orders.create') }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 3H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17M17 13v4a2 2 0 01-2 2H9a2 2 0 01-2-2v-4m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01" />
                            </svg>
                            Order Again
                        </a>
                        
                        <a href="{{ route('orders.show', $order->id) }}" 
                           class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            View Order Details
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>