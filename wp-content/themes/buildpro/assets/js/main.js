document.documentElement.classList.add('js');

(() => {
    const header = document.querySelector('[data-header]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const modal = document.querySelector('[data-modal]');
    const modalOpeners = document.querySelectorAll('[data-modal-open]');
    const modalClosers = document.querySelectorAll('[data-modal-close]');
    const leadForm = document.querySelector('[data-lead-form]');
    const navLinks = document.querySelectorAll('[data-section-link]');
    const revealItems = document.querySelectorAll('.bp-reveal');
    const sections = ['hero', 'features', 'projects', 'stages', 'contacts']
        .map((id) => document.getElementById(id))
        .filter(Boolean);

    const syncHeaderHeight = () => {
        if (!header) return;

        const gap = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--bp-scroll-gap')) || 0;

        document.documentElement.style.setProperty('--bp-header-height', `${header.offsetHeight}px`);
        document.documentElement.style.setProperty('--bp-scroll-offset', `${header.getBoundingClientRect().bottom + gap}px`);
    };

    const getScrollOffset = () => {
        if (!header) return 0;

        const gap = parseFloat(getComputedStyle(document.documentElement).getPropertyValue('--bp-scroll-gap')) || 0;
        return header.getBoundingClientRect().bottom + gap;
    };

    const setActiveSection = () => {
        if (!navLinks.length || !sections.length) return;

        const y = window.scrollY + getScrollOffset() + Math.min(window.innerHeight * 0.28, 180);
        const isAtPageEnd = window.scrollY + window.innerHeight >= document.documentElement.scrollHeight - 2;
        const current = isAtPageEnd ? sections[sections.length - 1].id : sections.reduce((active, section) => {
            return section.offsetTop <= y ? section.id : active;
        }, sections[0].id);

        navLinks.forEach((link) => {
            link.classList.toggle('is-active', link.dataset.sectionLink === current);
        });
    };

    const initReveals = () => {
        if (!revealItems.length) return;

        const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        if (prefersReducedMotion || !('IntersectionObserver' in window)) {
            revealItems.forEach((item) => item.classList.add('is-visible'));
            return;
        }

        const revealObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -8% 0px',
            threshold: 0.16,
        });

        revealItems.forEach((item) => {
            if (item.classList.contains('is-visible')) return;
            revealObserver.observe(item);
        });
    };

    const closeMenu = () => {
        if (!header || !menuToggle) return;
        header.classList.remove('is-open');
        document.body.classList.remove('nav-open');
        menuToggle.setAttribute('aria-expanded', 'false');
    };

    const openModal = () => {
        if (!modal) return;
        modal.classList.add('is-open');
        modal.classList.remove('is-sent');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        closeMenu();

        const input = modal.querySelector('input');
        window.setTimeout(() => input?.focus(), 80);
    };

    const closeModal = () => {
        if (!modal) return;
        modal.classList.remove('is-open', 'is-sent');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        leadForm?.reset();
    };

    menuToggle?.addEventListener('click', () => {
        if (!header) return;
        const open = header.classList.toggle('is-open');
        document.body.classList.toggle('nav-open', open);
        menuToggle.setAttribute('aria-expanded', String(open));
    });

    navLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            const target = document.getElementById(link.dataset.sectionLink);
            if (!target) return;

            event.preventDefault();
            closeMenu();

            window.requestAnimationFrame(() => {
                const top = target.getBoundingClientRect().top + window.scrollY - getScrollOffset();
                window.scrollTo({ top, behavior: 'smooth' });
            });
        });
    });

    modalOpeners.forEach((button) => button.addEventListener('click', openModal));
    modalClosers.forEach((button) => button.addEventListener('click', closeModal));

    leadForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        modal?.classList.add('is-sent');

        window.setTimeout(closeModal, 2600);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeModal();
            closeMenu();
        }
    });

    window.addEventListener('scroll', () => {
        setActiveSection();
    }, { passive: true });

    window.addEventListener('resize', () => {
        syncHeaderHeight();
        setActiveSection();
    }, { passive: true });

    syncHeaderHeight();
    initReveals();
    setActiveSection();
})();
