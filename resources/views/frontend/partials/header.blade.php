

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

      </ul>
      <div style="display: flex; align-items: center; gap: 12px;">
        <a href="{{ route('contact') }}" class="btn btn-ink">Get a Quote</a>

        <!-- Profile Dropdown -->
        <div class="profile-dropdown-container" id="profileDropdown">
          <button class="profile-dropdown-btn" type="button" aria-haspopup="true" aria-expanded="false" onclick="toggleProfileDropdown()">
            <div class="profile-avatar">
              <svg viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <span class="profile-name">
              @auth
                {{ explode(' ', auth()->user()->name)[0] }}
              @else
                Guest
              @endauth
            </span>
            <svg style="width:16px;height:16px;fill:var(--slate);" viewBox="0 0 24 24"><path d="M7 10l5 5 5-5H7z"/></svg>
          </button>

          <div class="profile-dropdown-menu" role="menu">
            @auth
              <a href="#" class="profile-menu-header">
                <div class="fullname">{{ auth()->user()->name }}</div>
                <div class="email">{{ auth()->user()->email }}</div>
              </a>
              <div class="profile-menu-divider"></div>
              <ul class="profile-menu-list">
                @if(auth()->user()->role?->slug !== 'client')
                  <li>
                    <a href="{{ route('admin.dashboard') }}">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                      Admin Panel
                    </a>
                  </li>
                @else
                  <li>
                    <a href="#">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                      Dashboard
                    </a>
                  </li>
                  <!-- <li>
                    <a href="#">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                      Change Password
                    </a>
                  </li> -->
                @endif
                <li>
                  <form method="POST" action="{{ route('logout') }}" style="margin:0;padding:0;">
                    @csrf
                    <button type="submit">
                      <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/></svg>
                      Sign Out
                    </button>
                  </form>
                </li>
              </ul>
            @else
              <ul class="profile-menu-list" style="padding: 8px 0;">
                <li>
                  <a href="{{ route('login') }}">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11 7L9.6 8.4l2.6 2.6H2v2h10.2l-2.6 2.6L11 17l5-5-5-5zm9 12h-8v2h8c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2h-8v2h8v14z"/></svg>
                    Sign In
                  </a>
                </li>
                <li>
                  <a href="{{ route('register') }}">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm-9-2V7H4v3H1v2h3v3h2v-3h3v-2H6zm9 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    Register
                  </a>
                </li>
              </ul>
            @endauth
          </div>
        </div>
      </div>
    </nav>
    <button class="nav-toggle" type="button" aria-label="Open navigation menu" aria-controls="site-nav" aria-expanded="false"><span></span></button>
  </div>
</header>

<script>
  function toggleProfileDropdown() {
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('is-open');
    const btn = dropdown.querySelector('.profile-dropdown-btn');
    const isExpanded = btn.getAttribute('aria-expanded') === 'true';
    btn.setAttribute('aria-expanded', !isExpanded);
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function(event) {
    const dropdown = document.getElementById('profileDropdown');
    if (dropdown && dropdown.classList.contains('is-open')) {
      if (!dropdown.contains(event.target)) {
        dropdown.classList.remove('is-open');
        dropdown.querySelector('.profile-dropdown-btn').setAttribute('aria-expanded', 'false');
      }
    }
  });
</script>
