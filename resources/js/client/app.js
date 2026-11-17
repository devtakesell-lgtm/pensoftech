/**
 * Client Portal JavaScript
 * Handles mobile sidebar drawer, backdrop, and profile dropdown toggle.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Sidebar Elements
    const sidebar = document.getElementById('clientSidebar');
    const sidebarBackdrop = document.getElementById('clientSidebarBackdrop');
    const menuToggle = document.getElementById('clientMenuToggle');
    const sidebarClose = document.getElementById('clientSidebarClose');

    // Profile Dropdown Elements
    const userDropdownWrap = document.querySelector('.client-user-dropdown-wrap');
    const userPill = document.querySelector('.client-user-pill');
    const dropdownMenu = document.querySelector('.client-dropdown-menu');

    // Open Sidebar
    if (menuToggle && sidebar && sidebarBackdrop) {
        menuToggle.addEventListener('click', () => {
            sidebar.classList.add('open');
            sidebarBackdrop.classList.add('show');
            document.body.style.overflow = 'hidden';
        });
    }

    // Close Sidebar Helper
    const closeSidebar = () => {
        if (sidebar && sidebarBackdrop) {
            sidebar.classList.remove('open');
            sidebarBackdrop.classList.remove('show');
            document.body.style.overflow = '';
        }
    };

    if (sidebarClose) {
        sidebarClose.addEventListener('click', closeSidebar);
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', closeSidebar);
    }

    // Toggle Profile Dropdown
    if (userPill && dropdownMenu) {
        userPill.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle('show');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userDropdownWrap || !userDropdownWrap.contains(e.target)) {
                dropdownMenu.classList.remove('show');
            }
        });
    }
});
