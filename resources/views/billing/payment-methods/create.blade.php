<x-payment-layout>
    <x-slot name="header">
        {{ __('Add New Payment Method') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-8">
                    <!-- Back Button -->
                    <div class="mb-8">
                        <a href="{{ route('billing.payment-methods.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Payment Methods</span>
                        </a>
                    </div>

                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Add New Card</h2>
                        <p class="text-gray-600">Save a new payment method for faster checkout</p>
                    </div>

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
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

                    <form method="POST" action="{{ route('billing.payment-methods.store') }}" class="space-y-6" id="create-card-form">
                        @csrf

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Card Label</label>
                            <input type="text" name="label" value="{{ old('label') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300"
                                   placeholder="e.g. Personal Card, Work Card" required>
                            <p class="text-sm text-gray-500 mt-1">Give this card a name to identify it later</p>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Cardholder Name</label>
                            <input type="text" name="cardholder_name" value="{{ old('cardholder_name') }}"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300"
                                   placeholder="Enter name as shown on card" required>
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
                            <input type="text" name="card_number" id="card_number" value="{{ old('card_number') }}"
                                   class="w-full px-6 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300 font-mono text-lg tracking-wider"
                                   placeholder="4111 1111 1111 1111" maxlength="19" required>
                        </div>

                        <div class="grid grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Expiry Month</label>
                                <select name="expiry_month" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300" required>
                                    <option value="">Month</option>
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ sprintf('%02d', $i) }}" {{ old('expiry_month') == sprintf('%02d', $i) ? 'selected' : '' }}>
                                            {{ sprintf('%02d', $i) }} - {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-3">Expiry Year</label>
                                <select name="expiry_year" class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300" required>
                                    <option value="">Year</option>
                                    @for($year = date('Y'); $year <= date('Y') + 10; $year++)
                                        <option value="{{ substr($year, -2) }}" {{ old('expiry_year') == substr($year, -2) ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Security Notice -->
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-shield-alt text-blue-600 mt-1 mr-3"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-medium mb-1">Your card details are secure</p>
                                    <p>All card information is encrypted and stored securely. We never store your CVV for your protection.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-4 pt-4">
                            <button type="submit" class="flex-1 purple-button text-white py-3 px-6 rounded-lg font-medium flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                <i class="fas fa-save mr-2"></i>
                                <span>Save Payment Method</span>
                            </button>
                            <a href="{{ route('billing.payment-methods.index') }}" class="sm:w-auto px-6 py-3 border-2 border-gray-200 text-gray-600 rounded-lg font-medium hover:border-gray-300 hover:bg-gray-50 transition-all duration-200 text-center">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
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
                <p class="text-xs text-gray-400 mono mt-2">
                    Powered by {{ config('app.name') }} • Secure card storage
                </p>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cardNumberInput = document.getElementById('card_number');

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
        });
    </script>
</x-payment-layout>