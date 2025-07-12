<footer class="bg-white text-black py-12 border-t border-gray-100">
    <div class="container mx-auto px-4 2xl:px-0 max-w-7xl">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-x-8 gap-y-10">
            <!-- Contact Us Now -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg">Contact Us Now</h3>
                <a href="https://wa.me/6281217905995" target="_blank"
                   class="flex items-center space-x-2 text-gray-700 hover:text-black transition">
                    <span>+62 812-1790-5995</span>
                </a>
                <p class="text-gray-700">Scan QR code to connect with us</p>
                <div class="flex flex-col space-y-3">
                    <div class="w-32 h-32 bg-white p-1 rounded-md shadow-sm">
                        <img src="{{ asset('qrc.png') }}" alt="QR Code" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <!-- Exclusive -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg">Exclusive</h3>
                <p class="font-semibold">Subscribe</p>
                <p class="text-gray-700">Get 10% off your first order</p>
                <div class="flex items-center border border-gray-300 rounded-md px-3 py-2 bg-white">
                    <input type="email" placeholder="Enter your email"
                           class="bg-transparent text-black outline-none w-full placeholder-gray-500"/>
                    <button class="ml-2 hover:text-gray-700 transition">
                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Support -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg">Support</h3>
                <p class="text-gray-700">Kp. Babakan Peundeuy 01/02 Bojongkokosan,<br/>Kec. Parungkuda,<br/>Sukabumi
                    Jawa Barat, 43357</p>
                <p class="text-gray-700">yulvacinta15@gmail.com</p>
            </div>

            <!-- Account -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg">Account</h3>
                <ul class="space-y-3 text-gray-700">
                    <li><a href="{{ route('profile.edit') }}" class="hover:text-black transition">My Account</a></li>
                    <li>
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                        class="hover:text-black transition bg-transparent p-0 border-0 text-gray-700">
                                    Logout
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-black transition">Login</a> /
                            <a href="{{ route('register') }}" class="hover:text-black transition">Register</a>
                        @endauth
                    </li>
                    <li><a href="{{ route('cart.index') }}" class="hover:text-black transition">Cart</a></li>
                    <li><a href="{{ route('vouchers.customer.index') }}"
                           class="hover:text-black transition">Voucher</a></li>
                </ul>
            </div>

            <!-- Quick Link -->
            <div class="space-y-4">
                <h3 class="font-bold text-lg">Quick Link</h3>
                <ul class="space-y-3 text-gray-700">
                    <li><a href="#" class="hover:text-black transition">Privacy Policy</a></li>
                    <li><a href="#" class="hover:text-black transition">Terms Of Use</a></li>
                    <li><a href="#" class="hover:text-black transition">FAQ</a></li>
                    <li><a href="#" class="hover:text-black transition">Contact</a></li>
                </ul>
            </div>
        </div>

    </div>
</footer>
<div class="text-center text-black text-sm py-5 border-t border-gray-100 bg-white">
    © Copyright Dapur ABC 2025. All rights reserved
</div>
