<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pizza Size Prices') }}
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
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Pizza</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Size</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Price (RM)</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                        @foreach ($pizzaSizePrices as $price)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $price->id }}</th>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">
                                    {{ $price->pizza->product->name }}
                                </td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">
                                    {{ $price->size->name }}
                                </td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">
                                    {{ number_format($price->base_price, 2) }}
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
