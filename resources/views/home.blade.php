@extends('layouts.app')

@section('content')
    <div>
        <!-- Banner Component -->
        <x-banner :activeBanners="$activeBanners"/>
        
        <div class="divider my-12"></div>

        <!-- Product Categories Component -->
        <x-product-categories :categories="$categories"/>

        <div class="divider my-12"></div>

        <!-- Product Flavours Component -->
        <x-product-flavours :flavours="$flavours"/>

        <div class="divider my-12"></div>

        <!-- Best Sellers Component -->
        <x-best-sellers :bestSellers="$bestSellers"/>

        <div class="divider my-12"></div>

        <!-- New Arrivals Component -->
        <x-new-arrivals :latestProducts="$latestProducts"/>
    </div>
@endsection
