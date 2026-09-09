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
        @can('access-admin')
            <a class="nav {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}" title="Dashboard">
                <i class="bi bi-grid-1x2-fill"></i>
                <span class="nav-title">Dashboard</span>
            </a>
        @endcan

        @can('view-leads')
            <a class="nav {{ request()->routeIs('admin.leads') ? 'active' : '' }}" href="{{ route('admin.leads') }}" title="Leads">
                <i class="bi bi-people"></i>
                <span class="nav-title">Leads</span>
                <span class="nav-badge">24</span>
            </a>
        @endcan

        @can('view-clients')
            <a class="nav {{ request()->routeIs('admin.clients') ? 'active' : '' }}" href="{{ route('admin.clients') }}" title="Clients">
                <i class="bi bi-building"></i>
                <span class="nav-title">Clients</span>
            </a>
        @endcan

        @can('view-quotes')
            <a class="nav {{ request()->routeIs('admin.quotes') ? 'active' : '' }}" href="{{ route('admin.quotes') }}" title="Quotes">
                <i class="bi bi-file-earmark-text"></i>
                <span class="nav-title">Quotes</span>
            </a>
        @endcan
        
        @canany(['view-services', 'view-projects', 'view-case-studies', 'view-industries'])
            <div class="label">SERVICES</div>
            @can('view-services')
                <a class="nav {{ request()->routeIs('admin.services') ? 'active' : '' }}" href="{{ route('admin.services') }}" title="Services">
                    <i class="bi bi-layers"></i>
                    <span class="nav-title">Services</span>
                </a>
            @endcan

            @can('view-projects')
                <a class="nav {{ request()->routeIs('admin.projects') ? 'active' : '' }}" href="{{ route('admin.projects') }}" title="Projects">
                    <i class="bi bi-kanban"></i>
                    <span class="nav-title">Projects</span>
                </a>
            @endcan

            @can('view-case-studies')
                <a class="nav {{ request()->routeIs('admin.case-studies') ? 'active' : '' }}" href="{{ route('admin.case-studies') }}" title="Case Studies">
                    <i class="bi bi-bar-chart"></i>
                    <span class="nav-title">Case Studies</span>
                </a>
            @endcan

            @can('view-industries')
                <a class="nav {{ request()->routeIs('admin.industries') ? 'active' : '' }}" href="{{ route('admin.industries') }}" title="Industries">
                    <i class="bi bi-diagram-3"></i>
                    <span class="nav-title">Industries</span>
                </a>
            @endcan
        @endcanany
        
        @canany(['view-pages', 'view-blogs', 'view-jobs'])
            <div class="label">CONTENT</div>
            @can('view-pages')
                <a class="nav {{ request()->routeIs('admin.pages') ? 'active' : '' }}" href="{{ route('admin.pages') }}" title="Pages">
                    <i class="bi bi-file-richtext"></i>
                    <span class="nav-title">Pages</span>
                </a>
            @endcan

            @can('view-blogs')
                <a class="nav {{ request()->routeIs('admin.blog') ? 'active' : '' }}" href="{{ route('admin.blog') }}" title="Blog">
                    <i class="bi bi-pencil-square"></i>
                    <span class="nav-title">Blog</span>
                </a>
            @endcan

            @can('view-jobs')
                <a class="nav {{ request()->routeIs('admin.careers') ? 'active' : '' }}" href="{{ route('admin.careers') }}" title="Careers">
                    <i class="bi bi-briefcase"></i>
                    <span class="nav-title">Careers</span>
                </a>
            @endcan
        @endcanany
        
        @canany(['view-users', 'view-roles', 'view-analytics', 'view-settings'])
            <div class="label">SYSTEM</div>
            @can('view-users')
                <a class="nav {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}" title="Users">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-title">Users</span>
                </a>
            @endcan

            @can('view-roles')
                <a class="nav {{ request()->routeIs('admin.roles*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}" title="Roles">
                    <i class="bi bi-shield-lock-fill"></i>
                    <span class="nav-title">Roles</span>
                </a>
                <a class="nav {{ request()->routeIs('admin.permissions*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}" title="Permissions">
                    <i class="bi bi-key-fill"></i>
                    <span class="nav-title">Permissions</span>
                </a>
            @endcan

            @can('view-analytics')
                <a class="nav {{ request()->routeIs('admin.analytics') ? 'active' : '' }}" href="{{ route('admin.analytics') }}" title="Analytics">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span class="nav-title">Analytics</span>
                </a>
            @endcan

            @can('view-settings')
                <a class="nav {{ request()->routeIs('admin.settings') ? 'active' : '' }}" href="{{ route('admin.settings') }}" title="Settings">
                    <i class="bi bi-gear"></i>
                    <span class="nav-title">Settings</span>
                </a>
            @endcan
        @endcanany
    </div>
    
    <div class="sidebottom">
        <div class="grow">
            <b>✦ Grow your agency</b>
            <small>Track leads, sales and projects in one place.</small>
            <button type="button">View Reports</button>
        </div>
        <div class="admin">
            <div class="avatar-wrap">
                <b class="avatar">{{ strtoupper(substr(auth()->user()?->name ?? 'AD', 0, 2)) }}</b>
                <span class="status-indicator"></span>
            </div>
            <div class="admin-info">
                <strong>{{ auth()->user()?->name ?? 'Admin' }}</strong>
                <small>{{ auth()->user()?->roles->first()?->name ? ucwords(str_replace('-', ' ', auth()->user()->roles->first()->name)) : 'Staff' }}</small>
            </div>
        </div>
    </div>
</aside>
