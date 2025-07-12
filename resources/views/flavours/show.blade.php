@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center gap-2 text-sm mb-8">
        <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Home</a>
        <span class="text-gray-500">/</span>
        <span class="font-medium">{{ $flavour->name }}</span>
    </div>

    <h1 class="text-3xl font-bold mb-8">{{ $flavour->name }} Products</h1>

    @if($products->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($products as $product)
            @include('products.partials.card')
        @endforeach
    </div>
        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-12">
            <p class="text-gray-500">No products found with this flavour.</p>
        </div>
    @endif
</div>
@endsection