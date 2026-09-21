<section class="bg-[#050505] py-24 md:py-32 overflow-hidden border-t border-white/10 relative">
    
    {{-- Glow effect --}}
    <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-[#4fd1c5]/5 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-16 text-center relative z-10">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-4 block">Our Portfolio</span>
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-white tracking-tight">
            Featured Projects
        </h2>
        <p class="text-gray-400 mt-6 max-w-2xl mx-auto text-lg">
            Explore our world-class enterprise solutions, custom-built to drive revenue and scale operations.
        </p>
    </div>

    @php
        $projects = [
            [
                'title' => 'Quantum Analytics',
                'desc' => 'Transforming Data into Actionable Insights for Enterprise SaaS.',
                'tags' => ['Enterprise Dashboard', 'Real-time Analytics', 'Cross-Platform UI'],
                'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'Nexus CRM',
                'desc' => 'A scalable customer relationship management tool for modern sales teams.',
                'tags' => ['CRM', 'Sales Automation', 'React Native'],
                'img' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'PayFlow FinTech',
                'desc' => 'Secure, global payment processing architecture with real-time fraud detection.',
                'tags' => ['FinTech', 'Payment Gateway', 'Cloud Security'],
                'img' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&q=80&w=1200'
            ],
            [
                'title' => 'Vitality HealthTech',
                'desc' => 'HIPAA-compliant patient management platform scaling to 10M+ users.',
                'tags' => ['HealthTech', 'HIPAA', 'Cloud Architecture'],
                'img' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&q=80&w=1200'
            ]
        ];
    @endphp

    {{-- Swiper Container --}}
    <div class="relative w-full max-w-[1920px] mx-auto px-6 lg:px-12 z-10">
        <div class="swiper projects-swiper overflow-hidden rounded-3xl pb-16">
            <div class="swiper-wrapper">
                
                @foreach($projects as $project)
                <div class="swiper-slide !w-full md:!w-[80%] lg:!w-[70%]" data-cursor-expand>
                    <div class="relative rounded-3xl overflow-hidden group border border-white/10 aspect-[16/10] md:aspect-[21/9]">
                        
                        {{-- Background Image --}}
                        <img src="{{ $project['img'] }}" alt="{{ $project['title'] }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        
                        {{-- Dark Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
                        <div class="absolute inset-0 bg-[#050505]/30 group-hover:bg-[#050505]/10 transition-colors duration-500"></div>

                        {{-- Glassmorphism Content Box --}}
                        <div class="absolute bottom-6 left-6 right-6 md:bottom-12 md:left-12 md:w-[60%] bg-black/40 backdrop-blur-xl border border-white/20 p-8 rounded-2xl transform translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-500 delay-100">
                            <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs mb-3 block">PROJECT: {{ $project['title'] }}</span>
                            <h3 class="text-white text-2xl md:text-3xl font-bold mb-4 leading-tight">{{ $project['desc'] }}</h3>
                            
                            <div class="flex flex-wrap gap-2 mb-8">
                                @foreach($project['tags'] as $tag)
                                    <span class="px-3 py-1 rounded-full border border-[#4fd1c5]/30 text-[#4fd1c5] text-xs font-medium bg-[#4fd1c5]/5">{{ $tag }}</span>
                                @endforeach
                            </div>
                            
                            <a href="#" class="inline-flex items-center justify-center w-full md:w-auto px-8 py-3 rounded-full border border-white/20 text-white font-medium hover:bg-white hover:text-black hover:border-white transition-colors duration-300">
                                View Full Case Study
                            </a>
                        </div>

                        {{-- Default Title (visible when not hovered) --}}
                        <div class="absolute bottom-8 left-8 md:bottom-12 md:left-12 group-hover:opacity-0 transition-opacity duration-300">
                            <h3 class="text-white text-3xl md:text-5xl font-bold">{{ $project['title'] }}</h3>
                        </div>

                    </div>
                </div>
                @endforeach

            </div>
            
            {{-- Navigation & Pagination --}}
            <div class="swiper-pagination !bottom-0"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof Swiper !== 'undefined') {
        new Swiper('.projects-swiper', {
            slidesPerView: 'auto',
            spaceBetween: 24,
            centeredSlides: true,
            grabCursor: true,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                768: {
                    spaceBetween: 48,
                }
            }
        });
    }
});
</script>
@endpush
