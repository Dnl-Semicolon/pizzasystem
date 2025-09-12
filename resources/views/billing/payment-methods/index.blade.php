<x-payment-layout>
    <x-slot name="header">
        {{ __('Manage Payment Methods') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-8">
                    
                    <!-- Back Button -->
                    <div class="mb-8">
                        <a href="{{ route('billing.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Billing</span>
                        </a>
                    </div>

                    <!-- Success/Error Messages -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-green-50 text-green-800 rounded-lg border border-green-200">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-6 p-4 bg-red-50 text-red-800 rounded-lg border border-red-200">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif

                    <!-- Header Section -->
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">💳 Payment Methods</h3>
                            <p class="text-gray-600">Manage your saved cards for faster checkout</p>
                        </div>
                        <div>
                            <a href="{{ route('billing.payment-methods.create') }}" class="purple-button text-white px-6 py-3 rounded-lg font-medium flex items-center space-x-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                <i class="fas fa-plus"></i>
                                <span>Add New Card</span>
                            </a>
                        </div>
                    </div>

                    @if($paymentMethods->count() > 0)
                        <!-- Payment Methods Grid -->
                        <div class="space-y-4 mb-8">
                            @foreach($paymentMethods as $method)
                                <div class="p-6 border-2 border-gray-200 rounded-lg hover:border-purple-300 hover:bg-purple-50 transition-all duration-200 {{ $method->is_default ? 'border-purple-500 bg-purple-50' : '' }}">
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
                                                <p class="text-gray-600 font-mono">{{ $method->masked_card_number }}</p>
                                                <div class="flex items-center space-x-4 text-sm text-gray-500 mt-1">
                                                    <span>{{ $method->cardholder_name }}</span>
                                                    <span>•</span>
                                                    <span>Expires {{ $method->expiry }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex items-center space-x-4">
                                            @if($method->is_default)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-300">
                                                    <i class="fas fa-star mr-1"></i>
                                                    Default
                                                </span>
                                            @else
                                                <form action="{{ route('billing.payment-methods.set-default', $method) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-purple-600 hover:text-purple-800 text-sm font-medium flex items-center">
                                                        <i class="fas fa-star mr-1"></i>
                                                        Set Default
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('billing.payment-methods.destroy', $method) }}" method="POST" class="inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this payment method?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Info Section -->
                        <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                            <div class="flex items-start space-x-3">
                                <i class="fas fa-info-circle text-blue-600 mt-0.5"></i>
                                <div class="text-sm text-blue-800">
                                    <p class="font-medium mb-2">Security Information</p>
                                    <ul class="space-y-1">
                                        <li>• Card numbers are encrypted and stored securely</li>
                                        <li>• CVV is never stored and required for each payment</li>
                                        <li>• You can manage and delete cards anytime</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- Empty State -->
                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fas fa-credit-card text-gray-400 text-2xl"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Saved Payment Methods</h3>
                            <p class="text-gray-600 mb-6">
                                Save cards during checkout for faster future purchases.
                            </p>
                            <a href="{{ route('orders.create') }}" class="inline-flex items-center px-6 py-3 bg-purple-600 text-white font-medium rounded-lg hover:bg-purple-700 transition-colors duration-200">
                                <i class="fas fa-shopping-cart mr-2"></i>
                                Start Shopping
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-payment-layout>