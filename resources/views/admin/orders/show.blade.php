@section('title', 'Order #' . $order->id . ' | Pizza Admin')
<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 sm:border-2 sm:border-gray-200 sm:border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- Breadcrumb -->
            <nav class="mb-6" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                    <li><a href="{{ route('admin.orders.index') }}" class="hover:text-gray-700 dark:hover:text-gray-200">Orders</a></li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span>#{{ $order->id }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Page header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Order #{{ $order->id }}</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Placed {{ $order->created_at->format('d/m/Y, H:i:s') }}</p>
                    </div>
                    <div class="flex items-center">
                        <span @class([
                            'inline-flex rounded-full px-3 py-1 text-sm font-medium ring-1 ring-inset',
                            'text-gray-700 ring-gray-300 bg-gray-50 dark:text-gray-300 dark:ring-gray-600 dark:bg-gray-800' => $order->status === 'pending',
                            'text-amber-700 ring-amber-300 bg-amber-50 dark:text-amber-300 dark:ring-amber-600 dark:bg-amber-800/20' => $order->status === 'draft',
                            'text-red-700 ring-red-300 bg-red-50 dark:text-red-300 dark:ring-red-600 dark:bg-red-800/20' => $order->status === 'pending_payment',
                            'text-emerald-700 ring-emerald-300 bg-emerald-50 dark:text-emerald-300 dark:ring-emerald-600 dark:bg-emerald-800/20' => in_array($order->status, ['paid', 'processing']),
                            'text-orange-700 ring-orange-300 bg-orange-50 dark:text-orange-300 dark:ring-orange-600 dark:bg-orange-800/20' => $order->status === 'preparing',
                            'text-blue-700 ring-blue-300 bg-blue-50 dark:text-blue-300 dark:ring-blue-600 dark:bg-blue-800/20' => $order->status === 'out_for_delivery',
                            'text-green-700 ring-green-300 bg-green-50 dark:text-green-300 dark:ring-green-600 dark:bg-green-800/20' => $order->status === 'delivered',
                        ])>
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Flash messages -->
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Items Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Items</h2>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-800/50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pizza</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Modifiers</th>
                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Qty</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unit</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach ($order->items as $item)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                            <td class="px-6 py-4">
                                                <div class="font-medium text-gray-900 dark:text-gray-100">
                                                    {{ $item->product->name }}
                                                    @if ($item->pizzaDetails)
                                                        <span class="text-sm text-gray-500 dark:text-gray-400">({{ $item->pizzaDetails->size->name }})</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @if ($item->pizzaDetails)
                                                    <div class="space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                                        <div>{{ $item->pizzaDetails->crust->name }} crust</div>
                                                        @if ($item->toppings->isNotEmpty())
                                                            <div class="flex flex-wrap gap-1">
                                                                @foreach ($item->toppings as $topping)
                                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                                                        {{ $topping->topping->name }}
                                                                    </span>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center text-sm text-gray-900 dark:text-gray-100">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm text-gray-900 dark:text-gray-100">
                                                RM{{ number_format($item->unit_price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 text-right text-sm font-medium text-gray-900 dark:text-gray-100">
                                                RM{{ number_format($item->final_price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Summary Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Summary</h2>
                        </div>
                        <div class="px-6 py-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-gray-900 dark:text-gray-100">Total</span>
                                <span class="text-2xl font-bold text-gray-900 dark:text-gray-100">RM{{ number_format($order->grand_total_cents / 100, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Customer</h2>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            <div>
                                <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Actions Section -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Actions</h2>
                        </div>
                        <div class="px-6 py-4 space-y-3">
                            @if(in_array($order->status, ['paid', 'processing']))
                                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="preparing">
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Start Preparing
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'preparing')
                                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="out_for_delivery">
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-500 hover:bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Out for Delivery
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'out_for_delivery')
                                <form method="POST" action="{{ route('admin.orders.update-status', $order->id) }}" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-500 hover:bg-green-600 border border-transparent rounded-md font-semibold text-sm text-white tracking-widest focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        Mark Delivered
                                    </button>
                                </form>
                            @endif

                            @if($order->status === 'delivered')
                                <div class="w-full text-center text-sm text-gray-500 dark:text-gray-400 py-2">
                                    Order completed
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
