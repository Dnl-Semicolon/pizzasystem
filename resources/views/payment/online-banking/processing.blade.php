<x-payment-layout>
    <x-slot name="header">
        Processing Payment
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <!-- Processing Header -->
                <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-8 py-6 text-white">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-university text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-bold">{{ $bankLabel }}</h1>
                                <p class="text-orange-100 text-sm">Processing Payment</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm text-orange-100">Amount</div>
                            <div class="text-2xl font-bold mono">RM{{ number_format($amount / 100, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Processing Content -->
                <div class="px-8 py-12">
                    <div class="text-center mb-8">
                        <!-- Processing Animation -->
                        <div class="relative mx-auto w-20 h-20 mb-6">
                            <div class="absolute inset-0 border-4 border-orange-200 rounded-full"></div>
                            <div class="absolute inset-0 border-4 border-orange-500 rounded-full border-t-transparent animate-spin"></div>
                            <div class="absolute inset-4 border-2 border-amber-300 rounded-full border-b-transparent animate-spin animation-delay-75"></div>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Processing Your Payment</h2>
                        <p class="text-gray-600">Please wait while we process your transaction securely...</p>
                    </div>

                    <!-- Critical Warning -->
                    <div class="bg-red-50 border-l-4 border-red-500 p-6 mb-8">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-exclamation-triangle text-red-500 text-xl"></i>
                            <div>
                                <h3 class="font-bold text-red-800 text-lg">IMPORTANT - DO NOT CLOSE THIS TAB</h3>
                                <p class="text-red-700 mt-1">
                                    Your payment is being processed. Closing this window or navigating away may result in payment failure or duplicate charges.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Processing Steps -->
                    <div class="space-y-4 max-w-md mx-auto mb-8">
                        <div id="step1" class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 border-2 border-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-check text-blue-500 text-xs"></i>
                                </div>
                                <span class="text-green-600 font-medium">Authentication successful</span>
                            </div>
                        </div>
                        <div id="step2" class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 border-2 border-blue-500 rounded-full flex items-center justify-center">
                                    <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                                </div>
                                <span class="text-blue-600 font-medium">Verifying account balance</span>
                            </div>
                        </div>
                        <div id="step3" class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                    <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                </div>
                                <span class="text-gray-500">Processing payment transfer</span>
                            </div>
                        </div>
                        <div id="step4" class="flex items-center justify-between text-sm">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center">
                                    <div class="w-2 h-2 bg-gray-300 rounded-full"></div>
                                </div>
                                <span class="text-gray-500">Generating transaction receipt</span>
                            </div>
                        </div>
                    </div>

                    <!-- Security Indicators -->
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-green-50 rounded-lg p-4 text-center">
                            <i class="fas fa-lock text-green-600 text-xl mb-2"></i>
                            <div class="font-medium text-green-800">Secure Connection</div>
                            <div class="text-sm text-green-600">256-bit Encryption</div>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4 text-center">
                            <i class="fas fa-shield-alt text-blue-600 text-xl mb-2"></i>
                            <div class="font-medium text-blue-800">Protected Transaction</div>
                            <div class="text-sm text-blue-600">Bank Guaranteed</div>
                        </div>
                    </div>

                    <!-- Auto-completion form -->
                    <form method="POST" action="{{ route('payment.online-banking.complete', ['key' => $key]) }}" id="completeForm" class="hidden">
                        @csrf
                        <input type="hidden" name="completed" value="1">
                    </form>

                    <!-- Manual completion button (fallback) -->
                    <div id="manualComplete" class="hidden text-center mt-8">
                        <p class="text-gray-600 mb-4">Taking longer than expected?</p>
                        <button onclick="document.getElementById('completeForm').submit();"
                                class="purple-button text-white px-6 py-3 rounded-lg font-medium">
                            Complete Payment Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 2;

        // Keep a removable beforeunload handler
        function handleBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = 'Your payment is being processed. Are you sure you want to leave?';
            return e.returnValue;
        }
        window.addEventListener('beforeunload', handleBeforeUnload);

        function swapClasses(el, removes = [], adds = []) {
            if (!el) return;
            removes.forEach(c => el.classList.remove(c));
            adds.forEach(c => el.classList.add(c));
        }

        function completeStep(stepEl, colorFrom, colorTo, textFrom, textTo) {
            if (!stepEl) return;
            const ring = stepEl.querySelector(`.border-${colorFrom}-500`);
            swapClasses(ring, [`border-${colorFrom}-500`], [`border-${colorTo}-500`]);

            const dot = stepEl.querySelector(`.w-2${colorFrom ? '' : ''}`);
            if (dot) {
                dot.classList.remove('animate-pulse', `bg-${colorFrom}-500`, 'bg-gray-300', 'rounded-full');
                dot.innerHTML = '<i class="fas fa-check text-green-500 text-xs"></i>';
            }

            const text = stepEl.querySelector(`.text-${textFrom}-600`) || stepEl.querySelector('.text-gray-500');
            if (text) {
                text.classList.remove(`text-${textFrom}-600`, 'text-gray-500');
                text.classList.add(`text-${textTo}-600`, 'font-medium');
            }
        }

        function startStep(stepEl) {
            if (!stepEl) return;
            const ring = stepEl.querySelector('.border-gray-300');
            swapClasses(ring, ['border-gray-300'], ['border-blue-500']);

            const dot = stepEl.querySelector('.bg-gray-300');
            if (dot) {
                swapClasses(dot, ['bg-gray-300'], ['bg-blue-500', 'animate-pulse']);
            }

            const text = stepEl.querySelector('.text-gray-500');
            if (text) {
                swapClasses(text, ['text-gray-500'], ['text-blue-600', 'font-medium']);
            }
        }

        function safeSubmitCompletion() {
            // Remove beforeunload first so navigation isn’t blocked
            window.removeEventListener('beforeunload', handleBeforeUnload);

            const form = document.getElementById('completeForm');
            if (form) {
                try { form.submit(); return; } catch (e) { /* fall through */ }
                window.location.href = form.action;
            } else {
                window.location.href = '{{ route("payment.online-banking.complete", ["key" => $key]) }}';
            }
        }

        function processNextStep() {
            if (currentStep === 2) {
                setTimeout(() => {
                    const step2 = document.getElementById('step2');
                    completeStep(step2, 'blue', 'green', 'blue', 'green');

                    const step3 = document.getElementById('step3');
                    startStep(step3);

                    currentStep = 3;
                    processNextStep();
                }, 2500);

            } else if (currentStep === 3) {
                setTimeout(() => {
                    const step3 = document.getElementById('step3');
                    completeStep(step3, 'blue', 'green', 'blue', 'green');

                    const step4 = document.getElementById('step4');
                    startStep(step4);

                    currentStep = 4;
                    processNextStep();
                }, 3000);

            } else if (currentStep === 4) {
                setTimeout(() => {
                    const step4 = document.getElementById('step4');
                    completeStep(step4, 'blue', 'green', 'blue', 'green');

                    setTimeout(safeSubmitCompletion, 1500);
                }, 2000);
            }
        }

        // Start processing after page load
        setTimeout(processNextStep, 1000);

        // Show manual completion button after 15 seconds as failsafe
        setTimeout(() => {
            const mc = document.getElementById('manualComplete');
            if (mc) mc.classList.remove('hidden');
        }, 15000);
    </script>


    <style>
        .animation-delay-75 {
            animation-delay: 75ms;
        }
    </style>
</x-payment-layout>
