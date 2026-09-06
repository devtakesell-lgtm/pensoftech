<header class="topbar">
    <button id="menu" class="icon"><i class="bi bi-list"></i></button>
    <div class="search">
        <i class="bi bi-search"></i>
        <input placeholder="Search anything...">
        <kbd>⌘ K</kbd>
    </div>
    <div class="actions d-flex align-items-center">
        <button class="icon me-3"><i class="bi bi-bell"></i><em></em></button>

        <div class="dropdown d-flex align-items-center" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
            <b class="avatar">AD</b>
            <span class="ms-2 fw-medium text-dark">Admin</span>
            <i class="bi bi-chevron-down ms-2 text-muted" style="font-size: 0.8rem;"></i>
        </div>

        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
            <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank"><i class="bi bi-box-arrow-up-right me-2"></i>Visit Website</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#"><i class="bi bi-key me-2"></i>Change Password</a></li>
            <li><a class="dropdown-item text-danger" href="#"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
        </ul>
    </div>
</header>
translate3d(-12px, 72.0px, 0px)
