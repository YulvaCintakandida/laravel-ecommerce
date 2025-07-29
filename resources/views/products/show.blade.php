@extends('layouts.app')

@section('content')
    <div>
        <!-- Breadcrumb navigation using component -->
        <div class="mb-6">
            <x-breadcrumb :items="[
                            ['title' => 'Products', 'url' => route('products.index'), 'icon' => 'heroicon-o-folder'],
                            ['title' => $product->name, 'current' => true, 'icon' => 'heroicon-o-document-plus'],
                        ]" class="mb-6"/>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Product Image Gallery -->
            <div class="space-y-4">
                <div class="card bg-base-100 shadow-lg border border-base-300 overflow-hidden relative">
                <img id="mainImage"
                    src="{{ $product->image ? Storage::url($product->image) : 'https://placehold.co/600x400' }}"
                    class="w-full h-96 object-cover object-center"
                    alt="{{ $product->name }}">
                    @if($product->current_stock <= 0)
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="text-white text-lg font-bold">Produk Habis</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Product Details -->
            <div class="flex flex-col">
                <div class="flex flex-wrap items-center gap-4 mb-4">
                    <h1 class="text-2xl font-bold capitalize">{{ $product->name }}</h1>
                    @if($product->created_at->gt(now()->subDays(7)))
                        <div class="badge badge-secondary badge-soft">New</div>
                    @endif 
                </div>

                <div class="divider !my-0"></div>

                <!-- Price Section -->
                <div class="mb-6 mt-2">
                    <div class="flex items-center gap-3">
                                        <span class="text-3xl font-bold text-black">
                                            Rp{{ number_format($product->price, 2, ',', '.') }}
                                        </span>
                    </div>
                </div>


                <!-- Categories & Tags -->
                <div class="flex flex-wrap gap-2 mb-6">
                    Tags:
                    @if($product->category)
                        <div class="badge badge-soft badge-primary badge-lg">{{ $product->category->name }}</div>
                    @endif
                    @if($product->flavour)
                        <div class="badge badge-soft badge-lg badge-accent">
                            {{ $product->flavour->name }}</div>
                    @endif
                </div>

                <!-- Description -->
                <div class="prose max-w-none mb-8">
                    <h3 class="text-xl font-semibold mb-2">Description</h3>
                    <p>{{ $product->description }}</p>
                </div>

                <!-- Add to Cart Form -->
                <div class="card bg-base-100 shadow-lg border border-base-300 mb-6">
                    <div class="card-body p-4">
                        <form action="{{ route('cart.add', $product) }}" method="POST"
                              class="flex items-end gap-4">
                            @csrf

                            <div class="mb-2 text-sm text-gray-600">
                                Stok tersedia: <span class="font-semibold">{{ $product->current_stock }}</span>
                            </div>

                            <x-button-primary
                                type="submit"
                                class="btn-lg flex-1"
                                :disabled="$product->current_stock <= 0"
                                icon='<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>'
                            >
                                {{ $product->current_stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                            </x-button-primary>
                        </form>
                    </div>
                </div>
                <!-- Product Information -->
                <div class="mb-6">
                    <h3 class="text-xl font-semibold mb-4">Product Information</h3>
                    <div class="overflow-x-auto">
                        <table class="table table-zebra w-full">
                            <tbody>
                            @if($product->category)
                                <tr>
                                    <td class="font-medium">Category</td>
                                    <td>{{ $product->category->name }}</td>
                                </tr>
                            @endif
                            @if($product->flavour)
                                <tr>
                                    <td class="font-medium">Flavour</td>
                                    <td>{{ $product->flavour->name }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-medium">Added</td>
                                <td>{{ $product->created_at->format('d M Y') }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <div>
                <h2 class="text-2xl font-bold mb-6">You May Also Like</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div
                            class="card bg-base-100 shadow-lg border border-base-300 hover:shadow-xl transition-shadow duration-300">
                            <figure class="px-4 pt-4">
                                <img src="{{ $relatedProduct->image ?? 'https://placehold.co/300x200' }}"
                                     alt="{{ $relatedProduct->name }}"
                                     class="rounded-xl h-48 w-full object-cover"/>
                            </figure>
                            <div class="card-body">
                                <h3 class="card-title">{{ $relatedProduct->name }}</h3>
                                <p class="text-primary font-bold">
                                    Rp {{ number_format($relatedProduct->price, 2, ',', '.') }}</p>
                                <div class="card-actions justify-end">
                                    <a href="{{ route('products.show', $relatedProduct) }}"
                                       class="btn btn-sm btn-outline">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Quantity control script -->
    <script>
        function incrementQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue < parseInt(input.max)) {
                input.value = currentValue + 1;
            }
        }

        function decrementQuantity() {
            const input = document.getElementById('quantity');
            const currentValue = parseInt(input.value);
            if (currentValue > parseInt(input.min)) {
                input.value = currentValue - 1;
            }
        }

                document.getElementById('quantity').addEventListener('keydown', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
            }
        });
    </script>
@endsection
