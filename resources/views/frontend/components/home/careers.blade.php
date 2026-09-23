<section class="bg-[#0a0a0a] py-10 md:py-24 overflow-hidden relative border-t border-white/10">
    
    {{-- Background Ambient Glow --}}
    <div class="absolute top-1/2 left-1/4 -translate-y-1/2 w-72 md:w-96 h-72 md:h-96 bg-[#4fd1c5]/10 rounded-full blur-[80px] md:blur-[120px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
        
        {{-- =========================================================
             MOBILE ONLY: Immersive Background Hero Card (md:hidden)
             ========================================================= --}}
        <div class="md:hidden relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl p-6 flex flex-col justify-center min-h-[360px] bg-[#111]">
            
            {{-- Background Image --}}
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1000" 
                 alt="Team Collaboration" 
                 class="absolute inset-0 w-full h-full object-cover object-center pointer-events-none">

            {{-- Dark cinematic multi-gradient overlay --}}
            <div class="absolute inset-0 bg-gradient-to-r from-black/95 via-black/85 to-black/60 pointer-events-none"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-transparent to-transparent pointer-events-none"></div>
            <div class="absolute top-0 right-0 w-60 h-60 bg-[#4fd1c5]/15 rounded-full blur-[80px] pointer-events-none"></div>

            {{-- Content --}}
            <div class="relative z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#4fd1c5]/10 border border-[#4fd1c5]/30 text-[#4fd1c5] font-bold tracking-widest uppercase text-[10px] mb-3">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5] animate-pulse"></span> We Are Hiring
                </span>

                <h2 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight leading-tight mb-3">
                    Join Our Dynamic Team of Innovators
                </h2>

                <p class="text-gray-300 text-xs sm:text-sm mb-4 leading-relaxed">
                    We always welcome talented professionals to strengthen our engineering, design, and growth squads. Shape the future of global SaaS with us.
                </p>

                {{-- Perk Badges --}}
                <div class="flex flex-wrap gap-2 mb-5">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-white text-[10px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Remote-First
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-white text-[10px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Competitive Pay
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 backdrop-blur-md border border-white/10 text-white text-[10px] font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Global Impact
                    </span>
                </div>

                <div>
                    <a href="{{ url('/careers') }}" class="bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-3 px-6 text-xs rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-[0_0_25px_rgba(79,209,197,0.4)] inline-flex items-center gap-2">
                        <span>Visit Careers</span>
                        <span class="text-base font-bold">→</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- =========================================================
             DESKTOP ONLY: Clean 2-Column Side-by-Side Layout (hidden md:grid)
             ========================================================= --}}
        <div class="hidden md:grid grid-cols-2 gap-12 lg:gap-16 items-center">
            
            {{-- Left Content --}}
            <div class="flex flex-col items-start">
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-3 block">Join Our Team</span>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight mb-6">
                    Join Our Dynamic Team of Innovators
                </h2>
                <p class="text-gray-400 text-base mb-8 max-w-lg leading-relaxed">
                    We always welcome talented professionals to strengthen our team. Shape the future of SaaS and digital transformation with us.
                </p>

                {{-- Perk Badges --}}
                <div class="flex flex-wrap gap-2.5 mb-8">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-white text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Remote-First
                    </span>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-white text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Competitive Pay
                    </span>
                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/5 border border-white/10 text-white text-xs font-semibold">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#4fd1c5]"></span> Global Impact
                    </span>
                </div>

                <a href="{{ url('/careers') }}" class="bg-[#4fd1c5] hover:bg-[#38b2a6] text-black font-extrabold py-4 px-8 text-sm rounded-full transition-all duration-300 transform hover:scale-105 hover:shadow-[0_0_25px_rgba(79,209,197,0.4)] inline-flex items-center gap-2">
                    <span>Visit Careers</span>
                    <span class="text-base font-bold">→</span>
                </a>
            </div>

            {{-- Right Clean Image Container --}}
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-tr from-[#4fd1c5]/25 to-transparent rounded-3xl blur-2xl transform translate-x-4 translate-y-4"></div>
                <div class="relative rounded-3xl overflow-hidden border border-white/10 shadow-2xl group bg-[#111]">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&q=80&w=1000" alt="Team Collaboration" class="w-full h-full object-cover aspect-[4/3] group-hover:scale-105 transition-transform duration-700">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-black/0 transition-colors duration-500"></div>
                </div>
            </div>

        </div>

    </div>
</section>
