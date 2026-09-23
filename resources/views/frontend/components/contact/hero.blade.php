<section class="relative w-full h-[60vh] min-h-[500px] overflow-hidden bg-black flex items-center justify-center pt-20">
    {{-- Background Image --}}
    <div class="absolute inset-0 z-0 w-full h-full">
        <img class="absolute inset-0 w-full h-full object-cover opacity-40 scale-105" 
             src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80" 
             alt="Contact Us Background">
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12 flex flex-col justify-center h-full pb-10 text-center">
        <h1 class="text-white text-5xl sm:text-6xl md:text-7xl font-bold tracking-tighter uppercase mb-6" data-aos="fade-up">
            Let's <span class="text-[#4fd1c5]">Talk</span>
        </h1>
        <p class="text-base sm:text-lg md:text-2xl text-white/80 max-w-2xl mx-auto font-medium" data-aos="fade-up" data-aos-delay="100">
            Whether you have a specific project in mind or just want to explore possibilities, we're ready to listen.
        </p>
    </div>
</section>
