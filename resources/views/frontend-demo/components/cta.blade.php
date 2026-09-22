<section class="bg-[#0b1120] py-32 relative overflow-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/demo/cta-bg.jpg') }}');">
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-3/4 h-1 bg-gradient-to-r from-transparent via-[#4fd1c5]/50 to-transparent blur-sm"></div>
    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/2 h-px bg-gradient-to-r from-transparent via-[#4fd1c5] to-transparent"></div>

    {{-- Center radial glow --}}
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-[#4fd1c5]/5 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-5xl md:text-7xl font-bold text-white tracking-tight mb-8 drop-shadow-sm">
            Let's build something <br class="hidden md:block"/>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white via-[#4fd1c5] to-[#4fd1c5]">amazing together</span>
        </h2>
        <p class="text-lg md:text-xl text-gray-400 mb-12 max-w-2xl mx-auto font-medium">
            Partner with PenSoftTech to turn your vision into innovative, scalable software solutions. From strategy to execution, we craft exceptional digital experiences that drive growth.
        </p>
        <div class="flex justify-center">
            <a href="#contact" class="group relative inline-flex items-center justify-center px-10 py-4 font-bold text-black transition-all duration-300 bg-[#4fd1c5] rounded-full hover:bg-[#38b2a6] hover:shadow-[0_0_40px_rgba(79,209,197,0.4)] hover:-translate-y-1">
                <span>GET IN TOUCH</span>
                <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </a>
        </div>
    </div>
</section>
