<div class="lg:col-span-2">
    <x-card class="overflow-x-auto">
        <div class="overflow-x-auto w-full">
            <table class="table table-zebra w-full">
                <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-end">Total</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($cartItems as $item)
                    <tr x-data="{
                                productId: {{ $item['product_id'] }},
                                quantity: {{ $item['quantity'] }},
                                price: {{ $item['price'] }},
                                maxStock: {{ $item['current_stock'] }},
                                outOfStock: {{ $item['current_stock'] <= 0 ? 'true' : 'false' }}
                            }">
                        <td class="flex items-center gap-3">
                            <img src="{{ $item['image'] ?? 'https://via.placeholder.com/80' }}"
                                 alt="{{ $item['name'] }}"
                                 class="w-16 h-16 object-cover rounded-lg">
                            <div>
                                <h3 class="font-medium">{{ $item['name'] }}</h3>
                                @if(isset($item['category']))
                                    <span class="text-xs text-gray-500">{{ $item['category'] }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="text-center">Rp {{ number_format($item['price'], 2, ',', '.') }}</td>
                        <td class="text-center">
                            <form x-ref="updateForm_{{ $item['product_id'] }}"
                                  action="{{ route('cart.update', $item['product_id']) }}" method="POST"
                                  class="flex justify-center">
                                @csrf
                                <div class="join">
                                    <template x-if="outOfStock">
                                        <div class="text-error font-medium">Out of Stock</div>
                                    </template>
                                    <template x-if="!outOfStock">
                                        <div class="join flex">
                                            <x-input
                                                x-ref="quantityInput_{{ $item['product_id'] }}"
                                                type="number"
                                                name="quantity"
                                                :value="$item['quantity']"
                                                min="1"
                                                :max="$item['current_stock']"
                                                class="w-14 text-center join-item input-sm"
                                                @change="updateQuantity($refs.updateForm_{{ $item['product_id'] }})"
                                            />
                                        </div>
                                    </template>
                                    @if($item['current_stock'] < $item['quantity'])
                                        <div class="text-error text-sm mt-1">
                                            Only {{ $item['current_stock'] }} items available
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </td>
                        <td class="text-end font-medium">
                            Rp {{ number_format($item['price'] * $item['quantity'], 2, ',', '.') }}
                        </td>
                        <td class="text-end">
                            <form action="{{ route('cart.remove', $item['product_id']) }}"
                                  method="POST">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-sm text-error">
                                    <x-icon name="heroicon-o-trash" class="h-5 w-5"/>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </x-card>
</div>
