<x-payment-layout>
    <x-slot name="header">
        FPX Online Banking
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-university text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold">FPX Online Banking</h1>
                                <p class="text-blue-100 text-sm">Secure Internet Banking Payment</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-blue-100">Payment Amount</div>
                            <div class="text-2xl font-bold mono">RM{{ number_format($grandTotal, 2) }}</div>
                        </div>
                    </div>
                </div>

                <div class="px-8 py-8">
                    <!-- Payment Summary -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal:</span>
                                <span class="mono">RM{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Delivery Fee:</span>
                                <span class="mono">RM{{ number_format($deliveryFee, 2) }}</span>
                            </div>
                            <div class="flex justify-between border-t pt-2 mt-2">
                                <span class="font-semibold text-gray-900">Total Amount:</span>
                                <span class="font-bold text-lg mono">RM{{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('payment.process', 'online_banking') }}">
                        @csrf
                        <div class="mb-8">
                            <h3 id="bankSelectionTitle" class="text-lg font-semibold text-gray-900 mb-4">Select Your Bank</h3>
                            <p class="text-gray-600 mb-6">Choose your preferred bank for secure online payment</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Major Banks Row 1 -->
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="maybank" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-yellow-500 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">M</span>
                                        </div>
                                        <span class="font-medium text-gray-900">Maybank</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="cimb" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-red-600 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">C</span>
                                        </div>
                                        <span class="font-medium text-gray-900">CIMB Bank</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="public_bank" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-blue-800 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">PB</span>
                                        </div>
                                        <span class="font-medium text-gray-900">Public Bank</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="rhb" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-blue-600 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">RHB</span>
                                        </div>
                                        <span class="font-medium text-gray-900">RHB Bank</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="hong_leong" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-green-600 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">HL</span>
                                        </div>
                                        <span class="font-medium text-gray-900">Hong Leong Bank</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="bsn" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-purple-600 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">BSN</span>
                                        </div>
                                        <span class="font-medium text-gray-900">BSN</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="ambank" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-orange-500 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">AM</span>
                                        </div>
                                        <span class="font-medium text-gray-900">AmBank</span>
                                    </div>
                                </label>

                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="provider" value="uob" required class="sr-only peer">
                                    <div class="border-2 border-gray-200 rounded-lg p-4 flex items-center space-x-3 peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-300 transition-all">
                                        <div class="w-8 h-8 bg-blue-900 rounded flex items-center justify-center">
                                            <span class="text-white font-bold text-xs">UOB</span>
                                        </div>
                                        <span class="font-medium text-gray-900">UOB</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                        
                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-center space-x-2 text-red-800 mb-2">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <span class="font-medium">Please fix the following errors:</span>
                                </div>
                                <ul class="text-red-700 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <!-- Security Info -->
                        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center space-x-2 text-green-800 mb-2">
                                <i class="fas fa-shield-alt"></i>
                                <span class="font-medium">Secure Payment</span>
                            </div>
                            <p class="text-green-700 text-sm">Your payment is protected by bank-level security protocols and encrypted connections.</p>
                        </div>
                        
                        <!-- Action Buttons with proper HCI placement -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('payment.index') }}" class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                                <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                                <span>Back to Payment Options</span>
                            </a>
                            <button type="submit" id="proceedBtn" disabled class="purple-button text-white px-8 py-3 rounded-lg font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                <span id="proceedText">Select Your Bank</span>
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const bankRadios = document.querySelectorAll('input[name="provider"]');
            const proceedBtn = document.getElementById('proceedBtn');
            const proceedText = document.getElementById('proceedText');
            const bankSelectionTitle = document.getElementById('bankSelectionTitle');
            
            // Bank name mapping
            const bankNames = {
                'maybank': 'Maybank',
                'cimb': 'CIMB Bank',
                'public_bank': 'Public Bank',
                'rhb': 'RHB Bank',
                'hong_leong': 'Hong Leong Bank',
                'bsn': 'BSN',
                'ambank': 'AmBank',
                'uob': 'UOB'
            };

            // Listen for bank selection changes
            bankRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.checked) {
                        // Enable the button
                        proceedBtn.disabled = false;
                        
                        // Update button text and heading to show selected bank
                        const selectedBank = bankNames[this.value] || this.value;
                        proceedText.textContent = `Proceed to ${selectedBank}`;
                        bankSelectionTitle.innerHTML = `<i class="fas fa-check-circle text-green-600 mr-2"></i>${selectedBank} Selected`;
                        
                        // Add visual feedback
                        proceedBtn.classList.add('animate-pulse');
                        setTimeout(() => {
                            proceedBtn.classList.remove('animate-pulse');
                        }, 1000);
                    }
                });
            });

            // Form submission handler
            document.querySelector('form').addEventListener('submit', function(e) {
                const selectedRadio = document.querySelector('input[name="provider"]:checked');
                if (!selectedRadio) {
                    e.preventDefault();
                    alert('Please select a bank to proceed.');
                    return;
                }
                
                // Show loading state
                proceedBtn.disabled = true;
                proceedText.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Connecting...';
            });
        });
    </script>
</x-payment-layout>