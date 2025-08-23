<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    Order #{{ $order->id }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
            <div class="mt-2 sm:mt-0">
                <span @class([
                    'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                    'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' => $order->status === 'pending',
                    'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300' => $order->status === 'processing',
                    'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300' => $order->status === 'preparing',
                    'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300' => $order->status === 'out_for_delivery',
                    'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' => $order->status === 'delivered',
                ])>
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Thank You Message -->
            @if($order->status !== 'delivered')
                <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-lg font-medium text-green-800 dark:text-green-200">
                                Thank you for your order!
                            </h3>
                            <p class="text-green-700 dark:text-green-300 mt-1">
                                Your order has been received and is being processed. We'll notify you when it's ready.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Order Tracking -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Order Progress</h3>
                    
                    <div class="relative">
                        <!-- Progress Line -->
                        <div class="absolute left-4 top-8 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-600"></div>
                        
                        <!-- Progress Steps -->
                        <div class="space-y-6">
                            <!-- Processing -->
                            <div class="relative flex items-start">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ in_array($order->status, ['processing', 'preparing', 'out_for_delivery', 'delivered']) ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600' }}">
                                    @if(in_array($order->status, ['processing', 'preparing', 'out_for_delivery', 'delivered']))
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @else
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Order Received</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">We've received your order and payment</p>
                                    @if($order->status === 'processing' || in_array($order->status, ['preparing', 'out_for_delivery', 'delivered']))
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ $order->created_at->format('M j, g:i A') }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Preparing -->
                            <div class="relative flex items-start">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ in_array($order->status, ['preparing', 'out_for_delivery', 'delivered']) ? 'bg-green-500' : ($order->status === 'processing' ? 'bg-orange-500' : 'bg-gray-300 dark:bg-gray-600') }}">
                                    @if(in_array($order->status, ['preparing', 'out_for_delivery', 'delivered']))
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @elseif($order->status === 'processing')
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    @else
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Preparing Your Order</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Our chefs are preparing your delicious pizza</p>
                                    @if($order->status === 'processing')
                                        <p class="text-xs text-orange-600 dark:text-orange-400">Current step</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Out for Delivery -->
                            <div class="relative flex items-start">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ in_array($order->status, ['out_for_delivery', 'delivered']) ? 'bg-green-500' : ($order->status === 'preparing' ? 'bg-blue-500' : 'bg-gray-300 dark:bg-gray-600') }}">
                                    @if(in_array($order->status, ['out_for_delivery', 'delivered']))
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @elseif($order->status === 'preparing')
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    @else
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Out for Delivery</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Your order is on its way to you</p>
                                    @if($order->status === 'preparing')
                                        <p class="text-xs text-blue-600 dark:text-blue-400">Next step</p>
                                    @elseif($order->status === 'out_for_delivery')
                                        <p class="text-xs text-blue-600 dark:text-blue-400">Current step - ETA: 15-20 minutes</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Delivered -->
                            <div class="relative flex items-start">
                                <div class="flex items-center justify-center w-8 h-8 rounded-full {{ $order->status === 'delivered' ? 'bg-green-500' : ($order->status === 'out_for_delivery' ? 'bg-green-500' : 'bg-gray-300 dark:bg-gray-600') }}">
                                    @if($order->status === 'delivered')
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @elseif($order->status === 'out_for_delivery')
                                        <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                                    @else
                                        <div class="w-2 h-2 bg-white rounded-full"></div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Delivered</h4>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Enjoy your meal!</p>
                                    @if($order->status === 'delivered')
                                        <p class="text-xs text-green-600 dark:text-green-400">Order completed</p>
                                    @elseif($order->status === 'out_for_delivery')
                                        <p class="text-xs text-green-600 dark:text-green-400">Final step</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start mb-6">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Order #{{ $order->id }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                            </p>
                        </div>
                        <div class="mt-4 sm:mt-0 text-right">
                            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                RM {{ number_format($order->total_amount, 2) }}
                            </p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                        </div>
                    </div>

                    <!-- Customer Info -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-6">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-2">Customer Information</h4>
                        <p class="text-gray-700 dark:text-gray-300">{{ $order->customer_name }}</p>
                    </div>

                    <!-- Order Items -->
                    <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Order Items</h4>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <h5 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                {{ $item->product->name }}
                                            </h5>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Quantity: {{ $item->quantity }}
                                            </p>

                                            @if ($item->pizzaDetails)
                                                <div class="mt-3 space-y-2">
                                                    <div class="flex flex-wrap gap-4 text-sm">
                                                        <span class="inline-flex items-center px-2 py-1 rounded-md bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                            {{ $item->pizzaDetails->size->name }}
                                                        </span>
                                                        <span class="inline-flex items-center px-2 py-1 rounded-md bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200">
                                                            {{ $item->pizzaDetails->crust->name }} Crust
                                                        </span>
                                                    </div>
                                                    
                                                    @if ($item->toppings->isNotEmpty())
                                                        <div>
                                                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Toppings:</p>
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach ($item->toppings as $t)
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200 text-xs">
                                                                        {{ $t->topping->name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-right ml-4">
                                            <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                RM {{ number_format($item->final_price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row gap-4">
                @if($order->status === 'delivered')
                    <button type="button" 
                            class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reorder
                    </button>
                @endif
                <a href="{{ route('products.index') }}" 
                   class="inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    Continue Shopping
                </a>
                <a href="{{ route('history.index') }}" 
                   class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    View Order History
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
