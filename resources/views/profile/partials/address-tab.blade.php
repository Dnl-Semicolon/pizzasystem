<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Delivery Addresses</h3>
            <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Address
            </a>
        </div>

        @php
            $addresses = Auth::user()->addresses()->orderBy('is_default', 'desc')->get();
        @endphp

        @if($addresses->count() > 0)
            <div class="space-y-4">
                @foreach($addresses as $address)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $address->is_default ? 'ring-2 ring-red-500 bg-red-50 dark:bg-red-900/10' : 'bg-gray-50 dark:bg-gray-900/50' }}">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2 mb-2">
                                    @if($address->label)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-200">
                                            {{ $address->label }}
                                        </span>
                                    @endif
                                    @if($address->is_default)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 dark:bg-red-900/50 text-red-800 dark:text-red-200">
                                            Default
                                        </span>
                                    @endif
                                </div>
                                <div class="text-sm text-gray-900 dark:text-gray-100">
                                    <p class="font-medium">{{ $address->recipient_name }} • {{ $address->phone }}</p>
                                    <p class="mt-1">{{ $address->address_line_1 }}</p>
                                    @if($address->address_line_2)
                                        <p>{{ $address->address_line_2 }}</p>
                                    @endif
                                    <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                    <p>{{ $address->country }}</p>
                                    @if($address->delivery_notes)
                                        <p class="mt-2 text-gray-600 dark:text-gray-400 italic">{{ $address->delivery_notes }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="flex flex-col space-y-2 ml-4">
                                @if(!$address->is_default)
                                    <form action="{{ route('addresses.set-default', $address) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-sm text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300">Set Default</button>
                                    </form>
                                @endif
                                <a href="{{ route('addresses.edit', $address) }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">Edit</a>
                                <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                <a href="{{ route('addresses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-200 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Manage All Addresses
                </a>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">No addresses saved</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by adding your first delivery address.</p>
                <div class="mt-6">
                    <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Address
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
