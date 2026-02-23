function openEditModal(id, currentText) {
    const modal = document.getElementById('editModal');
    const form  = document.getElementById('editForm');
    const input = document.getElementById('editInput');
    const box   = document.getElementById('editModalBox');

    form.action = '/edit-list/' + id;
    input.value = currentText;

    modal.classList.remove('hidden');
    box.style.transform = 'scale(0.95) translateY(8px)';
    box.style.opacity = '0';

    requestAnimationFrame(() => {
        requestAnimationFrame(() => {
            box.style.transition = 'transform 0.25s cubic-bezier(0.34,1.56,0.64,1), opacity 0.2s ease';
            box.style.transform = 'scale(1) translateY(0)';
            box.style.opacity = '1';
            input.focus();
            input.select();
            });
        });
    }

    function closeEditModal() {
        const modal = document.getElementById('editModal');
        const box   = document.getElementById('editModalBox');

        box.style.transform = 'scale(0.95) translateY(8px)';
        box.style.opacity = '0';
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // Close on Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeEditModal();
    });

    // Sidebar
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    toggle.addEventListener('click', () => {
        const isOpen = !sidebar.classList.contains('-translate-x-full');
        if (isOpen) {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.remove('opacity-100', 'pointer-events-auto');
            overlay.classList.add('opacity-0', 'pointer-events-none');
        } else {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-100', 'pointer-events-auto');
        }
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.remove('opacity-100', 'pointer-events-auto');
        overlay.classList.add('opacity-0', 'pointer-events-none');
    });