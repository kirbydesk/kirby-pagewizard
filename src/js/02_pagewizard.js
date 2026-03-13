window.desktopNav = function desktopNav() {
    return {
        openItem: null,

        isOpen(index) {
            return this.openItem === index;
        },

        open(index) {
            this.openItem = index;
        },

        close() {
            this.openItem = null;
        },

        toggle(index) {
            this.openItem = this.openItem === index ? null : index;
        }
    };
};

window.mobileNav = function mobileNav(initialOpenItem = null) {
    return {
        navOpen: false,
        openItem: null,
        initialOpenItem,

        init() {
            this.openItem = this.initialOpenItem;
        },

        isItemOpen(index) {
            return this.openItem === index;
        },

        toggleNav() {
            this.navOpen = !this.navOpen;
        },

        closeNav() {
            this.navOpen = false;
        },

        toggleItem(index) {
            this.openItem = this.openItem === index ? null : index;
        }
    };
};

document.addEventListener('DOMContentLoaded', () => {

    // Desktop: Intersection Observer → body.scrolled (Header schrumpft)
    const sentinel = document.getElementById('scroll-sentinel');
    if (sentinel) {
        new IntersectionObserver(([entry]) => {
            document.body.classList.toggle('scrolled', !entry.isIntersecting);
        }).observe(sentinel);
    }

    // Language and language level switcher (mobile)
    document.addEventListener('change', (event) => {
        const target = event.target;
        if (!(target instanceof HTMLSelectElement)) return;
        if (target.id !== 'language' && target.id !== 'languagelevel') return;

        const { value } = target;
        if (
            value.startsWith('/') ||
            value.startsWith(window.location.origin) ||
            value.startsWith('http')
        ) {
            window.location = value;
        }
    });
});
