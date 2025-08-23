<x-app-layout>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-red-600 to-red-800 dark:from-red-700 dark:to-red-900">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold text-white mb-6">
                    Authentic Italian Pizzas
                </h1>
                <p class="text-xl md:text-2xl text-red-100 mb-8 max-w-3xl mx-auto">
                    Crafted with love, using the finest ingredients and traditional recipes passed down through generations
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-red-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                        Order Now
                    </a>
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-lg font-medium rounded-md text-white hover:bg-white hover:text-red-600 transition duration-150 ease-in-out">
                        View Menu
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Pizzas Section -->
    <div class="py-16 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Our Signature Pizzas
                </h2>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Discover our most popular pizzas, made fresh daily with premium ingredients
                </p>
            </div>

            @if($featuredProducts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($featuredProducts as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="aspect-w-16 aspect-h-12 bg-gray-200 dark:bg-gray-700">
                                @if($product->image_url)
                                    <img src="{{ asset($product->image_url) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center">
                                        <span class="text-white text-xl font-semibold">🍕</span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                    {{ $product->name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">
                                    {{ $product->description }}
                                </p>
                                @if($product->pizza && $product->pizza->sizePrices->count() > 0)
                                    <div class="flex items-center justify-between">
                                        <div class="text-sm text-gray-500 dark:text-gray-400">
                                            Starting from
                                        </div>
                                        <div class="text-lg font-bold text-red-600 dark:text-red-400">
                                            RM{{ number_format($product->pizza->sizePrices->min('base_price'), 2) }}
                                        </div>
                                    </div>
                                @endif
                                <div class="mt-4">
                                    <a href="{{ route('pizzas.show', $product->id) }}"
                                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                        Order Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400">No featured pizzas available at the moment.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white dark:bg-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    Why Choose Us?
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Fast Delivery</h3>
                    <p class="text-gray-600 dark:text-gray-400">Hot, fresh pizzas delivered to your door in 30 minutes or less</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Quality Ingredients</h3>
                    <p class="text-gray-600 dark:text-gray-400">Only the finest, freshest ingredients make it onto our pizzas</p>
                </div>

                <div class="text-center">
                    <div class="w-16 h-16 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Made with Love</h3>
                    <p class="text-gray-600 dark:text-gray-400">Each pizza is handcrafted with passion and traditional techniques</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action Section -->
    <div class="bg-red-600 dark:bg-red-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="text-center">
                <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">
                    Ready to Order?
                </h2>
                <p class="text-xl text-red-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of satisfied customers who trust us for their pizza cravings
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('orders.create') }}" class="inline-flex items-center justify-center px-8 py-4 border border-transparent text-lg font-medium rounded-md text-red-600 bg-white hover:bg-gray-50 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m-2.4 0l-.4-2M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H15M17 13v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6"></path>
                        </svg>
                        Start Your Order
                    </a>
                    <a href="{{ route('cart.index') }}" class="inline-flex items-center justify-center px-8 py-4 border-2 border-white text-lg font-medium rounded-md text-white hover:bg-white hover:text-red-600 transition duration-150 ease-in-out">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        View Cart
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
