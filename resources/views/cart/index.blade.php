<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">{{ __("Your Cart") }}</h3>

{{--                    @php $cart = session('cart', []); @endphp--}}

                    @if (count($cart) === 0)
                        <p class="text-gray-500 dark:text-gray-400">Cart is empty.</p>
                    @else
                        <table class="table-auto w-full text-left border border-gray-300 dark:border-gray-700">
                            <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700">
                                <th class="px-4 py-2 border">Item</th>
                                <th class="px-4 py-2 border">Type</th>
                                <th class="px-4 py-2 border">Qty</th>
                                <th class="px-4 py-2 border">Price</th>
                                <th class="px-4 py-2 border">Total</th>
                                <th class="px-4 py-2 border">Details</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($cart as $item)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $item['product_name'] }}</td>
                                    <td class="px-4 py-2 border capitalize">{{ $item['type'] }}</td>
                                    <td class="px-4 py-2 border">{{ $item['quantity'] }}</td>
                                    <td class="px-4 py-2 border">RM {{ number_format($item['unit_price'], 2) }}</td>
                                    <td class="px-4 py-2 border">RM {{ number_format($item['total_price'], 2) }}</td>
                                    <td class="px-4 py-2 border text-sm">
                                        @if ($item['type'] === 'pizza')
                                            <div>Size: {{ $item['size'] }}</div>
                                            <div>Crust: {{ $item['crust'] }}</div>
                                            <div>Toppings:
                                                @if (!empty($item['toppings']))
                                                    {{ implode(', ', $item['toppings']) }}
                                                @else
                                                    None
                                                @endif
                                            </div>
                                        @else
                                            <span class="italic text-gray-500 dark:text-gray-400">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <form action="{{ route('orders.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="mt-6 bg-blue-600 text-white py-2 px-4 rounded">
                                Place Order
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
