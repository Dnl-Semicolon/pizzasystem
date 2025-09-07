<x-app-layout>
    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h1 class="text-xl font-semibold mb-6">Card Payment</h1>
                
                <div class="mb-6 p-4 bg-gray-50 rounded">
                    <h3 class="font-medium">Cart Summary</h3>
                    <p class="text-lg font-semibold">Amount: RM {{ number_format($grandTotal, 2) }}</p>
                </div>

                <form method="POST" action="{{ route('payment.process', 'card') }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2">Cardholder Name</label>
                            <input type="text" name="card_name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Card Number</label>
                            <input type="text" name="card_number" placeholder="4111 1111 1111 1111" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Expiry (MM/YY)</label>
                                <input type="text" name="exp" placeholder="12/25" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">CVV</label>
                                <input type="text" name="cvv" placeholder="123" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Note (optional)</label>
                            <input type="text" name="note" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
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
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                            Pay RM {{ number_format($grandTotal, 2) }}
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