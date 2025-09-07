<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="text-center mb-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full mx-auto flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-green-600">Payment Successful!</h1>
                    <p class="text-gray-600">Thank you for your purchase</p>
                </div>
                
                <div class="bg-gray-50 rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Order Details</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span>Order #</span>
                            <span class="font-medium">{{ $order->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Amount</span>
                            <span class="font-medium">RM {{ number_format($order->grand_total_cents / 100, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Status</span>
                            <span class="font-medium text-green-600">{{ ucfirst($order->status) }}</span>
                        </div>
                        @if($order->payments->isNotEmpty())
                            <div class="flex justify-between">
                                <span>Payment Method</span>
                                <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payments->first()->method)) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Reference</span>
                                <span class="font-medium">{{ $order->payments->first()->reference }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span>Date</span>
                            <span class="font-medium">{{ $order->updated_at->format('M j, Y g:i A') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 text-center space-y-4">
                    <p class="text-sm text-gray-600">
                        A confirmation email will be sent to your registered email address.
                    </p>
                    <div class="flex gap-4 justify-center">
                        <a href="{{ route('order.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            View Orders
                        </a>
                        <a href="{{ route('order.create') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                            New Order
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>