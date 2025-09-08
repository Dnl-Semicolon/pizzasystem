<x-payment-layout>
    <x-slot name="header">
        {{ __('Choose Payment Method') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-12">
                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-lg border border-green-200">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="mb-6 p-4 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if(session('info'))
                        <div class="mb-6 p-4 bg-blue-50 text-blue-800 rounded-lg border border-blue-200">
                            <i class="fas fa-info-circle mr-2"></i>
                            {{ session('info') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-medium">Please fix the following issues:</span>
                            </div>
                            <ul class="list-disc list-inside space-y-1 text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Special handling for payment errors --}}
                    @if($errors->has('payment'))
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
                            <div class="flex items-center">
                                <i class="fas fa-credit-card mr-2"></i>
                                <span class="font-medium">Payment Error:</span>
                                <span class="ml-2">{{ $errors->first('payment') }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Back to Checkout Button -->
                    <div class="mb-8">
                        <a href="{{ route('checkout.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Checkout</span>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    {{--<div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-center space-x-6 text-sm">
                            <div class="flex items-center space-x-2 text-blue-700">
                                <i class="fas fa-shield-check"></i>
                                <span class="font-medium">Bank-level security</span>
                            </div>
                            <div class="flex items-center space-x-2 text-blue-700">
                                <i class="fas fa-clock"></i>
                                <span class="font-medium">Instant processing</span>
                            </div>
                            <div class="flex items-center space-x-2 text-blue-700">
                                <i class="fas fa-undo"></i>
                                <span class="font-medium">30-day refund policy</span>
                            </div>
                        </div>
                    </div>--}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Order Summary -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-shopping-cart text-gray-600 mr-2"></i>
                                Order Summary
                            </h3>

                            <div class="bg-gray-50 rounded-lg p-6 space-y-4">
                                @foreach($cart as $item)
                                    <div class="flex justify-between items-start py-3 border-b border-gray-200 last:border-b-0">
                                        <div class="flex items-start space-x-4">
                                            @if($item->type === 'pizza' && $item->pizza?->product?->image_url)
                                                <img src="{{ $item->pizza->product->image_url }}"
                                                     alt="{{ $item->product_name }}"
                                                     class="w-16 h-16 rounded-lg object-cover">
                                            @elseif($item->type === 'product' && $item->product?->image_url)
                                                <img src="{{ $item->product->image_url }}"
                                                     alt="{{ $item->product_name }}"
                                                     class="w-16 h-16 rounded-lg object-cover">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <i class="fas fa-pizza-slice text-gray-400"></i>
                                                </div>
                                            @endif

                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-gray-900">{{ $item->product_name }}</p>
                                                @if($item->type === 'pizza')
                                                    <p class="text-sm text-gray-500 mt-1">
                                                        {{ $item->size?->name }} • {{ $item->crust?->name }}
                                                        @if($item->toppings->count() > 0)
                                                            <br>{{ $item->toppings->pluck('name')->join(', ') }}
                                                        @endif
                                                    </p>
                                                @endif
                                                <p class="text-sm text-gray-600 mt-1">Qty: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <p class="font-semibold text-gray-900">RM {{ number_format($item->total_price, 2) }}</p>
                                    </div>
                                @endforeach

                                <div class="pt-4 border-t border-gray-300 space-y-2">
                                    <div class="flex justify-between items-center text-gray-700">
                                        <span>Subtotal</span>
                                        <span>RM {{ number_format($subtotal, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-gray-700">
                                        <span>Delivery Fee</span>
                                        <span>RM {{ number_format($deliveryFee, 2) }}</span>
                                    </div>
                                    <div class="pt-2 border-t border-gray-300">
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-semibold text-gray-900">Total</span>
                                            <span class="text-xl font-bold text-gray-900">RM {{ number_format($grandTotal, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method Selection -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-credit-card text-gray-600 mr-2"></i>
                                Payment Method
                            </h3>

                            <form method="POST" action="{{ route('payment.choose') }}" class="space-y-6">
                                @csrf

                                <div class="space-y-3">
                                    <div class="relative">
                                        <input type="radio" name="payment_method" value="card" id="card" class="sr-only" required>
                                        <label for="card" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                                            <div class="flex items-center w-full">
                                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-credit-card text-blue-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900">Credit/Debit Card</p>
                                                    <p class="text-sm text-gray-500">Secure payment with your card</p>
                                                </div>
                                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                                    <div class="w-2 h-2 bg-purple-600 rounded-full opacity-0 transition-opacity duration-200" id="card-dot"></div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input type="radio" name="payment_method" value="online_banking" id="banking" class="sr-only" required>
                                        <label for="banking" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                                            <div class="flex items-center w-full">
                                                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-university text-green-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900">Online Banking</p>
                                                    <p class="text-sm text-gray-500">Transfer from your bank account</p>
                                                </div>
                                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                                    <div class="w-2 h-2 bg-purple-600 rounded-full opacity-0 transition-opacity duration-200" id="banking-dot"></div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>

                                    <div class="relative">
                                        <input type="radio" name="payment_method" value="cash" id="cash" class="sr-only" required>
                                        <label for="cash" class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                                            <div class="flex items-center w-full">
                                                <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                                    <i class="fas fa-money-bill-wave text-yellow-600"></i>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900">Cash on Delivery</p>
                                                    <p class="text-sm text-gray-500">Pay when you receive your order</p>
                                                </div>
                                                <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                                    <div class="w-2 h-2 bg-purple-600 rounded-full opacity-0 transition-opacity duration-200" id="cash-dot"></div>
                                                </div>
                                            </div>
                                        </label>
                                    </div>
                                </div>

                                @error('payment_method')
                                    <div class="text-red-600 text-sm bg-red-50 p-3 rounded-lg border border-red-200">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </div>
                                @enderror

                                <button type="submit" class="purple-button w-full text-white py-4 px-8 rounded-lg font-bold text-lg flex items-center justify-center space-x-2 shadow-lg">
                                    <span class="mono">Continue to Payment</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Footer -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center space-y-4">
                            {{--<div class="flex items-center justify-center space-x-8 text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <i class="fab fa-cc-visa text-2xl text-blue-600"></i>
                                    <i class="fab fa-cc-mastercard text-2xl text-red-500"></i>
                                    <i class="fab fa-cc-amex text-2xl text-blue-700"></i>
                                    <i class="fab fa-paypal text-2xl text-blue-600"></i>
                                </div>
                            </div>--}}
                            <div class="flex items-center justify-center space-x-6 text-xs text-gray-500">
                                {{--<div class="flex items-center space-x-1">
                                    <i class="fas fa-lock"></i>
                                    <span>256-bit SSL encryption</span>
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>PCI DSS compliant</span>
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>--}}
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Your data is protected</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mono">
                                Powered by {{ config('app.name') }} • Payments processed securely
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const radioInputs = document.querySelectorAll('input[name="payment_method"]');
            const labels = document.querySelectorAll('label[for^="card"], label[for^="banking"], label[for^="cash"]');
            const dots = document.querySelectorAll('[id$="-dot"]');

            radioInputs.forEach((input, index) => {
                input.addEventListener('change', function() {
                    // Reset all labels and dots
                    labels.forEach(label => {
                        label.classList.remove('border-purple-500', 'bg-purple-50');
                        label.classList.add('border-gray-200');
                    });
                    dots.forEach(dot => {
                        dot.classList.remove('opacity-100');
                        dot.classList.add('opacity-0');
                    });

                    // Activate selected option
                    if (this.checked) {
                        const label = document.querySelector(`label[for="${this.id}"]`);
                        const dot = document.getElementById(`${this.id}-dot`);

                        label.classList.remove('border-gray-200');
                        label.classList.add('border-purple-500', 'bg-purple-50');

                        dot.classList.remove('opacity-0');
                        dot.classList.add('opacity-100');
                    }
                });
            });
        });
    </script>
</x-payment-layout>
