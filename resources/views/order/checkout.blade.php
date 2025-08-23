<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-6 pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                        @csrf

                    <!-- Order Summary -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>

                        @if(empty($cart))
                            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                                <p>Your cart is empty</p>
                                <a href="{{ route('orders.create') }}" class="text-green-600 hover:text-green-700 text-sm">Continue shopping</a>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach($cart as $item)
                                    <div class="flex justify-between items-start py-3 border-b border-gray-100 dark:border-gray-700 last:border-b-0">
                                        <div class="flex-1">
                                            <h4 class="font-medium text-gray-900 dark:text-gray-100">
                                                {{ $item->product_name }}
                                            </h4>
                                            @if($item->size || $item->crust)
                                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                    @if($item->size)
                                                        <span>{{ $item->size->name }}</span>
                                                    @endif
                                                    @if($item->crust)
                                                        <span>• {{ $item->crust->name }}</span>
                                                    @endif
                                                </div>
                                            @endif
                                            @if($item->toppings && $item->toppings->count() > 0)
                                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                                    Toppings: {{ $item->toppings->pluck('name')->join(', ') }}
                                                </div>
                                            @endif
                                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                Qty: {{ $item->quantity }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="font-medium text-gray-900 dark:text-gray-100">
                                                RM {{ number_format($item->total_price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Delivery Mode -->
                {{--<div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Type</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="delivery_mode" value="delivery"
                                       {{ old('delivery_mode', session('checkout.delivery_mode', 'delivery')) == 'delivery' ? 'checked' : '' }}
                                       class="text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Delivery</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="delivery_mode" value="pickup"
                                       {{ old('delivery_mode', session('checkout.delivery_mode', 'delivery')) == 'pickup' ? 'checked' : '' }}
                                       class="text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Pickup</span>
                            </label>
                        </div>
                    </div>--}}

                    <!-- Contact Information -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6  mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Contact Information</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label for="contact_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Full Name *
                                </label>
                                <input type="text" id="contact_name" name="contact_name" required
                                       value="{{ old('contact_name', session('checkout.contact_name', Auth::check() ? Auth::user()->name : '')) }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="Your full name">
                            </div>
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Phone Number *
                                </label>
                                <input type="tel" id="contact_phone" name="contact_phone" required
                                       value="{{ old('contact_phone', session('checkout.contact_phone', Auth::check() ? (Auth::user()->phone ?? '') : '')) }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="+60123456789">
                            </div>
                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Email Address
                                </label>
                                <input type="email" id="contact_email" name="contact_email"
                                       value="{{ old('contact_email', session('checkout.contact_email', Auth::check() ? Auth::user()->email : '')) }}"
                                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                       placeholder="your@email.com">
                            </div>
                        </div>
                    </div>

                    <!-- Delivery Address -->
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Delivery Address</h3>

                        @if(Auth::check() && $addresses->count() > 0)
                            <div class="space-y-4">
                                <!-- Use Saved Address -->
                                <div class="flex items-center">
                                    <input type="checkbox" id="use-saved-address" name="use_saved_address" value="1" checked
                                           class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
                                    <label for="use-saved-address" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Use saved address
                                    </label>
                                </div>

                                <!-- Saved Address Selection -->
                                <div id="saved-address-section" class="space-y-3">
                                    <div class="grid gap-3">
                                        @foreach($addresses as $address)
                                            <label class="flex items-start p-3 border border-gray-200 dark:border-gray-700 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 {{ $address->is_default ? 'ring-2 ring-green-500 bg-green-50 dark:bg-green-900/10' : '' }}">
                                                <input type="radio" name="saved_address_id" value="{{ $address->id }}"
                                                       class="mt-1 text-green-600 focus:ring-green-500"
                                                       data-addr1="{{ $address->address_line_1 }}"
                                                       data-addr2="{{ $address->address_line_2 ?? '' }}"
                                                       data-postcode="{{ $address->postal_code }}"
                                                       data-city="{{ $address->city }}"
                                                       data-state="{{ $address->state }}"
                                                       data-notes="{{ $address->delivery_notes ?? '' }}"
                                                       {{ $address->is_default ? 'checked' : '' }}>
                                                <div class="ml-3 flex-1">
                                                    <div class="flex items-center space-x-2 mb-1">
                                                        @if($address->label)
                                                            <span class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $address->label }}</span>
                                                        @endif
                                                        @if($address->is_default)
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 dark:bg-green-900/50 text-green-800 dark:text-green-200">
                                                                Default
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                                        <p class="font-medium">{{ $address->recipient_name }} • {{ $address->phone }}</p>
                                                        <p>{{ $address->address_line_1 }}</p>
                                                        @if($address->address_line_2)
                                                            <p>{{ $address->address_line_2 }}</p>
                                                        @endif
                                                        <p>{{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}</p>
                                                        @if($address->delivery_notes)
                                                            <p class="italic">{{ $address->delivery_notes }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- New Address Form -->
                        <div id="new-address-section" class="space-y-4 {{ Auth::check() && $addresses->count() > 0 ? 'mt-6' : '' }}">
                            @if(Auth::check() && $addresses->count() > 0)
                                <hr class="border-gray-200 dark:border-gray-700">
                                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Or enter new address</h4>
                            @endif

                            <div class="space-y-4">
                                <div>
                                    <label for="addr1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Address Line 1 *
                                    </label>
                                    <input type="text" id="addr1" name="addr1"
                                           value="{{ old('addr1', session('checkout.addr1', '')) }}"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                           placeholder="Street address">
                                </div>

                                <div>
                                    <label for="addr2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Address Line 2
                                    </label>
                                    <input type="text" id="addr2" name="addr2"
                                           value="{{ old('addr2', session('checkout.addr2', '')) }}"
                                           class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                           placeholder="Apartment, suite, etc. (optional)">
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <div>
                                        <label for="postcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            Postcode *
                                        </label>
                                        <input type="text" id="postcode" name="postcode" maxlength="5"
                                               value="{{ old('postcode', session('checkout.postcode', '')) }}"
                                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                               placeholder="12345">
                                    </div>

                                    <div>
                                        <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            City *
                                        </label>
                                        <input type="text" id="city" name="city"
                                               value="{{ old('city', session('checkout.city', '')) }}"
                                               class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                               placeholder="Kuala Lumpur">
                                    </div>

                                    <div>
                                        <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                            State *
                                        </label>
                                        <select id="state" name="state"
                                                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="">Select state</option>
                                            @php $selectedState = old('state', session('checkout.state', '')); @endphp
                                            <option value="Johor" {{ $selectedState == 'Johor' ? 'selected' : '' }}>Johor</option>
                                            <option value="Kedah" {{ $selectedState == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                            <option value="Kelantan" {{ $selectedState == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                            <option value="Kuala Lumpur" {{ $selectedState == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                            <option value="Labuan" {{ $selectedState == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                            <option value="Malacca" {{ $selectedState == 'Malacca' ? 'selected' : '' }}>Malacca</option>
                                            <option value="Negeri Sembilan" {{ $selectedState == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                            <option value="Pahang" {{ $selectedState == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                            <option value="Penang" {{ $selectedState == 'Penang' ? 'selected' : '' }}>Penang</option>
                                            <option value="Perak" {{ $selectedState == 'Perak' ? 'selected' : '' }}>Perak</option>
                                            <option value="Perlis" {{ $selectedState == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                            <option value="Putrajaya" {{ $selectedState == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                                            <option value="Sabah" {{ $selectedState == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                            <option value="Sarawak" {{ $selectedState == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                            <option value="Selangor" {{ $selectedState == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                            <option value="Terengganu" {{ $selectedState == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="delivery_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                        Delivery Notes (Optional)
                                    </label>
                                    <textarea id="delivery_notes" name="delivery_notes" rows="3"
                                              class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                                              placeholder="Special delivery instructions, building access codes, etc.">{{ old('delivery_notes', session('checkout.delivery_notes', '')) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

                <!-- Order Total Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 sticky top-6">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Total</h3>

                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600 dark:text-gray-400">Delivery Fee</span>
                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($deliveryFee, 2) }}</span>
                            </div>
                            <hr class="border-gray-200 dark:border-gray-700">
                            <div class="flex justify-between text-base font-semibold">
                                <span class="text-gray-900 dark:text-gray-100">Total</span>
                                <span class="text-gray-900 dark:text-gray-100">RM {{ number_format($grandTotal, 2) }}</span>
                            </div>
                        </div>

                        <div class="mt-6 text-xs text-gray-500 dark:text-gray-400">
{{--                            <p>* Delivery fee may vary based on location</p>--}}
{{--                            <p>* GST included where applicable</p>--}}
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Sticky Bottom Bar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700 p-4 shadow-lg z-50">
        <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('orders.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Back to Cart
                </a>
                <div class="hidden sm:block text-sm text-gray-600 dark:text-gray-400">
                    Total: <span class="font-semibold text-gray-900 dark:text-gray-100">RM {{ number_format($grandTotal, 2) }}</span>
                </div>
            </div>

            <button type="submit" form="checkout-form"
                    class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                Continue to Payment
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Order Total (visible on mobile) -->
    <div class="sm:hidden block mb-4">
        <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                <span>Subtotal</span>
                <span>RM {{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                <span>Delivery</span>
                <span>RM {{ number_format($deliveryFee, 2) }}</span>
            </div>
            <div class="flex justify-between font-semibold text-gray-900 dark:text-gray-100">
                <span>Total</span>
                <span>RM {{ number_format($grandTotal, 2) }}</span>
            </div>
        </div>
    </div>

</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('checkout-form');
    const submitButton = document.querySelector('button[form="checkout-form"]');

    // Address toggle functionality
    const useSavedAddressCheckbox = document.getElementById('use-saved-address');
    const savedAddressSection = document.getElementById('saved-address-section');
    const newAddressSection = document.getElementById('new-address-section');

    // Handle saved address toggle
    if (useSavedAddressCheckbox) {
        // Initialize with saved address checked
        savedAddressSection.classList.remove('hidden');
        newAddressSection.querySelectorAll('input[required], select[required]').forEach(field => {
            field.setAttribute('data-required', 'true');
            field.removeAttribute('required');
        });

        // Auto-populate address fields if there's a default address selected on page load
        const defaultSelectedAddress = document.querySelector('input[name="saved_address_id"]:checked');
        if (defaultSelectedAddress) {
            document.getElementById('addr1').value = defaultSelectedAddress.dataset.addr1 || '';
            document.getElementById('addr2').value = defaultSelectedAddress.dataset.addr2 || '';
            document.getElementById('postcode').value = defaultSelectedAddress.dataset.postcode || '';
            document.getElementById('city').value = defaultSelectedAddress.dataset.city || '';
            document.getElementById('state').value = defaultSelectedAddress.dataset.state || '';
            document.getElementById('delivery_notes').value = defaultSelectedAddress.dataset.notes || '';
        }

        useSavedAddressCheckbox.addEventListener('change', function() {
            if (this.checked) {
                savedAddressSection.classList.remove('hidden');
                // Make new address fields optional when using saved address
                newAddressSection.querySelectorAll('input, select').forEach(field => {
                    field.removeAttribute('required');
                    field.value = '';
                });
            } else {
                savedAddressSection.classList.add('hidden');
                // Make new address fields required again
                newAddressSection.querySelectorAll('input[data-required], select[data-required]').forEach(field => {
                    field.setAttribute('required', 'required');
                });
                // Uncheck any selected saved addresses
                document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
                    radio.checked = false;
                });
            }
            validateForm();
        });

        // Handle saved address radio button changes
        document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.checked) {
                    // When a saved address is selected, make sure the checkbox is checked
                    useSavedAddressCheckbox.checked = true;
                    savedAddressSection.classList.remove('hidden');

                    // Populate new address fields with selected saved address data
                    document.getElementById('addr1').value = this.dataset.addr1 || '';
                    document.getElementById('addr2').value = this.dataset.addr2 || '';
                    document.getElementById('postcode').value = this.dataset.postcode || '';
                    document.getElementById('city').value = this.dataset.city || '';
                    document.getElementById('state').value = this.dataset.state || '';
                    document.getElementById('delivery_notes').value = this.dataset.notes || '';

                    // Make new address fields optional since we have a saved address
                    newAddressSection.querySelectorAll('input, select').forEach(field => {
                        field.removeAttribute('required');
                    });
                }
                validateForm();
            });
        });

        // Auto-switch to new address when typing in new address fields
        const newAddressFields = newAddressSection.querySelectorAll('input, select, textarea');
        let isPopulating = false; // Flag to prevent hiding during auto-population

        newAddressFields.forEach(field => {
            field.addEventListener('input', function() {
                // Don't hide saved addresses if we're auto-populating from a saved address
                if (isPopulating) return;

                // Only hide saved addresses if user is actually typing new content
                if (this.value.trim() && !document.querySelector('input[name="saved_address_id"]:checked')) {
                    return; // User is already in new address mode
                }

                // If user types in address fields while a saved address is selected, switch to new address mode
                if (this.value.trim() && document.querySelector('input[name="saved_address_id"]:checked')) {
                    // Uncheck saved address options and hide the section
                    useSavedAddressCheckbox.checked = false;
                    savedAddressSection.classList.add('hidden');
                    document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
                        radio.checked = false;
                    });
                    // Make new address fields required
                    newAddressSection.querySelectorAll('input[data-required], select[data-required]').forEach(requiredField => {
                        requiredField.setAttribute('required', 'required');
                    });
                    validateForm();
                }
            });
        });

        // Modify the saved address change handler to use the flag
        document.querySelectorAll('input[name="saved_address_id"]').forEach(radio => {
            const originalHandler = radio.onchange;
            radio.addEventListener('change', function() {
                if (this.checked) {
                    isPopulating = true;
                    // Populate fields (this code is already there)
                    document.getElementById('addr1').value = this.dataset.addr1 || '';
                    document.getElementById('addr2').value = this.dataset.addr2 || '';
                    document.getElementById('postcode').value = this.dataset.postcode || '';
                    document.getElementById('city').value = this.dataset.city || '';
                    document.getElementById('state').value = this.dataset.state || '';
                    document.getElementById('delivery_notes').value = this.dataset.notes || '';

                    // Reset flag after a short delay
                    setTimeout(() => {
                        isPopulating = false;
                    }, 100);
                }
            });
        });
    }

    // Basic form validation
    function validateForm() {
        let isValid = true;

        // Always required fields
        const contactName = document.getElementById('contact_name');
        const contactPhone = document.getElementById('contact_phone');

        if (!contactName.value.trim()) isValid = false;
        if (!contactPhone.value.trim()) isValid = false;

        // // Check if delivery mode is selected
        // const selectedDeliveryMode = document.querySelector('input[name="delivery_mode"]:checked');
        // if (!selectedDeliveryMode) isValid = false;

        // If using saved address, check if one is selected
        if (useSavedAddressCheckbox && useSavedAddressCheckbox.checked) {
            const selectedAddress = document.querySelector('input[name="saved_address_id"]:checked');
            if (!selectedAddress) {
                isValid = false;
            }
        } else {
            // Check new address fields
            const addr1 = document.getElementById('addr1');
            const postcode = document.getElementById('postcode');
            const city = document.getElementById('city');
            const state = document.getElementById('state');

            if (!addr1.value.trim()) isValid = false;
            if (!postcode.value.trim()) isValid = false;
            if (!city.value.trim()) isValid = false;
            if (!state.value.trim()) isValid = false;
        }

        if (submitButton) {
            submitButton.disabled = !isValid;
        }
        return isValid;
    }

    // Listen for input changes
    document.addEventListener('input', validateForm);
    document.addEventListener('change', validateForm);

    // Listen for delivery mode changes
    document.querySelectorAll('input[name="delivery_mode"]').forEach(radio => {
        radio.addEventListener('change', validateForm);
    });

    // Initial validation
    validateForm();

    // Handle form submission
    form.addEventListener('submit', function(e) {
        if (!validateForm()) {
            e.preventDefault();
            alert('Please fill in all required fields and select an address before continuing.');
            return;
        }
        // Form is valid, allow submission to proceed
    });
});
</script>

