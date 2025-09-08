<x-payment-layout>
    <x-slot name="header">
        Connecting to {{ $bankLabel }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Loading Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-university text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold">{{ $bankLabel }}</h1>
                                <p class="text-blue-100 text-sm">Secure Online Banking</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-blue-100">Payment Amount</div>
                            <div class="text-2xl font-bold mono">RM{{ number_format($amount / 100, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Loading Content -->
                <div class="px-8 py-12 text-center">
                    <div class="mb-8">
                        <!-- Loading Spinner -->
                        <div class="relative mx-auto w-16 h-16 mb-6">
                            <div class="absolute inset-0 border-4 border-blue-200 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-blue-600 rounded-full border-t-transparent animate-spin"></div>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Connecting to {{ $bankLabel }}</h2>
                        <p class="text-gray-600">Please wait while we securely connect you to your bank...</p>
                    </div>

                    <div class="space-y-4 max-w-md mx-auto">
                        <!-- Progress Steps -->
                        <div class="flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></div>
                                <span>Establishing secure connection</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-400">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                <span>Verifying security protocols</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between text-sm text-gray-400">
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                <span>Loading banking interface</span>
                            </div>
                        </div>
                    </div>

                    <!-- Security Notice -->
                    <div class="mt-8 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                        <div class="flex items-center justify-center space-x-2 text-amber-800">
                            <i class="fas fa-shield-alt"></i>
                            <span class="font-medium">Security Notice</span>
                        </div>
                        <p class="text-amber-700 text-sm mt-2">
                            Please do not close this window during the payment process. You will be redirected back automatically.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Auto-redirect Script -->
    <script>
        // Simulate loading delay and redirect
        setTimeout(() => {
            // Update progress indicators
            const steps = document.querySelectorAll('.flex.items-center.justify-between.text-sm');
            
            // Step 1 complete
            setTimeout(() => {
                steps[0].classList.remove('text-gray-500');
                steps[0].classList.add('text-green-600');
                steps[0].querySelector('.w-2.h-2').classList.remove('bg-blue-600', 'animate-pulse');
                steps[0].querySelector('.w-2.h-2').classList.add('bg-green-600');
                
                // Step 2 active
                steps[1].classList.remove('text-gray-400');
                steps[1].classList.add('text-blue-600');
                steps[1].querySelector('.w-2.h-2').classList.remove('bg-gray-300');
                steps[1].querySelector('.w-2.h-2').classList.add('bg-blue-600', 'animate-pulse');
            }, 1000);

            // Step 2 complete
            setTimeout(() => {
                steps[1].classList.remove('text-blue-600');
                steps[1].classList.add('text-green-600');
                steps[1].querySelector('.w-2.h-2').classList.remove('bg-blue-600', 'animate-pulse');
                steps[1].querySelector('.w-2.h-2').classList.add('bg-green-600');
                
                // Step 3 active
                steps[2].classList.remove('text-gray-400');
                steps[2].classList.add('text-blue-600');
                steps[2].querySelector('.w-2.h-2').classList.remove('bg-gray-300');
                steps[2].querySelector('.w-2.h-2').classList.add('bg-blue-600', 'animate-pulse');
            }, 2000);

            // Step 3 complete and redirect
            setTimeout(() => {
                steps[2].classList.remove('text-blue-600');
                steps[2].classList.add('text-green-600');
                steps[2].querySelector('.w-2.h-2').classList.remove('bg-blue-600', 'animate-pulse');
                steps[2].querySelector('.w-2.h-2').classList.add('bg-green-600');
                
                // Redirect to gateway
                window.location.href = '{{ route("payment.online-banking.gateway", ["key" => $key]) }}';
            }, 3000);
        }, 500);
    </script>
</x-payment-layout>