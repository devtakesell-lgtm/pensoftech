<section class="bg-[#050505] py-10 md:py-24 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-16 relative z-20">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end">
            <div>
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-4 block">Global Presence</span>
                <h2 class="text-2xl md:text-5xl font-extrabold text-white tracking-tight">
                    Powering scale,<br class="hidden md:block"> worldwide.
                </h2>
            </div>
            <div class="mt-2 md:mt-0 text-gray-400">
                <p class="max-w-xs text-xs md:text-base">Operating across 3 continents, delivering enterprise solutions to clients globally.</p>
            </div>
        </div>
    </div>

    {{-- Map Container --}}
    <div class="relative w-full max-w-6xl mx-auto h-[320px] sm:h-[420px] md:h-[600px] mt-4 md:mt-10 flex items-center justify-center">
        
        {{-- World Map Base SVG --}}
        <div class="relative w-full h-full">
            <svg class="w-full h-full text-white/[0.08]" viewBox="0 0 1000 500" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                {{-- North America --}}
                <path d="M150,120 Q180,80 260,90 Q300,110 320,160 Q280,220 220,250 Q160,220 140,170 Z" fill="currentColor" opacity="0.6"/>
                <path d="M120,60 Q160,40 220,50 Q200,90 140,80 Z" fill="currentColor" opacity="0.4"/>
                
                {{-- South America --}}
                <path d="M260,280 Q320,290 340,350 Q310,440 270,470 Q240,400 250,330 Z" fill="currentColor" opacity="0.6"/>
                
                {{-- Europe --}}
                <path d="M480,100 Q540,90 570,130 Q540,180 490,170 Q460,140 480,100 Z" fill="currentColor" opacity="0.6"/>
                <path d="M450,110 Q470,90 490,110 Q470,130 450,110 Z" fill="currentColor" opacity="0.5"/>
                
                {{-- Africa --}}
                <path d="M480,200 Q560,190 590,260 Q570,360 520,390 Q470,330 460,250 Z" fill="currentColor" opacity="0.6"/>
                
                {{-- Asia --}}
                <path d="M580,90 Q720,70 850,120 Q880,220 800,280 Q700,280 620,220 Q570,160 580,90 Z" fill="currentColor" opacity="0.6"/>
                <path d="M680,240 Q740,230 760,290 Q710,320 680,270 Z" fill="currentColor" opacity="0.5"/>
                
                {{-- Australia --}}
                <path d="M780,340 Q860,330 890,380 Q860,440 800,430 Q760,390 780,340 Z" fill="currentColor" opacity="0.6"/>
            </svg>

            {{-- Dotted Matrix Overlay --}}
            <div class="absolute inset-0 opacity-25" style="background-image: radial-gradient(#4fd1c5 1px, transparent 1px); background-size: 16px 16px; mask-image: radial-gradient(ellipse at center, black 60%, transparent 85%); -webkit-mask-image: radial-gradient(ellipse at center, black 60%, transparent 85%);"></div>

            {{-- Location 1: North America (New York) --}}
            <div class="absolute top-[32%] left-[23%] -translate-x-1/2 -translate-y-1/2 group cursor-pointer z-20">
                <div class="relative w-4 h-4 md:w-5 md:h-5">
                    <div class="absolute inset-0 bg-[#4fd1c5] rounded-full opacity-75 animate-ping"></div>
                    <div class="relative w-4 h-4 md:w-5 md:h-5 bg-[#4fd1c5] rounded-full border-2 border-[#050505] shadow-[0_0_15px_#4fd1c5]"></div>
                </div>
                {{-- Tooltip --}}
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-[#111]/90 backdrop-blur-md rounded-lg border border-white/20 opacity-90 sm:opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none shadow-xl">
                    <p class="text-white text-[11px] md:text-xs font-bold">New York, USA</p>
                    <p class="text-[#4fd1c5] text-[9px] md:text-[10px]">Headquarters</p>
                </div>
            </div>

            {{-- Location 2: Europe (London) --}}
            <div class="absolute top-[26%] left-[50%] -translate-x-1/2 -translate-y-1/2 group cursor-pointer z-20">
                <div class="relative w-3.5 h-3.5 md:w-4 md:h-4">
                    <div class="absolute inset-0 bg-[#4fd1c5] rounded-full opacity-75 animate-ping" style="animation-delay: 0.4s"></div>
                    <div class="relative w-3.5 h-3.5 md:w-4 md:h-4 bg-[#4fd1c5] rounded-full border-2 border-[#050505] shadow-[0_0_15px_#4fd1c5]"></div>
                </div>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-[#111]/90 backdrop-blur-md rounded-lg border border-white/20 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none shadow-xl">
                    <p class="text-white text-[11px] md:text-xs font-bold">London, UK</p>
                    <p class="text-gray-400 text-[9px] md:text-[10px]">European Hub</p>
                </div>
            </div>

            {{-- Location 3: South Asia (Dhaka) --}}
            <div class="absolute top-[48%] left-[71%] -translate-x-1/2 -translate-y-1/2 group cursor-pointer z-20">
                <div class="relative w-4 h-4 md:w-5 md:h-5">
                    <div class="absolute inset-0 bg-[#f6c90e] rounded-full opacity-75 animate-ping" style="animation-delay: 0.8s"></div>
                    <div class="relative w-4 h-4 md:w-5 md:h-5 bg-[#f6c90e] rounded-full border-2 border-[#050505] shadow-[0_0_15px_#f6c90e]"></div>
                </div>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-[#111]/90 backdrop-blur-md rounded-lg border border-white/20 opacity-90 sm:opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none shadow-xl">
                    <p class="text-white text-[11px] md:text-xs font-bold">Dhaka, BD</p>
                    <p class="text-[#f6c90e] text-[9px] md:text-[10px]">Global Dev Center</p>
                </div>
            </div>

            {{-- Location 4: Asia (Singapore) --}}
            <div class="absolute top-[58%] left-[78%] -translate-x-1/2 -translate-y-1/2 group cursor-pointer z-20">
                <div class="relative w-3.5 h-3.5 md:w-4 md:h-4">
                    <div class="absolute inset-0 bg-[#4fd1c5] rounded-full opacity-75 animate-ping" style="animation-delay: 1.2s"></div>
                    <div class="relative w-3.5 h-3.5 md:w-4 md:h-4 bg-[#4fd1c5] rounded-full border-2 border-[#050505] shadow-[0_0_15px_#4fd1c5]"></div>
                </div>
                <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 w-max px-3 py-1.5 bg-[#111]/90 backdrop-blur-md rounded-lg border border-white/20 opacity-0 group-hover:opacity-100 transition-all duration-300 pointer-events-none shadow-xl">
                    <p class="text-white text-[11px] md:text-xs font-bold">Singapore</p>
                    <p class="text-gray-400 text-[9px] md:text-[10px]">APAC Hub</p>
                </div>
            </div>

            {{-- Connection Lines --}}
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-10" aria-hidden="true" viewBox="0 0 1000 500" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="mapLineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                        <stop offset="0%" stop-color="#4fd1c5" stop-opacity="0.9" />
                        <stop offset="50%" stop-color="#f6c90e" stop-opacity="0.8" />
                        <stop offset="100%" stop-color="#4fd1c5" stop-opacity="0.4" />
                    </linearGradient>
                </defs>
                {{-- NY to London --}}
                <path d="M 230 160 Q 360 80 500 130" fill="none" stroke="url(#mapLineGrad)" stroke-width="2" stroke-dasharray="6 4" class="opacity-70" />
                {{-- London to Dhaka --}}
                <path d="M 500 130 Q 600 160 710 240" fill="none" stroke="url(#mapLineGrad)" stroke-width="2" stroke-dasharray="6 4" class="opacity-70" />
                {{-- Dhaka to Singapore --}}
                <path d="M 710 240 Q 750 260 780 290" fill="none" stroke="url(#mapLineGrad)" stroke-width="2" stroke-dasharray="6 4" class="opacity-70" />
            </svg>
        </div>

    </div>

    {{-- Bottom Fade to blend into next section --}}
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#050505] to-transparent pointer-events-none z-30"></div>
</section>
