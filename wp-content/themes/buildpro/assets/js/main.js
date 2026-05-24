document.documentElement.classList.add('js');

(() => {
    const header = document.querySelector('[data-header]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const modal = document.querySelector('[data-modal]');
    const modalOpeners = document.querySelectorAll('[data-modal-open]');
    const modalClosers = document.querySelectorAll('[data-modal-close]');
    const leadForm = document.querySelector('[data-lead-form]');
    const navLinks = document.querySelectorAll('[data-section-link]');
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

    const setHeaderState = () => {
        if (!header) return;
        header.classList.toggle('is-scrolled', window.scrollY > 50);
    };

    const setActiveSection = () => {
        if (!navLinks.length || !sections.length) return;

        const y = window.scrollY + 130;
        const current = sections.reduce((active, section) => {
            return section.offsetTop <= y ? section.id : active;
        }, sections[0].id);

        navLinks.forEach((link) => {
            link.classList.toggle('is-active', link.dataset.sectionLink === current);
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
        setHeaderState();
        setActiveSection();
    }, { passive: true });

    window.addEventListener('resize', syncHeaderHeight, { passive: true });

    syncHeaderHeight();
    setHeaderState();
    setActiveSection();
})();
