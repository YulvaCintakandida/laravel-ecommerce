<nav class="bg-white border-b border-gray-200">
    <div class="container mx-auto px-4 2xl:px-0 max-w-7xl">
        <div class="flex items-center justify-between h-24">
            <!-- Logo (Left) -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="text-primary font-bold text-2xl">Dapur ABC</a>
            </div>

            <!-- Center Navigation Items -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('home') }}"
                   class="text-black px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'underline underline-offset-8 decoration-primary' : '' }}">Home</a>
                <a href="{{ route('about') }}"
                   class="text-black px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('about') ? 'underline underline-offset-8 decoration-primary' : '' }}">About</a>
                <a href="{{ route('products.index') }}"
                   class="text-black px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('products.index') ? 'underline underline-offset-8 decoration-primary' : '' }}">Products</a>
                @auth
                    <a href="{{ route('vouchers.customer.index') }}"
                       class="text-black px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('vouchers.customer.index') ? 'underline underline-offset-8 decoration-primary' : '' }}">Vouchers</a>
                    <a href="{{ route('membership.index') }}"
                        class="text-black px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('membership.index') ? 'underline underline-offset-8 decoration-primary' : '' }}">
                        VIP Membership</a>
                @endauth
            </div>

            <!-- Right Side Items -->
            <div class="hidden md:flex items-center space-x-4">
                <!-- Search Bar -->
                <form action="{{ route('products.index') }}" method="GET" class="relative">
                    <input type="text"
                           placeholder="What are you looking for?"
                           class="input border-none w-58 bg-gray-200 text-black"
                           name="search"
                           value="{{ request('search') }}">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-2">
                        <x-icon name="heroicon-o-magnifying-glass" class="h-4 w-4 text-gray-400"/>
                    </button>
                </form>

                <a href="{{ route('cart.index') }}"
                   class="text-black flex items-center justify-center rounded-md text-sm font-medium relative">
                    <x-icon name="heroicon-o-shopping-cart" class="h-6 w-6"/>
                    @if(count(session()->get('cart', [])))
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                                                    {{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}
                                                                </span>
                    @endif
                </a>

                @auth
                    <x-dropdown align="right" width="10">
                        <x-slot name="trigger">
                            <button class="text-black p-2 rounded-md flex items-center justify-center cursor-pointer">
                                <x-icon name="heroicon-o-user-circle" class="h-6 w-6"/>
                            </button>
                        </x-slot>

                        <a href="{{ route('profile.edit') }}"
                           class="block px-4 py-2 text-sm text-black hover:bg-gray-100 flex items-center">
                            <x-icon name="heroicon-o-user" class="h-4 w-4 mr-2"/>
                            Profile
                        </a>
                        <a href="{{ route('orders.index') }}"
                           class="block px-4 py-2 text-sm text-black hover:bg-gray-100 flex items-center">
                            <x-icon name="heroicon-o-document-duplicate" class="h-4 w-4 mr-2"/>
                            My Orders
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full text-left block px-4 py-2 text-sm text-black hover:bg-gray-100 flex items-center">
                                <x-icon name="heroicon-o-arrow-right-on-rectangle" class="h-4 w-4 mr-2"/>
                                Logout
                            </button>
                        </form>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}"
                       class="text-black px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}"
                       class="text-black px-3 py-2 rounded-md text-sm font-medium">Register</a>
                @endauth
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button type="button"
                        class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-white focus:outline-none"
                        id="mobile-menu-button">
                    <span class="sr-only">Open main menu</span>
                    <!-- Menu icons -->
                    <x-icon name="heroicon-o-bars-3" id="menu-icon-open" class="block h-6 w-6"/>
                    <x-icon name="heroicon-o-x-mark" id="menu-icon-close" class="hidden h-6 w-6"/>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div class="hidden md:hidden" id="mobile-menu">
        <div class="pt-2 pb-3 space-y-1 container mx-auto px-4 sm:px-0">
            <a href="{{ route('home') }}"
               class="text-black block py-2 rounded-md text-base font-medium">Home</a>
            <a href="{{ route('about') }}"
               class="text-black block py-2 rounded-md text-base font-medium">About</a>
            <a href="{{ route('products.index') }}"
               class="text-black block py-2 rounded-md text-base font-medium">Products</a>

            @auth
                <a href="{{ route('orders.index') }}"
                   class="text-black block py-2 rounded-md text-base font-medium">My Orders</a>
            @endauth

            <a href="{{ route('cart.index') }}"
               class="text-black block py-2 rounded-md text-base font-medium flex items-center">
                <x-icon name="heroicon-o-shopping-cart" class="h-5 w-5 mr-2"/>
                Cart
                @if(count(session()->get('cart', [])))
                    <span
                        class="ml-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                                            {{ array_sum(array_column(session()->get('cart', []), 'quantity')) }}
                                                        </span>
                @endif
            </a>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="text-black block py-2 rounded-md text-base font-medium w-full text-left">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="text-black block py-2 rounded-md text-base font-medium">Login</a>
                <a href="{{ route('register') }}"
                   class="text-black block py-2 rounded-md text-base font-medium">Register</a>
            @endauth
        </div>
    </div>
</nav>
