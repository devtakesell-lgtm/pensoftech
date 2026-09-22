<section class="py-10 md:py-24 relative overflow-hidden bg-black border-t border-white/10">
    <div class="max-w-7xl mx-auto px-5 lg:px-12">
        
        {{-- Immersive Background Hero Card --}}
        <div class="relative rounded-2xl md:rounded-3xl overflow-hidden border border-white/15 shadow-2xl p-6 sm:p-10 md:p-16 flex flex-col justify-center min-h-[360px] md:min-h-[460px] bg-cover bg-center group"
             style="background-image: url('https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1400');">
            
            {{-- Dark cinematic multi-gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/95 via-black/85 to-black/60 sm:to-black/40"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent"></div>
            <div class="absolute top-0 right-0 w-80 h-80 bg-[#4fd1c5]/15 rounded-full blur-[100px] pointer-events-none"></div>

            {{-- Content --}}
            <div class="relative z-10 max-w-xl">
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-[#4fd1c5]/10 border border-[#4fd1c5]/30 text-[#4fd1c5] font-bold tracking-widest uppercase text-[10px] sm:text-xs mb-3 md:mb-4">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5] animate-pulse"></span> We Are Hiring
                </span>

                <h2 class="text-2xl sm:text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight mb-3 md:mb-5">
                    Join Our Dynamic Team of Innovators
                </h2>

                <p class="text-gray-300 text-xs sm:text-sm md:text-base mb-5 md:mb-8 leading-relaxed">
                    We always welcome talented professionals to strengthen our engineering, design, and growth squads. Shape the future of global SaaS with us.
                </p>

                {{-- Perk Badges --}}
                <div class="flex flex-wrap gap-2 mb-6 md:mb-8">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white text-[10px] sm:text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Remote-First
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white text-[10px] sm:text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Competitive Pay
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-white text-[10px] sm:text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Global Impact
                    </span>
                </div>

                <div>
                    <a href="{{ url('/careers') }}" class="bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-3 px-7 md:py-4 md:px-9 text-xs md:text-sm rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-[0_0_30px_rgba(79,209,197,0.5)] inline-flex items-center gap-2">
                        <span>Explore Open Roles</span>
                        <span class="text-base font-bold">→</span>
                    </a>
                </div>
            </div>

        </div>

    </div>
</section>
