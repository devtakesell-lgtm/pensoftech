<section class="relative w-full h-screen overflow-hidden bg-black flex items-center justify-center">
    {{-- Background Video --}}
    <div class="absolute inset-0 z-0 w-full h-full">
        {{-- Video scales down on load for a cinematic effect --}}
        <video id="heroVideo" autoplay loop muted playsinline class="absolute inset-0 w-full h-full object-cover opacity-60 scale-110 origin-center" 
            src="https://videos.pexels.com/video-files/3129957/3129957-hd_1920_1080_25fps.mp4">
        </video>
        {{-- Gradient Overlay for readability --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-transparent to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12 flex flex-col justify-end h-full pb-20 md:pb-32">
        <div class="max-w-4xl">
            <h1 class="text-white text-5xl sm:text-6xl md:text-7xl lg:text-[8rem] font-bold tracking-tighter leading-[0.9] uppercase">
                <span class="block overflow-hidden"><span class="hero-text-line block translate-y-full">Limitless,</span></span>
                <span class="block overflow-hidden"><span class="hero-text-line block translate-y-full text-[#4fd1c5]">Together.</span></span>
            </h1>
            <p class="hero-subtext mt-6 md:mt-8 text-base sm:text-lg md:text-2xl text-white/80 max-w-2xl font-medium opacity-0 translate-y-4">
                Asia's fastest-growing IT ecosystem. We build custom software and digital marketing engines that scale enterprise revenue.
            </p>
            <div class="hero-buttons mt-8 md:mt-10 flex flex-col sm:flex-row gap-4 opacity-0 translate-y-4">
                <a href="#ecosystem" data-cursor-expand class="px-8 py-4 bg-white text-black font-semibold rounded-full hover:bg-[#4fd1c5] hover:text-white transition-colors duration-300 text-center">
                    Explore Ecosystem
                </a>
                <a href="#work" data-cursor-expand class="px-8 py-4 bg-white/10 border border-white/20 text-white font-semibold rounded-full hover:bg-white/20 transition-colors duration-300 backdrop-blur-sm text-center">
                    View Our Work
                </a>
            </div>
        </div>
    </div>

    {{-- Scroll Indicator --}}
    <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10 flex flex-col items-center opacity-70">
        <span class="text-white/50 text-xs tracking-[0.2em] uppercase mb-3">Scroll</span>
        <div class="w-[1px] h-16 bg-white/20 overflow-hidden">
            <div class="w-full h-1/2 bg-white hero-scroll-line"></div>
        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    if (typeof gsap !== 'undefined') {
        const tl = gsap.timeline({ delay: 0.2 });
        
        // Video cinematic scale down
        tl.to('#heroVideo', {
            scale: 1,
            duration: 2.5,
            ease: 'power3.out'
        }, 0);

        // Text reveal
        tl.to('.hero-text-line', {
            y: '0%',
            duration: 1.2,
            stagger: 0.15,
            ease: 'power4.out'
        }, 0.3);

        // Subtext & Buttons fade in
        tl.to('.hero-subtext, .hero-buttons', {
            opacity: 1,
            y: 0,
            duration: 1,
            stagger: 0.2,
            ease: 'power3.out'
        }, 1);

        // Scroll indicator animation
        gsap.to('.hero-scroll-line', {
            y: 64,
            duration: 1.5,
            ease: 'power2.inOut',
            repeat: -1
        });
    }
});
</script>
@endpush
