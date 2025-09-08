<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    {{ __('Add New Address') }}
                </h2>
            </div>
            <a href="{{ route('addresses.index') }}" class="group inline-flex items-center px-4 py-2.5 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 hover:border-gray-300 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Addresses
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-xl border border-gray-200 dark:border-gray-700">
                <div class="bg-gray-50 dark:bg-gray-900 px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-red-50 dark:bg-red-900/20 rounded-lg flex items-center justify-center border border-red-200 dark:border-red-800">
                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Address Information</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Please fill in your delivery address details</p>
                        </div>
                    </div>
                </div>

                <div class="p-8">
                    <form method="POST" action="{{ route('addresses.store') }}" class="space-y-8">
                        @csrf

                        <!-- Label Section -->
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2">
                                <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                <x-input-label for="label" :value="__('Address Label')" class="text-sm font-medium" />
                                <span class="text-xs text-gray-500 dark:text-gray-400">(Optional)</span>
                            </div>
                            <x-text-input
                                id="label"
                                name="label"
                                type="text"
                                class="mt-1 block w-full transition-all duration-200 hover:border-red-400 focus:border-red-600 focus:ring-red-600 dark:focus:border-red-400 dark:focus:ring-red-400"
                                :value="old('label')"
                                placeholder="e.g. Home, Office, Mom's House"
                            />
                            <x-input-error class="mt-2" :messages="$errors->get('label')" />
                        </div>

                        <!-- Contact Information -->
                        <div class="bg-gray-50 dark:bg-gray-900 p-6 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center space-x-2 mb-4">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Contact Information</h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="recipient_name" :value="__('Recipient Name')" class="flex items-center space-x-2" />
                                    <x-text-input
                                        id="recipient_name"
                                        name="recipient_name"
                                        type="text"
                                        class="mt-2 block w-full transition-all duration-200 hover:border-green-400 focus:border-green-600 focus:ring-green-600 dark:focus:border-green-400 dark:focus:ring-green-400"
                                        :value="old('recipient_name')"
                                        required
                                        placeholder="Full name"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('recipient_name')" />
                                </div>

                                <div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                        <x-input-label for="phone" :value="__('Phone Number')" />
                                    </div>
                                    <x-text-input
                                        id="phone"
                                        name="phone"
                                        type="tel"
                                        class="mt-2 block w-full transition-all duration-200 hover:border-green-400 focus:border-green-600 focus:ring-green-600 dark:focus:border-green-400 dark:focus:ring-green-400"
                                        :value="old('phone')"
                                        required
                                        placeholder="+60 12-345 6789"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                </div>
                            </div>
                        </div>

                        <!-- Address Details -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-gray-100">Address Details</h4>
                            </div>

                            <div>
                                <x-input-label for="address_line_1" :value="__('Street Address')" />
                                <textarea
                                    id="address_line_1"
                                    name="address_line_1"
                                    rows="2"
                                    class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-600 dark:focus:border-blue-400 focus:ring-blue-600 dark:focus:ring-blue-400 shadow-sm transition-all duration-200 hover:border-blue-400 resize-none"
                                    required
                                    placeholder="Enter your street address, building name, unit number">{{ old('address_line_1') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('address_line_1')" />
                            </div>

                            <div>
                                <div class="flex items-center space-x-2">
                                    <x-input-label for="address_line_2" :value="__('Additional Address Information')" />
                                    <span class="text-xs text-gray-500 dark:text-gray-400">(Optional)</span>
                                </div>
                                <textarea
                                    id="address_line_2"
                                    name="address_line_2"
                                    rows="2"
                                    class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-600 dark:focus:border-blue-400 focus:ring-blue-600 dark:focus:ring-blue-400 shadow-sm transition-all duration-200 hover:border-blue-400 resize-none"
                                    placeholder="Apartment, suite, landmark, or other details">{{ old('address_line_2') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('address_line_2')" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <x-input-label for="city" :value="__('City')" />
                                    </div>
                                    <x-text-input
                                        id="city"
                                        name="city"
                                        type="text"
                                        class="mt-2 block w-full transition-all duration-200 hover:border-gray-400 focus:border-gray-700 focus:ring-gray-700 dark:focus:border-gray-300 dark:focus:ring-gray-300"
                                        :value="old('city')"
                                        required
                                        placeholder="Enter city"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('city')" />
                                </div>

                                <div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                        </svg>
                                        <x-input-label for="state" :value="__('State')" />
                                    </div>
                                    <select
                                        id="state"
                                        name="state"
                                        class="mt-2 block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-gray-700 dark:focus:border-gray-300 focus:ring-gray-700 dark:focus:ring-gray-300 shadow-sm transition-all duration-200 hover:border-gray-400"
                                        required
                                    >
                                        <option value="">Choose your state</option>
                                        <option value="Johor" {{ old('state') == 'Johor' ? 'selected' : '' }}>Johor</option>
                                        <option value="Kedah" {{ old('state') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                        <option value="Kelantan" {{ old('state') == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                        <option value="Kuala Lumpur" {{ old('state') == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                        <option value="Labuan" {{ old('state') == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                        <option value="Malacca" {{ old('state') == 'Malacca' ? 'selected' : '' }}>Malacca</option>
                                        <option value="Negeri Sembilan" {{ old('state') == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                        <option value="Pahang" {{ old('state') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                        <option value="Penang" {{ old('state') == 'Penang' ? 'selected' : '' }}>Penang</option>
                                        <option value="Perak" {{ old('state') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                        <option value="Perlis" {{ old('state') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                        <option value="Putrajaya" {{ old('state') == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                                        <option value="Sabah" {{ old('state') == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                        <option value="Sarawak" {{ old('state') == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                        <option value="Selangor" {{ old('state') == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                        <option value="Terengganu" {{ old('state') == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                    </select>
                                    <x-input-error class="mt-2" :messages="$errors->get('state')" />
                                </div>

                                <div>
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                        </svg>
                                        <x-input-label for="postal_code" :value="__('Postal Code')" />
                                    </div>
                                    <x-text-input
                                        id="postal_code"
                                        name="postal_code"
                                        type="text"
                                        class="mt-2 block w-full transition-all duration-200 hover:border-gray-400 focus:border-gray-700 focus:ring-gray-700 dark:focus:border-gray-300 dark:focus:ring-gray-300"
                                        :value="old('postal_code')"
                                        required
                                        placeholder="12345"
                                    />
                                    <x-input-error class="mt-2" :messages="$errors->get('postal_code')" />
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-green-500 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"></path>
                                    </svg>
                                    <x-input-label for="country" :value="__('Country')" />
                                </div>
                                <x-text-input
                                    id="country"
                                    name="country"
                                    type="text"
                                    class="mt-2 block w-full transition-all duration-200 hover:border-gray-400 focus:border-gray-700 focus:ring-gray-700 dark:focus:border-gray-300 dark:focus:ring-gray-300"
                                    :value="old('country', 'Malaysia')"
                                    required
                                />
                                <x-input-error class="mt-2" :messages="$errors->get('country')" />
                            </div>
                        </div>

                        <!-- Delivery Notes -->
                        <div class="bg-amber-50 dark:bg-amber-900/20 p-6 rounded-lg border border-amber-200 dark:border-amber-800">
                            <div class="flex items-center space-x-2 mb-3">
                                <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                                <h4 class="font-medium text-amber-900 dark:text-amber-100">Special Delivery Instructions</h4>
                                <span class="text-xs text-amber-700 dark:text-amber-300">(Optional)</span>
                            </div>
                            <textarea
                                id="delivery_notes"
                                name="delivery_notes"
                                rows="3"
                                class="mt-2 block w-full rounded-lg border-amber-300 dark:border-amber-700 bg-white dark:bg-gray-900 dark:text-gray-300 focus:border-amber-500 dark:focus:border-amber-600 focus:ring-amber-500 dark:focus:ring-amber-600 shadow-sm transition-all duration-200 hover:border-amber-400 resize-none"
                                placeholder="Any special instructions for delivery? e.g., Ring doorbell twice, Leave at gate, Call upon arrival, etc.">{{ old('delivery_notes') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('delivery_notes')" />
                        </div>

                        <!-- Default Address -->
                        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-center">
                                <input
                                    id="is_default"
                                    name="is_default"
                                    type="checkbox"
                                    class="rounded border-gray-300 dark:border-gray-600 text-red-600 shadow-sm focus:ring-red-500 dark:focus:ring-red-600 h-4 w-4 transition-all duration-200"
                                    value="1"
                                    {{ old('is_default') ? 'checked' : '' }}
                                >
                                <label for="is_default" class="ml-3 flex items-center cursor-pointer">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900 dark:text-gray-100">Set as default address</div>
                                        <div class="text-xs text-gray-600 dark:text-gray-400">Use this address for future orders automatically</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row items-center justify-end space-y-3 sm:space-y-0 sm:space-x-4 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('addresses.index') }}" class="w-full sm:w-auto group inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-gray-800 border-2 border-gray-300 dark:border-gray-600 rounded-lg font-medium text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-400 dark:hover:border-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-sm hover:shadow">
                                <svg class="w-4 h-4 mr-2 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </a>

                            <button type="submit" class="w-full sm:w-auto group inline-flex items-center justify-center px-8 py-3 bg-gray-900 dark:bg-gray-100 hover:bg-black dark:hover:bg-white border border-transparent rounded-lg font-semibold text-sm text-white dark:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <svg class="w-4 h-4 mr-2 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                {{ __('Save Address') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
