<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PenSoftTech — Scalable Software & Digital Transformation')</title>
    <meta name="description"
        content="@yield('description', 'PenSoftTech specializes in launching and scaling world-class B2B SaaS platforms with expert product, engineering, and growth strategies.')">
    <link rel="canonical" href="{{ config('app.url') }}">

    <!-- Open Graph / Meta -->
    <meta property="og:type" content="website">
    <meta property="og:title" content="PenSoftTech — Scalable Software Solutions">
    <meta property="og:description" content="Crafting exceptional digital experiences that drive exponential growth.">
    <meta property="og:url" content="{{ config('app.url') }}">

    <!-- Fonts: Plus Jakarta Sans + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Swiper CSS (CDN) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    @vite(['resources/css/frontend/app.css'])
    @stack('styles')
</head>

<body class="bg-black text-gray-100 antialiased selection:bg-[#4fd1c5] selection:text-black">

    {{-- Custom cursor elements --}}
    <div class="frontend-cursor hidden lg:block" id="frontendCursor"></div>
    <div class="frontend-cursor-trail hidden lg:block" id="frontendCursorTrail"></div>
    {{-- Header --}}
    @include('frontend.partials.header')

    {{-- Main Content --}}
    @yield('content')

    {{-- Footer (Dark Mode) --}}
    @include('frontend.partials.footer')

    {{-- Alpine JS for UI state --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- GSAP + ScrollTrigger --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    {{-- Swiper JS --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- Lenis Smooth Scroll --}}
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    @vite(['resources/js/frontend/app.js'])
    @stack('scripts')
</body>

</html>
