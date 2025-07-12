<div class="relative w-full mb-6">
    @if(count($activeBanners) > 0)
        <div class="swiper banner-swiper">
            <div class="swiper-wrapper">
                @foreach($activeBanners as $banner)
                    <div class="swiper-slide">
                        <a href="{{ route('vouchers.customer.index') }}">
                            <img src="{{ Storage::url($banner->image) }}"
                                 alt="{{ $banner->title }}"
                                 class="w-full h-full object-cover">
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    @else
        <div
            class="w-full h-[500px] bg-gradient-to-br from-lime-100 to-primary flex justify-center items-center text-center">
            <div class="p-8 max-w-xl">
                <h2 class="text-2xl font-bold mb-2">Welcome to Our Store</h2>
                <p class="mb-4">Discover our amazing products and special offers</p>
                <x-button-primary>
                    <a href="{{ route('products.index') }}">
                        Shop Now
                    </a>
                </x-button-primary>
            </div>
        </div>
    @endif
</div>

<style>
    .banner-swiper {
        width: 100%;
        height: 500px;
        overflow: hidden;
    }

    .swiper-slide {
        height: 100%;
    }

    .banner-swiper .swiper-button-prev,
    .banner-swiper .swiper-button-next {
        color: white;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        padding: 25px;
        width: 15px !important;
        height: 15px !important;
    }

    .banner-swiper .swiper-button-prev:after,
    .banner-swiper .swiper-button-next:after {
        font-size: 18px;
    }

    .banner-swiper .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background-color: white;
        opacity: 0.6;
    }

    .banner-swiper .swiper-pagination-bullet-active {
        opacity: 1;
        background-color: white;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.banner-swiper')) {
            const swiper = new Swiper('.banner-swiper', {
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
            });
        }
    });
</script>
