<aside class="client-sidebar" id="clientSidebar">
    <div class="client-sidebar-header">
        <a href="{{ route('client.dashboard') }}" class="client-sidebar-logo">
            <div class="client-sidebar-logo-icon">
                <i class="bi bi-layers-fill"></i>
            </div>
            <span>PenSoftTech</span>
            <span class="client-sidebar-badge">Portal</span>
        </a>
        <button type="button" class="client-sidebar-close" id="clientSidebarClose" aria-label="Close sidebar">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav class="client-sidebar-nav">
        <div class="client-nav-group-label">Overview</div>
        <a href="{{ route('client.dashboard') }}" class="client-nav-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}">
            <div class="client-nav-item-content">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </div>
        </a>

        <div class="client-nav-group-label">Work & Services</div>
        <a href="{{ route('client.projects.index') }}" class="client-nav-item {{ request()->routeIs('client.projects.*') ? 'active' : '' }}">
            <div class="client-nav-item-content">
                <i class="bi bi-briefcase-fill"></i>
                <span>My Projects</span>
            </div>
        </a>

        <a href="{{ route('client.leads.index') }}" class="client-nav-item {{ request()->routeIs('client.leads.index') ? 'active' : '' }}">
            <div class="client-nav-item-content">
                <i class="bi bi-chat-square-dots-fill"></i>
                <span>Inquiries & Quotes</span>
            </div>
        </a>

        <div class="client-nav-group-label">Quick Actions</div>
        <a href="{{ route('client.leads.create') }}" class="client-nav-item {{ request()->routeIs('client.leads.create') ? 'active' : '' }}">
            <div class="client-nav-item-content">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Request Service</span>
            </div>
        </a>
    </nav>

    <div class="client-sidebar-footer">
        <div class="client-support-card">
            <div class="client-support-card-title">
                <i class="bi bi-headset"></i>
                <span>Dedicated Support</span>
            </div>
            <p class="client-support-card-text">
                Have questions about your projects or need custom solutions? Reach our team anytime.
            </p>
            <a href="{{ route('contact') }}" class="client-support-btn">
                <i class="bi bi-envelope-paper"></i>
                <span>Contact Desk</span>
            </a>
        </div>
    </div>
</aside>
