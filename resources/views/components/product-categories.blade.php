<section class="mb-12">
    <!-- Section Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="w-1.5 h-12 bg-primary rounded-full mr-3"></div>
            <div class="flex flex-col">
                <span class="text-gray-500 text-sm uppercase tracking-wider font-medium">Browse</span>
                <h2 class="text-3xl font-bold">Product Categories</h2>
            </div>
        </div>
        <div class="flex gap-4">
            <button class="categories-swiper-prev btn btn-sm btn-outline btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="categories-swiper-next btn btn-sm btn-outline btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Categories Swiper -->
    <div class="swiper categories-swiper">
        <div class="swiper-wrapper">
            @foreach($categories as $category)
                <div class="swiper-slide">
                    <a href="{{ route('categories.show', $category) }}"
                       class="card h-72 bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border border-base-300 overflow-hidden group hover:bg-primary">
                        <div class="card-body p-6 text-center flex flex-col items-center justify-center">
                            <div
                                class="bg-primary/10 rounded-full w-24 h-24 mb-6 flex items-center justify-center transform transition-transform group-hover:scale-110 group-hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-12 w-12 text-primary group-hover:text-white transition-colors"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-3 group-hover:text-white transition-colors">{{ $category->name }}</h3>
                            <div
                                class="badge badge-primary py-2 px-4 transition-colors group-hover:bg-transparent group-hover:border-white group-hover:text-white">                                {{ $category->products_count }} {{ Str::plural('Product', $category->products_count) }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Categories Swiper
            const categoriesSwiper = new Swiper('.categories-swiper', {
                slidesPerView: 1,
                spaceBetween: 16,
                grabCursor: true,
                navigation: {
                    nextEl: '.categories-swiper-next',
                    prevEl: '.categories-swiper-prev',
                },
                breakpoints: {
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 16
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 24
                    }
                }
            });
        });
    </script>

    <style>
        .categories-swiper-prev,
        .categories-swiper-next {
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .categories-swiper-prev:hover,
        .categories-swiper-next:hover {
            opacity: 1;
        }

        .categories-swiper .swiper-slide .card {
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .categories-swiper .swiper-slide .card:hover {
            transform: translateY(-5px);
        }
    </style>
</section>
