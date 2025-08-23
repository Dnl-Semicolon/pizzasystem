<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Edit Address') }}
            </h2>
            <a href="{{ route('addresses.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Addresses
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('addresses.update', $address) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <x-input-label for="label" :value="__('Label (Optional)')" />
                            <x-text-input id="label" name="label" type="text" class="mt-1 block w-full" :value="old('label', $address->label)" placeholder="e.g. Home, Office" />
                            <x-input-error class="mt-2" :messages="$errors->get('label')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="recipient_name" :value="__('Recipient Name')" />
                                <x-text-input id="recipient_name" name="recipient_name" type="text" class="mt-1 block w-full" :value="old('recipient_name', $address->recipient_name)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('recipient_name')" />
                            </div>

                            <div>
                                <x-input-label for="phone" :value="__('Phone Number')" />
                                <x-text-input id="phone" name="phone" type="tel" class="mt-1 block w-full" :value="old('phone', $address->phone)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="address_line_1" :value="__('Address Line 1')" />
                            <textarea id="address_line_1" name="address_line_1" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>{{ old('address_line_1', $address->address_line_1) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address_line_1')" />
                        </div>

                        <div>
                            <x-input-label for="address_line_2" :value="__('Address Line 2 (Optional)')" />
                            <textarea id="address_line_2" name="address_line_2" rows="2" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm">{{ old('address_line_2', $address->address_line_2) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('address_line_2')" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <x-input-label for="city" :value="__('City')" />
                                <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="old('city', $address->city)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('city')" />
                            </div>

                            <div>
                                <x-input-label for="state" :value="__('State')" />
                                <select id="state" name="state" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" required>
                                    <option value="">Select State</option>
                                    @php
                                        $states = [
                                            'Johor', 'Kedah', 'Kelantan', 'Kuala Lumpur', 'Labuan', 'Malacca',
                                            'Negeri Sembilan', 'Pahang', 'Penang', 'Perak', 'Perlis', 'Putrajaya',
                                            'Sabah', 'Sarawak', 'Selangor', 'Terengganu'
                                        ];
                                    @endphp
                                    @foreach($states as $state)
                                        <option value="{{ $state }}" {{ (old('state', $address->state) == $state) ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('state')" />
                            </div>

                            <div>
                                <x-input-label for="postal_code" :value="__('Postal Code')" />
                                <x-text-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" :value="old('postal_code', $address->postal_code)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="country" :value="__('Country')" />
                            <x-text-input id="country" name="country" type="text" class="mt-1 block w-full" :value="old('country', $address->country)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('country')" />
                        </div>

                        <div>
                            <x-input-label for="delivery_notes" :value="__('Delivery Notes (Optional)')" />
                            <textarea id="delivery_notes" name="delivery_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 shadow-sm" placeholder="e.g. Ring doorbell, Leave at gate, etc.">{{ old('delivery_notes', $address->delivery_notes) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('delivery_notes')" />
                        </div>

                        <div class="flex items-center">
                            <input id="is_default" name="is_default" type="checkbox" class="rounded border-gray-300 dark:border-gray-700 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600" value="1" {{ old('is_default', $address->is_default) ? 'checked' : '' }}>
                            <label for="is_default" class="ml-2 text-sm text-gray-600 dark:text-gray-400">Set as default address</label>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('addresses.index') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>

                            <x-primary-button>
                                {{ __('Update Address') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>