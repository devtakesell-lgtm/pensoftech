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
        {{-- 1. Cinematic Video Hero (Dark) --}}
        @include('frontend-demo.components.hero')

        {{-- 2. Ecosystem (Light) --}}
        @include('frontend-demo.components.ecosystem')

        {{-- 3. Technologies (Dark) --}}
        <div id="tech">
            @include('frontend-demo.components.technologies')
        </div>

        {{-- 4. Services (Light) --}}
        <div id="services">
            @include('frontend-demo.components.services')
        </div>

        {{-- 5. Projects (Dark) --}}
        <div id="projects">
            @include('frontend-demo.components.projects')
        </div>

        {{-- 6. Case Studies (Light) --}}
        <div id="case-studies">
            @include('frontend-demo.components.case-studies')
        </div>

        {{-- 7. Industries (Dark) --}}
        <div id="industries">
            @include('frontend-demo.components.industries')
        </div>

        {{-- 8. Blog (Light) --}}
        <div id="blog">
            @include('frontend-demo.components.blog')
        </div>

        {{-- 9. Careers (Dark) --}}
        <div id="careers">
            @include('frontend-demo.components.careers')
        </div>

        {{-- 10. Leadership Team (Light) --}}
        <div id="team">
            @include('frontend-demo.components.team')
        </div>

        {{-- 11. Company Stats (Dark Bridge) --}}
        <div id="stats">
            @include('frontend-demo.components.stats')
        </div>

        {{-- 12. Customer Reviews (Light) --}}
        <div id="reviews">
            @include('frontend-demo.components.reviews')
        </div>

        {{-- 13. Interactive SVG Map (Dark) --}}
        @include('frontend-demo.components.map')

        {{-- 14. CTA Section (Dark) --}}
        @include('frontend-demo.components.cta')
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
