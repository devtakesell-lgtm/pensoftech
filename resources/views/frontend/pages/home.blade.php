@extends('frontend.layouts.front-master')

@section('title', 'PenSoftTech — Scalable Software Solutions & Engineering')

@section('content')

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
        {{-- <!-- @include('frontend.components.map') --> --}}

        {{-- 14. CTA Section (Dark) --}}
        <div id="contact">
            @include('frontend.components.cta')
        </div>
    </main>



@endsection
