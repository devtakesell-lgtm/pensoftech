<section class="bg-black py-10 md:py-24 overflow-hidden border-t border-white/10 relative">
    
    {{-- Glow effect --}}
    <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-[#4fd1c5]/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-12 text-center relative z-10">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-3 block">Target Markets</span>
        <h2 class="text-2xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight">
            Industries We Serve
        </h2>
        <p class="text-gray-400 mt-2 max-w-xl mx-auto text-xs md:text-base leading-relaxed">
            Tailored SaaS solutions driving digital transformation across key sectors.
        </p>
    </div>

    @php
        $industries = [
            ['icon' => '🏦', 'title' => 'FinTech', 'desc' => 'Global FinTech: Payments & Security. Scalable platforms for the future of finance.'],
            ['icon' => '⚕️', 'title' => 'Healthcare', 'desc' => 'HealthTech & MedTech. Innovating patient care with robust, compliant platforms.'],
            ['icon' => '🛒', 'title' => 'E-Commerce', 'desc' => 'E-Commerce & Retail. Optimizing digital stores for hyper-growth and conversion.'],
            ['icon' => '🏢', 'title' => 'B2B SaaS', 'desc' => 'B2B SaaS Excellence. Transforming businesses with scalable software solutions.'],
            ['icon' => '🚚', 'title' => 'Logistics', 'desc' => 'Logistics & Supply Chain. Streamlining operations and tracking with technology.'],
            ['icon' => '🧠', 'title' => 'AI & Data', 'desc' => 'AI, ML & Big Data. Leveraging data intelligence for smarter, predictive SaaS.'],
            ['icon' => '🎓', 'title' => 'Education', 'desc' => 'EdTech & Learning. Engaging platforms for modern digital education.'],
            ['icon' => '🏠', 'title' => 'Real Estate', 'desc' => 'PropTech Solutions. Digitizing property management and real estate transactions.']
        ];
    @endphp

    <div class="max-w-7xl mx-auto px-5 lg:px-12 relative z-10">
        {{-- Responsive 2-column mobile, 4-column desktop glass grid --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            
            @foreach($industries as $industry)
            <div class="group relative p-[1px] rounded-2xl bg-white/10 hover:bg-gradient-to-br hover:from-[#4fd1c5]/60 hover:to-transparent transition-all duration-500 cursor-pointer">
                <div class="relative h-full bg-[#0a0a0a]/90 backdrop-blur-md rounded-2xl p-4 sm:p-5 md:p-8 overflow-hidden transition-all duration-500 group-hover:bg-[#0a0a0a]/70 flex flex-col justify-between">
                    
                    {{-- Inner subtle glow on hover --}}
                    <div class="absolute inset-0 bg-[#4fd1c5]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>
                    
                    <div class="relative z-10">
                        {{-- Icon Box --}}
                        <div class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-xl sm:text-2xl md:text-3xl mb-3 md:mb-6 group-hover:border-[#4fd1c5]/40 group-hover:scale-110 group-hover:bg-[#4fd1c5]/10 transition-all duration-300">
                            {{ $industry['icon'] }}
                        </div>

                        {{-- Title --}}
                        <h3 class="text-sm sm:text-base md:text-xl font-bold text-white mb-1.5 md:mb-3 group-hover:text-[#4fd1c5] transition-colors duration-300 tracking-tight">
                            {{ $industry['title'] }}
                        </h3>

                        {{-- Description --}}
                        <p class="text-gray-400 text-[11px] sm:text-xs md:text-sm leading-relaxed group-hover:text-gray-300 transition-colors duration-300 line-clamp-2 md:line-clamp-none">
                            {{ $industry['desc'] }}
                        </p>
                    </div>

                    {{-- Corner Arrow (Visible on desktop hover, compact icon on mobile) --}}
                    <div class="mt-3 md:mt-0 md:absolute md:top-6 md:right-6 flex items-center gap-1 text-[#4fd1c5] text-[11px] md:text-xs font-semibold md:opacity-0 md:translate-x-2 md:-translate-y-2 md:group-hover:opacity-100 md:group-hover:translate-x-0 md:group-hover:translate-y-0 transition-all duration-300">
                        <span class="md:hidden">Explore</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 md:h-5 md:w-5 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
