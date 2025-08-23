<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pizza Order Item Toppings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full text-left border-collapse border-gray-400 dark:border-gray-600">
                        <thead class="font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Order ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Order Item ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Topping ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Topping Price</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                        @foreach ($toppings as $topping)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $topping->id }}</th>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">Ordered By {{ $topping->orderItem->order->customer_name }} <span class="font-mono text-sm">({{ $topping->orderItem->order_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{$topping->orderItem->product->name}} <span class="font-mono text-sm">({{ $topping->order_item_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $topping->topping->name }} <span class="font-mono text-sm">({{ $topping->topping_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">RM {{ number_format($topping->topping_price, 2) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
