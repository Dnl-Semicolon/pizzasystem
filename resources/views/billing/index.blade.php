<x-payment-layout>
    <x-slot name="header">
        {{ __('Billing Dashboard') }}
    </x-slot>
    
    <!-- Custom Tooltip Styles -->
    <style>
        .tooltip-container {
            position: relative;
        }
        
        .tooltip {
            position: absolute;
            z-index: 50;
            padding: 0.5rem 0.75rem;
            background-color: rgba(17, 24, 39, 0.95);
            color: white;
            font-size: 0.875rem;
            border-radius: 0.375rem;
            white-space: nowrap;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.15s ease-in-out, transform 0.15s ease-in-out;
            transform: translateY(0.25rem);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .tooltip-container:hover .tooltip {
            opacity: 1;
            transform: translateY(0);
        }
        
        .tooltip-top {
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(0.25rem);
            margin-bottom: 0.5rem;
        }
        
        .tooltip-container:hover .tooltip-top {
            transform: translateX(-50%) translateY(0);
        }
        
        .tooltip-bottom {
            top: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-0.25rem);
            margin-top: 0.5rem;
        }
        
        .tooltip-container:hover .tooltip-bottom {
            transform: translateX(-50%) translateY(0);
        }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="flex items-center justify-between mb-8">
                <div>
                    <div class="flex items-center space-x-4 mb-4">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                            <span>Back to Pizza Shop</span>
                        </a>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Your Billing Dashboard</h1>
                    <p class="text-gray-600">Manage your payments and view transaction history</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-purple-600 mono">
                        RM{{ number_format($billingStats['total_spent'] / 100, 2) }}
                    </div>
                    <div class="text-sm text-gray-500">Total Spent</div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('billing.payment-methods.index') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl p-6 text-white hover:from-purple-600 hover:to-purple-700 transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">💳 Payment Methods</h3>
                            <p class="text-purple-100">Manage your saved cards</p>
                            <p class="text-sm text-purple-200 mt-2">{{ Auth::user()->savedPaymentMethods()->count() }} saved cards</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-credit-card text-2xl"></i>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('orders.create') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl p-6 text-white hover:from-green-600 hover:to-green-700 transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold mb-2">🛒 Order Pizza</h3>
                            <p class="text-green-100">Start a new order</p>
                            <p class="text-sm text-green-200 mt-2">Fresh pizzas delivered to you</p>
                        </div>
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-pizza-slice text-2xl"></i>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Total Payments</p>
                            <p class="text-2xl font-bold text-gray-900 mono">{{ $billingStats['total_payments'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-receipt text-purple-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Successful</p>
                            <p class="text-2xl font-bold text-green-600 mono">{{ $billingStats['successful_payments'] }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">This Month</p>
                            <p class="text-2xl font-bold text-blue-600 mono">RM{{ number_format($billingStats['this_month_spent'] / 100, 2) }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar-month text-blue-600"></i>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-600">Average</p>
                            <p class="text-2xl font-bold text-orange-600 mono">
                                RM{{ $billingStats['total_payments'] > 0 ? number_format($billingStats['total_spent'] / $billingStats['total_payments'] / 100, 2) : '0.00' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-chart-line text-orange-600"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
                <form method="GET" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Search by reference, method, or payment ID..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        >
                    </div>
                    <div>
                        <select name="status" class="w-40 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            <option value="">All Status</option>
                            <option value="captured" {{ request('status') === 'captured' ? 'selected' : '' }}>Captured</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                        </select>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="purple-button text-white px-6 py-2 rounded-lg font-medium">
                            <i class="fas fa-search mr-2"></i>Search
                        </button>
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('billing.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                                Clear
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Payments Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                @if($payments->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Method</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($payments as $payment)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="tooltip-container">
                                                    <a href="{{ route('billing.show', $payment) }}" 
                                                       class="w-10 h-10 bg-purple-100 hover:bg-purple-200 rounded-full flex items-center justify-center mr-3 transition-colors cursor-pointer">
                                                        <i class="fas fa-receipt text-purple-600"></i>
                                                    </a>
                                                    <div class="tooltip tooltip-top">View payment details</div>
                                                </div>
                                                <div>
                                                    <div class="tooltip-container">
                                                        <a href="{{ route('billing.show', $payment) }}" 
                                                           class="text-sm font-medium text-gray-900 hover:text-purple-600 mono transition-colors">
                                                            #{{ $payment->id }}
                                                        </a>
                                                        <div class="tooltip tooltip-top">View payment details</div>
                                                    </div>
                                                    @if($payment->reference)
                                                        <div class="text-sm text-gray-500 mono">{{ $payment->reference }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900 mono">
                                                RM{{ number_format($payment->amount / 100, 2) }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                @if($payment->order)
                                                    <div class="tooltip-container">
                                                        <a href="{{ route('orders.show', $payment->order) }}" 
                                                           class="hover:text-blue-600 hover:underline transition-colors cursor-pointer">
                                                            Order #{{ $payment->order->id }}
                                                        </a>
                                                        <div class="tooltip tooltip-bottom">
                                                            View order details - {{ $payment->order->items->count() }} items, {{ ucfirst(str_replace('_', ' ', $payment->order->status)) }}
                                                        </div>
                                                    </div>
                                                @else
                                                    Order #N/A
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 capitalize">
                                                {{ str_replace('_', ' ', $payment->method) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span @class([
                                                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                                                'bg-green-100 text-green-800' => $payment->status === 'captured',
                                                'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                                'bg-red-100 text-red-800' => $payment->status === 'failed',
                                                'bg-gray-100 text-gray-800' => !in_array($payment->status, ['captured', 'pending', 'failed'])
                                            ])>
                                                {{ ucfirst($payment->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $payment->created_at->format('M j, Y') }}
                                            <div class="text-xs text-gray-400">
                                                {{ $payment->created_at->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <a href="{{ route('billing.show', $payment) }}" 
                                               class="text-purple-600 hover:text-purple-900 transition-colors">
                                                View Details
                                            </a>
                                            @if($payment->order && $payment->status === 'captured')
                                                <a href="{{ route('payments.receipt', $payment->order) }}" 
                                                   target="_blank"
                                                   class="text-blue-600 hover:text-blue-900 transition-colors">
                                                    Receipt
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    @if($payments->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $payments->withQueryString()->links() }}
                        </div>
                    @endif
                @else
                    <!-- Empty State -->
                    <div class="text-center py-12">
                        <div class="w-16 h-16 bg-gray-100 rounded-full mx-auto flex items-center justify-center mb-4">
                            <i class="fas fa-receipt text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No payments found</h3>
                        <p class="text-gray-500 mb-6">
                            @if(request()->hasAny(['search', 'status']))
                                No payments match your current filters.
                            @else
                                You haven't made any payments yet.
                            @endif
                        </p>
                        @if(request()->hasAny(['search', 'status']))
                            <a href="{{ route('billing.index') }}" 
                               class="purple-button text-white px-6 py-3 rounded-lg font-medium">
                                Clear Filters
                            </a>
                        @else
                            <a href="{{ route('products.index') }}" 
                               class="purple-button text-white px-6 py-3 rounded-lg font-medium">
                                Start Shopping
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-payment-layout>