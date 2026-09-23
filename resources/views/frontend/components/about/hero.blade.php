<section class="relative w-full h-[80vh] min-h-[600px] overflow-hidden bg-black flex items-center justify-center pt-20">
    {{-- Background Image --}}
    <div class="absolute inset-0 z-0 w-full h-full">
        <img class="absolute inset-0 w-full h-full object-cover opacity-50 scale-105" 
             src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&auto=format&fit=crop&w=2850&q=80" 
             alt="Team Collaboration">
        {{-- Gradient Overlay for readability --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-black/80 via-transparent to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 w-full max-w-7xl mx-auto px-6 lg:px-12 flex flex-col justify-center h-full pb-10">
        <div class="max-w-4xl text-center mx-auto">
            <h1 class="text-white text-5xl sm:text-6xl md:text-7xl font-bold tracking-tighter uppercase mb-6" data-aos="fade-up">
                We Are <span class="text-[#4fd1c5]">PenSoftTech</span>
            </h1>
            <p class="text-base sm:text-lg md:text-2xl text-white/80 max-w-2xl mx-auto font-medium" data-aos="fade-up" data-aos-delay="100">
                A collective of engineers, designers, and strategists driven by a singular mission: to build digital products that define the future.
            </p>
        </div>
    </div>
</section>
