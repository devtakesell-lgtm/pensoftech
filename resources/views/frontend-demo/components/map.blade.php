<section class="bg-[#050505] py-24 md:py-32 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-16 relative z-20">
        <div class="flex flex-col md:flex-row justify-between items-end">
            <div>
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-4 block">Global Presence</span>
                <h2 class="text-3xl md:text-5xl font-bold text-white tracking-tight">
                    Powering scale,<br>worldwide.
                </h2>
            </div>
            <div class="mt-6 md:mt-0 text-gray-400">
                <p class="max-w-xs">Operating across 3 continents, delivering enterprise solutions to clients globally.</p>
            </div>
        </div>
    </div>

    {{-- Map Container --}}
    <div class="relative w-full max-w-6xl mx-auto h-[400px] md:h-[600px] mt-10">
        
        {{-- Custom SVG Map Pattern (Simplified dotted world map approximation for a premium tech vibe) --}}
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 15px 15px; mask-image: radial-gradient(ellipse at center, black 40%, transparent 70%); -webkit-mask-image: radial-gradient(ellipse at center, black 40%, transparent 70%);"></div>

        {{-- Glowing Orbs (Offices/Locations) --}}
        
        {{-- Location 1: North America --}}
        <div class="absolute top-[30%] left-[25%] -translate-x-1/2 -translate-y-1/2 group" data-cursor-expand>
            <div class="relative w-4 h-4">
                <div class="absolute inset-0 bg-[#7655ff] rounded-full opacity-75 animate-ping"></div>
                <div class="relative w-4 h-4 bg-[#7655ff] rounded-full border-2 border-black"></div>
            </div>
            {{-- Tooltip --}}
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <p class="text-white text-xs font-bold">New York, USA</p>
                <p class="text-gray-400 text-[10px]">Headquarters</p>
            </div>
        </div>

        {{-- Location 2: Europe --}}
        <div class="absolute top-[25%] left-[55%] -translate-x-1/2 -translate-y-1/2 group" data-cursor-expand>
            <div class="relative w-3 h-3">
                <div class="absolute inset-0 bg-[#4fd1c5] rounded-full opacity-75 animate-ping" style="animation-delay: 0.5s"></div>
                <div class="relative w-3 h-3 bg-[#4fd1c5] rounded-full border-2 border-black"></div>
            </div>
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <p class="text-white text-xs font-bold">London, UK</p>
            </div>
        </div>

        {{-- Location 3: Asia --}}
        <div class="absolute top-[45%] left-[75%] -translate-x-1/2 -translate-y-1/2 group" data-cursor-expand>
            <div class="relative w-4 h-4">
                <div class="absolute inset-0 bg-[#f6c90e] rounded-full opacity-75 animate-ping" style="animation-delay: 1.2s"></div>
                <div class="relative w-4 h-4 bg-[#f6c90e] rounded-full border-2 border-black"></div>
            </div>
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <p class="text-white text-xs font-bold">Singapore</p>
                <p class="text-gray-400 text-[10px]">APAC Hub</p>
            </div>
        </div>

        {{-- Location 4: South Asia --}}
        <div class="absolute top-[50%] left-[68%] -translate-x-1/2 -translate-y-1/2 group" data-cursor-expand>
            <div class="relative w-3 h-3">
                <div class="absolute inset-0 bg-[#4fd1c5] rounded-full opacity-75 animate-ping" style="animation-delay: 0.8s"></div>
                <div class="relative w-3 h-3 bg-[#4fd1c5] rounded-full border-2 border-black"></div>
            </div>
            <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1 bg-white/10 backdrop-blur-md rounded-lg border border-white/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
                <p class="text-white text-xs font-bold">Dhaka, BD</p>
                <p class="text-gray-400 text-[10px]">Dev Center</p>
            </div>
        </div>

        {{-- Connection Lines (Using SVGs) --}}
        <svg class="absolute inset-0 w-full h-full pointer-events-none z-10" aria-hidden="true">
            <defs>
                <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" stop-color="#7655ff" stop-opacity="0.8" />
                    <stop offset="100%" stop-color="#4fd1c5" stop-opacity="0.2" />
                </linearGradient>
            </defs>
            {{-- Curved path from NY to London --}}
            <path d="M 25% 30% Q 40% 15% 55% 25%" fill="none" stroke="url(#lineGrad)" stroke-width="1.5" stroke-dasharray="4 4" class="map-line opacity-50" />
            {{-- Curved path from London to Singapore --}}
            <path d="M 55% 25% Q 65% 35% 75% 45%" fill="none" stroke="url(#lineGrad)" stroke-width="1.5" stroke-dasharray="4 4" class="map-line opacity-30" />
        </svg>

    </div>

    {{-- Bottom Fade to blend into next section --}}
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#050505] to-transparent pointer-events-none z-30"></div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
        // Animate the connection lines drawing in when scrolled into view
        gsap.from('.map-line', {
            scrollTrigger: {
                trigger: '.map-line',
                start: 'top 80%',
            },
            strokeDashoffset: 100,
            duration: 2,
            ease: 'power2.out',
            stagger: 0.5
        });
    }
});
</script>
@endpush
