@extends('frontend.layouts.front-master')

@section('title', 'PenSoftTech — Scalable Software Solutions & Engineering')

@section('content')

    {{-- ============================================================
     NAVBAR (Premium Frosted Navbar with Responsive Mobile Menu)
     ============================================================ --}}
    <nav id="mainNav" x-data="{ mobileMenuOpen: false }" class="fixed top-0 left-0 w-full z-[100] transition-all duration-300 bg-transparent py-4 md:py-6">
        <div class="max-w-7xl mx-auto px-5 lg:px-12 flex justify-between items-center relative z-[101]">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="text-white font-bold text-xl md:text-2xl tracking-tighter flex items-center gap-2.5 group" data-cursor-expand>
                <span class="w-8 h-8 bg-white text-black rounded-lg flex items-center justify-center font-extrabold group-hover:bg-[#4fd1c5] transition-colors">P</span>
                <span>PenSoftTech</span>
            </a>

            {{-- Desktop Nav links --}}
            <ul class="hidden md:flex items-center gap-8 text-white/80 font-medium text-sm">
                <li><a href="#ecosystem" data-cursor-expand class="hover:text-[#4fd1c5] transition-colors">Ecosystem</a></li>
                <li><a href="#tech" data-cursor-expand class="hover:text-[#4fd1c5] transition-colors">Tech Stack</a></li>
                <li><a href="#services" data-cursor-expand class="hover:text-[#4fd1c5] transition-colors">Services</a></li>
                <li><a href="#case-studies" data-cursor-expand class="hover:text-[#4fd1c5] transition-colors">Case Studies</a></li>
                <li><a href="#team" data-cursor-expand class="hover:text-[#4fd1c5] transition-colors">Leadership</a></li>
                <li><a href="#blog" data-cursor-expand class="hover:text-[#4fd1c5] transition-colors">Insights</a></li>
            </ul>

            {{-- Desktop CTA & Mobile Hamburger Wrapper --}}
            <div class="flex items-center gap-4">
                <a href="#contact" data-cursor-expand class="hidden md:inline-flex items-center justify-center px-6 py-2.5 bg-white/10 border border-white/20 text-white font-semibold rounded-full hover:bg-[#4fd1c5] hover:text-black hover:border-[#4fd1c5] transition-all backdrop-blur-md text-xs md:text-sm">
                    Start a Project
                </a>
                
                {{-- Hamburger Menu Button (Mobile) --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden flex flex-col justify-center items-center w-10 h-10 rounded-lg bg-white/5 border border-white/10 focus:outline-none transition-colors" :class="mobileMenuOpen ? 'bg-white/10' : ''" aria-label="Toggle navigation menu">
                    <span class="bg-white block transition-all duration-300 ease-out h-0.5 w-5 rounded-sm" :class="mobileMenuOpen ? 'rotate-45 translate-y-[5px]' : '-translate-y-1'"></span>
                    <span class="bg-white block transition-all duration-300 ease-out h-0.5 w-5 rounded-sm" :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100'"></span>
                    <span class="bg-white block transition-all duration-300 ease-out h-0.5 w-5 rounded-sm" :class="mobileMenuOpen ? '-rotate-45 -translate-y-[5px]' : 'translate-y-1'"></span>
                </button>
            </div>
        </div>

        {{-- Full Screen Mobile Menu Overlay (App-Style List) --}}
        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 backdrop-blur-none"
             x-transition:enter-end="opacity-100 backdrop-blur-xl"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 backdrop-blur-xl"
             x-transition:leave-end="opacity-0 backdrop-blur-none"
             class="fixed inset-0 bg-[#050b14]/95 z-[100] md:hidden flex flex-col pt-24 px-6 pb-8 overflow-y-auto"
             style="display: none;">
            
            <div class="flex flex-col flex-grow mt-4"
                 x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-500 delay-100"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                 
                <h4 class="text-xs font-bold text-[#4fd1c5] tracking-widest uppercase mb-4 pl-2">Navigation</h4>
                <div class="space-y-3">
                    <a href="#ecosystem" @click="mobileMenuOpen = false" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="text-lg font-semibold text-white tracking-wide">Ecosystem</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#tech" @click="mobileMenuOpen = false" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="text-lg font-semibold text-white tracking-wide">Tech Stack</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#services" @click="mobileMenuOpen = false" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="text-lg font-semibold text-white tracking-wide">Services</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#case-studies" @click="mobileMenuOpen = false" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="text-lg font-semibold text-white tracking-wide">Case Studies</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#team" @click="mobileMenuOpen = false" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="text-lg font-semibold text-white tracking-wide">Leadership</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="#blog" @click="mobileMenuOpen = false" class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                        <span class="text-lg font-semibold text-white tracking-wide">Insights & Blog</span>
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            {{-- Bottom Contact --}}
            <div class="mt-8 pt-8 border-t border-white/10"
                 x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-500 delay-200"
                 x-transition:enter-start="opacity-0 translate-y-8"
                 x-transition:enter-end="opacity-100 translate-y-0">
                <a href="#contact" @click="mobileMenuOpen = false" class="block w-full py-4 text-center rounded-xl bg-gradient-to-r from-[#4fd1c5] to-[#38b2a6] text-black font-bold text-lg mb-4 shadow-[0_0_20px_rgba(79,209,197,0.2)]">
                    Contact Us
                    <span class="block text-[10px] font-bold text-black/60 mt-0.5 uppercase tracking-widest">Let's Connect</span>
                </a>
                <p class="text-center text-gray-400 text-sm">or email us: <span class="text-white font-semibold">hello@pensoftech.com</span></p>
            </div>
        </div>
    </nav>

    <main class="bg-black">
        {{-- 1. Cinematic Video Hero (Dark) --}}
        @include('frontend.components.hero')

        {{-- 2. Ecosystem (Light) --}}
        @include('frontend.components.ecosystem')

        {{-- 3. Technologies (Dark) --}}
        <div id="tech">
            @include('frontend.components.technologies')
        </div>

        {{-- 4. Services (Light) --}}
        <div id="services">
            @include('frontend.components.services')
        </div>

        {{-- 5. Projects (Dark) --}}
        <div id="projects">
            @include('frontend.components.projects')
        </div>

        {{-- 6. Case Studies (Light) --}}
        <div id="case-studies">
            @include('frontend.components.case-studies')
        </div>

        {{-- 7. Industries (Dark) --}}
        <div id="industries">
            @include('frontend.components.industries')
        </div>

        {{-- 8. Blog (Light) --}}
        <div id="blog">
            @include('frontend.components.blog')
        </div>

        {{-- 9. Careers (Dark) --}}
        <div id="careers">
            @include('frontend.components.careers')
        </div>

        {{-- 10. Leadership Team (Light) --}}
        <div id="team">
            @include('frontend.components.team')
        </div>

        {{-- 11. Company Stats (Dark Bridge) --}}
        <div id="stats">
            @include('frontend.components.stats')
        </div>

        {{-- 12. Customer Reviews (Light) --}}
        <div id="reviews">
            @include('frontend.components.reviews')
        </div>

        {{-- 13. Interactive SVG Map (Dark) --}}
        @include('frontend.components.map')

        {{-- 14. CTA Section (Dark) --}}
        <div id="contact">
            @include('frontend.components.cta')
        </div>
    </main>

    {{-- Footer (Dark Mode) --}}
    @include('frontend.components.footer')

@endsection
