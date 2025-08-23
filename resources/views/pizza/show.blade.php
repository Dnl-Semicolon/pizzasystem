<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pizza') }}
        </h2>
    </x-slot>

    <div class="py-12">
        {{---------------------------------------------
             1. Wrap the entire page  in  a  form,
                mark the action as the addtoCart()
                method in the CartController class
                , mark it as  POST,  and  leave  a
                @csrf token.
          ---------------------------------------------}}
        <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            {{---------------------------------------------
               2. All the hidden input fields  are
                  here   to   be   used   by   the
                  CartController to  retrieve  via
                  $request (type Request) object.
              ---------------------------------------------}}

            {{-- name: pizza_id, immediately  from current pizza ('$pizza') --}}
            {{-- Comes from $pizza object --}}
            <input type="hidden" value="{{ $pizza->id }}"    name="pizza_id"   >

            {{-- Filled via JavaScript --}}
            <input type="hidden" id="selected_size_id"       name="size_id"    >
            <input type="hidden" id="selected_crust_id"      name="crust_id"   >
            <input type="hidden" id="selected_price"         name="price"      >
            <input type="hidden" id="selected_addon"         name="add_on_price"      >
            <input type="hidden" id="selected_unit_price"    name="unit_price" >
            <input type="hidden" id="selected_total_price"   name="total_price">
            <input type="hidden" id="selected_quantity"      name="quantity"   >
            <input type="hidden" id="selected_toppings_json" name="toppingsJson"   > {{-- JSON list --}}

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid grid-cols-1 xl:grid-cols-4 gap-10">

                            {{-- Left: Pizza Details --}}
                            <div class="md:col-span-2">
                                {{---------------------------------------------
                                     3. Display the current pizza's name.
                                  ---------------------------------------------}}
                                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $pizza->product->name }}</h2>

                                <p class="text-gray-500 dark:text-gray-400 mb-6">Select your size and crust</p>
                                {{---------------------------------------------
                                     4. For each pizza size, each  knows  as
                                        "$size"
                                  ---------------------------------------------}}
                                @foreach ($sizes as $size)
                                    {{---------------------------------------------
                                         5. Display  the  pizza size's  name  in
                                            uppercase form.
                                      ---------------------------------------------}}
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mt-6">{{ strtoupper($size->name) }}</h3>
                                    <div class="divide-y divide-gray-300 dark:divide-gray-600 border border-gray-300 dark:border-gray-600 rounded-lg">
                                        {{---------------------------------------------
                                             6. For each pizza crust, each knows  as
                                                "$crust"
                                          ---------------------------------------------}}
                                        @foreach ($crusts as $crust)
                                            {{---------------------------------------------
                                                 7. Check using the  price map,  whether
                                                    this    pizza    size    and   crust
                                                    combination   exists. If  so,   mark
                                                    $available as TRUE.
                                              ---------------------------------------------}}
                                            @php
                                                $available = isset($priceMap[$size->id][$crust->id]);
                                            @endphp
                                            {{---------------------------------------------
                                                 8. If and only if $available is TRUE
                                              ---------------------------------------------}}
                                            @if ($available)
                                                <label class="flex items-center justify-between py-3 px-4 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                                    <div class="flex items-center gap-3">
                                                        <input type="radio" name="pizza-selection" value="{{ $size->id }}-{{ $crust->id }}-{{ $priceMap[$size->id][$crust->id] }}" class="w-4 h-4 text-blue-600" data-size="{{ $size->name }}" data-crust="{{ $crust->name }}" data-price="{{ $priceMap[$size->id][$crust->id] }}" data-addon="{{ $addOnMap[$size->id][$crust->id] }}">
                                                        <img src="{{ asset($crust->image_url) }}" alt="{{ $crust->name }}" class="w-10 h-10 rounded object-cover">
                                                        <span>{{ $crust->name }}</span>
                                                    </div>
                                                    <span class="font-medium text-sm">RM {{ number_format($priceMap[$size->id][$crust->id], 2) }}</span>
                                                </label>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            {{-- Middle: Toppings --}}
                            <div id="toppings-section" class="opacity-50 pointer-events-none">
                                <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Add Something Extra</h3>
                                <div id="disabled-message" class="text-sm text-gray-500 dark:text-gray-400 mb-4 italic">
                                    Please select your pizza size and crust first
                                </div>
                                <ul class="divide-y divide-gray-300 dark:divide-gray-600">
                                    @foreach ($toppings as $topping)
                                        <li class="flex justify-between items-center py-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors rounded px-2">
                                            <label class="flex justify-between items-center w-full cursor-pointer">
                                                <div class="flex items-center gap-3">
                                                    <input type="checkbox" name="toppings[]" value="{{ $topping->id }}-{{ $topping->price }}" class="w-4 h-4 text-blue-600" data-name="{{ $topping->name }}" data-price="{{ $topping->price }}">
                                                    <img src="{{ asset($topping->image_url) }}" alt="{{ $topping->name }}" class="w-8 h-8 object-cover rounded">
                                                    <span class="text-sm">{{ $topping->name }}</span>
                                                </div>
                                                <span class="text-sm font-medium text-green-600">+RM {{ number_format($topping->price, 2) }}</span>
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mt-4">Quantity</label>
                                <input type="number" name="quantity" min="1" value="1" id="quantity" class="w-20 mt-1 p-2 border border-gray-300 dark:border-gray-600 rounded bg-white dark:bg-gray-800 text-gray-900 dark:text-white">
                            </div>

                            {{-- Right: Order Summary --}}
                            <div class="md:col-span-1">
                                <div class="sticky top-6 bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                                    <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300 mb-4">Your Order</h3>

                                    {{-- Pizza Selection Display --}}
                                    <div id="pizza-selection-display" class="mb-4">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                                            No pizza selected
                                        </div>
                                    </div>

                                    {{-- Your Toppings Section --}}
                                    <div class="mb-6">
                                        <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Your Toppings</h4>
                                        <div id="selected-toppings" class="space-y-2">
                                            <div class="text-sm text-gray-500 dark:text-gray-400 italic">
                                                No toppings selected
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Price Summary --}}
                                    <div class="border-t border-gray-300 dark:border-gray-600 pt-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm">Pizza:</span>
                                            <span class="text-sm" id="pizza-price">RM 0.00</span>
                                        </div>
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm">Toppings:</span>
                                            <span class="text-sm" id="toppings-price">RM 0.00</span>
                                        </div>
                                        <div class="flex justify-between items-center font-semibold text-lg border-t border-gray-300 dark:border-gray-600 pt-2">
                                            <span>Total:</span>
                                            <span id="total-price">RM 0.00</span>
                                        </div>
                                    </div>

                                    {{-- Add to Cart Button --}}
                                    <button id="add-to-cart-btn" type="submit" class="w-full mt-6 bg-gray-400 text-white py-3 px-4 rounded-lg font-medium cursor-not-allowed transition-colors" disabled>
                                        Select Pizza First
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // 1. Set 'selectedPizza' to null initially (no pizza chosen yet)
        let selectedPizza = null;
        // 2. Set selectedToppings to an empty array (no toppings selected yet)
        let selectedToppings = [];
        // 3. Create a variable to hold the pizza's price
        let pizzaPrice = 0;
        // 4. Create a variable to hold the total price of all selected toppings
        let toppingsPrice = 0;

        document.addEventListener('DOMContentLoaded', function() {
            //    Handle pizza selection
            //    ----------------------
            // 5. Once the DOM is fully loaded, look for all radio buttons
            //    with the name "pizza-selection"
            document.querySelectorAll('input[name="pizza-selection"]').forEach(radio => {
                // 6. For each of those radio buttons, add a 'change' event listener
                radio.addEventListener('change', function() {
                    // 7. When a radio button is selected (checked)
                    if (this.checked) {
                        // 8. Construct a 'selectedPizza' object that captures:
                        //    a. The pizza size from data-size attribute
                        //    b. The pizza crust from data-crust attribute
                        //    c. The size_id and crust_id by splitting the value (e.g. "1-2")
                        //    d. The total calculated price (as float) from data-price attribute
                        selectedPizza = {
                            size: this.dataset.size,
                            crust: this.dataset.crust,
                            size_id: this.value.split('-')[0],
                            crust_id: this.value.split('-')[1],
                            price: parseFloat(this.dataset.price),
                            add_on: parseFloat(this.dataset.addon),
                        };
                        // 9. Update the global pizzaPrice variable to match the chosen pizza's price
                        pizzaPrice = selectedPizza.price;

                        // 10. Call a function to update the UI showing the selected pizza info
                        updatePizzaDisplay();
                        // 11. Enable the topping checkboxes now that a pizza is selected
                        enableToppings();
                        // 12. Update the UI to reflect the new total price (pizza + toppings)
                        updatePriceDisplay();
                        // 13. Enable or update the "Add to Cart" button based on current state
                        updateAddToCartButton();
                    }
                });
            });

            // Handle toppings selection
            // 1. Once the DOM is ready, find all checkboxes with the name "toppings[]"
            document.querySelectorAll('input[name="toppings[]"]').forEach(checkbox => {
                // 2. For each topping checkbox, listen for when it gets checked or unchecked
                checkbox.addEventListener('change', function() {
                    // 3. Extract the topping name from the checkbox's data-name attribute
                    const toppingName = this.dataset.name;
                    // 4. Extract the topping price from the checkbox's data-price attribute (convert to float)
                    const toppingPrice = parseFloat(this.dataset.price);

                    // 5. If this checkbox is checked (topping selected)
                    if (this.checked) {
                        // 6. Push a new topping object with name and price into the selectedToppings array
                        selectedToppings.push({
                            name: toppingName,
                            price: toppingPrice
                        });
                    } else {
                        // 7. If unchecked, remove that topping from selectedToppings using its name as identifier
                        //  > Use the `filter()` method to remove the topping that was just unchecked.
                        //    ----------------------------------------------------------
                        //    selectedToppings is an array that holds all toppings the user has selected so far.
                        //    Each item in the array is an object with this structure:
                        //        { name: "Cheese", price: 2.00 }
                        //
                        //    The goal now is to __*remove*__ the topping that the user just unchecked.
                        //
                        //    The `filter()` method loops through every topping (`t`) in the array and *keeps*
                        //    only the ones where `t.name !== toppingName` — meaning:
                        //    "Keep all toppings EXCEPT the one that matches the name of  the topping just unchecked."
                        //    i.e.: if the currently looped 't' (topping) isn't the same as the  "toppingName"  that's
                        //    supposed to be unchecked, keep it. Otherwise, you've found it, so no keep it / tossed it.
                        //
                        //    So if the toppingName is "Cheese", this line will rebuild the array and exclude Cheese.
                        //    The result is a new array that no longer includes the unchecked topping, and we assign
                        //    that new array back to selectedToppings.
                        selectedToppings = selectedToppings.filter(t => t.name !== toppingName);
                    }

                    // 8. Update the UI to show selected toppings visually
                    updateToppingsDisplay();
                    // 9. Update the total price to include or exclude this topping
                    updatePriceDisplay();
                    // 10. Update the state of the "Add to Cart" button (enable/disable or price update)
                    updateAddToCartButton();
                });
            });

            // 1. Listen for any changes in the "Quantity" input field
            document.getElementById('quantity').addEventListener('input', function () {
                // 2. When the user changes the quantity (e.g. from 1 to 2),
                //    recalculate the total price based on the new quantity.
                updatePriceDisplay();
                // 3. Update the state of the "Add to Cart" button (price update)
                updateAddToCartButton(); // Optional: to update the button label
            });


            // Add to cart functionality
            // 1. Add an event listener to the "Add to Cart" button
            document.getElementById('add-to-cart-btn').addEventListener('click', function() {
                // 2. Only proceed if a pizza has been selected
                if (selectedPizza) {
                    // 3. Calculate the total price by combining base pizza price and toppings
                    const totalPrice = pizzaPrice + toppingsPrice;
                    // alert(`Added to cart!\n\nPizza: ${selectedPizza.size} ${selectedPizza.crust}\nToppings: ${selectedToppings.length > 0 ? selectedToppings.map(t => t.name).join(', ') : 'None'}\nTotal: RM ${totalPrice.toFixed(2)}`);

                    // Here you can add AJAX call to actually add to cart
                    // fetch('/add-to-cart', { ... })
                }
            });
        });

        function updatePizzaDisplay() {
            const display = document.getElementById('pizza-selection-display');
            if (selectedPizza) {
                display.innerHTML = `
                    <div class="text-sm">
                        <div class="font-medium">${selectedPizza.size.charAt(0).toUpperCase() + selectedPizza.size.slice(1)} ${selectedPizza.crust}</div>
                        <div class="text-gray-500 dark:text-gray-400">{{ $pizza->product->name }}</div>
                    </div>
                `;
            }
        }

        function enableToppings() {
            const toppingsSection = document.getElementById('toppings-section');
            const disabledMessage = document.getElementById('disabled-message');

            toppingsSection.classList.remove('opacity-50', 'pointer-events-none');
            disabledMessage.style.display = 'none';
        }

        function updateToppingsDisplay() {
            const toppingsContainer = document.getElementById('selected-toppings');

            if (selectedToppings.length === 0) {
                toppingsContainer.innerHTML = '<div class="text-sm text-gray-500 dark:text-gray-400 italic">No toppings selected</div>';
            } else {
                toppingsContainer.innerHTML = selectedToppings.map(topping =>
                    `<div class="flex justify-between items-center text-sm">
                        <span>${topping.name}</span>
                        <span>+RM ${topping.price.toFixed(2)}</span>
                    </div>`
                ).join('');
            }
        }

        function updatePriceDisplay() {
            toppingsPrice = selectedToppings.reduce((sum, topping) => sum + topping.price, 0);
            const quantity = parseInt(document.getElementById('quantity').value) || 1;
            const totalPrice = (pizzaPrice + toppingsPrice) * quantity;

            document.getElementById('pizza-price').textContent = `RM ${(pizzaPrice * quantity).toFixed(2)}`;
            document.getElementById('toppings-price').textContent = `RM ${(toppingsPrice * quantity).toFixed(2)}`;
            document.getElementById('total-price').textContent = `RM ${totalPrice.toFixed(2)}`;
        }


        function updateAddToCartButton() {
            const button = document.getElementById('add-to-cart-btn');

            if (selectedPizza) {
                const quantity = parseInt(document.getElementById('quantity').value) || 1;
                const totalPrice = (pizzaPrice + toppingsPrice) * quantity;
                button.disabled = false;
                button.classList.remove('bg-gray-400', 'cursor-not-allowed');
                button.classList.add('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
                button.textContent = `Add to Cart - RM ${totalPrice.toFixed(2)}`;
                document.getElementById('selected_quantity').value = document.getElementById('quantity').value;
                document.getElementById('selected_size_id').value = selectedPizza.size_id;
                document.getElementById('selected_crust_id').value = selectedPizza.crust_id;
                document.getElementById('selected_price').value = selectedPizza.price;
                document.getElementById('selected_addon').value = selectedPizza.add_on;
                document.getElementById('selected_unit_price').value = (pizzaPrice + toppingsPrice).toFixed(2);
                document.getElementById('selected_total_price').value = totalPrice.toFixed(2);
                document.getElementById('selected_toppings_json').value = JSON.stringify(selectedToppings);
            } else {
                button.disabled = true;
                button.classList.add('bg-gray-400', 'cursor-not-allowed');
                button.classList.remove('bg-blue-600', 'hover:bg-blue-700', 'cursor-pointer');
                button.textContent = 'Select Pizza First';
            }
        }
    </script>
</x-app-layout>
