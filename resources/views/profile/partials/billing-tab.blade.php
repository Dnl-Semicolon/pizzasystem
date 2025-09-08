<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Billing & Payments</h3>
        </div>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $billingStats['total_payments'] ?? 0 }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Payments</div>
            </div>
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4 text-center">
                <div class="text-2xl font-bold text-gray-900 dark:text-gray-100">RM{{ number_format(($billingStats['total_spent'] ?? 0) / 100, 2) }}</div>
                <div class="text-sm text-gray-500 dark:text-gray-400">Total Spent</div>
            </div>
        </div>

        <!-- Main Billing Dashboard Button -->
        <div class="text-center py-8">
            <div class="mb-6">
                <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full mx-auto flex items-center justify-center mb-4 shadow-lg">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">Manage Your Billing</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    View your payment history, download receipts, and manage your billing preferences in our dedicated billing dashboard.
                </p>
            </div>

            <!-- Stripe-style Manage Billing Button -->
            <a href="{{ route('billing.index') }}" 
               target="_blank"
               class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105 hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 group">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                <span>Open Billing Dashboard</span>
                <svg class="w-4 h-4 ml-2 transform transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                Opens in a new tab
            </p>
        </div>

        @if(isset($recentPayments) && $recentPayments->count() > 0)
            <!-- Recent Payments Preview -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700">
                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Activity</h4>
                <div class="space-y-3">
                    @foreach($recentPayments->take(3) as $payment)
                        <div class="flex items-center justify-between py-2 px-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        Payment #{{ $payment->id }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $payment->created_at->format('M j, Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    RM{{ number_format($payment->amount / 100, 2) }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 capitalize">
                                    {{ str_replace('_', ' ', $payment->method) }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                @if($recentPayments->count() > 3)
                    <div class="mt-4 text-center">
                        <a href="{{ route('billing.index') }}" 
                           target="_blank"
                           class="text-sm text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300">
                            View {{ $recentPayments->count() - 3 }} more payments →
                        </a>
                    </div>
                @endif
            </div>
        @else
            <!-- Empty State -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-700 text-center py-8">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No payments yet</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Your payment history will appear here once you make your first purchase.</p>
            </div>
        @endif
    </div>
</div>