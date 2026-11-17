document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu');
    const sidebar = document.getElementById('sidebar');

    // Restore desktop collapsed state from localStorage if previously set
    if (window.innerWidth > 768 && localStorage.getItem('admin_sidebar_collapsed') === 'true') {
        sidebar?.classList.add('collapsed');
        document.body.classList.add('sidebar-collapsed');
    }

    if (menuBtn && sidebar) {
        menuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            if (window.innerWidth <= 768) {
                // Mobile behavior: slide in / out
                sidebar.classList.toggle('open');
                document.body.classList.toggle('sidebar-open');
            } else {
                // Desktop behavior: collapse to left showing only icons, or expand back
                sidebar.classList.toggle('collapsed');
                document.body.classList.toggle('sidebar-collapsed');
                localStorage.setItem('admin_sidebar_collapsed', sidebar.classList.contains('collapsed'));
            }
        });
    }

    // Close mobile drawer when clicking backdrop or outside
    const backdrop = document.getElementById('sidebarBackdrop');
    backdrop?.addEventListener('click', () => {
        sidebar?.classList.remove('open');
        document.body.classList.remove('sidebar-open');
    });

    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 && sidebar?.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !menuBtn?.contains(e.target)) {
                sidebar.classList.remove('open');
                document.body.classList.remove('sidebar-open');
            }
        }
    });

    // Notification interactive actions
    const markAllBtn = document.getElementById('markAllReadBtn');
    markAllBtn?.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();

        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        document.querySelectorAll('.unread-dot').forEach(dot => {
            dot.remove();
        });

        const badge = document.getElementById('notificationBadgeCount');
        if (badge) badge.remove();

        const newPill = document.getElementById('notificationNewPill');
        if (newPill) newPill.remove();

        markAllBtn.remove();
    });

    // Search shortcut (Ctrl+K / Cmd+K)
    document.addEventListener('keydown', (e) => {
        if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
            e.preventDefault();
            document.querySelector('.search input')?.focus();
        }
    });
});