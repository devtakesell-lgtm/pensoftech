@extends('frontend.layouts.front-master')

@section('title', 'About Us — PenSoftTech')

@section('content')

    <main class="bg-black">
        {{-- 1. About Hero (Dark) --}}
        @include('frontend.components.about.hero')

        {{-- 2. Our Story (Light) --}}
        <div id="story">
            @include('frontend.components.about.story')
        </div>

        {{-- 3. Core Values (Dark) --}}
        <div id="values">
            @include('frontend.components.about.values')
        </div>

        {{-- 4. Leadership Team (Light) --}}
        <div id="team">
            @include('frontend.components.global.team')
        </div>

        {{-- 5. Company Stats (Dark Bridge) --}}
        <div id="stats">
            @include('frontend.components.global.stats')
        </div>

        {{-- 6. CTA Section (Dark) --}}
        <div id="contact">
            @include('frontend.components.global.cta')
        </div>
    </main>

@endsection
