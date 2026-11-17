<header class="client-topbar">
    <div class="client-topbar-left">
        <button type="button" class="client-menu-toggle" id="clientMenuToggle" aria-label="Open sidebar menu">
            <i class="bi bi-list"></i>
        </button>
        <div class="client-breadcrumb-wrap">
            <h1 class="client-topbar-title">@yield('page_title', 'Client Portal')</h1>
            <nav class="client-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('client.dashboard') }}">Portal</a>
                <span>/</span>
                <span>@yield('breadcrumb_current', 'Dashboard')</span>
            </nav>
        </div>
    </div>

    <div class="client-topbar-right">
        <a href="{{ route('client.leads.create') }}" class="client-cta-btn">
            <i class="bi bi-plus-lg"></i>
            <span>New Request</span>
        </a>

        <a href="{{ route('home') }}" class="client-website-link">
            <i class="bi bi-box-arrow-up-right"></i>
            <span>View Website</span>
        </a>

        <div class="client-user-dropdown-wrap">
            <div class="client-user-pill" role="button" tabindex="0" aria-label="User profile menu">
                <div class="client-user-avatar">
                    @if (auth()->user()?->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" alt="{{ auth()->user()->name }}">
                    @else
                        {{ strtoupper(substr(auth()->user()?->name ?? 'C', 0, 1)) }}
                    @endif
                </div>
                <div class="client-user-info">
                    <span class="client-user-name">{{ explode(' ', auth()->user()?->name ?? 'Client')[0] }}</span>
                    <span class="client-user-role">{{ auth()->user()?->client?->company_name ?? 'Client Account' }}</span>
                </div>
                <i class="bi bi-chevron-down" style="font-size: 0.75rem; color: var(--cp-ink-muted); margin-left: 2px;"></i>
            </div>

            <div class="client-dropdown-menu">
                <div class="client-dropdown-header">
                    <div class="client-dropdown-header-name">{{ auth()->user()?->name }}</div>
                    <div class="client-dropdown-header-email">{{ auth()->user()?->email }}</div>
                </div>

                <a href="{{ route('client.projects.index') }}" class="client-dropdown-item">
                    <i class="bi bi-briefcase"></i>
                    <span>My Projects</span>
                </a>

                <a href="{{ route('client.leads.index') }}" class="client-dropdown-item">
                    <i class="bi bi-chat-square-dots"></i>
                    <span>Inquiries & Quotes</span>
                </a>

                <a href="{{ route('home') }}" class="client-dropdown-item">
                    <i class="bi bi-house"></i>
                    <span>Public Website</span>
                </a>

                <hr style="border: none; border-top: 1px solid var(--cp-border-light); margin: 6px 0;">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="client-dropdown-item text-danger">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>
