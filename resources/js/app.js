import './bootstrap';
import flatpickr from 'flatpickr';
import "flatpickr/dist/flatpickr.min.css";

document.addEventListener("DOMContentLoaded", function () {

    // ===== FLATPICKR =====
    flatpickr("#dueDate", {
        dateFormat: "Y-m-d",
        enableTime: false,
        clickOpens: true,
    });

    flatpickr("#editDueDate", {
        dateFormat: "Y-m-d",
        enableTime: false,
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
            const next = html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
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
    const box   = document.getElementById('editModalBox');

    form.action  = '/edit-list/' + id;
    input.value  = currentText;

    modal.classList.remove('hidden');
    animateIn(box);
    input.focus();
    input.select();
};

window.closeEditModal = function () {
    const modal = document.getElementById('editModal');
    const box   = document.getElementById('editModalBox');
    animateOut(box, () => modal.classList.add('hidden'));
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
    const modal = document.getElementById('deleteModal');
    const box   = document.getElementById('DeleteBox');
    animateOut(box, () => modal.classList.add('hidden'));
};


// ===== ANIMATION HELPERS =====
function animateIn(el) {
    el.style.opacity   = '0';
    el.style.transform = 'scale(0.97) translateY(6px)';
    requestAnimationFrame(() => requestAnimationFrame(() => {
        el.style.transition = 'opacity 0.18s ease, transform 0.2s ease';
        el.style.opacity    = '1';
        el.style.transform  = 'scale(1) translateY(0)';
    }));
}

function animateOut(el, cb) {
    el.style.transition = 'opacity 0.15s ease, transform 0.15s ease';
    el.style.opacity    = '0';
    el.style.transform  = 'scale(0.97) translateY(4px)';
    setTimeout(cb, 150);
}