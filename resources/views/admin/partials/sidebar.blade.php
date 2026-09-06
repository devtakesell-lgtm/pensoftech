<aside class="sidebar" id="sidebar">
    <div class="brand">
        <b class="logo">P</b>
        <div class="brand-info">
            <strong>PenSoftTech</strong>
            <small>AGENCY</small>
        </div>
    </div>
    
    <div class="nav-section">
        <div class="label">MAIN</div>
        <a class="nav {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="Dashboard">
            <i class="bi bi-grid-1x2-fill"></i>
            <span class="nav-title">Dashboard</span>
            <!-- @if(request()->routeIs('admin.dashboard'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.leads') ? 'active' : '' }}" href="{{ route('admin.leads') }}" title="Leads">
            <i class="bi bi-people"></i>
            <span class="nav-title">Leads</span>
            <!-- @if(request()->routeIs('admin.leads'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @else
                <span class="nav-badge">24</span>
            @endif -->
                <span class="nav-badge">24</span>
        </a>
        <a class="nav {{ request()->routeIs('admin.clients') ? 'active' : '' }}" href="{{ route('admin.clients') }}" title="Clients">
            <i class="bi bi-building"></i>
            <span class="nav-title">Clients</span>
            <!-- @if(request()->routeIs('admin.clients'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.quotes') ? 'active' : '' }}" href="{{ route('admin.quotes') }}" title="Quotes">
            <i class="bi bi-file-earmark-text"></i>
            <span class="nav-title">Quotes</span>
            <!-- @if(request()->routeIs('admin.quotes'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        
        <div class="label">SERVICES</div>
        <a class="nav {{ request()->routeIs('admin.services') ? 'active' : '' }}" href="{{ route('admin.services') }}" title="Services">
            <i class="bi bi-layers"></i>
            <span class="nav-title">Services</span>
            <!-- @if(request()->routeIs('admin.services'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.projects') ? 'active' : '' }}" href="{{ route('admin.projects') }}" title="Projects">
            <i class="bi bi-kanban"></i>
            <span class="nav-title">Projects</span>
            <!-- @if(request()->routeIs('admin.projects'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.case-studies') ? 'active' : '' }}" href="{{ route('admin.case-studies') }}" title="Case Studies">
            <i class="bi bi-bar-chart"></i>
            <span class="nav-title">Case Studies</span>
            <!-- @if(request()->routeIs('admin.case-studies'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.industries') ? 'active' : '' }}" href="{{ route('admin.industries') }}" title="Industries">
            <i class="bi bi-diagram-3"></i>
            <span class="nav-title">Industries</span>
            <!-- @if(request()->routeIs('admin.industries'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        
        <div class="label">CONTENT</div>
        <a class="nav {{ request()->routeIs('admin.pages') ? 'active' : '' }}" href="{{ route('admin.pages') }}" title="Pages">
            <i class="bi bi-file-richtext"></i>
            <span class="nav-title">Pages</span>
            <!-- @if(request()->routeIs('admin.pages'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.blog') ? 'active' : '' }}" href="{{ route('admin.blog') }}" title="Blog">
            <i class="bi bi-pencil-square"></i>
            <span class="nav-title">Blog</span>
            <!-- @if(request()->routeIs('admin.blog'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.careers') ? 'active' : '' }}" href="{{ route('admin.careers') }}" title="Careers">
            <i class="bi bi-briefcase"></i>
            <span class="nav-title">Careers</span>
            <!-- @if(request()->routeIs('admin.careers'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        
        <div class="label">SYSTEM</div>
        <a class="nav {{ request()->routeIs('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}" title="Users & Roles">
            <i class="bi bi-person-gear"></i>
            <span class="nav-title">Users & Roles</span>
            <!-- @if(request()->routeIs('admin.users'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}" title="Analytics">
            <i class="bi bi-graph-up-arrow"></i>
            <span class="nav-title">Analytics</span>
            <!-- @if(request()->routeIs('admin.analytics'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
        <a class="nav {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}" title="Settings">
            <i class="bi bi-gear"></i>
            <span class="nav-title">Settings</span>
            <!-- @if(request()->routeIs('admin.settings'))
                <span class="active-badge"><span class="pulse-dot"></span>Active</span>
            @endif -->
        </a>
    </div>
    
    <div class="sidebottom">
        <div class="grow">
            <b>✦ Grow your agency</b>
            <small>Track leads, sales and projects in one place.</small>
            <button type="button">View Reports</button>
        </div>
        <div class="admin">
            <div class="avatar-wrap">
                <b class="avatar">AD</b>
                <span class="status-indicator"></span>
            </div>
            <div class="admin-info">
                <strong>Admin</strong>
                <small>Super Admin</small>
            </div>
        </div>
    </div>
</aside>
