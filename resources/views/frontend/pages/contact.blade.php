@extends('frontend.layouts.front-master')

@section('title', 'Contact Us — PenSoftTech')

@section('content')

    <main class="bg-black">
        {{-- 1. Contact Hero (Dark) --}}
        @include('frontend.components.contact.hero')

        {{-- 2. Form & Contact Info (Light) --}}
        <div id="contact-form">
            @include('frontend.components.contact.form-section')
        </div>

        {{-- 3. Global Presence / Map (Dark) --}}
        <div id="locations">
            @include('frontend.components.home.map')
        </div>

        {{-- 4. FAQ / What Happens Next (Light) --}}
        <div id="faq">
            @include('frontend.components.contact.faq')
        </div>
    </main>

@endsection
