<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'PenSoftTech') - PenSoftTech</title>
    <meta
        name="description"
        content="PenSoftTech is a software development and digital marketing agency that provides custom software solutions, web and mobile app development, SEO, PPC, and other digital marketing services to help businesses grow online."
    >
    <meta name="keywords" content="software development company, digital marketing agency, PenSoftTech, web development, mobile app development, SEO agency, PPC agency, custom software">
    <link rel="canonical" href="{{ config('app.url') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="PenSoftTech - Software Development & Digital Marketing Agency">
    <meta property="og:description" content="Custom software and digital marketing under one accountable roof. Explore both PenSoftTech verticals.">
    <meta property="og:url" content="{{ config('app.url') }}">
    <link rel="icon" href="data:,">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/frontend/app.css', 'resources/js/frontend/app.js'])
    @stack('styles')
</head>
<body>
    @include('frontend.partials.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @stack('scripts')
</body>
</html>
