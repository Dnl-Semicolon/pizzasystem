@php use App\Models\CrustPriceAddition; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{-- Header Text --}}
            {{ __('Menu') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid grid-cols-1 md:grid-cols-8 gap-8">

                            {{-- Product Menu --}}
                            <div class="md:col-span-5">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">Menu</h3>

                                {{-- Grouped by type --}}
                                @php
                                    /**
                                     * @var $products
                                     */
                                    $grouped = $products->groupBy('type');
                                @endphp

                                @foreach ($grouped as $type => $group)
                                    <h4 class="text-md font-bold text-gray-600 dark:text-gray-300 mt-6 mb-2 capitalize">{{ $type }}</h4>
                                    <div class="grid lg:grid-cols-2 gap-4">
                                        @foreach ($group as $product)
                                            <div class="border border-gray-300 dark:border-gray-400 rounded-lg p-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 shadow">
                                                <img src="{{ $product->image_url ? asset($product->image_url) : 'https://placehold.co/600x400.png' }}" alt="">
                                                <div class="font-semibold text-lg mb-1">{{ $product->name }}</div>
                                                <p class="lg:min-h-20 min-h-10 text-sm text-gray-500 dark:text-gray-400 mb-2">{{ $product->description }}</p>

                                                @if ($product->type === 'pizza')
                                                    <form method="POST" action="{{ route('cart.add') }}">
                                                        @csrf
                                                        <input type="hidden" name="pizza_id" value="{{ $product->pizza->id }}">
                                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                        <select name="variant" class="w-full text-sm rounded border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200">
                                                            @foreach($product->pizza->sizePrices as $sizePrice)
                                                                @foreach($crusts as $crust)
                                                                    @php
                                                                        $base = $product->pizza->sizePrices()
                                                                            ->where('pizza_size_id', $sizePrice->pizza_size_id)
                                                                            ->first()?->base_price;

                                                                        $addon = CrustPriceAddition::where('crust_id', $crust->id)
                                                                            ->where('pizza_size_id', $sizePrice->pizza_size_id)
                                                                            ->first()?->price_addition;
                                                                    @endphp

                                                                    @if(!is_null($base) && !is_null($addon))
                                                                        <option value="{{ $sizePrice->pizza_size_id }}_{{ $crust->id }}">
                                                                            {{ $sizePrice->size->name }} {{ $crust->name }} — RM {{ number_format($base + $addon, 2) }}
                                                                        </option>
                                                                    @endif
                                                                @endforeach
                                                            @endforeach
                                                        </select>
                                                        <div class="flex justify-between items-center mt-4">
                                                            <a href="{{ route('pizzas.show', $product->pizza->id) }}"
                                                                   class="text-blue-600 dark:text-blue-400 text-sm hover:text-white bg-gray-100 dark:bg-gray-700 hover:bg-blue-600 dark:hover:bg-blue-500 rounded transition-all duration-200 px-3 py-1">Customise</a> {{-- class="text-blue-600 dark:text-blue-400 text-sm">Customise</a> --}}
                                                            <button type="submit"
                                                                    class="add-product-btn bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
                                                                    data-product='@json($product)'>Add</button>
                                                        </div>
                                                    </form>
                                                @else
                                                    <div class="flex justify-between items-center mt-3">
                                                        <span class="text-sm font-medium">RM {{ number_format($product->price, 2) }}</span>
                                                        <form method="POST" action="{{ route('cart.add') }}">
                                                            @csrf
                                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                            <input type="hidden" name="quantity" value="1">
                                                            <button type="submit"
                                                                    class="add-product-btn bg-green-600 text-white px-3 py-1 rounded text-sm"
                                                                    data-product='@json($product)'>Add</button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            {{-- Order Cart --}}
                            <div class="md:col-span-3">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-100 mb-4">Your Cart</h3>
                                <div id="order-cart" class="space-y-4">
                                    {{-- JS will inject order items here --}}
                                    @if (count($cart) !== 0)
                                        @foreach ($cart as $item)
                                        <div class="border p-4 rounded bg-white dark:bg-gray-900">
                                            <p class="font-semibold">
                                                {{$item['product_name']}} ({{ucfirst($item['type'])}})
                                            </p>
                                            {{-- If pizza, show size, crust, toppings --}}
                                            @if ($item['type'] === 'pizza')
                                                <ul class="text-sm mt-2 space-y-1">
                                                    <li><strong>Size:</strong> {{ $item['size'] }}</li>
                                                    <li><strong>Crust:</strong> {{ $item['crust'] }}</li>
                                                    @if (!empty($item['toppings']))
                                                        <li>
                                                            <strong>Toppings:</strong>
                                                            {{ implode(', ', $item['toppings']) }}
                                                        </li>
                                                    @endif
                                                    <li><strong>Quantity:</strong> {{ $item['quantity'] }}</li>
                                                    <li><strong>Unit Price:</strong> RM {{ number_format($item['unit_price'], 2) }}</li>
                                                    <li><strong>Total:</strong> RM {{ number_format($item['total_price'], 2) }}</li>
                                                </ul>
                                            @endif
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                                <!-- Order Summary Card -->
                                @if (count($cart) !== 0)
                                    @php
                                        $subtotal = 0;
                                        foreach ($cart as $item) {
                                            $subtotal += ($item['unit_price'] ?? $item['total_price'] ?? 0) * ($item['quantity'] ?? 1);
                                        }
                                        $deliveryFee = 5.00;
                                        $grandTotal = $subtotal + $deliveryFee;
                                    @endphp

                                    <div class="mt-6 bg-gray-50 dark:bg-gray-900 rounded-lg p-4 border border-gray-200 dark:border-gray-700">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100 mb-3">Order Total</h4>
                                        <div class="space-y-2 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($subtotal, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600 dark:text-gray-400">Delivery Fee</span>
                                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($deliveryFee, 2) }}</span>
                                            </div>
                                            <hr class="border-gray-300 dark:border-gray-600">
                                            <div class="flex justify-between font-semibold">
                                                <span class="text-gray-900 dark:text-gray-100">Total</span>
                                                <span class="text-green-600 dark:text-green-400">RM {{ number_format($grandTotal, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Action Buttons -->
                                <div class="mt-6 space-y-3">
                                    @if (count($cart) !== 0)
                                        <a href="{{ route('checkout.index') }}"
                                           class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Proceed to Checkout
                                        </a>

                                        <form action="{{ route('orders.store') }}" method="POST" class="w-full">
                                            @csrf
                                            <button type="submit"
                                                    class="w-full inline-flex items-center justify-center px-6 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                </svg>
                                                Quick Order (Skip Checkout)
                                            </button>
                                        </form>
                                    @else
                                        <div class="text-center text-gray-500 dark:text-gray-400 py-4">
                                            <p class="text-sm">Add items to your cart to proceed</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>

<!-- TODO: ensure session('cart') structure matches checkout/payment UIs; keep prices formatted with number_format; do not implement controller yet -->

                </div>
            </div>
        </div>
    </div>

    <script>
        const products = @json($products);
        const pizzaData = @json($pizzasWithPrices);

        const cartContainer = document.getElementById('order-cart');

        // document.querySelectorAll('.add-product-btn').forEach(btn => {
        //     btn.addEventListener('click', () => {
        //         const product = JSON.parse(btn.dataset.product);
        //         const isPizza = product.type === 'pizza';
        //
        //         let itemHtml = `<div class="border p-4 rounded bg-white dark:bg-gray-900">
        //         <p class="font-semibold">${product.name} (${product.type})</p>`;
        //
        //         if (isPizza && pizzaData[product.id]) {
        //             itemHtml += `<ul class="text-sm mt-2">`;
        //             pizzaData[product.id].prices.forEach(p => {
        //                 itemHtml += `<li>${p.size}: RM ${parseFloat(p.price).toFixed(2)}</li>`;
        //             });
        //             itemHtml += `</ul>`;
        //         } else {
        //             itemHtml += `<p class="text-sm text-gray-500 mt-1">RM ${parseFloat(product.price).toFixed(2)}</p>`;
        //         }
        //
        //         itemHtml += `</div>`;
        //         cartContainer.innerHTML += itemHtml;
        //     });
        // });
    </script>
</x-app-layout>
