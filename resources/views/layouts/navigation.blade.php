<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    {{--Primary Navigation Menu--}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> {{--  remember to add in: max-w-7xl  --}}
        <div class="flex justify-between h-16">
            <div class="flex">
                {{--Logo--}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}">
                        {{--<x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />--}}
                        <x-pizza-logo class="h-12 w-12"/>
                    </a>
                </div>

                {{--Navigation Links--}}
                <div class="hidden sm:flex sm:-my-px sm:ms-10 overflow-x-auto sm:max-w-64 md:max-w-xs lg:max-w-lg xl:max-w-3xl whitespace-nowrap space-x-8 scrollbar-hidden"> {{-- hidden space-x-8 sm:-my-px sm:ms-10 sm:flex --}}
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    <x-nav-link :href="route('admin.products.index')">
                        {{ __('Admin') }}
                    </x-nav-link>
                    <x-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                        {{ __('Cart') }}
                    </x-nav-link>
                    {{--
                    <x-nav-link :href="route('pizzas.index')" :active="request()->routeIs('pizzas.*')">
                        {{ __('Pizzas') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pizzaSizes.index')" :active="request()->routeIs('pizzaSizes.index')">
                        {{ __('Pizza Sizes') }}
                    </x-nav-link>
                    <x-nav-link :href="route('crusts.index')" :active="request()->routeIs('crusts.index')">
                        {{ __('Crusts') }}
                    </x-nav-link>
                    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                        {{ __('Products') }}
                    </x-nav-link>
                    <x-nav-link :href="route('toppings.index')" :active="request()->routeIs('toppings.index')">
                        {{ __('Toppings') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pizzaSizePrices.index')" :active="request()->routeIs('pizzaSizePrices.index')">
                        {{ __('Pizza Size Prices') }}
                    </x-nav-link>
                    <x-nav-link :href="route('crustPriceAdditions.index')" :active="request()->routeIs('crustPriceAdditions.index')">
                        {{ __('Crust Price Additions') }}
                    </x-nav-link>
                    --}}
                    <x-nav-link :href="route('orders.create')" :active="request()->routeIs('orders.create')">
                        {{ __('Menu') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                        {{ __('Orders') }}
                    </x-nav-link>
                    <x-nav-link :href="route('orderItems.index')" :active="request()->routeIs('orderItems.index')">
                        {{ __('Order Items') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pizzaOrderItemDetails.index')" :active="request()->routeIs('pizzaOrderItemDetails.index')">
                        {{ __('Pizza Order Item Details') }}
                    </x-nav-link>
                    <x-nav-link :href="route('pizzaOrderItemToppings.index')" :active="request()->routeIs('pizzaOrderItemToppings.index')">
                        {{ __('Pizza Order Item Toppings') }}
                    </x-nav-link>
                    {{--Guest navigation links - only show for anonymous users--}}
                    @guest
                        {{--You can add additional guest navigation links here if needed--}}
                        {{--Example: About, Services, Contact, etc.--}}
                    @endguest
                </div>
            </div>

            {{--Right side navigation: Authentication dependent--}}
            @auth
            {{--Settings Dropdown for authenticated users--}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                {{--<a class="mr-4 inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-150"
                   href="{{ route('cart.index') }}">{{ __('Cart') }}
                </a>--}}
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-block me-5 px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-150">
                        Clear Cart
                    </button>
                </form>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
            @else
            <!-- Guest authentication links: show Login and Register for anonymous users -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                {{--<a class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-150"
                   href="{{ route('cart.index') }}">{{ __('Cart') }}
                </a>--}}

                <!-- Login Link -->
                <a
                    href="{{ route('login') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal transition-colors duration-150"
                >
                    {{ __('Log in') }}
                </a>

                <!-- Register Link -->
                <a
                    href="{{ route('register') }}"
                    class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-150"
                >
                    {{ __('Register') }}
                </a>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal transition-colors duration-150">
                        Clear Cart
                    </button>
                </form>
            </div>
            @endauth

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{--Responsive Navigation Menu--}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.products.index')">
                {{ __('Admin') }}
            </x-responsive-nav-link>
            {{--
            <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.*')">
                {{ __('Cart') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pizzas.index')" :active="request()->routeIs('pizzas.*')">
                {{ __('Pizzas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pizzaSizes.index')" :active="request()->routeIs('pizzaSizes.index')">
                {{ __('Pizza Sizes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('crusts.index')" :active="request()->routeIs('crusts.index')">
                {{ __('Crusts') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
                {{ __('Products') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('toppings.index')" :active="request()->routeIs('toppings.index')">
                {{ __('Toppings') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pizzaSizePrices.index')" :active="request()->routeIs('pizzaSizePrices.index')">
                {{ __('Pizza Size Prices') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('crustPriceAdditions.index')" :active="request()->routeIs('crustPriceAdditions.index')">
                {{ __('Crust Price Additions') }}
            </x-responsive-nav-link>
            --}}
            <x-responsive-nav-link :href="route('orders.create')" :active="request()->routeIs('orders.create')">
                {{ __('Menu') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                {{ __('Orders') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('orderItems.index')" :active="request()->routeIs('orderItems.index')">
                {{ __('Order Items') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pizzaOrderItemDetails.index')" :active="request()->routeIs('pizzaOrderItemDetails.index')">
                {{ __('Pizza Order Item Details') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('pizzaOrderItemToppings.index')" :active="request()->routeIs('pizzaOrderItemToppings.index')">
                {{ __('Pizza Order Item Toppings') }}
            </x-responsive-nav-link>

            <!-- Additional guest navigation links can be added here for mobile -->
            @guest
                <!-- Example: You can add other public pages here if needed -->
            @endguest

        </div>
        @auth
        <!-- Responsive Settings Options for authenticated users -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <!-- Mobile authentication links for guest users -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">Guest</div>
                <div class="font-medium text-sm text-gray-500">Welcome to the Pizza Shop</div>
            </div>
            <div class="mt-3 space-y-1">
                <!-- Mobile Login Link -->
                <a
                    href="{{ route('login') }}"
                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                >
                    {{ __('Log in') }}
                </a>

                <!-- Mobile Register Link -->
                <a
                    href="{{ route('register') }}"
                    class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                >
                    {{ __('Register') }}
                </a>
            </div>
        </div>
        @endauth
    </div>
</nav>
