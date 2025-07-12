@extends('layouts.app')

@section('content')
    <div>
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Available Vouchers</h1>
            <x-button-primary>
                <a href="{{ route('products.index') }}" class="flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 17l-5-5m0 0l5-5m-5 5h12"/>
                    </svg>
                    Back to Shopping
                </a>
            </x-button-primary>
        </div>

        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($availableVouchers as $voucher)
                <div class="flex">
                    <div class="voucher-container">
                        <!-- Left section with jagged edge -->
                        <div
                            class="bg-primary rounded-t-lg md:rounded-t-none md:rounded-l-lg p-6 text-white flex flex-col justify-center items-center relative voucher-left">
                            <div class="text-3xl font-bold">
                                {{ $voucher->discount_type === 'percentage' ? $voucher->discount_value . '%' : 'Rp ' . number_format($voucher->discount_value, 0, ',', '.') }}
                            </div>
                            <div class="text-sm">OFF</div>
                        </div>

                        <!-- Middle content section -->
                        <div
                            class="bg-base-100 border-x md:border-y md:border-l md:border-r-0 border-base-300 p-6 flex-grow voucher-middle">
                            <div>
                                <h2 class="text-xl font-bold">{{ $voucher->code }}</h2>
                                <p class="text-sm text-gray-500">{{ $voucher->description }}</p>
                            </div>

                            <div class="mt-4 space-y-2">
                                <div class="text-sm">
                                    <span class="text-gray-500">Valid until:</span>
                                    {{ $voucher->end_date->format('d M Y') }}
                                </div>
                                <div class="text-sm">
                                    <span class="text-gray-500">Remaining:</span>
                                    {{ $voucher->max_usage - $voucher->current_usage }} left
                                </div>
                            </div>
                        </div>

                        <!-- Right action section -->
                        <div
                            class="bg-base-100 border border-base-300 rounded-b-lg md:rounded-b-none md:rounded-r-lg p-4 flex items-center justify-center voucher-right">
                            <form action="{{ route('vouchers.customer.claim', $voucher) }}" method="POST">
                                @csrf
                                @if($voucher->current_usage >= $voucher->max_usage)
                                    <button type="button" class="btn btn-disabled w-full" disabled>
                                        Expired
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-primary w-full">
                                        Claim Now
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($myVouchers->isNotEmpty())
            <h2 class="text-2xl font-bold mt-12 mb-6">My Vouchers</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                @foreach($myVouchers as $userVoucher)
                    <div class="flex">
                        <div class="voucher-container">
                            <!-- Left section with jagged edge -->
                            <div
                                class="bg-primary {{ $userVoucher->is_used ? 'error' : ($userVoucher->voucher->userVouchers()->where('is_used', true)->count() >= $userVoucher->voucher->max_usage ? 'warning' : 'secondary') }} rounded-t-lg md:rounded-t-none md:rounded-l-lg p-6 text-white flex flex-col justify-center items-center relative voucher-left">
                                <div class="text-3xl font-bold">
                                    {{ $userVoucher->voucher->discount_type === 'percentage' ? $userVoucher->voucher->discount_value . '%' : 'Rp ' . number_format($userVoucher->voucher->discount_value, 0, ',', '.') }}
                                </div>
                                <div class="text-sm">OFF</div>
                            </div>

                            <!-- Middle content section -->
                            <div
                                class="bg-base-100 border-x md:border-y md:border-l md:border-r-0 border-base-300 p-6 flex-grow voucher-middle">
                                <div>
                                    <h2 class="text-xl font-bold">{{ $userVoucher->voucher->code }}</h2>
                                    <p class="text-sm text-gray-500">{{ $userVoucher->voucher->description }}</p>
                                </div>

                                <div class="mt-4 space-y-2">
                                    <div class="text-sm">
                                        <span class="text-gray-500">Valid until:</span>
                                        {{ $userVoucher->voucher->end_date->format('d M Y') }}
                                    </div>
                                    <div class="text-sm">
                                        <span class="text-gray-500">Status:</span>
                                        @if($userVoucher->is_used)
                                            <span class="text-error">Used</span>
                                        @elseif($userVoucher->voucher->userVouchers()->where('is_used', true)->count() >= $userVoucher->voucher->max_usage)
                                            <span class="text-warning">Not Available</span>
                                        @else
                                            <span class="text-success">Available</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Right status section -->
                            <div
                                class="bg-base-100 border border-base-300 rounded-b-lg md:rounded-b-none md:rounded-r-lg p-4 flex items-center justify-center voucher-right">
                                <div class="text-center">
                                    @if($userVoucher->is_used)
                                        <div class="badge badge-error p-3">USED</div>
                                    @elseif($userVoucher->voucher->userVouchers()->where('is_used', true)->count() >= $userVoucher->voucher->max_usage)
                                        <div class="badge badge-warning p-3">EXPIRED</div>
                                    @else
                                        <div class="badge badge-success p-3">ACTIVE</div>
                                        <!-- Add "Apply in Cart" button for active vouchers -->
                                        <a href="{{ route('cart.index') }}" class="btn btn-sm btn-primary mt-2 w-full">
                                            Apply in Cart
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="card bg-base-100 shadow-xl text-center py-12 px-6 mt-8">
                <figure class="mx-auto mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                              d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </figure>
                <div class="card-body">
                    <h2 class="card-title text-xl justify-center">You have no vouchers yet</h2>
                    <p class="text-gray-500 mb-4">Claim available vouchers to get discounts on your purchases.</p>
                </div>
            </div>
        @endif
    </div>

    <style>
        .voucher-container {
            display: flex;
            width: 100%;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 1rem;
            flex-direction: column;
        }

        .voucher-left {
            width: 100%;
            position: relative;
        }

        .voucher-left::after {
            content: "";
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 10px;
            background-image: radial-gradient(circle at 6px 0, transparent 6px, currentColor 7px, transparent 8px);
            background-size: 12px 12px;
            background-position: center -4px;
            background-repeat: repeat-x;
            filter: drop-shadow(0 2px 2px rgba(0, 0, 0, 0.15));
            z-index: 10;
            color: white;
        }

        .voucher-middle {
            flex: 1;
        }

        .voucher-right {
            width: 100%;
        }

        @media (min-width: 768px) {
            .voucher-container {
                flex-direction: row;
            }

            .voucher-left {
                width: 120px;
                min-width: 120px;
            }

            .voucher-left::after {
                bottom: auto;
                right: 0;
                top: 0;
                bottom: 0;
                left: auto;
                width: 10px;
                height: auto;
                background-image: radial-gradient(circle at 0 6px, transparent 6px, currentColor 7px, transparent 8px);
                background-size: 12px 12px;
                background-position: -4px center;
                background-repeat: repeat-y;
            }

            .voucher-right {
                width: 150px;
                min-width: 150px;
            }
        }
    </style>

    <script>
        function incrementQuantity(id) {
            const input = document.getElementById(id);
            const currentValue = parseInt(input.value);
            if (currentValue < parseInt(input.max)) {
                input.value = currentValue + 1;
                input.form.submit();
            }
        }

        function decrementQuantity(id) {
            const input = document.getElementById(id);
            const currentValue = parseInt(input.value);
            if (currentValue > parseInt(input.min)) {
                input.value = currentValue - 1;
                input.form.submit();
            }
        }
    </script>
@endsection
