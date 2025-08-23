<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pizza Order Item Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto sm:px-6 lg:px-8"> {{-- max-w-7xl  --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <table class="min-w-full text-left border-collapse border-gray-400 dark:border-gray-600">
                        <thead class="font-medium text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Order ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Order Item ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Pizza Size ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Crust ID</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Base Price</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Crust Addition</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Toppings Total</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Toppings</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                        @foreach ($details as $detail)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $detail->id }}</th>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">Ordered By {{ $detail->orderItem->order->customer_name }} <span class="font-mono text-sm">({{ $detail->orderItem->order_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{$detail->orderItem->product->name}} <span class="font-mono text-sm">({{ $detail->order_item_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{$detail->size->name}} <span class="font-mono text-sm">({{ $detail->pizza_size_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{$detail->crust->name}} <span class="font-mono text-sm">({{ $detail->crust_id }})</span></td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">RM {{ number_format($detail->base_price, 2) }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">RM {{ number_format($detail->crust_addition, 2) }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">RM {{ number_format($detail->toppings_total, 2) }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">
                                    @php
                                         /** @var $toppings */
                                        $relatedToppings = $toppings->where('order_item_id', $detail->order_item_id);
                                    @endphp

                                    @if ($relatedToppings->isEmpty())
                                        <span class="italic text-gray-500 dark:text-gray-400">None</span>
                                    @else
                                        <ul class="space-y-1">
                                            @foreach ($relatedToppings as $top)
                                                <li class="text-sm">
                                                    {{ $top->topping->name }}
                                                    <span class="font-mono text-xs text-gray-500">(+RM {{ number_format($top->topping_price, 2) }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
