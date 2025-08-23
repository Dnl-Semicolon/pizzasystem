@section('title', 'Order Dashboard | Pizza Admin')
<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 sm:border-2 sm:border-gray-200 sm:border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- Page header -->
            <div class="mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">Orders Dashboard</h1>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Monitor incoming orders and access full details.</p>
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- REFRESH Button --}}
                        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center rounded-md px-5 py-2 me-3 text-sm font-semibold text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-indigo-500">Orders</a>
                        {{-- C: CREATE PRODUCT Button --}}
                        <a href="#" class="inline-flex items-center px-3 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">New Order</a>
                    </div>
                </div>
            </div>

            <!-- Flash messages -->
            @if (session('success'))
                <div class="mb-4 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-md border border-red-200 bg-red-50 p-3 text-sm text-red-800 dark:border-red-900/40 dark:bg-red-900/20 dark:text-red-200">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Filters -->

            <div class="grid grid-cols-1 gap-4 xl:grid-cols-3 mb-8">
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm tracking-wide text-gray-500 dark:text-gray-400">Total Orders</p>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{$orders->count()}}</div>
                        </div>
                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm tracking-wide text-gray-500 dark:text-gray-400">Processing</p>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{$orders->where('status', 'processing')->count()}}</div>
                        </div>
                    </div>
                </div>
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-sm tracking-wide text-gray-500 dark:text-gray-400">Revenue (est.)</p>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            @php
                                $revenue = null;
                                if ($orders->count() !== 0) {
                                    foreach($orders as $order) {
                                        $revenue += $order->total_amount;
                                    }
                                    $revenue = round($revenue, 2);
                                }
                            @endphp
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">RM{{number_format($revenue, 2)}}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-2 flex items-center justify-between">
                <div class="flex items-center gap-2">
                </div>
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    {{ number_format($orders->total()) }} total
                </div>
            </div>

            <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="w-10 px-3 py-2">
                                <input id="select-all" type="checkbox" class="h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                            </th>
                            <th class="px-3 py-2 text-left text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Order</th>
                            <th class="px-3 py-2 text-left text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Customer</th>
                            <th class="px-3 py-2 text-left text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Status</th>
                            <th class="px-3 py-2 text-right text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Items</th>
                            <th class="px-3 py-2 text-right text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Total</th>
                            <th class="px-3 py-2 text-left text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Created</th>
                            <th class="px-3 py-2 text-right text-sm font-medium tracking-wider text-gray-600 dark:text-gray-300">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white dark:divide-gray-800 dark:bg-gray-900">
                        @forelse ($orders as $order)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/60">
                                <td class="px-3 py-2 align-middle">
                                    <input type="checkbox" name="ids[]" value="{{ $order->id }}" class="row-check h-4 w-4 rounded border-gray-300 dark:border-gray-600 dark:bg-gray-900">
                                </td>
                                <td class="px-3 py-2 align-middle">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">#{{ $order->id }}</div>
                                </td>
                                <td class="px-3 py-2 align-middle">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->customer_name }}</div>
                                </td>
                                <td class="px-3 py-2 align-middle">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">
                                        <span
                                            @class([
                                                'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-gray-700 ring-gray-300 bg-gray-50' => $order->status === 'out_for_delivery',
                                                'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-blue-700 ring-blue-300 bg-blue-50' => $order->status === 'preparing',
                                                'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-green-700 ring-green-300 bg-green-50' => $order->status === 'delivered',
                                                'inline-flex rounded-full px-2 py-0.5 text-xs font-medium ring-1 ring-inset text-amber-700 ring-amber-300 bg-amber-50' => $order->status === 'processing',
                                            ])>
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-3 py-2 align-middle text-right">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->items->count() }}</div>
                                </td>
                                <td class="px-3 py-2 align-middle text-right">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">RM{{ $order->total_amount }}</div>
                                </td>
                                <td class="px-3 py-2 align-middle text-left">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->created_at }}</div>
                                </td>
                                <td class="px-3 py-2 align-top">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{route('admin.orders.show', $order->id)}}" class="rounded-md border border-gray-300 px-2.5 py-1.5 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-700 dark:text-gray-200 dark:hover:bg-gray-800">
                                            View
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-3 py-10 text-center text-sm text-gray-500 dark:text-gray-400">
                                    No orders found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between border-t border-gray-200 bg-white px-3 py-2 text-sm text-gray-600 dark:border-gray-800 dark:bg-gray-900 dark:text-gray-300">
                <div>
                    <div class="sm:hidden">
                        Showing
                        <span class="font-medium">{{ $orders->firstItem() ?: 0 }}</span>
                        to
                        <span class="font-medium">{{ $orders->lastItem() ?: 0 }}</span>
                        of
                        <span class="font-medium">{{ $orders->total() }}</span>
                        results
                    </div>
                </div>
                <div class="flex items-center">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>

        </div>
    </div>
    <!-- Select all (vanilla JS, no dependency) -->
    <script>
        (function () {
            const all = document.getElementById('select-all');
            const rows = Array.from(document.querySelectorAll('.row-check'));
            if (!all || rows.length === 0) return;
            all.addEventListener('change', () => {
                rows.forEach(cb => cb.checked = all.checked);
            });
        })();
    </script>
</x-admin-layout>
