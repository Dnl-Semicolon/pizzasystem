<x-payment-layout>
    <x-slot name="header">
        {{ __('Choose Payment Method') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-8">
                    
                    <!-- Back Button -->
                    <div class="mb-8">
                        <a href="{{ route('payment.method', 'card') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Payment</span>
                        </a>
                    </div>

                    <!-- Header Section -->
                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">💳 Choose a Saved Card</h3>
                        <p class="text-gray-600">Select from your saved payment methods</p>
                    </div>

                    @if($paymentMethods->count() > 0)
                        <form method="GET" action="{{ route('payment.method', 'card') }}" class="space-y-4">
                            @foreach($paymentMethods as $method)
                                <label class="block p-6 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 {{ $method->is_default ? 'border-purple-500 bg-purple-50' : '' }} saved-method-option">
                                    <input type="radio" name="selected_method" value="{{ $method->id }}" class="sr-only" {{ $method->is_default ? 'checked' : '' }}>
                                    <div class="flex items-center justify-between">
                                        <!-- Card Info -->
                                        <div class="flex items-center space-x-4">
                                            <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg flex items-center justify-center">
                                                @if($method->card_brand === 'VISA')
                                                    <i class="fab fa-cc-visa text-white text-xl"></i>
                                                @elseif($method->card_brand === 'MASTERCARD')
                                                    <i class="fab fa-cc-mastercard text-white text-xl"></i>
                                                @elseif($method->card_brand === 'AMEX')
                                                    <i class="fab fa-cc-amex text-white text-xl"></i>
                                                @else
                                                    <i class="fas fa-credit-card text-white text-xl"></i>
                                                @endif
                                            </div>
                                            
                                            <div>
                                                <h4 class="font-semibold text-gray-900">
                                                    {{ $method->card_brand }}
                                                    @if($method->label)
                                                        <span class="text-sm text-gray-500">({{ $method->label }})</span>
                                                    @endif
                                                </h4>
                                                <p class="text-gray-600 font-mono text-lg">{{ $method->masked_card_number }}</p>
                                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                                    <span>{{ $method->cardholder_name }}</span>
                                                    <span>•</span>
                                                    <span>Expires {{ $method->expiry }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Selection Indicator -->
                                        <div class="flex items-center space-x-4">
                                            @if($method->is_default)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                                    <i class="fas fa-star mr-1"></i>
                                                    Default
                                                </span>
                                            @endif
                                            <div class="w-5 h-5 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                                <div class="w-2 h-2 bg-purple-600 rounded-full opacity-0 transition-opacity duration-200 selection-dot"></div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            @endforeach
                            
                            <!-- Continue Button -->
                            <div class="pt-6">
                                <button type="submit" class="w-full bg-purple-600 text-white py-4 px-8 rounded-lg font-bold text-lg hover:bg-purple-700 transition-colors duration-200 flex items-center justify-center space-x-2">
                                    <span>Use Selected Card</span>
                                    <i class="fas fa-arrow-right"></i>
                                </button>
                            </div>
                        </form>

                        <!-- New Card Option -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('payment.method', 'card') }}?use_new_card=1" class="block text-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200">
                                <i class="fas fa-plus text-gray-400 text-2xl mb-2"></i>
                                <p class="font-medium text-gray-600">Use a New Card Instead</p>
                                <p class="text-sm text-gray-500">Enter new card details</p>
                            </a>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-credit-card text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Saved Payment Methods</h3>
                            <p class="text-gray-600 mb-6">
                                You'll need to enter your card details to continue.
                            </p>
                            <a href="{{ route('payment.method', 'card') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                <i class="fas fa-credit-card mr-2"></i>
                                Enter Card Details
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const methodOptions = document.querySelectorAll('.saved-method-option');
            const selectionDots = document.querySelectorAll('.selection-dot');

            methodOptions.forEach((option, index) => {
                option.addEventListener('click', function() {
                    const radio = this.querySelector('input[type="radio"]');
                    
                    // Clear all selections
                    methodOptions.forEach(opt => {
                        opt.classList.remove('border-purple-500', 'bg-purple-50');
                        opt.classList.add('border-gray-200');
                    });
                    selectionDots.forEach(dot => {
                        dot.classList.remove('opacity-100');
                        dot.classList.add('opacity-0');
                    });

                    // Select current option
                    radio.checked = true;
                    this.classList.remove('border-gray-200');
                    this.classList.add('border-purple-500', 'bg-purple-50');
                    this.querySelector('.selection-dot').classList.remove('opacity-0');
                    this.querySelector('.selection-dot').classList.add('opacity-100');
                });

                // Initialize default selection
                if (option.querySelector('input[type="radio"]').checked) {
                    option.click();
                }
            });
        });
    </script>
</x-payment-layout>