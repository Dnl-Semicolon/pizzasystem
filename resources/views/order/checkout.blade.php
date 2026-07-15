<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-6 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf

                    <!-- Order Summary -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 mb-6 transition-all duration-300">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Order Summary
                        </h3>

                        @if(empty($cart))
                            <div class="text-center py-12 text-gray-500 dark:text-gray-400">
                                <svg class="w-16 h-16 mx-auto mb-4 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l-1 7a1 1 0 01-1 1H7a1 1 0 01-1-1L5 9z"/>
                                </svg>
                                <p class="text-lg mb-3">Your cart is empty</p>
                                <a href="{{ route('orders.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Continue shopping
                                </a>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach($cart as $item)
                                    <div class="flex items-start p-4 bg-gray-50/50 dark:bg-gray-700/30 rounded-xl border border-gray-100/50 dark:border-gray-600/30 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group gap-4">
                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @php
                                                $imageUrl = null;
                                                if ($item->type === 'pizza' && $item->pizza?->product?->image_url) {
                                                    $imageUrl = $item->pizza->product->image_url;
                                                } elseif ($item->type === 'product' && $item->product?->image_url) {
                                                    $imageUrl = $item->product->image_url;
                                                }
                                            @endphp

                                            @if($imageUrl)
                                                <img src="{{ $imageUrl }}" alt="{{ $item->product_name }}"
                                                     class="w-16 h-16 object-cover rounded-xl shadow-sm group-hover:shadow-md transition-all duration-200 border border-gray-200 dark:border-gray-600">
                                            @else
                                                <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-xl flex items-center justify-center shadow-sm group-hover:shadow-md transition-all duration-200">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($item->type === 'pizza')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3L2 12l10 9 10-9-10-9zM12 3v18"/>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                        @endif
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Product Details -->
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 dark:text-gray-100 group-hover:text-green-700 dark:group-hover:text-green-400 transition-colors duration-200 truncate">
                                                {{ $item->product_name }}
                                            </h4>
                                            @if($item->size || $item->crust)
                                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex items-center space-x-2">
                                                    @if($item->size)
                                                        <span class="inline-flex items-center px-2 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-md text-xs font-medium">{{ $item->size->name }}</span>
                                                    @endif
                                                    @if($item->crust)
                                                        <span class="inline-flex items-center px-2 py-1 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-md text-xs font-medium">{{ $item->crust->name }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($item->toppings && $item->toppings->count() > 0)
                                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wide">Toppings:</span>
                                                    <div class="flex flex-wrap gap-1 mt-1">
                                                        @foreach($item->toppings as $topping)
                                                            <span class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 rounded-md text-xs">{{ $topping->name }}</span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-2 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 110 2h-1l-.867 12.142A2 2 0 0118.138 18H5.862a2 2 0 01-1.995-1.858L3 4H2a1 1 0 110-2h4zM9 6v10a1 1 0 102 0V6a1 1 0 10-2 0zm4 0v10a1 1 0 102 0V6a1 1 0 10-2 0z"/>
                                                </svg>
                                                Qty: {{ $item->quantity }}
                                            </div>
                                        </div>

                                        <!-- Price -->
                                        <div class="flex flex-col items-end justify-center">
                                            <div class="font-bold text-lg text-green-700 dark:text-green-400">
                                                RM {{ number_format($item->total_price, 2) }}
                                            </div>
                                            @if($item->quantity > 1)
                                                <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                    RM {{ number_format($item->total_price / $item->quantity, 2) }} each
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Delivery Mode -->
                {{--<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Type</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="delivery_mode" value="delivery"
                                       {{ old('delivery_mode', session('checkout.delivery_mode', 'delivery')) == 'delivery' ? 'checked' : '' }}
                                       class="text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="delivery_mode" value="pickup"
                                       {{ old('delivery_mode', session('checkout.delivery_mode', 'delivery')) == 'pickup' ? 'checked' : '' }}
                                       class="text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pickup</span>
                            </label>
                        </div>
                    </div>--}}

                    <!-- Contact Information -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 mb-6 transition-all duration-300">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                            Contact Information
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <div class="space-y-2">
                                <label for="contact_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        Full Name *
                                    </span>
                                </label>
                                <input type="text" id="contact_name" name="contact_name" required
                                       value="{{ old('contact_name', session('checkout.contact_name', Auth::check() ? Auth::user()->name : '')) }}"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                       placeholder="Your full name">
                            </div>
                            <div class="space-y-2">
                                <label for="contact_phone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                        </svg>
                                        Phone Number *
                                    </span>
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" required
                                       value="{{ old('contact_phone', session('checkout.contact_phone', Auth::check() ? (Auth::user()->phone ?? '') : '')) }}"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                       placeholder="+60123456789">
                            </div>
                            <div class="space-y-2">
                                <label for="contact_email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                        Email Address
                                    </span>
                                </label>
                                <input type="email" id="contact_email" name="contact_email"
                                       value="{{ old('contact_email', session('checkout.contact_email', Auth::check() ? Auth::user()->email : '')) }}"
                                       class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                       placeholder="your@email.com">
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-xl shadow-lg hover:shadow-xl border border-gray-200/50 dark:border-gray-700/50 p-6 transition-all duration-300">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Delivery Address
                        </h3>

                        @if(Auth::check() && $addresses->count() > 0)
                            <div class="space-y-4">
                                <!-- Use Saved Address -->
                                <div class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg border border-green-200 dark:border-green-800">
                                    <input type="checkbox" id="use-saved-address" name="use_saved_address" value="1" checked
                                           class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 focus:ring-2 focus:ring-green-500/20">
                                    <label for="use-saved-address" class="ml-3 text-sm font-medium text-green-800 dark:text-green-200 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                        </svg>
                                        Use saved address
                                    </label>
                                </div>

                                <!-- Saved Address Selection -->
                                <div id="saved-address-section" class="space-y-4">
                                    <div class="grid gap-4">
                                        @foreach($addresses as $address)
                                            <label class="group relative flex items-start p-4 border-2 {{ $address->is_default ? 'border-green-500 bg-gradient-to-br from-green-50 to-green-100/30 dark:from-green-900/20 dark:to-green-800/10' : 'border-gray-200 dark:border-gray-700' }} rounded-xl cursor-pointer hover:border-green-400 hover:bg-gradient-to-br hover:from-green-50/50 hover:to-green-100/20 dark:hover:from-green-900/10 dark:hover:to-green-800/5 transition-all duration-300 hover:shadow-md">
                                                <input type="radio" name="saved_address_id" value="{{ $address->id }}"
                                                       class="mt-1.5 text-green-600 focus:ring-2 focus:ring-green-500/50 transition-all duration-200"
                                                       data-addr1="{{ $address->address_line_1 }}"
                                                       data-addr2="{{ $address->address_line_2 ?? '' }}"
                                                       data-postcode="{{ $address->postal_code }}"
                                                       data-city="{{ $address->city }}"
                                                       data-state="{{ $address->state }}"
                                                       data-notes="{{ $address->delivery_notes ?? '' }}"
                                                       {{ $address->is_default ? 'checked' : '' }}>
                                                <div class="ml-4 flex-1">
                                                    <div class="flex items-center justify-between mb-2">
                                                        <div class="flex items-center space-x-2">
                                                            @if($address->label)
                                                                <span class="text-base font-semibold text-gray-900 dark:text-gray-100 flex items-center">
                                                                    <svg class="w-4 h-4 mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                                    </svg>
                                                                    {{ $address->label }}
                                                                </span>
                                                            @endif
                                                            @if($address->is_default)
                                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-200 dark:bg-green-900/60 text-green-800 dark:text-green-300 border border-green-300 dark:border-green-700">
                                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                                    </svg>
                                                                    Default
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400 space-y-1">
                                                        <p class="font-semibold text-gray-800 dark:text-gray-200 flex items-center">
                                                            <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                            </svg>
                                                            {{ $address->recipient_name }} • {{ $address->phone }}
                                                        </p>
                                                        <div class="pl-6 space-y-0.5">
                                                            <p>{{ $address->address_line_1 }}</p>
                                                            @if($address->address_line_2)
                                                                <p>{{ $address->address_line_2 }}</p>
                                                            @endif
                                                            <p class="font-medium">{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                                            @if($address->delivery_notes)
                                                                <p class="italic text-orange-600 dark:text-orange-400 mt-2 flex items-center">
                                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                                                    </svg>
                                                                    {{ $address->delivery_notes }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- New Address Form -->
                        <div id="new-address-section" class="space-y-6 {{ Auth::check() && $addresses->count() > 0 ? 'mt-8' : '' }}">
                            @if(Auth::check() && $addresses->count() > 0)
                                <div class="relative">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
                                    </div>
                                    <div class="relative flex justify-center">
                                        <span class="bg-white dark:bg-gray-800 px-4 text-sm font-medium text-gray-900 dark:text-gray-100">Or enter new address</span>
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-6">
                                <div class="space-y-2">
                                    <label for="addr1" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            Address Line 1 *
                                        </span>
                                    </label>
                                    <input type="text" id="addr1" name="addr1"
                                           value="{{ old('addr1', session('checkout.addr1', '')) }}"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                           placeholder="Street address, building name">
                                </div>

                                <div class="space-y-2">
                                    <label for="addr2" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                                            </svg>
                                            Address Line 2
                                        </span>
                                    </label>
                                    <input type="text" id="addr2" name="addr2"
                                           value="{{ old('addr2', session('checkout.addr2', '')) }}"
                                           class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                           placeholder="Apartment, suite, floor (optional)">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                                    <div class="space-y-2">
                                        <label for="postcode" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                </svg>
                                                Postcode *
                                            </span>
                                        </label>
                                        <input type="text" id="postcode" name="postcode" maxlength="5"
                                               value="{{ old('postcode', session('checkout.postcode', '')) }}"
                                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                               placeholder="12345">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="city" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                City *
                                            </span>
                                        </label>
                                        <input type="text" id="city" name="city"
                                               value="{{ old('city', session('checkout.city', '')) }}"
                                               class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4"
                                               placeholder="Kuala Lumpur">
                                    </div>

                                    <div class="space-y-2">
                                        <label for="state" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                            <span class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                                </svg>
                                                State *
                                            </span>
                                        </label>
                                        <select id="state" name="state"
                                                class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4">
                                            <option value="">Select state</option>
                                            @php $selectedState = old('state', session('checkout.state', '')); @endphp
                                            <option value="Johor" {{ $selectedState == 'Johor' ? 'selected' : '' }}>Johor</option>
                                            <option value="Kedah" {{ $selectedState == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                            <option value="Kelantan" {{ $selectedState == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                            <option value="Kuala Lumpur" {{ $selectedState == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                            <option value="Labuan" {{ $selectedState == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                            <option value="Malacca" {{ $selectedState == 'Malacca' ? 'selected' : '' }}>Malacca</option>
                                            <option value="Negeri Sembilan" {{ $selectedState == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                            <option value="Pahang" {{ $selectedState == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                            <option value="Penang" {{ $selectedState == 'Penang' ? 'selected' : '' }}>Penang</option>
                                            <option value="Perak" {{ $selectedState == 'Perak' ? 'selected' : '' }}>Perak</option>
                                            <option value="Perlis" {{ $selectedState == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                            <option value="Putrajaya" {{ $selectedState == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                                            <option value="Sabah" {{ $selectedState == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                            <option value="Sarawak" {{ $selectedState == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                            <option value="Selangor" {{ $selectedState == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                            <option value="Terengganu" {{ $selectedState == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="space-y-2">
                                    <label for="delivery_notes" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                            </svg>
                                            Delivery Notes (Optional)
                                        </span>
                                    </label>
                                    <textarea id="delivery_notes" name="delivery_notes" rows="4"
                                              class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-800/50 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-2 focus:ring-green-500/20 hover:border-green-300 transition-all duration-200 py-3 px-4 resize-none"
                                              placeholder="Special delivery instructions, building access codes, gate passwords, landmarks, etc.">{{ old('delivery_notes', session('checkout.delivery_notes', '')) }}</textarea>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Help our delivery team find you easily
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <!-- Order Total Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-gradient-to-br from-white to-gray-50/50 dark:from-gray-800 dark:to-gray-900/50 backdrop-blur-sm rounded-2xl shadow-2xl border-2 border-green-200/50 dark:border-green-800/50 p-6 sticky top-6 hover:shadow-3xl transition-all duration-300">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-6 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Order Total
                        </h3>

                        <div class="space-y-4">
                            <div class="bg-gray-50/50 dark:bg-gray-700/30 rounded-xl p-4 space-y-3">
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                        </svg>
                                        Subtotal
                                    </span>
                                    <span class="text-gray-900 dark:text-gray-100 font-semibold">RM {{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-gray-600 dark:text-gray-400 flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1-1V9a1 1 0 011-1h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V15a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                                        </svg>
                                        Delivery Fee
                                    </span>
                                    <span class="text-gray-900 dark:text-gray-100 font-semibold">RM {{ number_format($deliveryFee, 2) }}</span>
                                </div>
                            </div>

                            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-4 text-white shadow-lg">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Total
                                    </span>
                                    <span class="text-2xl font-bold">RM {{ number_format($grandTotal, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center text-blue-800 dark:text-blue-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-sm font-medium">Price Information</span>
                            </div>
                            <div class="mt-2 text-xs text-blue-700 dark:text-blue-400 space-y-1">
                                <p>• All prices shown are final</p>
                                <p>• Delivery fee calculated based on distance</p>
                                <p>• GST included where applicable</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Sticky Bottom Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/95 dark:bg-gray-800/95 backdrop-blur-sm border-t-2 border-green-200 dark:border-green-800 p-4 shadow-2xl z-50">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-6">
                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center px-5 py-3 bg-gray-100/80 dark:bg-gray-700/80 text-gray-700 dark:text-gray-300 rounded-xl hover:bg-gray-200 dark:hover:bg-gray-600 hover:shadow-lg transform hover:scale-105 transition-all duration-200 font-medium border border-gray-200 dark:border-gray-600">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Cart
                </a>
                <div class="hidden sm:flex items-center p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl border border-gray-200 dark:border-gray-600">
                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total: </span>
                    <span class="text-lg font-bold text-green-700 dark:text-green-400 ml-1">RM {{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>

            <button type="submit" form="checkout-form"
                    class="group w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white font-bold rounded-xl hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-4 focus:ring-green-500/50 transform hover:scale-105 hover:shadow-2xl transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100 disabled:hover:shadow-none">
                <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Continue to Payment
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Order Total (visible on mobile) -->
    <div class="sm:hidden block mb-4">
        <div class="bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50 p-5 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700">
            <div class="space-y-3">
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        Subtotal
                    </span>
                    <span class="font-medium">RM {{ number_format($subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1-1V9a1 1 0 011-1h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 01.293.707V15a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                        Delivery
                    </span>
                    <span class="font-medium">RM {{ number_format($deliveryFee, 2) }}</span>
                </div>
                <div class="border-t border-gray-300 dark:border-gray-600 pt-3">
                    <div class="flex justify-between font-bold text-lg text-green-700 dark:text-green-400">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Total
                        </span>
                        <span>RM {{ number_format($grandTotal, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitButton = document.querySelector('button[form="checkout-form"]');

    // Address toggle functionality
    const useSavedAddressCheckbox = document.getElementById('use-saved-address');
    const savedAddressSection = document.getElementById('saved-address-section');
    const newAddressSection = document.getElementById('new-address-section');

    // Handle saved address toggle
    if (useSavedAddressCheckbox) {
        // Initialize with saved address checked
        savedAddressSection.classList.remove('hidden');
        newAddressSection.querySelectorAll('input[required], select[required]').forEach(field => {
            field.setAttribute('data-required', 'true');
            field.removeAttribute('required');
        });

        // Auto-populate address fields if there's a default address selected on page load
        const defaultSelectedAddress = document.querySelector('input[name="saved_address_id"]:checked');
        if (defaultSelectedAddress) {
            document.getElementById('addr1').value = defaultSelectedAddress.dataset.addr1 || '';
            document.getElementById('addr2').value = defaultSelectedAddress.dataset.addr2 || '';
            document.getElementById('postcode').value = defaultSelectedAddress.dataset.postcode || '';
            document.getElementById('city').value = defaultSelectedAddress.dataset.city || '';
            document.getElementById('state').value = defaultSelectedAddress.dataset.state || '';
            document.getElementById('delivery_notes').value = defaultSelectedAddress.dataset.notes || '';
        }

        useSavedAddressCheckbox.addEventListener('change', function() {
            if (this.checked) {
                savedAddressSection.classList.remove('hidden');
                // Make new address fields optional when using saved address
                newAddressSection.querySelectorAll('input, select').forEach(field => {
                    field.removeAttribute('required');
                    field.value = '';
                });
            } else {
                savedAddressSection.classList.add('hidden');
                // Make new address fields required again
                newAddressSection.querySelectorAll('input[data-required], select[data-required]').forEach(field => {
                    field.setAttribute('required', 'required');
                });
                // Uncheck any selected saved addresses
                document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
                    radio.checked = false;
                });
            }
            validateForm();
        });

        // Handle saved address radio button changes
        document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    // When a saved address is selected, make sure the checkbox is checked
                    useSavedAddressCheckbox.checked = true;
                    savedAddressSection.classList.remove('hidden');

                    // Populate new address fields with selected saved address data
                    document.getElementById('addr1').value = this.dataset.addr1 || '';
                    document.getElementById('addr2').value = this.dataset.addr2 || '';
                    document.getElementById('postcode').value = this.dataset.postcode || '';
                    document.getElementById('city').value = this.dataset.city || '';
                    document.getElementById('state').value = this.dataset.state || '';
                    document.getElementById('delivery_notes').value = this.dataset.notes || '';

                    // Make new address fields optional since we have a saved address
                    newAddressSection.querySelectorAll('input, select').forEach(field => {
                        field.removeAttribute('required');
                    });
                }
                validateForm();
            });
        });

        // Auto-switch to new address when typing in new address fields
        const newAddressFields = newAddressSection.querySelectorAll('input, select, textarea');
        let isPopulating = false; // Flag to prevent hiding during auto-population

        newAddressFields.forEach(field => {
            field.addEventListener('input', function() {
                // Don't hide saved addresses if we're auto-populating from a saved address
                if (isPopulating) return;

                // Only hide saved addresses if user is actually typing new content
                if (this.value.trim() && !document.querySelector('input[name="saved_address_id"]:checked')) {
                    return; // User is already in new address mode
                }

                // If user types in address fields while a saved address is selected, switch to new address mode
                if (this.value.trim() && document.querySelector('input[name="saved_address_id"]:checked')) {
                    // Uncheck saved address options and hide the section
                    useSavedAddressCheckbox.checked = false;
                    savedAddressSection.classList.add('hidden');
                    document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
                        radio.checked = false;
                    });
                    // Make new address fields required
                    newAddressSection.querySelectorAll('input[data-required], select[data-required]').forEach(requiredField => {
                        requiredField.setAttribute('required', 'required');
                    });
                    validateForm();
                }
            });
        });

        // Modify the saved address change handler to use the flag
        document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
            const originalHandler = radio.onchange;
            radio.addEventListener('change', function() {
                if (this.checked) {
                    isPopulating = true;
                    // Populate fields (this code is already there)
                    document.getElementById('addr1').value = this.dataset.addr1 || '';
                    document.getElementById('addr2').value = this.dataset.addr2 || '';
                    document.getElementById('postcode').value = this.dataset.postcode || '';
                    document.getElementById('city').value = this.dataset.city || '';
                    document.getElementById('state').value = this.dataset.state || '';
                    document.getElementById('delivery_notes').value = this.dataset.notes || '';

                    // Reset flag after a short delay
                    setTimeout(() => {
                        isPopulating = false;
                    }, 100);
                }
            });
        });
    }

    // Basic form validation
    function validateForm() {
        let isValid = true;

        // Always required fields
        const contactName = document.getElementById('contact_name');
        const contactPhone = document.getElementById('contact_phone');

        if (!contactName.value.trim()) isValid = false;
        if (!contactPhone.value.trim()) isValid = false;

        // // Check if delivery mode is selected
        // const selectedDeliveryMode = document.querySelector('input[name="delivery_mode"]:checked');
        // if (!selectedDeliveryMode) isValid = false;

        // If using saved address, check if one is selected
        if (useSavedAddressCheckbox && useSavedAddressCheckbox.checked) {
            const selectedAddress = document.querySelector('input[name="saved_address_id"]:checked');
            if (!selectedAddress) {
                isValid = false;
            }
        } else {
            // Check new address fields
            const addr1 = document.getElementById('addr1');
            const postcode = document.getElementById('postcode');
            const city = document.getElementById('city');
            const state = document.getElementById('state');

            if (!addr1.value.trim()) isValid = false;
            if (!postcode.value.trim()) isValid = false;
            if (!city.value.trim()) isValid = false;
            if (!state.value.trim()) isValid = false;
        }

        if (submitButton) {
            submitButton.disabled = !isValid;
        }
        return isValid;
    }

    // Listen for input changes
    document.addEventListener('input', validateForm);
    document.addEventListener('change', validateForm);

    // Listen for delivery mode changes
    document.querySelectorAll('input[name="delivery_mode"]').forEach(radio => {
        radio.addEventListener('change', validateForm);
    });

    // Initial validation
    validateForm();

    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Please fill in all required fields and select an address before continuing.');
            return;
        }
        // Form is valid, allow submission to proceed
    });
});
</script>

