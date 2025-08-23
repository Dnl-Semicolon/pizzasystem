<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Delivery Addresses') }}
            </h2>
            <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Address
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="mb-6 bg-green-100 dark:bg-green-900/20 border border-green-400 text-green-700 dark:text-green-300 px-4 py-3 rounded">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($addresses->count() > 0)
                        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                            @foreach($addresses as $address)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 {{ $address->is_default ? 'ring-2 ring-red-500 bg-red-50 dark:bg-red-900/10' : 'bg-gray-50 dark:bg-gray-900/50' }}">
                                    
                                    <div class="flex items-center space-x-2 mb-3">
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

                                    <div class="text-sm text-gray-900 dark:text-gray-100 mb-4">
                                        <p class="font-medium">{{ $address->recipient_name }}</p>
                                        <p class="text-gray-600 dark:text-gray-400">{{ $address->phone }}</p>
                                        <p class="mt-2">{{ $address->address_line_1 }}</p>
                                        @if($address->address_line_2)
                                            <p>{{ $address->address_line_2 }}</p>
                                        @endif
                                        <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                        <p>{{ $address->country }}</p>
                                        @if($address->delivery_notes)
                                            <p class="mt-2 text-gray-600 dark:text-gray-400 italic">
                                                {{ $address->delivery_notes }}
                                            </p>
                                        @endif
                                    </div>

                                    <div class="flex flex-wrap gap-2">
                                        @if(!$address->is_default)
                                            <form action="{{ route('addresses.set-default', $address) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="text-xs px-3 py-1 bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300 rounded hover:bg-red-200 dark:hover:bg-red-900/50">
                                                    Set Default
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ route('addresses.edit', $address) }}" class="text-xs px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded hover:bg-blue-200 dark:hover:bg-blue-900/50">
                                            Edit
                                        </a>
                                        <form action="{{ route('addresses.destroy', $address) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs px-3 py-1 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded hover:bg-red-200 dark:hover:bg-red-900/50 hover:text-red-700 dark:hover:text-red-300">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
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
                                <a href="{{ route('addresses.create') }}" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
        </div>
    </div>
</x-app-layout>