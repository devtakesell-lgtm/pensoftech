<section class="bg-[#f9fafb] py-10 md:py-24 overflow-hidden border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-12 text-center">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Customer Reviews</span>
        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight">
            What Our Clients Say
        </h2>
    </div>

    @php
        $reviews = [
            ['name' => 'Alex Carter', 'title' => 'Founder, Stackly', 'text' => 'The team delivered a phenomenal SaaS platform. Their expertise and dedication are unparalleled.', 'img' => 'https://randomuser.me/api/portraits/men/32.jpg'],
            ['name' => 'Sarah Chen', 'title' => 'CTO, Innovate Corp', 'text' => 'Outstanding results! They transformed our vision into a market-ready product in record time.', 'img' => 'https://randomuser.me/api/portraits/women/44.jpg'],
            ['name' => 'Michael Braun', 'title' => 'CEO, NextGen Solutions', 'text' => 'Incredible collaboration and top-tier engineering. Highly recommend for any enterprise project.', 'img' => 'https://randomuser.me/api/portraits/men/46.jpg'],
            ['name' => 'Jessica Lee', 'title' => 'Director of Product', 'text' => 'They didn\'t just build software, they helped refine our entire product strategy. Brilliant minds.', 'img' => 'https://randomuser.me/api/portraits/women/68.jpg'],
            ['name' => 'David Osei', 'title' => 'Founder, FinTech Pro', 'text' => 'Flawless execution. Our new cloud architecture is faster and more secure than we ever imagined.', 'img' => 'https://randomuser.me/api/portraits/men/22.jpg'],
        ];
    @endphp

    {{-- Swiper Container --}}
    <div class="max-w-7xl mx-auto px-5 lg:px-12">
        <div class="swiper reviews-swiper overflow-hidden rounded-2xl w-full pb-8 md:pb-12">
            <div class="swiper-wrapper">
                
                @foreach($reviews as $review)
                <div class="swiper-slide !w-[280px] sm:!w-[320px] md:!w-[400px]" data-cursor-expand>
                    <div class="bg-white rounded-2xl md:rounded-3xl p-5 md:p-8 border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.03)] md:shadow-[0_8px_30px_rgba(0,0,0,0.04)] h-full flex flex-col">
                        
                        {{-- Stars --}}
                        <div class="flex gap-1 text-[#facc15] mb-3 md:mb-6">
                            @for($i=0; $i<5; $i++)
                                <svg class="w-4 h-4 md:w-5 md:h-5 fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                            @endfor
                        </div>

                        {{-- Review Text --}}
                        <p class="text-gray-700 text-xs md:text-base mb-4 md:mb-8 flex-grow leading-relaxed">
                            "{{ $review['text'] }}"
                        </p>

                        {{-- User Info --}}
                        <div class="flex items-center gap-3 md:gap-4 mt-auto">
                            <img src="{{ $review['img'] }}" alt="{{ $review['name'] }}" class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover shadow-sm">
                            <div>
                                <h4 class="font-bold text-gray-900 text-xs md:text-sm">{{ $review['name'] }}</h4>
                                <p class="text-[10px] md:text-xs text-gray-500">{{ $review['title'] }}</p>
                            </div>
                        </div>
                        
                    </div>
                </div>
                @endforeach

            </div>
            
            {{-- Pagination --}}
            <div class="swiper-pagination !bottom-0"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof Swiper !== 'undefined') {
        new Swiper('.reviews-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 24,
            grabCursor: true,
            loop: true,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    spaceBetween: 32,
                }
            }
        });
    }
});
</script>
@endpush
