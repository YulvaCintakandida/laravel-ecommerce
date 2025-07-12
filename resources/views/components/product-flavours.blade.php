<section class="my-16">
    <!-- Section Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center">
            <div class="w-1.5 h-12 bg-primary rounded-full mr-3"></div>
            <div class="flex flex-col">
                <span class="text-gray-500 text-sm uppercase tracking-wider font-medium">Taste</span>
                <h2 class="text-3xl font-bold">Product Flavours</h2>
            </div>
        </div>
        <div class="flex gap-4">
            <button class="flavours-swiper-prev btn btn-sm btn-outline btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button class="flavours-swiper-next btn btn-sm btn-outline btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Flavours Swiper -->
    <div class="swiper flavours-swiper">
        <div class="swiper-wrapper">
            @foreach($flavours as $flavour)
                <div class="swiper-slide">
                    <a href="{{ route('flavours.show', $flavour) }}"
                       class="card h-72 bg-base-100 shadow-xl hover:shadow-2xl transition-all duration-300 border border-base-300 overflow-hidden group hover:bg-primary">
                        <div class="card-body p-6 text-center flex flex-col items-center justify-center">
                            <div
                                class="bg-primary/10 rounded-full w-24 h-24 mb-6 flex items-center justify-center transform transition-transform group-hover:scale-110 group-hover:bg-white/20">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-12 w-12 text-primary group-hover:text-white transition-colors"
                                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold mb-3 group-hover:text-white transition-colors">{{ $flavour->name }}</h3>
                            <div
                                class="badge badge-primary badge-soft py-2 px-4 transition-colors group-hover:bg-transparent group-hover:border-white group-hover:text-white">
                                {{ $flavour->products_count }} {{ Str::plural('Product', $flavour->products_count) }}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Flavours Swiper
            const flavoursSwiper = new Swiper('.flavours-swiper', {
                slidesPerView: 1,
                spaceBetween: 16,
                grabCursor: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                navigation: {
                    nextEl: '.flavours-swiper-next',
                    prevEl: '.flavours-swiper-prev',
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
        .flavours-swiper-prev,
        .flavours-swiper-next {
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .flavours-swiper-prev:hover,
        .flavours-swiper-next:hover {
            opacity: 1;
        }

        .flavours-swiper .swiper-slide .card {
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .flavours-swiper .swiper-slide .card:hover {
            transform: translateY(-5px);
        }
    </style>
</section>
