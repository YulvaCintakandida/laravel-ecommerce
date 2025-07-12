{{-- resources/views/cart/index.blade.php --}}
@extends('layouts.app')

@section('content')
    <div x-data="cartPage">
        <section class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <x-breadcrumb :items="[
                                                                [
                                                                    'title' => 'Products',
                                                                    'url' => route('products.index'),
                                                                    'icon' => 'heroicon-o-shopping-bag'
                                                                ],
                                                                [
                                                                    'title' => 'Shopping Cart',
                                                                    'current' => true,
                                                                    'icon' => 'heroicon-o-shopping-cart'
                                                                ]
                                                            ]"/>
            <a href="{{ route('products.index') }}" class="btn btn-outline btn-sm gap-2">
                <x-icon name="heroicon-o-arrow-left" class="h-5 w-5"/>
                Continue Shopping
            </a>
        </section>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                @include('cart.partials.cart-items')

                <!-- Order Summary -->
                @include('cart.partials.order-summary', ['cartItems' => $cartItems])
            </div>
        @else
            <x-card class="text-center py-12">
                <figure class="mx-auto mb-4">
                    <x-icon name="heroicon-o-shopping-cart" class="h-24 w-24 text-gray-400"/>
                </figure>
                <div class="card-body">
                    <h2 class="card-title text-xl justify-center">Your cart is empty</h2>
                    <p class="text-gray-500 mb-4">Looks like you haven't added any products to your cart yet.</p>
                    <div class="card-actions justify-center">
                        <x-button-primary href="{{ route('products.index') }}" class="btn-lg">
                            Start Shopping
                        </x-button-primary>
                    </div>
                </div>
            </x-card>
        @endif
    </div>
@endsection
