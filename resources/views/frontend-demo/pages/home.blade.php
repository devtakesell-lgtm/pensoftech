@extends('frontend-demo.layouts.demo-master')

@section('title', 'PenSoftTech — World-Class Design Demo')

@section('content')

    {{-- ============================================================
     NAVBAR (Simplified Premium Dark Navbar for the demo)
     ============================================================ --}}
    <nav id="demoNav" class="fixed top-0 left-0 w-full z-50 transition-all duration-300 bg-transparent py-6">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex justify-between items-center">
            {{-- Logo --}}
            <a href="{{ route('demo.home') }}" class="text-white font-bold text-2xl tracking-tighter flex items-center gap-2 group" data-cursor-expand>
                <span class="w-8 h-8 bg-white text-black rounded-lg flex items-center justify-center font-extrabold group-hover:bg-[#4fd1c5] transition-colors">P</span>
                PenSoftTech
            </a>

            {{-- Nav links --}}
            <ul class="hidden md:flex items-center gap-8 text-white/80 font-medium text-sm">
                <li><a href="#ecosystem" data-cursor-expand class="hover:text-white transition-colors">Ecosystem</a></li>
                <li><a href="#tech" data-cursor-expand class="hover:text-white transition-colors">Tech</a></li>
                <li><a href="#team" data-cursor-expand class="hover:text-white transition-colors">Team</a></li>
            </ul>

            {{-- CTA --}}
            <a href="#contact" data-cursor-expand class="hidden md:inline-flex items-center justify-center px-6 py-2.5 bg-white/10 border border-white/20 text-white font-semibold rounded-full hover:bg-white hover:text-black transition-colors backdrop-blur-md">
                Start a Project
            </a>
        </div>
    </nav>

    <main class="bg-black">
        {{-- 1. Cinematic Video Hero --}}
        @include('frontend-demo.components.hero')

        {{-- 2. Ecosystem Sticky Reveal (Light Mode) --}}
        @include('frontend-demo.components.ecosystem')

        {{-- 3. Our Services Grid (Light Mode) --}}
        <div id="services">
            @include('frontend-demo.components.services')
        </div>

        {{-- 4. Careers / Join Our Team (Dark Mode) --}}
        <div id="careers">
            @include('frontend-demo.components.careers')
        </div>

        {{-- 5. Leadership Team Swiper (Light Mode) --}}
        <div id="team">
            @include('frontend-demo.components.team')
        </div>

        {{-- 6. Tech Stack Marquee (Light Mode) --}}
        <div id="tech">
            @include('frontend-demo.components.technologies')
        </div>

        {{-- 7. Customer Reviews (Light Mode) --}}
        <div id="reviews">
            @include('frontend-demo.components.reviews')
        </div>

        {{-- 8. Interactive SVG Map (Dark Mode) --}}
        @include('frontend-demo.components.map')
    </main>

    {{-- Footer (Dark Mode) --}}
    @include('frontend-demo.components.footer')

@endsection

@push('scripts')
<script>
    // Navbar scroll effect
    const navbar = document.getElementById('demoNav');
    if (navbar) {
        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                navbar.classList.remove('bg-transparent', 'py-6');
                navbar.classList.add('bg-black/80', 'backdrop-blur-xl', 'py-4', 'border-b', 'border-white/10');
            } else {
                navbar.classList.add('bg-transparent', 'py-6');
                navbar.classList.remove('bg-black/80', 'backdrop-blur-xl', 'py-4', 'border-b', 'border-white/10');
            }
        }, { passive: true });
    }
</script>
@endpush
