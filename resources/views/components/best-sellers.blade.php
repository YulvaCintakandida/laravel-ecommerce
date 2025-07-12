<section class="mb-20">
    <!-- Section Header -->
    <div class="grid grid-cols-[auto_1fr] items-center mb-8">
        <div class="w-1.5 h-12 bg-primary rounded-full mr-3"></div>
        <div>
            <span class="text-gray-500 text-sm uppercase tracking-wider font-medium">Today's</span>
            <h2 class="text-3xl font-bold">Best Sellers</h2>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8">
        @foreach($bestSellers as $product)
            <div
                class="card bg-base-100 shadow-xl h-full border border-base-300 hover:shadow-2xl transition-shadow duration-300 overflow-hidden group">
                <figure class="relative overflow-hidden h-56">
                    <img src="{{ Storage::url($product->image) ?? 'https://placehold.co/400x300' }}"
                         alt="{{ $product->name }}"
                         class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">

                    <!-- Sale Badge -->
                    @if($product->is_sale ?? false)
                        <div class="absolute top-2 left-2 badge badge-error">Sale</div>
                    @endif

                    @if($product->created_at->gt(now()->subDays(7)))
                        <div class="absolute top-2 left-2 badge badge-secondary">New</div>
                    @endif

                    @if(isset($product->category))
                        <div class="absolute top-2 right-2 badge badge-primary">{{ $product->category->name }}</div>
                    @endif

                    @if($product->current_stock <= 0)
                        <div class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center">
                            <span class="text-white text-lg font-bold">Out of Stock</span>
                        </div>
                    @else
                        <div
                            class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 grid place-items-center transition-opacity duration-300">
                            <a href="{{ route('products.show', $product) }}"
                               class="btn btn-circle btn-sm bg-white text-black hover:bg-primary hover:text-white border-none">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                                     viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                                </svg>
                            </a>
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
                        @if($product->original_price ?? false)
                            <span class="text-gray-400 text-sm line-through">
                                                    Rp {{ number_format($product->original_price, 2, ',', '.') }}
                                                </span>
                        @endif
                    </div>

                    <div class="card-actions grid grid-cols-1 sm:grid-cols-2 mt-4">
                        <a href="{{ route('products.show', $product) }}" class="btn btn-outline btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Details
                        </a>

                        @auth
                            <form action="{{ route('cart.add', $product) }}" method="POST" class="w-full">
                                @csrf
                                <button type="submit"
                                        class="btn btn-success w-full" {{ $product->current_stock <= 0 ? 'disabled' : '' }}>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                         viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    {{ $product->current_stock <= 0 ? 'Sold Out' : 'Cart' }}
                                </button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-success w-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Cart
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- View All Link -->
    <div class="grid place-items-center mt-14">
        <a href="{{ route('products.index') }}" class="btn btn-primary px-10">
            View All Products
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M17 8l4 4m0 0l-4 4m4-4H3"/>
            </svg>
        </a>
    </div>
</section>
