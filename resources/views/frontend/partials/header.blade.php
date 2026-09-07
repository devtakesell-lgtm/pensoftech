{{-- <header class="site-header">
  <div class="container">
    <a href="{{ route('home') }}" class="logo" aria-label="PenSoftTech home">
      <svg class="logo-mark" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0H32V32H0V0Z" fill="#10151A"/>
        <path d="M0 32L32 0V32H0Z" fill="#FF5A36"/>
        <path d="M0 0L32 32H0V0Z" fill="#3B4FE0"/>
      </svg>
      <span>Pen<b>Soft</b>Tech</span>
    </a>
    <nav class="main-nav" id="main-nav">
      <a href="{{ route('home') }}" data-page="home">Home</a>
      <a href="{{ route('software-development') }}" data-page="software-development">Software Development</a>
      <a href="{{ route('digital-marketing') }}" data-page="digital-marketing">Digital Marketing</a>
      <a href="{{ route('about') }}" data-page="about">About</a>
      <a href="{{ route('contact') }}" data-page="contact">Contact</a>
      <a href="contact.html" class="btn btn-primary">Start a project</a>
    </nav>
    <div class="header-actions">
      <a href="#" class="btn btn-primary">Start a project</a>
      <button class="nav-toggle" aria-label="Toggle menu" aria-expanded="false"><span></span><span></span><span></span></button>
    </div>
  </div>
</header> --}}

<header class="site-header">
  <div class="container">
    <a href="{{ route('home') }}" class="brand"><span class="brand-mark"></span>PenSoftTech</a>
    <nav class="nav" id="site-nav">
      <ul class="nav-links main-nav">
        <li><a href="{{ route('home') }}" @class(['is-active' => request()->routeIs('home')]) @if (request()->routeIs('home')) aria-current="page" @endif>Home</a></li>
        <li><a href="{{ route('software-development') }}" @class(['is-active' => request()->routeIs('software-development')]) @if (request()->routeIs('software-development')) aria-current="page" @endif>Software Development</a></li>
        <li><a href="{{ route('digital-marketing') }}" @class(['is-active' => request()->routeIs('digital-marketing')]) @if (request()->routeIs('digital-marketing')) aria-current="page" @endif>Digital Marketing</a></li>
        <li><a href="{{ route('about') }}" @class(['is-active' => request()->routeIs('about')]) @if (request()->routeIs('about')) aria-current="page" @endif>About</a></li>
        <li><a href="{{ route('contact') }}" @class(['is-active' => request()->routeIs('contact')]) @if (request()->routeIs('contact')) aria-current="page" @endif>Contact</a></li>
        @auth
          @if(auth()->user()->role?->slug !== 'client')
            <li><a href="{{ route('admin.dashboard') }}">Admin Panel</a></li>
          @endif
        @else
          <li><a href="{{ route('login') }}" @class(['is-active' => request()->routeIs('login', 'register')])>Sign In</a></li>
        @endauth
      </ul>
      <div style="display: flex; align-items: center; gap: 12px;">
        @auth
          <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" style="background: none; border: none; font-size: 14px; font-weight: 600; color: var(--slate); cursor: pointer; padding: 6px 10px;">Sign Out</button>
          </form>
        @endauth
        <a href="{{ route('contact') }}" class="btn btn-ink">Get a Quote</a>
      </div>
    </nav>
    <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-controls="site-nav" aria-expanded="false"><span></span></button>
  </div>
</header>
