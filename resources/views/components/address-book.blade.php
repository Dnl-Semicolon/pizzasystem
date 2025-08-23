@props(['useDefault' => false, 'addresses' => []])

<div class="space-y-4">
    <div class="flex items-center">
        <input type="checkbox" id="use-default-address" name="use_default_address" value="1" 
               {{ $useDefault ? 'checked' : '' }}
               class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500">
        <label for="use-default-address" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
            Use my default address
        </label>
    </div>

    <div id="address-select" class="{{ $useDefault ? '' : 'hidden' }}">
        <label for="saved-address" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
            Select Address
        </label>
        <select id="saved-address" name="saved_address_id" 
                class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500">
            <option value="">Choose an address</option>
            @forelse($addresses as $address)
                <option value="{{ $address['id'] ?? '' }}">{{ $address['label'] ?? 'Address' }}</option>
            @empty
                <option value="1">123 Main Street, City Center, 12345 Kuala Lumpur</option>
                <option value="2">456 Business Avenue, KLCC, 50088 Kuala Lumpur</option>
            @endforelse
        </select>
    </div>

    <div id="new-address-form" class="{{ $useDefault ? 'hidden' : '' }} space-y-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Full Name *
                </label>
                <input type="text" id="full_name" name="full_name" required
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                       placeholder="Enter full name">
                <div class="text-red-500 text-xs mt-1 hidden" id="full_name_error">Please enter your full name</div>
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Phone Number *
                </label>
                <input type="tel" id="phone" name="phone" required
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                       placeholder="e.g., +60123456789">
                <div class="text-red-500 text-xs mt-1 hidden" id="phone_error">Please enter a valid phone number</div>
            </div>
        </div>

        <div>
            <label for="address_line_1" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Address Line 1 *
            </label>
            <input type="text" id="address_line_1" name="address_line_1" required
                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                   placeholder="Street address">
            <div class="text-red-500 text-xs mt-1 hidden" id="address_line_1_error">Please enter your address</div>
        </div>

        <div>
            <label for="address_line_2" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Address Line 2
            </label>
            <input type="text" id="address_line_2" name="address_line_2"
                   class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                   placeholder="Apartment, suite, etc. (optional)">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="postcode" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Postcode *
                </label>
                <input type="text" id="postcode" name="postcode" required maxlength="5"
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                       placeholder="12345">
                <div class="text-red-500 text-xs mt-1 hidden" id="postcode_error">Please enter a valid postcode</div>
            </div>
            
            <div>
                <label for="city" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    City *
                </label>
                <input type="text" id="city" name="city" required
                       class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                       placeholder="Kuala Lumpur">
                <div class="text-red-500 text-xs mt-1 hidden" id="city_error">Please enter your city</div>
            </div>
            
            <div>
                <label for="state" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    State *
                </label>
                <select id="state" name="state" required
                        class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">Select state</option>
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Penang">Penang</option>
                    <option value="Johor">Johor</option>
                    <option value="Perak">Perak</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Terengganu">Terengganu</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Melaka">Melaka</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                </select>
                <div class="text-red-500 text-xs mt-1 hidden" id="state_error">Please select your state</div>
            </div>
        </div>

        <div>
            <label for="delivery_notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                Delivery Notes (Optional)
            </label>
            <textarea id="delivery_notes" name="delivery_notes" rows="3"
                      class="w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 shadow-sm focus:border-green-500 focus:ring-green-500"
                      placeholder="Special delivery instructions, building access codes, etc."></textarea>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const useDefaultCheckbox = document.getElementById('use-default-address');
    const addressSelect = document.getElementById('address-select');
    const newAddressForm = document.getElementById('new-address-form');

    function toggleAddressInputs() {
        if (useDefaultCheckbox.checked) {
            addressSelect.classList.remove('hidden');
            newAddressForm.classList.add('hidden');
            newAddressForm.querySelectorAll('input[required], select[required]').forEach(input => {
                input.removeAttribute('required');
            });
        } else {
            addressSelect.classList.add('hidden');
            newAddressForm.classList.remove('hidden');
            newAddressForm.querySelectorAll('input[data-required="true"], select[data-required="true"]').forEach(input => {
                input.setAttribute('required', 'required');
            });
        }
    }

    useDefaultCheckbox.addEventListener('change', toggleAddressInputs);
    
    newAddressForm.querySelectorAll('input[required], select[required]').forEach(input => {
        input.setAttribute('data-required', 'true');
    });
    
    toggleAddressInputs();
});
</script>

<!-- TODO: hydrate with user's saved addresses; TODO: client-side show/hide and persist to session on continue -->