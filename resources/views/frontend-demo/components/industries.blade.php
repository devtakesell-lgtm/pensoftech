<section class="bg-black py-24 md:py-32 overflow-hidden border-t border-white/10 relative">
    
    {{-- Glow effect --}}
    <div class="absolute bottom-0 left-0 w-1/3 h-1/3 bg-[#4fd1c5]/10 rounded-full blur-[150px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-6 lg:px-12 mb-16 text-center relative z-10">
        <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-sm mb-4 block">Target Markets</span>
        <h2 class="text-4xl md:text-5xl font-bold text-white tracking-tight">
            Industries We Serve
        </h2>
        <p class="text-gray-400 mt-6 max-w-2xl mx-auto text-lg">
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

    <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            @foreach($industries as $industry)
            <div class="group relative p-[1px] rounded-2xl bg-white/5 hover:bg-gradient-to-br hover:from-[#4fd1c5]/50 hover:to-transparent transition-all duration-500 cursor-pointer">
                <div class="relative h-full bg-[#0a0a0a] rounded-2xl p-8 overflow-hidden transition-all duration-500 group-hover:bg-[#0a0a0a]/90">
                    
                    {{-- Inner subtle glow on hover --}}
                    <div class="absolute inset-0 bg-[#4fd1c5]/5 opacity-0 group-hover:opacity-100 transition-opacity duration-500 blur-xl"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-3xl mb-6 group-hover:border-[#4fd1c5]/30 group-hover:scale-110 transition-all duration-300">
                            {{ $industry['icon'] }}
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3 group-hover:text-[#4fd1c5] transition-colors duration-300">{{ $industry['title'] }}</h3>
                        <p class="text-gray-400 text-sm leading-relaxed group-hover:text-gray-300 transition-colors duration-300">
                            {{ $industry['desc'] }}
                        </p>
                    </div>

                    {{-- Corner arrow --}}
                    <div class="absolute top-6 right-6 opacity-0 translate-x-2 -translate-y-2 group-hover:opacity-100 group-hover:translate-x-0 group-hover:translate-y-0 transition-all duration-300 text-[#4fd1c5]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </div>

                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
