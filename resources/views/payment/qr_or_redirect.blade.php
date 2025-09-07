@extends('layouts.payment')

@section('title', 'Complete Payment')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white/80 payment-card rounded-2xl p-8 shadow-lg border border-white/50 text-center">
        <!-- Payment Action Required -->
        <div class="mb-8">
            <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="text-3xl">⏳</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900 mb-3">Payment Action Required</h2>
            <p class="text-gray-600">Please complete the payment using the method below</p>
        </div>

        <!-- Payment Status -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 mb-8">
            <div class="flex items-center justify-center mb-4">
                <span class="bg-yellow-500 text-white px-4 py-2 rounded-full text-sm font-medium">
                    Waiting for Payment
                </span>
            </div>
            <p class="text-sm text-gray-700">
                Order #{{ $order->id }} - RM{{ number_format($order->total_amount, 2) }}
            </p>
        </div>

        <!-- QR Code or Redirect Action -->
        @if(!empty($result->meta['qr_code']))
            <!-- QR Code Payment -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Scan QR Code to Pay</h3>
                <div class="bg-white p-6 rounded-xl border-2 border-dashed border-gray-300 inline-block">
                    <div class="w-48 h-48 mx-auto bg-gray-100 rounded-lg flex items-center justify-center">
                        @if(filter_var($result->meta['qr_code'], FILTER_VALIDATE_URL))
                            <img src="{{ $result->meta['qr_code'] }}" alt="QR Code" class="max-w-full max-h-full">
                        @else
                            <!-- QR code data - you might want to use a QR code generator here -->
                            <div class="text-xs text-gray-500 p-4 text-center">
                                QR Code<br>
                                <small class="break-all">{{ Str::limit($result->meta['qr_code'], 30) }}</small>
                            </div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-4">
                    Use your banking app or e-wallet to scan this QR code
                </p>
            </div>
        @elseif(!empty($result->meta['redirect_url']))
            <!-- Redirect Payment -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Complete Payment</h3>
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 p-6 rounded-xl border border-blue-200">
                    <div class="text-blue-600 mb-4">
                        <span class="text-4xl">🏦</span>
                    </div>
                    <p class="text-gray-700 mb-6">
                        Click the button below to continue to your bank's secure payment page
                    </p>
                    <a href="{{ $result->meta['redirect_url'] }}" 
                       class="inline-flex items-center bg-gradient-to-r from-blue-500 to-indigo-500 text-white px-8 py-4 rounded-xl font-semibold hover:from-blue-600 hover:to-indigo-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <span class="mr-2">🔗</span>
                        Continue to Bank
                    </a>
                </div>
            </div>
        @else
            <!-- Generic Action Required -->
            <div class="mb-8">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Processing</h3>
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-6 rounded-xl border border-purple-200">
                    <div class="text-purple-600 mb-4">
                        <span class="text-4xl">💳</span>
                    </div>
                    <p class="text-gray-700 mb-4">{{ $result->message }}</p>
                    @if(!empty($result->reference))
                        <p class="text-sm text-gray-600">
                            Reference: <code class="bg-gray-100 px-2 py-1 rounded">{{ $result->reference }}</code>
                        </p>
                    @endif
                </div>
            </div>
        @endif

        <!-- Instructions -->
        <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                <span class="bg-blue-100 p-2 rounded-full mr-3 text-sm">💡</span>
                What happens next?
            </h4>
            <ul class="space-y-2 text-sm text-gray-700">
                <li class="flex items-start">
                    <span class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center mr-3 mt-0.5 text-xs">1</span>
                    Complete the payment using the method above
                </li>
                <li class="flex items-start">
                    <span class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center mr-3 mt-0.5 text-xs">2</span>
                    You'll automatically be redirected when payment is successful
                </li>
                <li class="flex items-start">
                    <span class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center mr-3 mt-0.5 text-xs">3</span>
                    Your order will be confirmed and preparation will begin
                </li>
            </ul>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <button onclick="checkPaymentStatus()" 
                    class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-6 py-3 rounded-xl font-medium hover:from-green-600 hover:to-emerald-600 transition-all duration-300 shadow-lg hover:shadow-xl">
                <span class="flex items-center justify-center">
                    <span class="mr-2">🔄</span>
                    Check Payment Status
                </span>
            </button>
            
            <a href="{{ route('orders.index') }}" 
               class="bg-gray-200 text-gray-800 px-6 py-3 rounded-xl font-medium hover:bg-gray-300 transition-all duration-300">
                <span class="flex items-center justify-center">
                    <span class="mr-2">📋</span>
                    View My Orders
                </span>
            </a>
        </div>

        <!-- Auto-refresh notification -->
        <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-700 flex items-center justify-center">
                <span class="mr-2">🔄</span>
                This page will automatically check for payment updates every 30 seconds
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let checkInterval;

function checkPaymentStatus() {
    const button = event.target.closest('button');
    const originalText = button.innerHTML;
    
    button.innerHTML = '<span class="flex items-center justify-center"><svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Checking...</span>';
    button.disabled = true;
    
    fetch(`{{ route('payment.status', $order) }}`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'completed') {
            window.location.href = data.redirect_url || `{{ route('orders.receipt', $order) }}`;
        } else if (data.status === 'failed') {
            alert('Payment failed: ' + (data.message || 'Unknown error'));
            window.location.href = `{{ route('payment.index') }}`;
        } else {
            // Still pending
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error checking payment status:', error);
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    });
}

// Auto-refresh every 30 seconds
document.addEventListener('DOMContentLoaded', function() {
    checkInterval = setInterval(function() {
        fetch(`{{ route('payment.status', $order) }}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'completed') {
                clearInterval(checkInterval);
                window.location.href = data.redirect_url || `{{ route('orders.receipt', $order) }}`;
            } else if (data.status === 'failed') {
                clearInterval(checkInterval);
                alert('Payment failed: ' + (data.message || 'Unknown error'));
                window.location.href = `{{ route('payment.index') }}`;
            }
        })
        .catch(error => {
            console.error('Auto-check error:', error);
        });
    }, 30000); // 30 seconds
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (checkInterval) {
        clearInterval(checkInterval);
    }
});
</script>
@endpush