<!-- resources/views/cart/partials/order-summary.blade.php -->
<div class="lg:col-span-1 space-y-6">
    <!-- Shipping Address Card -->
    <x-card>
        <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
            <x-icon name="heroicon-o-map-pin" class="h-5 w-5"/>
            Shipping Address
        </h2>

        <div class="space-y-2">
            <p class="font-medium">{{ Auth::user()->name }}</p>
            <p class="text-gray-600">{{ Auth::user()->phone }}</p>
            <p class="text-gray-600">{{ Auth::user()->address }}</p>
        </div>
    </x-card>

    <!-- Order Summary Card -->
    <x-card>
        <div>
            <div>
                <h2 class="text-lg font-bold mb-4 flex items-center gap-2">
                    <x-icon name="heroicon-o-document-text" class="h-5 w-5"/>
                    Order Summary
                </h2>

                <!-- Order Summary totals -->
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span>Rp {{ number_format($total, 2, ',', '.') }}</span>
                    </div>

                    @if(session('applied_voucher'))
                        <div class="flex justify-between text-success">
                            <span>Discount</span>
                            <span>-Rp {{ number_format(session('applied_voucher')['discount_amount'], 2, ',', '.') }}</span>
                        </div>
                    @endif

                    <div class="border-t border-gray-200 pt-3">
                        <div class="flex justify-between font-bold">
                            <span>Total</span>
                            <span>
                                                    Rp {{ number_format($total - (session('applied_voucher')['discount_amount'] ?? 0), 2, ',', '.') }}
                                                </span>
                        </div>
                    </div>
                </div>
            </div>

           <!-- Voucher Section -->
            <div class="border-gray-200 pt-4" x-data="{ showVoucherOptions: false }">
                <h3 class="font-medium mb-3">Apply Voucher</h3>

                {{-- Jika sudah ada voucher yang dipakai --}}
                @if(session('applied_voucher'))
                    <div class="flex justify-between items-center p-3 bg-success/10 border border-success/20 rounded-lg mb-4">
                        <div>
                            <span class="font-medium">{{ session('applied_voucher')['code'] }}</span>
                            <div class="text-sm text-success">
                                -Rp {{ number_format(session('applied_voucher')['discount_amount'], 2, ',', '.') }}
                            </div>
                        </div>

                        <form action="{{ route('cart.voucher.remove') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm text-error hover:bg-error/10" aria-label="Remove voucher">
                                X
                            </button>
                        </form>
                    </div>

                @else
                    @php
                        // Cek apakah user punya voucher yang belum dipakai
                        $hasVouchers = Auth::user()->vouchers()->wherePivot('is_used', false)->exists();
                    @endphp

                    @if($hasVouchers)
                        {{-- Tombol untuk tampilkan pilihan voucher --}}
                        <div x-show="!showVoucherOptions" class="mb-3">
                            <x-button-primary
                                type="button"
                                class="w-full btn-sm"
                                @click="showVoucherOptions = true"
                            >
                                <x-icon name="heroicon-o-tag" class="h-5 w-5 mr-1" />
                                Select Voucher
                            </x-button-primary>
                        </div>

                        {{-- Form pilihan voucher --}}
                        <div x-show="showVoucherOptions" class="rounded-lg border border-base-300 p-3 mb-3" x-cloak>
                            <form action="{{ route('cart.voucher.apply') }}" method="POST">
                                @csrf
                                <div class="flex justify-between mb-3">
                                    <x-label for="voucher_id" text="Available Vouchers" class="mb-0" />
                                    <button type="button"
                                            @click="showVoucherOptions = false"
                                            class="text-sm text-gray-500 cursor-pointer hover:text-gray-700"
                                            aria-label="Cancel voucher selection">
                                        Cancel
                                    </button>
                                </div>

                                <div class="space-y-2 mb-3 max-h-48 overflow-y-auto">
                                    @foreach(Auth::user()->vouchers()->wherePivot('is_used', false)->get() as $voucher)
                                        @php
                                            // Pastikan voucher belum dipakai melebihi max_usage
                                            $usedCount = $voucher->userVouchers()->where('is_used', true)->count();
                                        @endphp

                                        @if($usedCount < $voucher->max_usage)
                                            <label class="flex items-center gap-2 p-2 border rounded-lg hover:bg-base-200 cursor-pointer">
                                                <x-input type="radio" name="voucher_id" value="{{ $voucher->id }}" />
                                                <div class="flex-1">
                                                    <div class="font-medium line-clamp-1">{{ $voucher->code }}</div>
                                                    <div class="text-xs text-success">
                                                        @if($voucher->discount_type === 'percentage')
                                                            {{ $voucher->discount_value }}% off
                                                        @else
                                                            Rp {{ number_format($voucher->discount_value, 0, ',', '.') }} off
                                                        @endif
                                                    </div>
                                                </div>
                                            </label>
                                        @endif
                                    @endforeach
                                </div>

                                <x-button-primary type="submit" class="w-full btn-sm">
                                    Apply Voucher
                                </x-button-primary>
                            </form>
                        </div>

                    @else
                        <div class="text-sm text-gray-500 italic mb-3">
                            You don't have any available vouchers
                        </div>
                    @endif
                @endif
            </div>


            <!-- Checkout Button -->
            @php
                // Check if $cartItems is passed to this partial
                $hasOutOfStock = isset($cartItems) ? collect($cartItems)->contains(function ($item) {
                    return $item['current_stock'] <= 0 || $item['quantity'] > $item['current_stock'];
                }) : false;
            @endphp

            <a href="{{ route('checkout.index') }}">
                <x-button-primary
                    class="w-full gap-2 {{ $hasOutOfStock ? 'btn-disabled' : '' }}"
                >
                    Proceed to Checkout
                    <x-icon name="heroicon-o-arrow-right" class="h-5 w-5"/>
                </x-button-primary>
            </a>


            @if($hasOutOfStock)
                <div class="text-error text-sm text-center mt-2">
                    Remove out of stock items to proceed with checkout
                </div>
            @endif
        </div>
    </x-card>
</div>
