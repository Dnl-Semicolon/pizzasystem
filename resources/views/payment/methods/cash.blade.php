<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-xl font-semibold mb-6">Cash Payment</h1>
                
                <div class="mb-6 p-4 bg-gray-50 rounded">
                    <h3 class="font-medium">Cart Summary</h3>
                    <p class="text-lg font-semibold">Amount: RM {{ number_format($grandTotal, 2) }}</p>
                </div>

                <div class="mb-6 p-4 bg-blue-50 rounded">
                    <h4 class="font-medium text-blue-900">Cash on Delivery</h4>
                    <p class="text-blue-800">Payment will be collected when your order is delivered.</p>
                </div>

                <form method="POST" action="{{ route('payment.process', 'cash') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Special Instructions (optional)</label>
                            <textarea name="note" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md"
                                      placeholder="Any special instructions for delivery..."></textarea>
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
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                            Confirm Cash Order
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