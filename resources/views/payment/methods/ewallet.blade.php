<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-xl font-semibold mb-6">E-Wallet Payment</h1>
                
                <div class="mb-6 p-4 bg-gray-50 rounded">
                    <h3 class="font-medium">Cart Summary</h3>
                    <p class="text-lg font-semibold">Amount: RM {{ number_format($grandTotal, 2) }}</p>
                </div>

                <form method="POST" action="{{ route('payment.process', 'ewallet') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">E-Wallet Provider</label>
                            <select name="provider" class="w-full px-3 py-2 border border-gray-300 rounded-md">
                                <option value="grabpay">GrabPay</option>
                                <option value="boost">Boost</option>
                                <option value="tng">Touch 'n Go eWallet</option>
                                <option value="shopee_pay">ShopeePay</option>
                            </select>
                        </div>
                    </div>
                    
                    @if($errors->any())
                        <div class="mt-4 p-3 bg-red-100 text-red-700 rounded">
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                    
                    <div class="mt-6 flex gap-4">
                        <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded hover:bg-purple-700">
                            Pay with E-Wallet
                        </button>
                        <a href="{{ route('payment.index') }}" class="bg-gray-300 text-gray-700 px-6 py-2 rounded hover:bg-gray-400">
                            Back
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>