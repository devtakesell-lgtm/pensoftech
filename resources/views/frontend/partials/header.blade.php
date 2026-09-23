@php
    $isHome = request()->routeIs('home') || request()->is('/');
@endphp

<nav id="mainNav" x-data="{ mobileMenuOpen: false }"
    class="fixed top-0 left-0 w-full z-[9999] transition-all duration-300 {{ $isHome ? 'bg-transparent py-4 md:py-6' : 'bg-black/90 backdrop-blur-xl py-4 border-b border-white/10' }}"
    data-is-home="{{ $isHome ? 'true' : 'false' }}">
    <div class="max-w-7xl mx-auto px-5 lg:px-12 flex justify-between items-center relative z-[10000]">
        {{-- Logo --}}
        <a href="{{ route('home') }}"
            class="text-white font-bold text-xl md:text-2xl tracking-tighter flex items-center gap-2.5 group"
            data-cursor-expand>
            <span
                class="w-8 h-8 bg-white text-black rounded-lg flex items-center justify-center font-extrabold group-hover:bg-[#4fd1c5] transition-colors">P</span>
            <span>PenSoftTech</span>
        </a>

        {{-- Desktop Nav links --}}
        <ul class="hidden md:flex items-center gap-8 text-white/80 font-medium text-sm">
            <li><a href="{{ route('services') }}" data-cursor-expand
                    class="{{ request()->routeIs('services') ? 'text-[#4fd1c5]' : 'hover:text-[#4fd1c5]' }} transition-colors">Services</a>
            </li>
            <li><a href="{{ route('about') }}" data-cursor-expand
                    class="{{ request()->routeIs('about') ? 'text-[#4fd1c5]' : 'hover:text-[#4fd1c5]' }} transition-colors">About
                    Us</a></li>
            <li><a href="{{ route('contact') }}" data-cursor-expand
                    class="{{ request()->routeIs('contact') ? 'text-[#4fd1c5]' : 'hover:text-[#4fd1c5]' }} transition-colors">Contact</a>
            </li>
            {{-- <li><a href="{{ route('home') }}#case-studies" data-cursor-expand
                    class="{{ request()->routeIs('') ? 'text-[#4fd1c5]' : 'hover:text-[#4fd1c5]' }} transition-colors">Case
                    Studies</a></li>
            <li><a href="{{ route('about') }}" data-cursor-expand
                    class="{{ request()->routeIs('') ? 'text-[#4fd1c5]' : 'hover:text-[#4fd1c5]' }} transition-colors">Leadership</a>
            </li>
            <li><a href="{{ route('home') }}#blog" data-cursor-expand
                    class="{{ request()->routeIs('') ? 'text-[#4fd1c5]' : 'hover:text-[#4fd1c5]' }} transition-colors">Insights</a>
            </li> --}}
        </ul>

        {{-- Desktop CTA & Mobile Hamburger Wrapper --}}
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}#contact" data-cursor-expand
                class="hidden md:inline-flex items-center justify-center px-6 py-2.5 bg-white/10 border border-white/20 text-white font-semibold rounded-full hover:bg-[#4fd1c5] hover:text-black hover:border-[#4fd1c5] transition-all backdrop-blur-md text-xs md:text-sm">
                Start a Project
            </a>

            {{-- Hamburger Menu Button (Mobile) --}}
            <button type="button" @click.stop="mobileMenuOpen = !mobileMenuOpen"
                class="md:hidden flex flex-col justify-center items-center w-10 h-10 rounded-lg bg-white/10 border border-white/15 focus:outline-none transition-colors relative z-[10001]"
                :class="mobileMenuOpen ? 'bg-white/20' : ''" aria-label="Toggle navigation menu">
                <span class="bg-white block transition-all duration-300 ease-out h-0.5 w-5 rounded-sm"
                    :class="mobileMenuOpen ? 'rotate-45 translate-y-[5px]' : '-translate-y-1'"></span>
                <span class="bg-white block transition-all duration-300 ease-out h-0.5 w-5 rounded-sm"
                    :class="mobileMenuOpen ? 'opacity-0' : 'opacity-100'"></span>
                <span class="bg-white block transition-all duration-300 ease-out h-0.5 w-5 rounded-sm"
                    :class="mobileMenuOpen ? '-rotate-45 -translate-y-[5px]' : 'translate-y-1'"></span>
            </button>
        </div>
    </div>

    {{-- Full Screen Mobile Menu Overlay (App-Style List) --}}
    <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 backdrop-blur-none" x-transition:enter-end="opacity-100 backdrop-blur-xl"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 backdrop-blur-xl"
        x-transition:leave-end="opacity-0 backdrop-blur-none"
        class="fixed inset-0 bg-[#050b14]/98 z-[9999] md:hidden flex flex-col pt-24 px-6 pb-8 overflow-y-auto min-h-screen"
        style="display: none;">

        <div class="flex flex-col flex-grow mt-4" x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-500 delay-100"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">

            <h4 class="text-xs font-bold text-[#4fd1c5] tracking-widest uppercase mb-4 pl-2">Navigation</h4>
            <div class="space-y-3">
                <a href="{{ route('home') }}#ecosystem" @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg font-semibold text-white tracking-wide">Ecosystem</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('home') }}#tech" @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg font-semibold text-white tracking-wide">Tech Stack</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('home') }}#services" @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg font-semibold text-white tracking-wide">Services</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('home') }}#case-studies" @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg font-semibold text-white tracking-wide">Case Studies</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('about') }}" @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg font-semibold text-white tracking-wide">Leadership</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
                <a href="{{ route('home') }}#blog" @click="mobileMenuOpen = false"
                    class="flex items-center justify-between p-4 rounded-xl bg-white/5 border border-white/10 hover:bg-white/10 transition-colors">
                    <span class="text-lg font-semibold text-white tracking-wide">Insights & Blog</span>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Bottom Contact --}}
        <div class="mt-8 pt-8 border-t border-white/10" x-show="mobileMenuOpen"
            x-transition:enter="transition ease-out duration-500 delay-200"
            x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0">
            <a href="{{ route('home') }}#contact" @click="mobileMenuOpen = false"
                class="block w-full py-4 text-center rounded-xl bg-gradient-to-r from-[#4fd1c5] to-[#38b2a6] text-black font-bold text-lg mb-4 shadow-[0_0_20px_rgba(79,209,197,0.2)]">
                Contact Us
                <span class="block text-[10px] font-bold text-black/60 mt-0.5 uppercase tracking-widest">Let's
                    Connect</span>
            </a>
            <p class="text-center text-gray-400 text-sm">or email us: <span
                    class="text-white font-semibold">hello@pensoftech.com</span></p>
        </div>
    </div>
</nav>
