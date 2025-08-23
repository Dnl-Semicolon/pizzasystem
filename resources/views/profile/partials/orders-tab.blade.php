<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Orders</h3>
            <a href="{{ route('history.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                View All Orders
            </a>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $orderStats['total_orders'] }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Orders</div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">RM{{ number_format($orderStats['total_spent'], 2) }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Spent</div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $orderStats['favorite_pizza'] ?? '-' }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Favorite Pizza</div>
            </div>
        </div>
        
        @if($orders->count() > 0)
            <!-- Recent Orders List -->
            <div class="space-y-4">
                @foreach($orders as $order)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                            <!-- Order Info -->
                            <div class="flex-1">
                                <div class="flex items-center space-x-4 mb-3">
                                    <h4 class="text-md font-semibold text-gray-900 dark:text-gray-100">
                                        Order #{{ $order->id }}
                                    </h4>
                                    <span @class([
                                        'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                        'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' => $order->status === 'pending',
                                        'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300' => $order->status === 'processing',
                                        'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300' => $order->status === 'preparing',
                                        'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300' => $order->status === 'out_for_delivery',
                                        'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' => $order->status === 'delivered',
                                    ])>
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                </div>
                                
                                <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <p>{{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                                    <p>{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }} • <span class="font-semibold text-gray-900 dark:text-gray-100">RM{{ number_format($order->total_amount, 2) }}</span></p>
                                </div>

                                <!-- Order Items Preview -->
                                <div class="flex flex-wrap gap-2">
                                    @foreach($order->items->take(3) as $item)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-xs text-gray-600 dark:text-gray-300">
                                            {{ $item->quantity }}× {{ $item->product->name }}
                                            @if($item->pizzaDetails)
                                                ({{ $item->pizzaDetails->size->name }})
                                            @endif
                                        </span>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <span class="inline-flex items-center px-2 py-1 rounded-md bg-gray-100 dark:bg-gray-700 text-xs text-gray-600 dark:text-gray-300">
                                            +{{ $order->items->count() - 3 }} more
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="mt-4 lg:mt-0 lg:ml-6 flex flex-col sm:flex-row gap-2">
                                <a href="{{ route('orders.show', $order->id) }}" 
                                   class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                    View Details
                                </a>
                                @if($order->status === 'delivered')
                                    <button type="button" 
                                            class="inline-flex items-center justify-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                        Reorder
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($orderStats['total_orders'] > 5)
                <div class="mt-6 text-center">
                    <a href="{{ route('history.index') }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        View {{ $orderStats['total_orders'] - 5 }} More Orders
                    </a>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No orders yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Start your pizza journey by placing your first order!</p>
                <div class="mt-6 space-x-3">
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        Start Shopping
                    </a>
                    <a href="{{ route('pizzas.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Browse Pizzas
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>