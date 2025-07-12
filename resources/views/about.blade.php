@extends('layouts.app')

@section('content')
    <div class="py-8">
        <section class="flex flex-col md:flex-row justify-between items-center gap-12 bg-base-100">
            <!-- Left side - Our Story -->
            <div class="flex-1 space-y-4">
                <h2 class="text-6xl font-normal text-primary mb-6">Our Story</h2>
                <p class="text-gray-700">
                    Dapur ABC started its journey with passion and commitment to bring authentic flavors to your table.
                    Our launch was a celebration of culinary excellence and innovation, bringing together food
                    enthusiasts
                    who share our vision of quality ingredients and exceptional taste experiences.
                </p>
                <p class="text-gray-700">
                    Our mission is to create a community of food lovers who appreciate the art of cooking and the joy
                    of sharing meals. We believe that every dish tells a story, and we are here to help you write
                    yours.
                </p>
            </div>

            <!-- Right side - Featured Product Image -->
            <div class="flex-1 md:flex-[1.5]">
                <img
                    src="{{ asset('about.jpg') }}"
                    alt="Featured Product"
                    class="rounded-lg w-full h-auto object-cover shadow-lg max-h-[500px]"
                >
            </div>
        </section>

        {{--        <section class="py-16">--}}
        {{--            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">--}}
        {{--                <!-- Card 1 -->--}}
        {{--                <div--}}
        {{--                    class="card bg-base-100 shadow-lg hover:shadow-xl transition-all border border-base-300 p-6 text-center">--}}
        {{--                    <div class="flex justify-center mb-4">--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary" fill="none"--}}
        {{--                             viewBox="0 0 24 24" stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"--}}
        {{--                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>--}}
        {{--                        </svg>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-4xl font-bold mb-2">5000+</div>--}}
        {{--                    <p class="text-gray-600">Customers Served</p>--}}
        {{--                </div>--}}

        {{--                <!-- Card 2 (with primary background) -->--}}
        {{--                <div--}}
        {{--                    class="card bg-primary text-primary-content shadow-lg hover:shadow-xl transition-all p-6 text-center">--}}
        {{--                    <div class="flex justify-center mb-4">--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16" fill="none" viewBox="0 0 24 24"--}}
        {{--                             stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"--}}
        {{--                                  d="M13 10V3L4 14h7v7l9-11h-7z"/>--}}
        {{--                        </svg>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-4xl font-bold mb-2">50+</div>--}}
        {{--                    <p>Premium Products</p>--}}
        {{--                </div>--}}

        {{--                <!-- Card 3 -->--}}
        {{--                <div--}}
        {{--                    class="card bg-base-100 shadow-lg hover:shadow-xl transition-all border border-base-300 p-6 text-center">--}}
        {{--                    <div class="flex justify-center mb-4">--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary" fill="none"--}}
        {{--                             viewBox="0 0 24 24" stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"--}}
        {{--                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>--}}
        {{--                        </svg>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-4xl font-bold mb-2">10+</div>--}}
        {{--                    <p class="text-gray-600">Years of Experience</p>--}}
        {{--                </div>--}}

        {{--                <!-- Card 4 -->--}}
        {{--                <div--}}
        {{--                    class="card bg-base-100 shadow-lg hover:shadow-xl transition-all border border-base-300 p-6 text-center">--}}
        {{--                    <div class="flex justify-center mb-4">--}}
        {{--                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-primary" fill="none"--}}
        {{--                             viewBox="0 0 24 24" stroke="currentColor">--}}
        {{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"--}}
        {{--                                  d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>--}}
        {{--                        </svg>--}}
        {{--                    </div>--}}
        {{--                    <div class="text-4xl font-bold mb-2">25+</div>--}}
        {{--                    <p class="text-gray-600">Partner Locations</p>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </section>--}}

        {{--        <section class="py-16">--}}
        {{--            <h2 class="text-4xl font-bold text-primary text-center mb-10">Our Team</h2>--}}

        {{--            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl">--}}
        {{--                <!-- Team Member 1 -->--}}
        {{--                <div>--}}
        {{--                    <figure class="pt-4">--}}
        {{--                        <img src="https://placehold.co/300x300" alt="Team Member"--}}
        {{--                             class="rounded-xl object-cover h-64 w-full"/>--}}
        {{--                    </figure>--}}
        {{--                    <div class="card-body items-center text-center">--}}
        {{--                        <h3 class="card-title text-xl font-bold">Jane Doe</h3>--}}
        {{--                        <p class="text-gray-600">Founder & CEO</p>--}}
        {{--                        <div class="flex space-x-4 mt-2">--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}

        {{--                <!-- Team Member 2 -->--}}
        {{--                <div>--}}
        {{--                    <figure class="pt-4">--}}
        {{--                        <img src="https://placehold.co/300x300" alt="Team Member"--}}
        {{--                             class="rounded-xl object-cover h-64 w-full"/>--}}
        {{--                    </figure>--}}
        {{--                    <div class="card-body items-center text-center">--}}
        {{--                        <h3 class="card-title text-xl font-bold">John Smith</h3>--}}
        {{--                        <p class="text-gray-600">Head Chef</p>--}}
        {{--                        <div class="flex space-x-4 mt-2">--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}

        {{--                <!-- Team Member 3 -->--}}
        {{--                <div>--}}
        {{--                    <figure class=" pt-4">--}}
        {{--                        <img src="https://placehold.co/300x300" alt="Team Member"--}}
        {{--                             class="rounded-xl object-cover h-64 w-full"/>--}}
        {{--                    </figure>--}}
        {{--                    <div class="card-body items-center text-center">--}}
        {{--                        <h3 class="card-title text-xl font-bold">Sarah Lee</h3>--}}
        {{--                        <p class="text-gray-600">Marketing Director</p>--}}
        {{--                        <div class="flex space-x-4 mt-2">--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm-2 16h-2v-6h2v6zm-1-6.891c-.607 0-1.1-.496-1.1-1.109 0-.612.492-1.109 1.1-1.109s1.1.497 1.1 1.109c0 .613-.493 1.109-1.1 1.109zm8 6.891h-1.998v-2.861c0-1.881-2.002-1.722-2.002 0v2.861h-2v-6h2v1.093c.872-1.616 4-1.736 4 1.548v3.359z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                            <a href="#" class="text-gray-500 hover:text-primary">--}}
        {{--                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"--}}
        {{--                                     fill="currentColor" viewBox="0 0 24 24">--}}
        {{--                                    <path--}}
        {{--                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>--}}
        {{--                                </svg>--}}
        {{--                            </a>--}}
        {{--                        </div>--}}
        {{--                    </div>--}}
        {{--                </div>--}}
        {{--            </div>--}}
        {{--        </section>--}}

        <section class="py-16 bg-base-100">
            <h2 class="text-4xl font-bold text-primary text-center mb-12">Why Choose Us</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
                <!-- Diverse Menu -->
                <div class="flex flex-col items-center text-center p-6 hover:shadow-lg transition-all rounded-lg">
                    <div class="bg-primary/10 p-4 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M21 15.9A11.971 11.971 0 0012 4.99a11.971 11.971 0 00-9 10.91A9.966 9.966 0 0112 21.99a9.966 9.966 0 019-6.09zm-9 1.91c2.209 0 4-1.79 4-4s-1.791-4-4-4-4 1.79-4 4 1.791 4 4 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Menu Beragam</h3>
                    <p class="text-gray-600">Menyajikan berbagai pilihan hidangan lokal dan internasional</p>
                </div>

                <!-- Customer Support -->
                <div class="flex flex-col items-center text-center p-6 hover:shadow-lg transition-all rounded-lg">
                    <div class="bg-primary/10 p-4 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Customer Service 24/7</h3>
                    <p class="text-gray-600">Hubungi kami melalui email atau chat WhatsApp</p>
                </div>

                <!-- Secure Transactions (replacing Money Back) -->
                <div class="flex flex-col items-center text-center p-6 hover:shadow-lg transition-all rounded-lg">
                    <div class="bg-primary/10 p-4 rounded-full mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-primary" fill="none"
                             viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                  d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Transaksi Aman</h3>
                    <p class="text-gray-600">Pembayaran aman dan terjamin melalui berbagai metode</p>
                </div>
            </div>
        </section>
    </div>
@endsection
