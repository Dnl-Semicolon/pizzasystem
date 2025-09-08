<x-payment-layout>
    <x-slot name="header">
        {{ __('Cash on Delivery') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                <div class="p-8">
                    <!-- Back Button -->
                    <div class="mb-8">
                        <a href="{{ route('payment.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Payment Methods</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                        <!-- Order Summary ---->
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

                            <!-- Cash on Delivery Info -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                                        <i class="fas fa-money-bill-wave text-yellow-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-yellow-900">Cash on Delivery</h4>
                                        <p class="text-yellow-700 text-sm">Pay when you receive your order</p>
                                    </div>
                                </div>
                                <div class="space-y-3 text-sm text-yellow-800">
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-check-circle text-yellow-600"></i>
                                        <span>No upfront payment required</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-truck text-yellow-600"></i>
                                        <span>Pay directly to delivery person</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <i class="fas fa-coins text-yellow-600"></i>
                                        <span>Please have exact change ready</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment Form -->
                        <div class="space-y-6">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                <i class="fas fa-clipboard-list text-gray-600 mr-2"></i>
                                Order Details
                            </h3>

                            <form method="POST" action="{{ route('payment.process', 'cash') }}" class="space-y-6">
                                @csrf

                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-3">Special Instructions (optional)</label>
                                    <textarea name="note" rows="4"
                                              class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:border-purple-500 focus:ring-2 focus:ring-purple-200 transition-all duration-200 hover:border-gray-300"
                                              placeholder="Any special instructions for delivery (e.g., gate code, specific entrance, preferred delivery time)..."></textarea>
                                    <p class="text-xs text-gray-500 mt-2">
                                        <i class="fas fa-info-circle mr-1"></i>
                                        Help our delivery team find you easily
                                    </p>
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

                                <div class="flex flex-col sm:flex-row gap-4 sm:justify-between">
                                    <a href="{{ route('payment.index') }}" class="sm:w-auto px-6 py-4 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-all duration-200 text-center flex items-center justify-center space-x-2 shadow-sm">
                                        <i class="fas fa-times mr-1"></i>
                                        <span>Cancel</span>
                                    </a>
                                    <button type="submit" class="flex-1 sm:flex-none sm:min-w-[200px] bg-yellow-600 hover:bg-yellow-700 text-white py-4 px-8 rounded-lg font-bold text-lg flex items-center justify-center space-x-2 shadow-lg hover:shadow-xl transition-all duration-200">
                                        <i class="fas fa-handshake mr-2"></i>
                                        <span class="mono">Confirm Cash Order</span>
                                    </button>
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
                                    <span>Secure Order Processing</span>
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-clock"></i>
                                    <span>Real-time Order Tracking</span>
                                </div>
                                <div class="w-1 h-1 bg-gray-300 rounded-full"></div>
                                <div class="flex items-center space-x-1">
                                    <i class="fas fa-user-shield"></i>
                                    <span>Your data is protected</span>
                                </div>
                            </div>
                            <p class="text-xs text-gray-400 mono">
                                Powered by {{ config('app.name') }} • Cash payments handled securely
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-payment-layout>
