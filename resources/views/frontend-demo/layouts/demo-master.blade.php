<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PenSoftTech') — New Design Demo</title>
    <meta name="description" content="PenSoftTech — Software Development & Digital Marketing. New design concept.">
    <meta name="robots" content="noindex, nofollow">

    <!-- Fonts: Plus Jakarta Sans + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet">

    <!-- Swiper CSS — Demo only, loaded via CDN as approved in coding-rules Section 26 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

    @vite(['resources/css/demo/app.css'])
    @stack('styles')
</head>

<body class="demo-body">

    {{-- Custom cursor elements --}}
    <div class="demo-cursor" id="demoCursor"></div>
    <div class="demo-cursor-trail" id="demoCursorTrail"></div>

    @yield('content')

    {{-- GSAP + ScrollTrigger — Demo only, loaded via CDN as approved in coding-rules Section 26 --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    {{-- Swiper JS — Demo only --}}
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- Lenis Smooth Scroll — Demo only --}}
    <script src="https://cdn.jsdelivr.net/npm/@studio-freight/lenis@1.0.42/dist/lenis.min.js"></script>

    @vite(['resources/js/demo/app.js'])
    @stack('scripts')
</body>

</html>
