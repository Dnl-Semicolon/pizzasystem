@extends('layouts.payment')

@section('title', 'Payment Successful')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Success Hero Section -->
    <div class="text-center mb-12">
        <div class="bg-green-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
            <span class="text-4xl">🎉</span>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h1>
        <p class="text-lg text-gray-600">Your order has been confirmed and is being prepared</p>
    </div>

    <!-- Order Confirmation Card -->
    <div class="bg-white/80 payment-card rounded-2xl p-8 shadow-lg border border-white/50 mb-8">
        <!-- Order Header -->
        <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h2>
                    <p class="text-green-700 font-medium">{{ $order->customer_name }}</p>
                </div>
                <div class="text-right">
                    <div class="bg-green-600 text-white px-4 py-2 rounded-full text-sm font-semibold">
                        {{ ucfirst($order->status) }}
                    </div>
                    <p class="text-sm text-gray-600 mt-2">{{ $order->created_at->format('M d, Y h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Order Details Grid -->
        <div class="grid lg:grid-cols-2 gap-8 mb-8">
            <!-- Order Items -->
            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="bg-orange-100 p-2 rounded-full mr-3">🍕</span>
                    Order Items
                </h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <div class="flex justify-between items-start">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-900">{{ $item->product->name }}</h4>
                                    @if($item->pizzaDetails)
                                        <div class="text-sm text-gray-600 mt-2 space-y-1">
                                            <p><span class="font-medium">Size:</span> {{ $item->pizzaDetails->size->name }}</p>
                                            <p><span class="font-medium">Crust:</span> {{ $item->pizzaDetails->crust->name }}</p>
                                            @if($item->toppings->count() > 0)
                                                <p><span class="font-medium">Toppings:</span> {{ $item->toppings->pluck('topping.name')->join(', ') }}</p>
                                            @endif
                                        </div>
                                    @endif
                                    <p class="text-sm text-gray-600 mt-1">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-right ml-4">
                                    <span class="font-bold text-gray-900">RM{{ number_format($item->final_price, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Summary -->
            <div>
                <h3 class="text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <span class="bg-blue-100 p-2 rounded-full mr-3">💳</span>
                    Payment Summary
                </h3>
                
                @php
                    $subtotal = $order->items->sum('final_price');
                    $deliveryFee = 5.00;
                @endphp
                
                <div class="bg-gray-50 rounded-xl p-6 space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">RM{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Delivery Fee</span>
                        <span class="font-medium">RM{{ number_format($deliveryFee, 2) }}</span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total Paid</span>
                        <span class="text-green-600">RM{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 mt-4">
                        <p class="text-sm text-green-800 font-medium">
                            Paid via 
                            @switch($order->payment_method)
                                @case('card') Credit/Debit Card @break
                                @case('cash') Cash on Delivery @break
                                @case('ewallet') E-Wallet @break
                                @case('online_banking') Online Banking @break
                                @default {{ ucfirst($order->payment_method) }}
                            @endswitch
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- What's Next Section -->
        <div class="bg-blue-50 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <span class="bg-blue-100 p-2 rounded-full mr-3">🕐</span>
                What happens next?
            </h3>
            <div class="grid md:grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="bg-blue-200 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">👨‍🍳</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Preparing</h4>
                    <p class="text-sm text-gray-600">Our chefs are preparing your delicious order</p>
                </div>
                <div class="text-center">
                    <div class="bg-orange-200 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">🚗</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">On the Way</h4>
                    <p class="text-sm text-gray-600">Your order will be delivered hot and fresh</p>
                </div>
                <div class="text-center">
                    <div class="bg-green-200 w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-xl">🎉</span>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-1">Delivered</h4>
                    <p class="text-sm text-gray-600">Enjoy your amazing pizza!</p>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('orders.create') }}" 
               class="bg-gradient-to-r from-orange-500 to-red-500 text-white px-8 py-3 rounded-xl font-semibold hover:from-orange-600 hover:to-red-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                <span class="flex items-center justify-center">
                    <span class="mr-2">🛒</span>
                    Order Again
                </span>
            </a>
            
            <a href="{{ route('orders.show', $order->id) }}" 
               class="bg-gray-200 text-gray-800 px-8 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-all duration-300">
                <span class="flex items-center justify-center">
                    <span class="mr-2">📋</span>
                    View Details
                </span>
            </a>
        </div>
    </div>

    <!-- Additional Info -->
    <div class="text-center">
        <div class="bg-white/60 rounded-xl p-6 border border-white/50">
            <p class="text-sm text-gray-600 mb-2">
                <span class="font-medium">📧 Confirmation sent to your email</span>
            </p>
            <p class="text-xs text-gray-500">
                Need help? Contact us at support@pizzapalace.com or (555) 123-PIZZA
            </p>
        </div>
    </div>
</div>
@endsection