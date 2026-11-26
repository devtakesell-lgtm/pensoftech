document.addEventListener('DOMContentLoaded', () => {
    const menuBtn = document.getElementById('menu');
    const sidebar = document.getElementById('sidebar');
    const SIDEBAR_SCROLL_KEY = 'admin_sidebar_scroll';

    const saveSidebarScroll = () => {
        if (sidebar) {
            sessionStorage.setItem(SIDEBAR_SCROLL_KEY, String(sidebar.scrollTop));
        }
    };

    const restoreSidebarScroll = () => {
        if (!sidebar) {
            return;
        }

        const savedScroll = sessionStorage.getItem(SIDEBAR_SCROLL_KEY);
        if (savedScroll !== null) {
            sidebar.scrollTop = parseInt(savedScroll, 10) || 0;
        }

        const activeItem = sidebar.querySelector('.nav-sub-link.active, .nav.active');
        if (activeItem && activeItem.offsetParent !== null) {
            const sidebarRect = sidebar.getBoundingClientRect();
            const itemRect = activeItem.getBoundingClientRect();

            if (itemRect.top < sidebarRect.top) {
                sidebar.scrollTop -= sidebarRect.top - itemRect.top + 12;
                saveSidebarScroll();
            } else if (itemRect.bottom > sidebarRect.bottom) {
                sidebar.scrollTop += itemRect.bottom - sidebarRect.bottom + 12;
                saveSidebarScroll();
            }
        }
    };

    // Restore desktop collapsed state from localStorage if previously set
    if (window.innerWidth > 768 && localStorage.getItem('admin_sidebar_collapsed') === 'true') {
        sidebar?.classList.add('collapsed');
        document.body.classList.add('sidebar-collapsed');
    }

    if (sidebar) {
        restoreSidebarScroll();
        sidebar.addEventListener('scroll', saveSidebarScroll, { passive: true });
        sidebar.addEventListener('click', (e) => {
            if (e.target.closest('a[href]')) {
                saveSidebarScroll();
            }
        });
        window.addEventListener('pagehide', saveSidebarScroll);
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