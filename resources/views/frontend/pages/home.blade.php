@extends('frontend.layouts.front-master')

@section('title', 'PenSoftTech — Scalable Software Solutions & Engineering')

@section('content')

    <main class="bg-black">
        {{-- 1. Cinematic Video Hero (Dark) --}}

        <h1>PenSoftTech Manchur</h1>
        @include('frontend.components.home.hero')

        {{-- 2. Ecosystem (Light) --}}
        @include('frontend.components.home.ecosystem')

        {{-- 3. Technologies (Dark) --}}
        <div id="tech">
            @include('frontend.components.home.technologies')
        </div>

        {{-- 4. Services (Light) --}}
        <div id="services">
            @include('frontend.components.home.services')
        </div>

        {{-- 5. Projects (Dark) --}}
        <div id="projects">
            @include('frontend.components.home.projects')
        </div>

        {{-- 6. Case Studies (Light) --}}
        <div id="case-studies">
            @include('frontend.components.home.case-studies')
        </div>

        {{-- 7. Industries (Dark) --}}
        <div id="industries">
            <x-frontend.home.industries />
        </div>

        {{-- 8. Blog (Light) --}}
        <div id="blog">
            @include('frontend.components.home.blog')
        </div>

        {{-- 9. Careers (Dark) --}}
        <div id="careers">
            @include('frontend.components.home.careers')
        </div>

        {{-- 10. Leadership Team (Light) --}}
        @if ($teamMemberExists)
            <div id="team">
                <x-frontend.team />
            </div>
        @endif

        {{-- 11. Company Stats (Dark Bridge) --}}
        <div id="stats">
            @include('frontend.components.global.stats')
        </div>

        {{-- 12. Customer Reviews (Light) --}}
        <div id="reviews">
            @include('frontend.components.home.reviews')
        </div>

        {{-- 13. Interactive SVG Map (Dark) --}}
        {{-- <!-- @include('frontend.components.home.map') --> --}}

        {{-- 14. CTA Section (Dark) --}}
        <div id="contact">
            @include('frontend.components.global.cta')
        </div>
    </main>



@endsection
