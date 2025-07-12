@extends('layouts.app')

@section('content')
    <div>
        <div class="flex flex-col md:flex-row justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Checkout</h1>
            <div class="text-sm breadcrumbs">
                <ul>
                    <li><a href="{{ route('cart.index') }}">Cart</a></li>
                    <li>Checkout</li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="card bg-base-100 shadow-lg border border-base-300 mb-6">
                    <div class="card-body">
                        <h2 class="card-title flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                            </svg>
                            Order Summary
                        </h2>

                        <div class="overflow-x-auto">
                            <table class="table table-zebra w-full">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Total</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($validCartItems as $item)
                                <tr>
                                        <td class="flex items-center gap-3">
                                            @if(isset($item['image']))
                                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}"
                                                     class="w-12 h-12 object-cover rounded">
                                            @else
                                                <div
                                                    class="w-12 h-12 bg-base-300 rounded flex items-center justify-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-6 w-6 text-gray-500" fill="none" viewBox="0 0 24 24"
                                                         stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2"
                                                              d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="font-medium">{{ $item['name'] }}</div>
                                                @if(isset($item['category']))
                                                    <div class="text-xs text-gray-500">{{ $item['category'] }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">Rp {{ number_format($item['price'], 2, ',', '.') }}</td>
                                        <td class="text-center">{{ $item['quantity'] }}</td>
                                        <td class="text-right">
                                            Rp {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right font-bold">Subtotal:</td>
                                        <td class="text-right">Rp {{ number_format($subtotal, 2, ',', '.') }}</td>
                                    </tr>
                                    @if(session('applied_voucher'))
                                        <tr>
                                            <td colspan="3" class="text-right font-bold text-success">
                                                Discount ({{ session('applied_voucher')['code'] }}):
                                            </td>
                                            <td class="text-right text-success">
                                                -Rp {{ number_format($discountAmount, 2, ',', '.') }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td colspan="3" class="text-right text-lg font-bold">Total:</td>
                                        <td class="text-right text-lg font-bold text-primary">
                                            Rp {{ number_format($total, 2, ',', '.') }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <a href="{{ route('cart.index') }}" class="btn btn-outline btn-sm gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 19l-7-7 7-7"/>
                                </svg>
                                Return to Cart
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Form for checkout -->
                <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" class="hidden">
                    @csrf
                </form>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="card bg-base-100 shadow-lg border border-base-300 sticky top-8">
                    <div class="card-body">
                        <h2 class="card-title flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Payment Details
                        </h2>
                        <div class="divider my-1"></div>

                       <!-- Update Payment Details section -->
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 2, ',', '.') }}</span>
                            </div>
                            @if(session('applied_voucher'))
                                <div class="flex justify-between text-success">
                                    <span>Discount ({{ session('applied_voucher')['code'] }})</span>
                                    <span>-Rp {{ number_format($discountAmount, 2, ',', '.') }}</span>
                                </div>
                            @endif
                            <div class="divider my-1"></div>
                            <div class="flex justify-between font-bold">
                                <span>Total</span>
                                <span class="text-primary">Rp {{ number_format($total, 2, ',', '.') }}</span>
                            </div>
                        </div>

                                                <!-- Delivery Method Selection -->
                        <!-- <div class="card bg-base-100 shadow-lg border border-base-300 mb-6">
                            <div class="card-body">
                                <h2 class="card-title flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    Delivery Method
                                </h2>
                        
                                <div class="space-y-4">
                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-3">
                                            <input type="radio" name="delivery_method" value="pickup" class="radio radio-primary" checked/>
                                            <span class="label-text">Pickup at Store</span>
                                        </label>
                                    </div>
                        
                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-3">
                                            <input type="radio" name="delivery_method" value="delivery" class="radio radio-primary"/>
                                            <span class="label-text">Delivery to Address</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div> -->
            
                        <!-- <div class="mt-6">
                            <form action="{{ route('payment.process') }}" method="POST">
                                @csrf
                                <input type="hidden" name="delivery_method" id="selected_delivery_method" value="pickup">
                                <button type="submit" class="btn btn-primary btn-block gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                    </svg>
                                    Pay Now with Midtrans
                                </button>
                            </form>
                        </div> -->
                        <div class="mt-6">
                            <form action="{{ route('payment.process') }}" method="POST">
                                @csrf
                                <div class="space-y-4 mb-4">
                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-3">
                                            <input type="radio" name="delivery_method" value="pickup" class="radio radio-primary" checked/>
                                            <span class="label-text">Pickup at Store</span>
                                        </label>
                                    </div>
                                    
                                    <div class="form-control">
                                        <label class="label cursor-pointer justify-start gap-3">
                                            <input type="radio" name="delivery_method" value="delivery" class="radio radio-primary"/>
                                            <span class="label-text">Delivery to Address</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/>
                                    </svg>
                                    Pay Now with Midtrans
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
