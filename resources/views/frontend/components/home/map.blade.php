<section class="bg-[#050505] py-10 md:py-24 overflow-hidden relative">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 mb-6 md:mb-16 relative z-20">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end">
            <div>
                <span class="text-[#4fd1c5] font-bold tracking-widest uppercase text-xs md:text-sm mb-1.5 md:mb-4 block">Our Headquarters</span>
                <h2 class="text-2xl md:text-5xl font-extrabold text-white tracking-tight">
                    Visit us at our<br class="hidden md:block"> office.
                </h2>
            </div>
            <div class="mt-2 md:mt-0 text-gray-400">
                <p class="max-w-xs text-xs md:text-base">We're always open for a cup of coffee and a great conversation.</p>
            </div>
        </div>
    </div>

    {{-- Map Container --}}
    <div class="relative w-full max-w-5xl mx-auto h-[200px] sm:h-[250px] md:h-[320px] mt-4 md:mt-10 rounded-2xl overflow-hidden border border-white/10 shadow-2xl">
        {{-- Google Maps Embed --}}
        <iframe 
            src="https://maps.google.com/maps?q=23.77880197600973,90.35603828071379&z=15&output=embed" 
            class="w-full h-full border-0 opacity-80 hover:opacity-100 transition-opacity duration-500" 
            allowfullscreen="" 
            loading="lazy" 
            referrerpolicy="no-referrer-when-downgrade">
        </iframe>
    </div>

    {{-- Bottom Fade to blend into next section --}}
    <div class="absolute bottom-0 left-0 w-full h-32 bg-gradient-to-t from-[#050505] to-transparent pointer-events-none z-30"></div>
</section>
