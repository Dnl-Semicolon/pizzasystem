{{-- resources/views/history/index.blade.php - Fixed order totals to use grand_total_cents and updated status colors --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Order History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('history.index') }}" class="space-y-4 md:space-y-0 md:flex md:items-center md:space-x-4">
                        <!-- Search -->
                        <div class="flex-1">
                            <label for="search" class="sr-only">Search orders</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text"
                                       name="search"
                                       id="search"
                                       value="{{ request('search') }}"
                                       placeholder="Search by order ID or pizza name..."
                                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md leading-5 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-red-500 focus:border-red-500">
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="sr-only">Filter by status</label>
                            <select name="status"
                                    id="status"
                                    class="block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500">
                                <option value="all" {{ request('status') === 'all' ? 'selected' : '' }}>All Orders</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                                <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="preparing" {{ request('status') === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="out_for_delivery" {{ request('status') === 'out_for_delivery' ? 'selected' : '' }}>Out for Delivery</option>
                                <option value="delivered" {{ request('status') === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.414A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter
                        </button>

                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('history.index') }}"
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                Clear
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            <!-- Orders List -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if($orders->count() > 0)
                    <div class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($orders as $order)
                            <div class="p-6 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150 ease-in-out">
                                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                                    <!-- Order Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-4 mb-3">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                Order #{{ $order->id }}
                                            </h3>
                                            <span @class([
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300' => $order->status === 'pending',
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-300' => $order->status === 'draft',
                                                'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-300' => $order->status === 'pending_payment',
                                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' => $order->status === 'paid',
                                                'bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300' => in_array($order->status, ['processing', 'preparing']),
                                                'bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300' => $order->status === 'out_for_delivery',
                                                'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300' => $order->status === 'delivered',
                                            ])>
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </div>

                                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                            <p>Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                                            <p>{{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }} • Total: <span class="font-semibold text-gray-900 dark:text-gray-100">RM{{ number_format($order->grand_total_cents / 100, 2) }}</span></p>
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
                                           class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                            View Details
                                        </a>
                                        @if($order->status === 'delivered')
                                            <button type="button"
                                                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                                Reorder
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="bg-white dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700 dark:text-gray-300">
                                Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                            </div>
                            <div>
                                {{ $orders->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No orders found</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            @if(request()->hasAny(['search', 'status']))
                                Try adjusting your search criteria or
                                <a href="{{ route('history.index') }}" class="text-red-600 hover:text-red-500">clear filters</a>.
                            @else
                                You haven't placed any orders yet.
                            @endif
                        </p>
                        @if(!request()->hasAny(['search', 'status']))
                            <div class="mt-6">
                                <a href="{{ route('products.index') }}"
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Start Shopping
                                </a>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
