<x-payment-layout>
    <x-slot name="header">
        {{ __('Payment Details') }}
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('billing.index') }}" 
                   class="inline-flex items-center space-x-2 text-gray-600 hover:text-purple-700 hover:bg-purple-50 px-3 py-2 rounded-lg transition-all duration-200 group">
                    <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform duration-200"></i>
                    <span>Back to Billing Dashboard</span>
                </a>
            </div>

            <!-- Payment Header -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2 mono">Payment #{{ $payment->id }}</h1>
                        @if($payment->reference)
                            <p class="text-gray-600 mono">Reference: {{ $payment->reference }}</p>
                        @endif
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold text-purple-600 mono">
                            RM{{ number_format($payment->amount / 100, 2) }}
                        </div>
                        <div class="mt-2">
                            <span @class([
                                'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium',
                                'bg-green-100 text-green-800' => $payment->status === 'captured',
                                'bg-yellow-100 text-yellow-800' => $payment->status === 'pending',
                                'bg-red-100 text-red-800' => $payment->status === 'failed',
                                'bg-gray-100 text-gray-800' => !in_array($payment->status, ['captured', 'pending', 'failed'])
                            ])>
                                <i @class([
                                    'fas mr-2',
                                    'fa-check-circle' => $payment->status === 'captured',
                                    'fa-clock' => $payment->status === 'pending',
                                    'fa-times-circle' => $payment->status === 'failed',
                                    'fa-question-circle' => !in_array($payment->status, ['captured', 'pending', 'failed'])
                                ])></i>
                                {{ ucfirst($payment->status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Payment Method</h3>
                        <p class="text-lg font-medium text-gray-900 capitalize">
                            <i class="fas fa-credit-card mr-2 text-purple-600"></i>
                            {{ str_replace('_', ' ', $payment->method) }}
                        </p>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Payment Date</h3>
                        <p class="text-lg font-medium text-gray-900">
                            <i class="fas fa-calendar mr-2 text-purple-600"></i>
                            {{ $payment->created_at->format('M j, Y g:i A') }}
                        </p>
                    </div>
                    @if($payment->captured_at)
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-2">Captured At</h3>
                            <p class="text-lg font-medium text-gray-900">
                                <i class="fas fa-clock mr-2 text-green-600"></i>
                                {{ $payment->captured_at->format('M j, Y g:i A') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <!-- Order Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-gray-900">Order Details</h2>
                        @if($payment->order)
                            <a href="{{ route('orders.show', $payment->order) }}" 
                               class="text-purple-600 hover:text-purple-700 font-medium text-sm">
                                View Full Order →
                            </a>
                        @endif
                    </div>
                    
                    @if($payment->order)
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order #</span>
                                <span class="font-medium mono">#{{ $payment->order->id }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Customer</span>
                                <span class="font-medium">{{ $payment->order->customer_name ?? $payment->order->user->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Status</span>
                                <span class="font-medium capitalize">{{ str_replace('_', ' ', $payment->order->status) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Items</span>
                                <span class="font-medium">{{ $payment->order->items->count() }} items</span>
                            </div>
                            <div class="flex justify-between border-t pt-3 mt-3">
                                <span class="text-gray-600">Order Total</span>
                                <span class="font-medium mono">RM{{ number_format($payment->order->grand_total_cents / 100, 2) }}</span>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        @if($payment->order->items->count() > 0)
                            <div class="mt-6">
                                <h3 class="text-sm font-medium text-gray-500 uppercase tracking-wider mb-3">Items</h3>
                                <div class="space-y-2">
                                    @foreach($payment->order->items->take(3) as $item)
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-600">{{ $item->quantity }}× {{ $item->product->name ?? 'Unknown Item' }}</span>
                                            <span class="font-medium mono">RM{{ number_format(($item->unit_price_cents * $item->quantity) / 100, 2) }}</span>
                                        </div>
                                    @endforeach
                                    @if($payment->order->items->count() > 3)
                                        <div class="text-sm text-gray-500 italic">
                                            +{{ $payment->order->items->count() - 3 }} more items
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-exclamation-triangle text-2xl mb-2"></i>
                            <p>Order information not available</p>
                        </div>
                    @endif
                </div>

                <!-- Payment Attempts -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Payment Attempts</h2>
                    
                    @if($paymentAttempts->count() > 0)
                        <div class="space-y-4">
                            @foreach($paymentAttempts as $attempt)
                                <div @class([
                                    'border rounded-lg p-4',
                                    'border-green-200 bg-green-50' => $attempt->status === 'success',
                                    'border-red-200 bg-red-50' => $attempt->status === 'failed',
                                    'border-yellow-200 bg-yellow-50' => $attempt->status === 'pending',
                                    'border-gray-200 bg-gray-50' => !in_array($attempt->status, ['success', 'failed', 'pending'])
                                ])>
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center space-x-2">
                                            <i @class([
                                                'fas',
                                                'fa-check-circle text-green-600' => $attempt->status === 'success',
                                                'fa-times-circle text-red-600' => $attempt->status === 'failed',
                                                'fa-clock text-yellow-600' => $attempt->status === 'pending',
                                                'fa-question-circle text-gray-600' => !in_array($attempt->status, ['success', 'failed', 'pending'])
                                            ])></i>
                                            <span class="font-medium capitalize">{{ $attempt->status }}</span>
                                        </div>
                                        <span class="text-sm text-gray-500">
                                            {{ $attempt->created_at->format('M j, Y g:i A') }}
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Method:</span>
                                            <span class="font-medium capitalize ml-1">{{ str_replace('_', ' ', $attempt->method) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Amount:</span>
                                            <span class="font-medium mono ml-1">RM{{ number_format($attempt->amount / 100, 2) }}</span>
                                        </div>
                                    </div>
                                    @if($attempt->error_message)
                                        <div class="mt-2 text-sm text-red-600">
                                            <strong>Error:</strong> {{ $attempt->error_message }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-info-circle text-2xl mb-2"></i>
                            <p>No payment attempt details available</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Actions</h2>
                <div class="flex flex-wrap gap-3">
                    @if($payment->order && $payment->status === 'captured')
                        <a href="{{ route('payments.receipt', $payment->order) }}" 
                           target="_blank"
                           class="purple-button text-white px-6 py-3 rounded-lg font-medium">
                            <i class="fas fa-receipt mr-2"></i>
                            View Receipt
                        </a>
                        <a href="{{ route('orders.show', $payment->order) }}" 
                           class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                            <i class="fas fa-box mr-2"></i>
                            View Order Details
                        </a>
                    @endif
                    
                    @if($payment->order && $payment->order->status === 'delivered')
                        <button type="button" 
                                class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                            <i class="fas fa-redo mr-2"></i>
                            Reorder Items
                        </button>
                    @endif
                </div>
            </div>

            <!-- Metadata (if available) -->
            @if($payment->meta)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Technical Details</h2>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <pre class="text-sm text-gray-700 mono overflow-x-auto">{{ json_encode($payment->meta, JSON_PRETTY_PRINT) }}</pre>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-payment-layout>