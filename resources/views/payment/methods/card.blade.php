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
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-credit-card text-gray-600 mr-2"></i>
                                    Card Details
                                </h3>
                                @if(Auth::check() && isset($savedPaymentMethods) && $savedPaymentMethods->count() > 0)
                                    <a href="{{ route('billing.payment-methods.index') }}" class="text-sm text-purple-600 hover:text-purple-800 flex items-center">
                                        <i class="fas fa-cog mr-1"></i>
                                        Manage Cards
                                    </a>
                                @endif
                            </div>

                            @if(Auth::check() && isset($savedPaymentMethods) && $savedPaymentMethods->count() > 0)
                                @php
                                    $selectedMethod = request('selected_method') ? $savedPaymentMethods->find(request('selected_method')) : $savedPaymentMethods->where('is_default', true)->first();
                                    $useNewCard = request('use_new_card') == '1';
                                @endphp
                                
                                @if(!$useNewCard && $selectedMethod)
                                    <!-- Selected Saved Card (Compact) -->
                                    <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-6">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                                    @if($selectedMethod->card_brand === 'VISA')
                                                        <i class="fab fa-cc-visa text-white"></i>
                                                    @elseif($selectedMethod->card_brand === 'MASTERCARD')
                                                        <i class="fab fa-cc-mastercard text-white"></i>
                                                    @elseif($selectedMethod->card_brand === 'AMEX')
                                                        <i class="fab fa-cc-amex text-white"></i>
                                                    @else
                                                        <i class="fas fa-credit-card text-white"></i>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-medium text-purple-900">{{ $selectedMethod->display_name }}</p>
                                                    <p class="text-sm text-purple-600">{{ $selectedMethod->masked_card_number }}</p>
                                                </div>
                                            </div>
                                            <a href="{{ route('billing.payment-methods.select') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                                                Change
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <!-- Choose Saved Card Button -->
                                    <div class="mb-6">
                                        <a href="{{ route('billing.payment-methods.select') }}" class="block p-4 border-2 border-dashed border-purple-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-all duration-200 text-center">
                                            <i class="fas fa-bookmark text-purple-600 text-xl mb-2"></i>
                                            <p class="font-medium text-purple-900">Use a Saved Card</p>
                                            <p class="text-sm text-purple-600">{{ $savedPaymentMethods->count() }} saved cards available</p>
                                        </a>
                                    </div>
                                    
                                    <div class="relative mb-6">
                                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                            <div class="w-full border-t border-gray-300"></div>
                                        </div>
                                        <div class="relative flex justify-center">
                                            <span class="bg-white px-4 text-sm font-medium text-gray-500">Or enter new card details</span>
                                        </div>
                                    </div>
                                @endif

                                <!-- Hidden input for selected saved payment method -->
                                <input type="hidden" name="saved_payment_method_id" id="selected_saved_method" value="{{ $selectedMethod && !$useNewCard ? $selectedMethod->id : '' }}">
                                
                                @if(!$useNewCard && $selectedMethod)
                                    <!-- CVV field for saved methods -->
                                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                        <div class="flex items-center text-blue-800 mb-4">
                                            <i class="fas fa-info-circle mr-2"></i>
                                            <span class="text-sm font-medium">For security, please enter your CVV to complete the payment.</span>
                                        </div>
                                        <div class="w-32">
                                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                CVV
                                                <i class="fas fa-question-circle text-gray-400 ml-1 text-xs" title="3 digits on back of card"></i>
                                            </label>
                                            <input type="text" name="cvv" placeholder="123" required
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono"
                                                   maxlength="4">
                                        </div>
                                    </div>
                                @endif
                            @endif

                            <form method="POST" action="{{ route('payment.process', 'card') }}" class="space-y-6" id="card-payment-form">
                                @csrf

                                @if(Auth::check() && isset($savedPaymentMethods) && $savedPaymentMethods->count() > 0 && !$useNewCard && $selectedMethod)
                                    <!-- Using saved method - form is simplified -->
                                @else
                                    <!-- New Card Form Fields -->
                                    <div id="new-card-section" class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-3">Cardholder Name</label>
                                        <input type="text" name="card_name" id="card_name"
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
                                        <input type="text" name="card_number" id="card_number" placeholder="4111 1111 1111 1111"
                                               class="w-full px-6 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono text-lg tracking-wider"
                                               maxlength="19">
                                    </div>

                                    <div class="grid grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3">Expiry Date</label>
                                            <input type="text" name="exp" id="exp" placeholder="MM/YY"
                                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono"
                                                   maxlength="5">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-3 flex items-center">
                                                CVV
                                                <i class="fas fa-question-circle text-gray-400 ml-1 text-xs" title="3 digits on back of card"></i>
                                            </label>
                                            <input type="text" name="cvv" id="cvv" placeholder="123"
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

                                        @if(Auth::check())
                                            <!-- Save Payment Method Option -->
                                            <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                                                <label class="flex items-center">
                                                    <input type="checkbox" name="save_payment_method" value="1" 
                                                           class="rounded border-gray-300 text-purple-600 shadow-sm focus:ring-purple-500 focus:ring-2 focus:ring-purple-500/20">
                                                    <span class="ml-3 text-sm">
                                                        <span class="font-medium text-purple-900">Save this card for future purchases</span>
                                                        <span class="block text-purple-700">Securely encrypted and stored for faster checkout</span>
                                                    </span>
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                @endif

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
            // Form fields
            const cardNameInput = document.getElementById('card_name');
            const cardNumberInput = document.getElementById('card_number');
            const expInput = document.getElementById('exp');
            const cvvInput = document.querySelector('input[name="cvv"]');

            // Card number formatting
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
            if (expInput) {
                expInput.addEventListener('input', function(e) {
                    let value = e.target.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    e.target.value = value;
                });
            }

            // CVV numeric only
            if (cvvInput) {
                cvvInput.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/\D/g, '');
                });
            }
        });
    </script>
</x-payment-layout>
