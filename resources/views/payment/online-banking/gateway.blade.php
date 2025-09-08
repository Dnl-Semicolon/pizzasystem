<x-payment-layout>
    <x-slot name="header">
        {{ $bankLabel }} Online Banking
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Bank Header -->
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-university text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold">{{ $bankLabel }}</h1>
                                <p class="text-blue-100 text-sm">Internet Banking Portal</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-4">
                            <div class="text-right">
                                <div class="text-sm text-blue-100">Payment Amount</div>
                                <div class="text-2xl font-bold mono">RM{{ number_format($amount / 100, 2) }}</div>
                            </div>
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        </div>
                    </div>
                </div>

                <!-- Banking Interface -->
                <div class="px-8 py-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Secure Login</h2>
                        <p class="text-gray-600">Please enter your online banking credentials to proceed with the payment.</p>
                    </div>

                    <!-- Payment Details -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-8">
                        <h3 class="font-semibold text-gray-900 mb-4">Payment Details</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Merchant:</span>
                                <span class="font-medium">{{ config('app.name') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Amount:</span>
                                <span class="font-bold text-lg mono">RM{{ number_format($amount / 100, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reference:</span>
                                <span class="font-mono text-sm text-gray-500">{{ now()->format('YmdHis') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('payment.online-banking.authenticate', ['key' => $key]) }}" id="loginForm">
                        @csrf
                        <div class="space-y-6">
                            <div>
                                <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-user mr-2"></i>Username / Customer ID
                                </label>
                                <input type="text" id="username" name="username" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter your username">
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class="fas fa-lock mr-2"></i>Password
                                </label>
                                <input type="password" id="password" name="password" required 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Enter your password">
                            </div>

                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center space-x-2 text-blue-800 mb-2">
                                    <i class="fas fa-info-circle"></i>
                                    <span class="font-medium">Demo Mode</span>
                                </div>
                                <p class="text-blue-700 text-sm">
                                    This is a simulation environment. You can enter any credentials to proceed with the payment demonstration.
                                </p>
                            </div>

                            <div class="flex space-x-4">
                                <button type="submit" id="loginBtn"
                                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                                    <span id="btnText">
                                        <i class="fas fa-sign-in-alt mr-2"></i>Secure Login
                                    </span>
                                    <span id="btnLoader" class="hidden">
                                        <i class="fas fa-spinner fa-spin mr-2"></i>Authenticating...
                                    </span>
                                </button>
                                <a href="{{ route('payment.index') }}" 
                                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                    Cancel
                                </a>
                            </div>
                        </div>
                    </form>

                    <!-- Security Features -->
                    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex items-center space-x-3 p-4 bg-green-50 rounded-lg">
                            <i class="fas fa-shield-alt text-green-600"></i>
                            <div>
                                <div class="font-medium text-green-800">256-bit SSL</div>
                                <div class="text-sm text-green-600">Encryption</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-4 bg-blue-50 rounded-lg">
                            <i class="fas fa-user-shield text-blue-600"></i>
                            <div>
                                <div class="font-medium text-blue-800">Multi-Factor</div>
                                <div class="text-sm text-blue-600">Authentication</div>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 p-4 bg-purple-50 rounded-lg">
                            <i class="fas fa-clock text-purple-600"></i>
                            <div>
                                <div class="font-medium text-purple-800">Session</div>
                                <div class="text-sm text-purple-600">Timeout: 15min</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Security Warning Modal Backdrop (Initially Hidden) -->
    <div id="securityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md mx-4">
            <div class="flex items-center space-x-3 mb-4">
                <i class="fas fa-exclamation-triangle text-amber-500 text-xl"></i>
                <h3 class="font-bold text-gray-900">Important Security Notice</h3>
            </div>
            <p class="text-gray-600 mb-6">Please do not close this browser tab or window during the payment process. Doing so may interrupt your transaction.</p>
            <button onclick="closeSecurityModal()" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                I Understand
            </button>
        </div>
    </div>

    <script>
        // Show security modal after 2 seconds
        setTimeout(() => {
            document.getElementById('securityModal').classList.remove('hidden');
        }, 2000);

        function closeSecurityModal() {
            document.getElementById('securityModal').classList.add('hidden');
        }

        // Form submission handler
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const loginBtn = document.getElementById('loginBtn');
            const btnText = document.getElementById('btnText');
            const btnLoader = document.getElementById('btnLoader');
            
            // Show loading state
            btnText.classList.add('hidden');
            btnLoader.classList.remove('hidden');
            loginBtn.disabled = true;
        });

        // Auto-fill demo credentials for easier testing (optional)
        document.addEventListener('DOMContentLoaded', function() {
            // This is just for demo purposes - remove in production
            setTimeout(() => {
                document.getElementById('username').placeholder = 'Try: demo_user';
                document.getElementById('password').placeholder = 'Try: demo123';
            }, 1000);
        });
    </script>
</x-payment-layout>