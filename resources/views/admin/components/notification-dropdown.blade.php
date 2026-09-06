<div class="dropdown notification-dropdown-wrapper">
    <button class="icon me-3 position-relative" id="notificationDropdown" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" title="Notifications">
        <i class="bi bi-bell"></i>
        @if($unreadCount > 0)
            <span class="notification-badge" id="notificationBadgeCount">{{ $unreadCount }}</span>
        @endif
    </button>

    <div class="dropdown-menu dropdown-menu-end notification-menu shadow-lg border-0" aria-labelledby="notificationDropdown">
        <!-- Header -->
        <div class="notification-header d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <h6 class="mb-0 fw-bold text-dark" style="font-size: 14px;">Notifications</h6>
                @if($unreadCount > 0)
                    <span class="badge rounded-pill bg-primary-subtle text-primary fw-bold" id="notificationNewPill" style="font-size: 10px;">{{ $unreadCount }} New</span>
                @endif
            </div>
            @if($unreadCount > 0)
                <button type="button" class="btn-mark-all" id="markAllReadBtn">Mark all as read</button>
            @endif
        </div>

        <!-- Notification Items List -->
        <div class="notification-list" id="notificationList">
            @forelse($notifications as $notification)
                <a href="{{ $notification['link'] ?? '#' }}" class="notification-item d-flex align-items-start gap-3 text-decoration-none {{ !empty($notification['unread']) ? 'unread' : '' }}">
                    <div class="notification-icon {{ $notification['color'] ?? 'blue' }}">
                        <i class="bi {{ $notification['icon'] ?? 'bi-bell-fill' }}"></i>
                    </div>
                    <div class="notification-content flex-grow-1">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="notification-title">{{ $notification['title'] }}</span>
                            <span class="notification-time">{{ $notification['time'] }}</span>
                        </div>
                        <p class="notification-msg mb-0">{{ $notification['message'] }}</p>
                    </div>
                    @if(!empty($notification['unread']))
                        <span class="unread-dot"></span>
                    @endif
                </a>
            @empty
                <div class="p-4 text-center text-muted">
                    <i class="bi bi-bell-slash fs-2 d-block mb-2 text-secondary opacity-50"></i>
                    <p class="mb-0 small">No notifications found.</p>
                </div>
            @endforelse
        </div>

        <!-- Footer -->
        <div class="notification-footer text-center">
            <a href="{{ route('admin.leads') }}" class="view-all-link">
                View All Activities <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>