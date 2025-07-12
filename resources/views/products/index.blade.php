@extends('layouts.app')

@section('content')
    <div class="flex flex-col mb-8">
        <h1 class="text-3xl font-bold mb-4">Our Products</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar: Sorting and Filtering -->
        <div class="lg:w-1/4">
            <div class="sticky top-4 space-y-4">
                <form action="{{ route('products.index') }}" method="GET">
                    <!-- Search Card -->
                    <!-- Search using the Collapsible Component -->
                    <x-collapsible title="Search" :open="true" class="mb-4">
                        <x-input
                            type="text"
                            name="search"
                            iconName="heroicon-o-magnifying-glass"
                            placeholder="Search products..."
                            value="{{ request('search') }}"
                        />
                    </x-collapsible>

                    <x-collapsible title="Sort By" class="mb-4">
                        <div class="space-y-2">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <x-input
                                    type="radio"
                                    name="sort"
                                    value="newest"
                                    class="radio radio-sm"
                                    :checked="request('sort') == 'newest' || !request('sort')"
                                />
                                <span>Newest First</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <x-input
                                    type="radio"
                                    name="sort"
                                    value="price_asc"
                                    class="radio radio-sm"
                                    :checked="request('sort') == 'price_asc'"
                                />
                                <span>Price: Low to High</span>
                            </label>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <x-input
                                    type="radio"
                                    name="sort"
                                    value="price_desc"
                                    class="radio radio-sm"
                                    :checked="request('sort') == 'price_desc'"
                                />
                                <span>Price: High to Low</span>
                            </label>
                        </div>
                    </x-collapsible>

                    <!-- Apply Button -->
                    <x-button-primary type="submit" class="w-full">Apply Filters</x-button-primary>
                </form>
            </div>
        </div>

        <!-- Main Content: Product Cards -->
        <div class="lg:w-3/4">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div
                            class="card bg-base-100 shadow-xl h-full border border-base-300 hover:shadow-2xl transition-shadow duration-300 overflow-hidden group">
                            <figure class="relative overflow-hidden h-56">
                                <img src="{{ Storage::url($product->image) ?? 'https://placehold.co/400x300' }}"
                                alt="{{ $product->name }}"
                                     class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">

                                @if($product->created_at->gt(now()->subDays(7)))
                                    <div class="absolute top-2 left-2 badge badge-secondary">New</div>
                                @endif

                                @if(isset($product->category))
                                    <div
                                        class="absolute top-2 right-2 badge badge-primary">{{ $product->category->name }}</div>
                                @endif

                                @if($product->current_stock <= 0)
                                    <div
                                        class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                        <span class="text-white text-lg font-bold">Produk Habis</span>
                                    </div>
                                @endif
                            </figure>

                            <div class="card-body">
                                <h2 class="card-title capitalize">{{ $product->name }}</h2>
                                <p class="text-sm text-gray-500">{{ Str::limit($product->description, 100) }}</p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span
                                        class="text-xl font-bold text-primary">Rp {{ number_format($product->price, 2, ',', '.') }}</span>
                                    @if(isset($product->old_price) && $product->old_price > $product->price)
                                        <span
                                            class="text-sm line-through text-gray-400">Rp {{ number_format($product->old_price, 2, ',', '.') }}</span>
                                    @endif
                                </div>

                                <div class="card-actions justify-between items-center mt-4">
                                    <a href="{{ route('products.show', $product) }}"
                                       class="btn btn-outline btn-primary">
                                        <x-icon name="heroicon-o-eye" class="h-5 w-5 mr-1"/>
                                        Details
                                    </a>

                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <x-button-primary type="submit" class="btn-success"
                                                          :disabled="$product->current_stock <= 0">
                                            <x-icon name="heroicon-o-shopping-cart" class="h-5 w-5 mr-1"/>
                                            {{ $product->current_stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                        </x-button-primary>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <x-alert type="info" class="shadow-lg">
                    No products found. Please try a different search or check back later.
                </x-alert>
            @endif
        </div>
    </div>
@endsection
