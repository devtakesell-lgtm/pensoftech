<section class="bg-white py-10 md:py-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-5 lg:px-12">

        {{-- Section Header & Navigation Controls --}}
        <div class="flex items-end justify-between mb-6 md:mb-12">
            <div>
                <span
                    class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Leadership</span>
                <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-black tracking-tight">
                    Minds behind the machine.
                </h2>
            </div>
            <div class="flex gap-2.5 sm:gap-4">
                <button
                    class="team-prev w-9 h-9 sm:w-11 sm:h-11 md:w-12 md:h-12 rounded-full border border-gray-200 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all text-sm md:text-base font-bold shadow-sm">
                    ←
                </button>
                <button
                    class="team-next w-9 h-9 sm:w-11 sm:h-11 md:w-12 md:h-12 rounded-full border border-gray-200 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all text-sm md:text-base font-bold shadow-sm">
                    →
                </button>
            </div>
        </div>



        {{-- Single Unified Leadership Swiper --}}
        <div class="swiper team-swiper overflow-hidden w-full rounded-2xl md:rounded-3xl">
            <div class="swiper-wrapper py-2 md:py-4">
                @foreach ($teamMembers as $leader)
                    @php
                        $roleName =
                            $leader->profile?->designation ?:
                            ($leader->roles->first()?->name
                                ? ucwords(str_replace('-', ' ', $leader->roles->first()->name))
                                : 'Staff');
                        $isCeo = $leader->hasRole('administrator') && stripos($roleName, 'Founder') !== false;
                        $quote = $leader->profile?->short_bio ?: 'Committed to driving excellence and innovation.';

                        if ($leader->avatar) {
                            $imgUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($leader->avatar);
                        } else {
                            // Using dicebear as placeholder if no avatar exists
                            $imgUrl =
                                'https://api.dicebear.com/7.x/initials/svg?seed=' .
                                urlencode($leader->name) .
                                '&backgroundColor=4fd1c5&textColor=000000';
                        }

                        $socials = $leader->profile?->social_links ?? [];
                    @endphp
                    <div class="swiper-slide !w-[240px] sm:!w-[280px] md:!w-[340px]" data-cursor-expand>
                        <div
                            class="group relative w-full aspect-[3/4] rounded-2xl md:rounded-3xl overflow-hidden shadow-md border border-gray-100 cursor-grab active:cursor-grabbing bg-black">

                            {{-- Image (Full Color & Vivid) --}}
                            <img src="{{ $imgUrl }}" alt="{{ $leader->name }}"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                                loading="lazy">

                            {{-- Overlay Gradient --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/40 to-transparent">
                            </div>

                            {{-- Badge for Admin/CEO --}}
                            @if ($isCeo)
                                <div class="absolute top-3.5 left-3.5 z-10">
                                    <span
                                        class="inline-block px-2.5 py-1 bg-[#4fd1c5] text-black text-[9px] md:text-[10px] font-black uppercase rounded-md tracking-wider shadow-sm">
                                        Leadership
                                    </span>
                                </div>
                            @endif

                            {{-- Text Content --}}
                            <div class="absolute bottom-0 left-0 w-full p-4 sm:p-6 transition-transform duration-300">
                                <h3 class="text-white text-lg sm:text-xl font-extrabold mb-0.5">{{ $leader->name }}</h3>
                                <p class="text-[#4fd1c5] font-semibold text-xs sm:text-sm mb-2">{{ $roleName }}</p>

                                <p
                                    class="text-gray-300 text-[11px] sm:text-xs italic leading-relaxed line-clamp-2 border-l border-[#4fd1c5]/60 pl-2 mb-3">
                                    "{{ $quote }}"
                                </p>

                                {{-- Social links --}}
                                <div class="flex gap-2">
                                    @if (!empty($socials['linkedin']))
                                        <a href="{{ $socials['linkedin'] }}" target="_blank"
                                            class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-black transition-colors text-[10px] font-bold">in</a>
                                    @endif
                                    @if (!empty($socials['twitter']))
                                        <a href="{{ $socials['twitter'] }}" target="_blank"
                                            class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-black transition-colors text-[10px] font-bold">𝕏</a>
                                    @endif
                                    @if (!empty($socials['facebook']))
                                        <a href="{{ $socials['facebook'] }}" target="_blank"
                                            class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-black transition-colors text-[10px] font-bold">fb</a>
                                    @endif
                                    @if (!empty($socials['github']))
                                        <a href="{{ $socials['github'] }}" target="_blank"
                                            class="w-7 h-7 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-black transition-colors text-[10px] font-bold">gh</a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</section>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof Swiper !== 'undefined') {
                new Swiper('.team-swiper', {
                    slidesPerView: 'auto',
                    spaceBetween: 16,
                    grabCursor: true,
                    loop: true,
                    speed: 600,
                    autoplay: {
                        delay: 3000,
                        disableOnInteraction: false,
                    },
                    navigation: {
                        nextEl: '.team-next',
                        prevEl: '.team-prev',
                    },
                    breakpoints: {
                        640: {
                            spaceBetween: 20,
                        },
                        768: {
                            spaceBetween: 28,
                        }
                    }
                });
            }
        });
    </script>
@endpush
