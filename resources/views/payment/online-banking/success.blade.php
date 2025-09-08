<x-payment-layout>
    <x-slot name="header">
        Payment Successful
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-check-circle text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold">Payment Successful</h1>
                                <p class="text-green-100 text-sm">{{ $bankLabel }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-green-100">Amount Paid</div>
                            <div class="text-2xl font-bold mono">RM{{ number_format($amount / 100, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Success Content -->
                <div class="px-8 py-12">
                    <div class="text-center mb-8">
                        <!-- Success Animation -->
                        <div class="relative mx-auto w-20 h-20 mb-6">
                            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-3xl animate-pulse"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 w-6 h-6 bg-emerald-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Payment Received Successfully!</h2>
                        <p class="text-gray-600">Your transaction has been processed and confirmed.</p>
                    </div>

                    <!-- Transaction Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Transaction Summary</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order ID:</span>
                                <span class="font-mono">#{{ $orderId }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Bank:</span>
                                <span class="font-medium">{{ $bankLabel }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reference:</span>
                                <span class="font-mono text-sm">{{ $reference }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Date & Time:</span>
                                <span class="font-medium">{{ now()->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-3 mt-3">
                                <span class="text-gray-600 font-medium">Amount Paid:</span>
                                <span class="font-bold text-lg mono text-green-600">RM{{ number_format($amount / 100, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Success Message -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                        <div class="flex items-start space-x-3">
                            <i class="fas fa-info-circle text-green-600 text-xl mt-0.5"></i>
                            <div>
                                <h3 class="font-bold text-green-800 mb-2">What's Next?</h3>
                                <p class="text-green-700 mb-3">
                                    Your payment has been successfully processed. You will be automatically redirected to your receipt page in a few seconds.
                                </p>
                                <ul class="text-green-700 text-sm space-y-1">
                                    <li>• A confirmation email has been sent to your registered email address</li>
                                    <li>• Your order is now being prepared</li>
                                    <li>• You can track your order status in your account dashboard</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Redirect Notice -->
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="inline-flex items-center space-x-2 text-blue-600">
                                <i class="fas fa-spinner fa-spin"></i>
                                <span>Redirecting you back to {{ config('app.name') }}...</span>
                            </div>
                        </div>
                        <div class="space-x-4">
                            <a href="{{ route('payments.receipt', ['order' => $orderId]) }}" 
                               class="purple-button text-white px-6 py-3 rounded-lg font-medium">
                                <i class="fas fa-receipt mr-2"></i>View Receipt
                            </a>
                            <a href="{{ route('billing.index') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                <i class="fas fa-history mr-2"></i>View All Payments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Remove the beforeunload protection since payment is complete
        window.removeEventListener('beforeunload', function(){});
        
        // Auto-redirect to receipt after 5 seconds
        let countdown = 5;
        const countdownElement = document.createElement('div');
        countdownElement.className = 'text-sm text-gray-500 mt-2';
        countdownElement.innerHTML = `Redirecting in ${countdown} seconds...`;
        
        // Insert countdown element
        document.querySelector('.text-center').appendChild(countdownElement);
        
        const countdownTimer = setInterval(() => {
            countdown--;
            countdownElement.innerHTML = `Redirecting in ${countdown} seconds...`;
            
            if (countdown <= 0) {
                clearInterval(countdownTimer);
                window.location.href = '{{ route("payments.receipt", ["order" => $orderId]) }}';
            }
        }, 1000);

        // Celebration animation
        setTimeout(() => {
            // Add some confetti animation or additional success indicators
            const successIcon = document.querySelector('.fa-check.animate-pulse');
            successIcon.classList.add('animate-bounce');
        }, 1000);
    </script>
</x-payment-layout>