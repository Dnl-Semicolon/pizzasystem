<x-admin-layout>
    <div class="p-4 sm:ml-64">
        <div class="p-4 sm:border-2 sm:border-gray-200 sm:border-dashed rounded-lg dark:border-gray-700 mt-14">
            <!-- KPI cards -->
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-4">
                <!-- Total Pizzas -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Total Pizzas</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">{{ $pizzaDelta ?? '+0%' }}</span>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $pizzasCount ?? ($products->count() ?? 0) }}</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">All-time</p>
                        </div>
                        {{-- tiny bar trend (last 7 days) --}}
                        @php $bars = $pizzaTrend ?? [5,7,3,6,8,9,4]; $max = max($bars) ?: 1; @endphp
                        <div class="flex items-end gap-1 h-12 w-32">
                            @foreach($bars as $v)
                                <div class="w-2 rounded bg-gradient-to-t from-gray-300 to-gray-500 dark:from-gray-700 dark:to-gray-400" style="height: {{ intval(($v/$max)*100) }}%"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Orders Today -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Orders Today</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">{{ $ordersDelta ?? '+0%' }}</span>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $ordersToday ?? 0 }}</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">vs yesterday</p>
                        </div>
                        @php $bars = $ordersTrend ?? [3,2,4,5,6,5,7]; $max = max($bars) ?: 1; @endphp
                        <div class="flex items-end gap-1 h-12 w-32">
                            @foreach($bars as $v)
                                <div class="w-2 rounded bg-gradient-to-t from-gray-300 to-gray-500 dark:from-gray-700 dark:to-gray-400" style="height: {{ intval(($v/$max)*100) }}%"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Revenue (RM) -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Revenue</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">RM</span>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <div class="text-2xl xl:text-xl font-semibold text-gray-900 dark:text-gray-100">RM {{ number_format($revenueToday ?? 0, 2) }}</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Today</p>
                        </div>
                        @php $bars = $revenueTrend ?? [120,340,280,500,420,610,700]; $max = max($bars) ?: 1; @endphp
                        <div class="flex items-end gap-1 h-12 w-32">
                            @foreach($bars as $v)
                                @php $h = intval(($v/$max)*100); @endphp
                                <div class="w-2 rounded bg-gradient-to-t from-gray-300 to-gray-500 dark:from-gray-700 dark:to-gray-400" style="height: {{ $h }}%"></div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Active Users -->
                <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4">
                    <div class="flex items-center justify-between">
                        <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">Active Users</p>
                        <span class="text-xs px-2 py-1 rounded-full bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-300">{{ $activeUsersDelta ?? '+0%' }}</span>
                    </div>
                    <div class="mt-3 flex items-end justify-between">
                        <div>
                            <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ $activeUsers ?? ($users->count() ?? 0) }}</div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Last 24h</p>
                        </div>
                        @php $bars = $activeUsersTrend ?? [1,3,2,5,3,4,6]; $max = max($bars) ?: 1; @endphp
                        <div class="flex items-end gap-1 h-12 w-32">
                            @foreach($bars as $v)
                                <div class="w-2 rounded bg-gradient-to-t from-gray-300 to-gray-500 dark:from-gray-700 dark:to-gray-400" style="height: {{ intval(($v/$max)*100) }}%"></div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
