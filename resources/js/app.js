import './bootstrap';

// ═══════════════════════════════════
// Navigation mobile
// ═══════════════════════════════════
window.toggleMobileNav = function () {
    const nav = document.getElementById('mobile-nav');
    const menuIcon = document.getElementById('menu-icon');
    const closeIcon = document.getElementById('close-icon');
    if (!nav) return;
    nav.classList.toggle('hidden');
    menuIcon?.classList.toggle('hidden');
    closeIcon?.classList.toggle('hidden');
};

window.closeMobileNav = function () {
    const nav = document.getElementById('mobile-nav');
    if (!nav) return;
    nav.classList.add('hidden');
    document.getElementById('menu-icon')?.classList.remove('hidden');
    document.getElementById('close-icon')?.classList.add('hidden');
};

// ═══════════════════════════════════
// Navbar scroll effect
// ═══════════════════════════════════
window.addEventListener('scroll', function () {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    if (window.scrollY > 80) {
        navbar.classList.add('bg-[#0f1117]/95', 'backdrop-blur-md', 'shadow-lg');
    } else {
        navbar.classList.remove('bg-[#0f1117]/95', 'backdrop-blur-md', 'shadow-lg');
    }
}, { passive: true });

// ═══════════════════════════════════
// FAQ accordéon (avec a11y)
// ═══════════════════════════════════
window.toggleFaq = function (btn) {
    const parent = btn.closest('[data-faq]') || btn.parentElement;
    const answer = parent?.querySelector('.faq-answer');
    const chevron = btn.querySelector('.faq-chevron');
    if (!answer) return;
    const isOpen = answer.classList.contains('open');

    // Ferme tous les autres
    document.querySelectorAll('[data-faq]').forEach(item => {
        if (item !== parent) {
            const otherAnswer = item.querySelector('.faq-answer');
            const otherChevron = item.querySelector('.faq-chevron');
            if (otherAnswer) {
                otherAnswer.classList.remove('open');
                otherAnswer.style.maxHeight = '0';
            }
            if (otherChevron) {
                otherChevron.style.transform = 'rotate(0deg)';
            }
            item.classList.remove('bg-gray-200');
            item.classList.add('bg-gray-200/60');
        }
    });

    if (isOpen) {
        answer.classList.remove('open');
        answer.style.maxHeight = '0';
        if (chevron) chevron.style.transform = 'rotate(0deg)';
        parent.classList.remove('bg-gray-200');
        parent.classList.add('bg-gray-200/60');
    } else {
        answer.classList.add('open');
        answer.style.maxHeight = answer.scrollHeight + 'px';
        if (chevron) chevron.style.transform = 'rotate(180deg)';
        parent.classList.add('bg-gray-200');
        parent.classList.remove('bg-gray-200/60');
    }
};

// ═══════════════════════════════════
// Scroll horizontal des cards
// ═══════════════════════════════════
window.scrollCards = function (direction) {
    const container = document.getElementById('cards-container');
    if (!container) return;
    container.scrollBy({
        left: direction === 'left' ? -320 : 320,
        behavior: 'smooth',
    });
};

// ═══════════════════════════════════
// Toasts
// ═══════════════════════════════════
window.showToast = function (msg, type = 'error') {
    const colors = {
        error:   'bg-red-500 text-white border-red-600',
        success: 'bg-green-500 text-white border-green-600',
        info:    'bg-blue-500 text-white border-blue-600',
    };
    const container = document.getElementById('toast-container');
    if (!container) {
        // Fallback alert if container doesn't exist
        alert(msg);
        return;
    }
    const el = document.createElement('div');
    el.className = `px-5 py-3 rounded-xl shadow-lg border text-sm font-bold transition-all duration-300 transform translate-y-2 opacity-0 flex items-center justify-between gap-4 pointer-events-auto ${colors[type] ?? colors.info}`;
    el.innerHTML = `
        <span>${msg}</span>
        <button onclick="this.parentElement.remove()" class="text-white hover:text-gray-200 font-bold ml-2">×</button>
    `;
    container.appendChild(el);

    // Trigger transition
    setTimeout(() => {
        el.classList.remove('translate-y-2', 'opacity-0');
    }, 10);

    setTimeout(() => {
        el.classList.add('translate-y-2', 'opacity-0');
        setTimeout(() => el.remove(), 300);
    }, 4500);
};

// ═══════════════════════════════════
// Partage de véhicule corrigé
// ═══════════════════════════════════
window.shareVehicle = function (url, title) {
    const shareUrl = url || window.location.href;
    const shareTitle = title || document.title;
    const text = `${shareTitle}\n\nDécouvrez cette annonce sur THARA MOTORS :\n${shareUrl}`;
    
    if (navigator.share) {
        navigator.share({ title: shareTitle, url: shareUrl, text })
            .then(() => {
                if (window.showToast) window.showToast('Partage réussi !', 'success');
            })
            .catch((error) => {
                if (error.name !== 'AbortError') {
                    if (window.showToast) window.showToast('Erreur lors du partage', 'error');
                }
            });
    } else {
        // Copy to clipboard fallback
        if (navigator.clipboard) {
            navigator.clipboard.writeText(shareUrl)
                .then(() => {
                    if (window.showToast) window.showToast('Lien copié dans le presse-papiers !', 'success');
                })
                .catch(() => {
                    window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank', 'noopener');
                });
        } else {
            window.open('https://wa.me/?text=' + encodeURIComponent(text), '_blank', 'noopener');
        }
    }
};
