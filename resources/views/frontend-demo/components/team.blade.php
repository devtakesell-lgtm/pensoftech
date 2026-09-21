<section class="bg-white py-24 md:py-32 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 lg:px-12">
        <div class="flex flex-col md:flex-row justify-between items-end mb-16">
            <div>
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-4 block">Leadership</span>
                <h2 class="text-4xl md:text-5xl font-bold text-black tracking-tight">
                    Minds behind the machine.
                </h2>
            </div>
            <div class="hidden md:flex gap-4 mt-6 md:mt-0">
                <button class="team-prev w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all">
                    ←
                </button>
                <button class="team-next w-12 h-12 rounded-full border border-gray-200 flex items-center justify-center hover:border-black hover:bg-black hover:text-white transition-all">
                    →
                </button>
            </div>
        </div>

        @php
            $ceo = ['name' => 'Sarah Jenkins', 'role' => 'Chief Executive Officer', 'img' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=800'];
            
            $team = [
                ['name' => 'David Chen', 'role' => 'Chief Technology Officer', 'img' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=800'],
                ['name' => 'Elena Rodriguez', 'role' => 'Head of Ecosystems', 'img' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=800'],
                ['name' => 'Michael Chang', 'role' => 'VP of Engineering', 'img' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&q=80&w=800'],
                ['name' => 'Amira Hassan', 'role' => 'Director of Growth', 'img' => 'https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&q=80&w=800'],
            ];
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            {{-- Left Column: Anchored CEO --}}
            <div class="lg:col-span-4 flex flex-col">
                <div class="group relative w-full h-[500px] lg:h-[600px] rounded-3xl overflow-hidden shadow-lg" data-cursor-expand>
                    {{-- Image --}}
                    <img src="{{ $ceo['img'] }}" alt="{{ $ceo['name'] }}" 
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 filter group-hover:scale-105" loading="lazy">
                    
                    {{-- Overlay Gradient --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                    
                    {{-- Text Content --}}
                    <div class="absolute bottom-0 left-0 w-full p-8">
                        <h3 class="text-white text-3xl font-bold mb-1">{{ $ceo['name'] }}</h3>
                        <p class="text-white/80 font-medium text-lg mb-6">{{ $ceo['role'] }}</p>
                        
                        <p class="text-white/90 text-sm italic border-l-2 border-[#4fd1c5] pl-4">
                            "Visionary leadership is about empowering others to achieve the extraordinary. It's the art of transforming potential into global impact."
                        </p>
                        
                        {{-- Social links --}}
                        <div class="mt-6 flex gap-3">
                            <a href="#" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-white transition-colors">in</a>
                            <a href="#" class="w-10 h-10 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-white transition-colors">𝕏</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Auto-Looping Carousel --}}
            <div class="lg:col-span-8 flex items-center">
                {{-- REMOVED !overflow-visible to prevent bleeding over the CEO card --}}
                <div class="swiper team-swiper overflow-hidden w-full rounded-3xl">
                    <div class="swiper-wrapper py-4">
                        @foreach($team as $member)
                        <div class="swiper-slide !w-[280px] md:!w-[340px]" data-cursor-expand>
                            <div class="group relative w-full aspect-[3/4] rounded-3xl overflow-hidden shadow-md cursor-grab active:cursor-grabbing">
                                {{-- Image --}}
                                <img src="{{ $member['img'] }}" alt="{{ $member['name'] }}" 
                                    class="absolute inset-0 w-full h-full object-cover transition-all duration-700 filter grayscale group-hover:grayscale-0 group-hover:scale-105" loading="lazy">
                                
                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-80 group-hover:opacity-90 transition-opacity duration-500"></div>
                                
                                {{-- Text Content --}}
                                <div class="absolute bottom-0 left-0 w-full p-6 translate-y-4 group-hover:translate-y-0 transition-transform duration-500">
                                    <h3 class="text-white text-xl font-bold mb-1">{{ $member['name'] }}</h3>
                                    <p class="text-white/80 font-medium text-sm">{{ $member['role'] }}</p>
                                    
                                    {{-- Social links reveal on hover --}}
                                    <div class="mt-4 flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-500 delay-100">
                                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-white transition-colors text-sm">in</a>
                                        <a href="#" class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white hover:bg-[#4fd1c5] hover:text-white transition-colors text-sm">𝕏</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
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
            spaceBetween: 24,
            grabCursor: true,
            loop: true,
            speed: 800, // Smooth slide transition speed
            autoplay: {
                delay: 2500,
                disableOnInteraction: false, // Keeps playing after user swipes
            },
            navigation: {
                nextEl: '.team-next',
                prevEl: '.team-prev',
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
