<x-payment-layout>
    <x-slot name="header">
        {{ __('Secure Card Payment') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-8">
                    <!-- Back Button -->
                    <div class="mb-8">
                        <a href="{{ route('payment.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Payment Methods</span>
                        </a>
                    </div>

                    <!-- Security Badge -->
{{--                    <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-lg">--}}
{{--                        <div class="flex items-center justify-center space-x-2 text-green-700">--}}
{{--                            <i class="fas fa-shield-check text-lg"></i>--}}
{{--                            <span class="font-medium">Your payment is secured with 256-bit SSL encryption</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Order Summary -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-receipt text-gray-600 mr-2"></i>
                                Order Summary
                            </h3>
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-700">Total Amount</span>
                                    <span class="text-2xl font-bold text-gray-900">RM {{ number_format($grandTotal, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Card Payment Form -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-credit-card text-gray-600 mr-2"></i>
                                Card Details
                            </h3>

                            <form method="POST" action="{{ route('payment.process', 'card') }}" class="space-y-6">
                                @csrf

                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Cardholder Name</label>
                                        <input type="text" name="card_name" required
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300"
                                               placeholder="Enter your full name">
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                            Card Number
                                            <div class="ml-2 flex space-x-1">
                                                <i class="fab fa-cc-visa text-blue-600"></i>
                                                <i class="fab fa-cc-mastercard text-red-500"></i>
                                                <i class="fab fa-cc-amex text-blue-700"></i>
                                            </div>
                                        </label>
                                        <input type="text" name="card_number" placeholder="4111 1111 1111 1111" required
                                               class="w-full px-6 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono text-lg tracking-wider"
                                               maxlength="19">
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Expiry Date</label>
                                            <input type="text" name="exp" placeholder="MM/YY" required
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono"
                                                   maxlength="5">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                CVV
                                                <i class="fas fa-question-circle text-gray-400 ml-1 text-xs" title="3 digits on back of card"></i>
                                            </label>
                                            <input type="text" name="cvv" placeholder="123" required
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono"
                                                   maxlength="4">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Order Note (optional)</label>
                                        <input type="text" name="note"
                                               class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300"
                                               placeholder="Special instructions for your order">
                                    </div>
                                </div>

                                @if($errors->any())
                                    <div class="p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
                                        <div class="flex items-center mb-2">
                                            <i class="fas fa-exclamation-triangle mr-2"></i>
                                            <span class="font-medium">Please fix the following errors:</span>
                                        </div>
                                        <ul class="list-disc list-inside space-y-1 text-sm">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="flex flex-col sm:flex-row gap-4">
                                    <button type="submit" class="flex-1 purple-button text-white py-4 px-8 rounded-lg font-bold text-lg flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                        <i class="fas fa-lock mr-2"></i>
                                        <span class="mono">Pay RM {{ number_format($grandTotal, 2) }}</span>
                                    </button>
                                    <a href="{{ route('payment.index') }}" class="sm:w-auto px-6 py-4 border-2 border-gray-200 text-gray-600 rounded-lg font-medium hover:border-gray-300 hover:bg-gray-50 transition-all duration-200 text-center">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Payment Footer -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="text-center space-y-4">
                            <div class="flex items-center justify-center space-x-6 text-xs text-gray-500">
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-shield-alt"></i>
                                    <span>PCI DSS Compliant</span>
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-lock"></i>
                                    <span>256-bit SSL Encryption</span>
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Your data is protected</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mono">
                                Powered by {{ config('app.name') }} Payment Gateway • Transactions processed securely
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Card number formatting
            const cardNumberInput = document.querySelector('input[name="card_number"]');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
                    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || '';
                    if (formattedValue.length <= 19) {
                        e.target.value = formattedValue;
                    }
                });
            }

            // Expiry date formatting
            const expiryInput = document.querySelector('input[name="exp"]');
            if (expiryInput) {
                expiryInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // CVV numeric only
            const cvvInput = document.querySelector('input[name="cvv"]');
            if (cvvInput) {
                cvvInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }
        });
    </script>
</x-payment-layout>
