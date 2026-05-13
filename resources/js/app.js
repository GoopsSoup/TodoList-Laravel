import './bootstrap';
import flatpickr from 'flatpickr';
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", function () {

    // ===== FLATPICKR =====
    flatpickr("#dueDate", {
        dateFormat: "Y-m-d",
    });

    flatpickr("#editDueDate", {
        dateFormat: "Y-m-d",
    });

    // Make calendar icon open the date picker
    const dateBtn    = document.querySelector('.add-date-btn');
    const dueDateEl  = document.getElementById('dueDate');
    if (dateBtn && dueDateEl) {
        dateBtn.addEventListener('click', () => {
            if (dueDateEl._flatpickr) dueDateEl._flatpickr.open();
        });
    }

    // ===== DARK / LIGHT MODE =====
    const html          = document.documentElement;
    const themeToggle   = document.getElementById('themeToggle');
    const themeLabel    = document.getElementById('themeLabel');
    const themeCheckbox = document.getElementById('themeCheckbox');

    const saved = localStorage.getItem('taskflow-theme') || 'light';
    applyTheme(saved);

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        const isDark = theme === 'dark';
        if (themeToggle)   themeToggle.classList.toggle('on', isDark);
        if (themeLabel)    themeLabel.textContent = isDark ? 'Dark mode' : 'Light mode';
        if (themeCheckbox) themeCheckbox.checked = isDark;
    }

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            const next = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
            localStorage.setItem('taskflow-theme', next);
            applyTheme(next);
        });
    }


    // ===== SIDEBAR MOBILE =====
    const sidebarToggle  = document.getElementById('sidebarToggle');
    const sidebar        = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    function closeSidebar() {
        sidebar && sidebar.classList.remove('open');
        sidebarOverlay && sidebarOverlay.classList.remove('visible');
    }

    sidebarToggle && sidebarToggle.addEventListener('click', () => {
        const isOpen = sidebar.classList.contains('open');
        isOpen ? closeSidebar() : (sidebar.classList.add('open'), sidebarOverlay.classList.add('visible'));
    });

    sidebarOverlay && sidebarOverlay.addEventListener('click', closeSidebar);


    // ===== ESCAPE TO CLOSE MODALS =====
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeEditModal();
            closeDeleteModal();
        }
    });

    // Close modals clicking backdrop
    document.getElementById('editModal')?.addEventListener('click', function (e) {
        if (e.target === this) closeEditModal();
    });
    document.getElementById('deleteModal')?.addEventListener('click', function (e) {
        if (e.target === this) closeDeleteModal();
    });

});

// ===== EDIT MODAL =====
window.openEditModal = function (id, currentText) {
    const modal = document.getElementById('editModal');
    const form  = document.getElementById('editForm');
    const input = document.getElementById('editInput');

    form.action  = '/edit-list/' + id;
    input.value  = currentText;

    modal.classList.remove('hidden');

    input.focus();
    input.select();
};

window.closeEditModal = function () {
    document.getElementById('editModal').classList.add('hidden');
};



// ===== DELETE MODAL =====
window.openDeleteModal = function (id) {
    const modal = document.getElementById('deleteModal');
    const form  = document.getElementById('deleteForm');
    const box   = document.getElementById('DeleteBox');

    form.action = '/delete-list/' + id;

    modal.classList.remove('hidden');
    animateIn(box);
};

window.closeDeleteModal = function () {
    document.getElementById('deleteModal').classList.add('hidden');
};