@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <div class="flex items-center gap-2 text-sm mb-8">
            <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Home</a>
            <span class="text-gray-500">/</span>
            <span class="font-medium">{{ $category->name }}</span>
        </div>

        <!-- Category Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold">{{ $category->name }}</h1>
            <p class="text-gray-500 mt-2">{{ $category->description }}</p>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
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

                            @if($product->current_stock <= 0)
                                <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                                    <span class="text-white text-lg font-bold">Out of Stock</span>
                                </div>
                            @endif
                        </figure>

                        <div class="card-body">
                            <h2 class="card-title">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-500">{{ Str::limit($product->description, 100) }}</p>
                            <div class="flex items-center gap-2 mt-2">
                            <span class="text-xl font-bold text-primary">
                                Rp {{ number_format($product->price, 2, ',', '.') }}
                            </span>
                            </div>

                            <div class="card-actions justify-between items-center mt-4">
                                <a href="{{ route('products.show', $product) }}"
                                   class="btn btn-outline btn-primary">
                                    Details
                                </a>

                                @auth
                                    <form action="{{ route('cart.add', $product) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-success"
                                            {{ $product->current_stock <= 0 ? 'disabled' : '' }}>
                                            Add to Cart
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-success">
                                        Add to Cart
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-500">No products found in this category.</p>
            </div>
        @endif
    </div>
@endsection
