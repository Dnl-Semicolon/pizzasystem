<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Products') }}
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
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Name</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Type</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Description</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Price</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Is Active</th>
                            <th scope="col" class="px-4 py-2 border-gray-300 dark:border-gray-700">Created At</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                        @foreach ($products as $product)
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $product->id }}</th>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $product->name }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $product->type }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $product->description }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">RM {{ number_format($product->price, 2) }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $product->is_active }}</td>
                                <td class="px-4 py-2 border-gray-300 dark:border-gray-700">{{ $product->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
