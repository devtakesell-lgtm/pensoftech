<div class="dropdown profile-dropdown-wrapper">
    <div class="profile-trigger d-flex align-items-center" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
        <div class="avatar-wrap">
            <b class="avatar">{{ $initials }}</b>
            <span class="status-indicator"></span>
        </div>
        <div class="profile-meta ms-2 d-none d-sm-block text-start">
            <span class="profile-name">{{ $name }}</span>
            <small class="profile-role">{{ $role }}</small>
        </div>
        <i class="bi bi-chevron-down profile-chevron ms-2"></i>
    </div>

    <div class="dropdown-menu dropdown-menu-end profile-menu shadow-lg border-0" aria-labelledby="profileDropdown">
        <!-- User Info Header -->
        <div class="profile-menu-header">
            <div class="d-flex align-items-center gap-3">
                <b class="avatar avatar-lg">{{ $initials }}</b>
                <div class="user-details overflow-hidden">
                    <h6 class="user-fullname mb-0 text-truncate">{{ $name }}</h6>
                    <span class="user-email text-truncate d-block">{{ $email }}</span>
                    <span class="badge bg-primary-subtle text-primary rounded-pill user-badge mt-1">{{ $role }}</span>
                </div>
            </div>
        </div>

        <div class="profile-menu-body py-1">
            <div class="menu-section-label">MANAGEMENT</div>
            <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('home') }}" target="_blank">
                <span class="d-flex align-items-center">
                    <i class="bi bi-globe2 me-2 text-primary"></i>Visit Website
                </span>
                <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill py-0 px-2" style="font-size: 8.5px; font-weight: 700;">LIVE</span>
            </a>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.settings') }}">
                <i class="bi bi-person-gear me-2 text-secondary"></i>Account Settings
            </a>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.settings') }}">
                <i class="bi bi-shield-lock me-2 text-secondary"></i>Change Password
            </a>
        </div>

        <div class="profile-menu-footer border-top pt-1 pb-1">
            <a class="dropdown-item text-danger d-flex align-items-center logout-item" href="#">
                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
            </a>
        </div>
    </div>
</div>