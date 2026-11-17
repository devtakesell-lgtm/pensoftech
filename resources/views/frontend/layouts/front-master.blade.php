<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- 1. Browser Tab Title --}}
    <title>@yield('title', setting('seo_meta_title', setting('company_name', 'PenSoftTech') . ' — Scalable Software & Digital Transformation'))</title>

    {{-- 2. Search Engine Meta Tags --}}
    <meta name="title" content="@yield('meta_title', View::yieldContent('title', setting('seo_meta_title', setting('company_name', 'PenSoftTech'))))">
    <meta name="description" content="@yield('meta_description', View::yieldContent('description', setting('seo_meta_description', 'PenSoftTech specializes in launching and scaling world-class B2B SaaS platforms with expert product, engineering, and growth strategies.')))">
    <meta name="keywords" content="@yield('meta_keywords', View::yieldContent('keywords', setting('seo_meta_keywords', 'software development, SaaS, cloud architecture, UI/UX design, digital transformation')))">
    <meta name="robots" content="@yield('robots', 'index, follow')">
    <link rel="canonical" href="@yield('canonical_url', View::yieldContent('canonical', url()->current()))">

    {{-- 3. Open Graph / Social Sharing (Facebook, LinkedIn, Discord) --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', View::yieldContent('meta_title', View::yieldContent('title', setting('seo_meta_title', setting('company_name', 'PenSoftTech')))))">
    <meta property="og:description" content="@yield('og_description', View::yieldContent('meta_description', View::yieldContent('description', setting('seo_meta_description', 'Crafting exceptional digital experiences that drive exponential growth.'))))">
    <meta property="og:image" content="@yield('og_image', url(setting('seo_og_image', '/default-og.jpg')))">
    <meta property="og:url" content="@yield('og_url', url()->current())">

    {{-- 4. Twitter Cards (X / Twitter) --}}
    <meta name="twitter:card" content="@yield('twitter_card', 'summary_large_image')">
    <meta name="twitter:title" content="@yield('og_title', View::yieldContent('meta_title', View::yieldContent('title', setting('seo_meta_title', setting('company_name', 'PenSoftTech')))))">
    <meta name="twitter:description" content="@yield('og_description', View::yieldContent('meta_description', View::yieldContent('description', setting('seo_meta_description', 'Crafting exceptional digital experiences that drive exponential growth.'))))">
    <meta name="twitter:image" content="@yield('og_image', url(setting('seo_og_image', '/default-og.jpg')))">

    {{-- 5. Structured Data (JSON-LD Schema) --}}
    @yield('seo_schema')

    <!-- Fonts: Plus Jakarta Sans + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

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
    <x-frontend.footer />

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
