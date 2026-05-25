document.documentElement.classList.add('js');

(() => {
    const header = document.querySelector('[data-header]');
    const menuToggle = document.querySelector('[data-menu-toggle]');
    const modal = document.querySelector('[data-modal]');
    const modalOpeners = document.querySelectorAll('[data-modal-open]');
    const modalClosers = document.querySelectorAll('[data-modal-close]');
    const leadForm = document.querySelector('[data-lead-form]');
    const phoneInputs = document.querySelectorAll('[data-phone-mask]');
    const navLinks = document.querySelectorAll('[data-section-link]');
    const revealItems = document.querySelectorAll('.bp-reveal');
    const sections = ['hero', 'features', 'projects', 'stages', 'contacts']
        .map((id) => document.getElementById(id))
        .filter(Boolean);
    const modalFocusableSelector = [
        'a[href]',
        'button:not([disabled])',
        'input:not([disabled])',
        'textarea:not([disabled])',
        'select:not([disabled])',
        '[tabindex]:not([tabindex="-1"])',
    ].join(', ');
    let lastFocusedElement = null;
    let inertTargets = [];
    const phoneMaskState = new WeakMap();

    const isElementVisible = (element) => {
        const rect = element.getBoundingClientRect();
        const style = window.getComputedStyle(element);

        return rect.width > 0 && rect.height > 0 && style.visibility !== 'hidden' && style.display !== 'none';
    };

    const getModalFocusableElements = () => {
        if (!modal) return [];

        return [...modal.querySelectorAll(modalFocusableSelector)].filter(isElementVisible);
    };

    const getInertTargets = () => {
        if (!modal) return [];

        const targets = new Set();

        [...document.body.children].forEach((element) => {
            if (element !== modal && !element.contains(modal)) {
                targets.add(element);
            }
        });

        if (modal.parentElement) {
            [...modal.parentElement.children].forEach((element) => {
                if (element !== modal) {
                    targets.add(element);
                }
            });
        }

        return [...targets].filter((element) => !element.contains(modal));
    };

    const setPageInert = (shouldInert) => {
        if (!modal) return;

        if (shouldInert) {
            inertTargets = getInertTargets();
            inertTargets.forEach((element) => {
                element.dataset.bpModalHadAriaHidden = element.hasAttribute('aria-hidden') ? 'true' : 'false';
                element.dataset.bpModalPreviousAriaHidden = element.getAttribute('aria-hidden') || '';
                element.setAttribute('aria-hidden', 'true');
                element.setAttribute('inert', '');
            });
            return;
        }

        inertTargets.forEach((element) => {
            if (element.dataset.bpModalHadAriaHidden === 'true') {
                element.setAttribute('aria-hidden', element.dataset.bpModalPreviousAriaHidden || '');
            } else {
                element.removeAttribute('aria-hidden');
            }

            element.removeAttribute('inert');
            delete element.dataset.bpModalHadAriaHidden;
            delete element.dataset.bpModalPreviousAriaHidden;
        });
        inertTargets = [];
    };

    const focusFirstModalElement = () => {
        const firstFocusable = modal?.querySelector('input, textarea, select') || getModalFocusableElements()[0];
        const dialog = modal?.querySelector('[role="dialog"]');

        (firstFocusable || dialog)?.focus();
    };

    const getPhoneDigits = (value) => {
        const normalizedValue = value.trim();
        let digits = value.replace(/\D/g, '');

        if (!digits) {
            return '';
        }

        if (digits.startsWith('8')) {
            digits = digits.slice(1);
        } else if (digits.startsWith('7') && (normalizedValue.startsWith('+7') || digits.length > 10)) {
            digits = digits.slice(1);
        }

        return digits.slice(0, 10);
    };

    const formatPhoneDigits = (digits) => {
        const area = digits.slice(0, 3);
        const prefix = digits.slice(3, 6);
        const firstPair = digits.slice(6, 8);
        const secondPair = digits.slice(8, 10);

        if (!digits.length) return '';

        let formatted = '+7';

        if (area) {
            formatted += ` (${area}`;
        }

        if (area.length === 3) {
            formatted += ')';
        }

        if (prefix) {
            formatted += ` ${prefix}`;
        }

        if (firstPair) {
            formatted += `-${firstPair}`;
        }

        if (secondPair) {
            formatted += `-${secondPair}`;
        }

        return formatted;
    };

    const movePhoneCaretToEnd = (input) => {
        window.requestAnimationFrame(() => {
            const position = input.value.length;
            input.setSelectionRange?.(position, position);
        });
    };

    const maskPhoneInput = (input, inputType = '') => {
        const previousState = phoneMaskState.get(input);
        const isDeleting = inputType === 'deleteContentBackward' || inputType === 'deleteContentForward';
        let digits = getPhoneDigits(input.value);

        if (isDeleting && previousState && digits === previousState.digits && input.value.length < previousState.value.length) {
            digits = previousState.digits.slice(0, -1);
        }

        input.value = formatPhoneDigits(digits);
        input.setCustomValidity('');
        phoneMaskState.set(input, {
            digits,
            value: input.value,
        });
        movePhoneCaretToEnd(input);
    };

    const trapModalFocus = (event) => {
        if (!modal?.classList.contains('is-open')) return;

        const focusableElements = getModalFocusableElements();

        if (!focusableElements.length) {
            event.preventDefault();
            modal.querySelector('[role="dialog"]')?.focus();
            return;
        }

        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        const activeElement = document.activeElement;

        if (event.shiftKey && (activeElement === firstElement || !modal.contains(activeElement))) {
            event.preventDefault();
            lastElement.focus();
            return;
        }

        if (!event.shiftKey && activeElement === lastElement) {
            event.preventDefault();
            firstElement.focus();
        }
    };

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

    const initMagneticCursor = () => {
        const motionQuery = window.matchMedia('(prefers-reduced-motion: reduce)');
        const pointerQuery = window.matchMedia('(hover: hover) and (pointer: fine)');
        const magneticSelector = [
            '.bp-header__logo',
            '.bp-nav__link',
            '.bp-header__phone',
            '.bp-btn',
            '.bp-menu-toggle',
            '.bp-modal__close',
            '.bp-lead-form input',
            '.bp-text-link',
            '.bp-section-nav__link',
            '.bp-footer__social',
            '.bp-footer__link',
            '.bp-footer__bottom a',
        ].join(', ');
        const canUseMagneticCursor = () => pointerQuery.matches && !motionQuery.matches && window.innerWidth > 900;
        let cleanup = null;

        const clamp = (value, min, max) => Math.min(Math.max(value, min), max);
        const lerp = (current, target, amount) => current + (target - current) * amount;

        const setup = () => {
            if (!canUseMagneticCursor()) {
                cleanup?.();
                cleanup = null;
                return;
            }

            if (cleanup) return;

            const cursor = document.createElement('div');
            cursor.className = 'bp-cursor';
            cursor.setAttribute('aria-hidden', 'true');
            cursor.innerHTML = '<span class="bp-cursor__ring"></span><span class="bp-cursor__dot"></span><span class="bp-cursor__drop"></span>';
            document.body.append(cursor);
            document.documentElement.classList.add('has-magnetic-cursor');

            const pointer = {
                x: window.innerWidth / 2,
                y: window.innerHeight / 2,
                visible: false,
                down: false,
            };

            const visual = {
                x: pointer.x,
                y: pointer.y,
                activeItem: null,
                detachTimer: null,
                frame: null,
                rectFrame: null,
                running: false,
            };

            const items = [...document.querySelectorAll(magneticSelector)].map((element) => {
                const surfaceElement = element.matches('.bp-lead-form input')
                    ? element.closest('label')
                    : element;
                const item = {
                    element,
                    surfaceElement,
                    currentX: 0,
                    currentY: 0,
                    targetX: 0,
                    targetY: 0,
                    rect: element.getBoundingClientRect(),
                    isInput: element.matches('input'),
                    isRound: element.matches('.bp-footer__social'),
                    settled: true,
                };

                element.classList.add('bp-magnetic');
                if (surfaceElement && surfaceElement !== element) {
                    surfaceElement.classList.add('bp-magnetic-surface');
                }

                return item;
            });
            const movingItems = new Set();

            const triggerDetach = (item) => {
                if (!item) return;

                const rect = item.element.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const angle = Math.atan2(pointer.y - centerY, pointer.x - centerX);

                cursor.style.setProperty('--bp-drop-x', `${Math.cos(angle) * 22}px`);
                cursor.style.setProperty('--bp-drop-y', `${Math.sin(angle) * 22}px`);
                cursor.classList.remove('is-detaching');
                void cursor.offsetWidth;
                cursor.classList.add('is-detaching');

                window.clearTimeout(visual.detachTimer);
                visual.detachTimer = window.setTimeout(() => cursor.classList.remove('is-detaching'), 420);
            };

            const resetCursorShape = () => {
                cursor.classList.remove('is-magnetic', 'is-inside', 'is-input', 'is-down');
            };

            const startAnimation = () => {
                if (visual.running) return;

                visual.running = true;
                visual.frame = window.requestAnimationFrame(animate);
            };

            const clearItemState = (item) => {
                item.targetX = 0;
                item.targetY = 0;
                item.settled = false;
                movingItems.add(item);
                item.element.classList.remove('is-magnetic-active', 'is-magnetic-inside');
                item.surfaceElement?.classList.remove('is-magnetic-active', 'is-magnetic-inside');
                item.surfaceElement?.style.removeProperty('--bp-magnetic-radius');
                startAnimation();
            };

            const setActiveItem = (item) => {
                if (visual.activeItem === item) return;

                if (visual.activeItem) {
                    clearItemState(visual.activeItem);
                }

                visual.activeItem = item;
                item.rect = item.element.getBoundingClientRect();
                const computedRadius = parseFloat(window.getComputedStyle(item.element).borderTopLeftRadius);
                const magneticRadius = item.isRound
                    ? 999
                    : item.isInput
                        ? 8
                        : Number.isFinite(computedRadius) && computedRadius > 0
                            ? Math.min(computedRadius + 2, 12)
                            : 8;

                item.surfaceElement?.style.setProperty('--bp-magnetic-radius', `${magneticRadius}px`);
                item.element.classList.add('is-magnetic-active', 'is-magnetic-inside');
                item.surfaceElement?.classList.add('is-magnetic-active', 'is-magnetic-inside');
                updateActiveItem();
            };

            const clearActiveItem = (item) => {
                if (visual.activeItem !== item) return;

                triggerDetach(item);
                clearItemState(item);
                visual.activeItem = null;
                resetCursorShape();
            };

            const updateActiveItem = () => {
                const item = visual.activeItem;
                if (!item) return;

                const baseRect = {
                    left: item.rect.left,
                    top: item.rect.top,
                    width: item.rect.width,
                    height: item.rect.height,
                };
                const centerX = baseRect.left + baseRect.width / 2;
                const centerY = baseRect.top + baseRect.height / 2;
                const maxOffset = item.isInput ? 6 : 12;

                item.rect = {
                    ...baseRect,
                    right: baseRect.left + baseRect.width,
                    bottom: baseRect.top + baseRect.height,
                };
                item.targetX = clamp((pointer.x - centerX) * 0.16, -maxOffset, maxOffset);
                item.targetY = clamp((pointer.y - centerY) * 0.16, -maxOffset, maxOffset);
                item.settled = false;
                movingItems.add(item);
                startAnimation();
            };

            const updatePointer = (event) => {
                if (event.pointerType && event.pointerType !== 'mouse') return;

                pointer.x = event.clientX;
                pointer.y = event.clientY;
                pointer.visible = true;
                updateActiveItem();
                startAnimation();
            };

            const animate = () => {
                let anyMoving = false;

                const animateItem = (item) => {
                    item.currentX = lerp(item.currentX, item.targetX, 0.24);
                    item.currentY = lerp(item.currentY, item.targetY, 0.24);

                    if (Math.abs(item.currentX - item.targetX) < 0.02) item.currentX = item.targetX;
                    if (Math.abs(item.currentY - item.targetY) < 0.02) item.currentY = item.targetY;

                    item.element.style.setProperty('--bp-magnetic-x', `${item.currentX.toFixed(2)}px`);
                    item.element.style.setProperty('--bp-magnetic-y', `${item.currentY.toFixed(2)}px`);
                    if (item.surfaceElement && item.surfaceElement !== item.element) {
                        item.surfaceElement.style.setProperty('--bp-magnetic-x', `${item.currentX.toFixed(2)}px`);
                        item.surfaceElement.style.setProperty('--bp-magnetic-y', `${item.currentY.toFixed(2)}px`);
                    }
                    item.settled = item.currentX === item.targetX && item.currentY === item.targetY;
                    anyMoving = anyMoving || !item.settled;
                };

                movingItems.forEach((item) => {
                    animateItem(item);
                    if (item.settled) movingItems.delete(item);
                });

                visual.x = lerp(visual.x, pointer.x, visual.activeItem ? 0.34 : 0.24);
                visual.y = lerp(visual.y, pointer.y, visual.activeItem ? 0.34 : 0.24);

                if (Math.abs(visual.x - pointer.x) < 0.02) visual.x = pointer.x;
                if (Math.abs(visual.y - pointer.y) < 0.02) visual.y = pointer.y;

                cursor.style.transform = `translate3d(${visual.x.toFixed(2)}px, ${visual.y.toFixed(2)}px, 0)`;
                cursor.classList.toggle('is-visible', pointer.visible);
                cursor.classList.toggle('is-magnetic', !!visual.activeItem);
                cursor.classList.toggle('is-inside', !!visual.activeItem);
                cursor.classList.toggle('is-input', !!visual.activeItem?.isInput);
                cursor.classList.toggle('is-down', pointer.down);

                const cursorMoving = visual.x !== pointer.x || visual.y !== pointer.y;

                if (anyMoving || cursorMoving) {
                    visual.frame = window.requestAnimationFrame(animate);
                    return;
                }

                visual.running = false;
                visual.frame = null;
            };

            const onPointerLeaveWindow = () => {
                pointer.visible = false;
                if (visual.activeItem) {
                    clearItemState(visual.activeItem);
                    visual.activeItem = null;
                    resetCursorShape();
                }
                startAnimation();
            };

            const onPointerDown = () => {
                pointer.down = true;
                startAnimation();
            };

            const onPointerUp = () => {
                pointer.down = false;
                startAnimation();
            };

            const refreshActiveRect = () => {
                if (!visual.activeItem) return;

                visual.activeItem.rect = visual.activeItem.element.getBoundingClientRect();
                updateActiveItem();
            };

            const scheduleRectRefresh = () => {
                if (!visual.activeItem || visual.rectFrame) return;

                visual.rectFrame = window.requestAnimationFrame(() => {
                    visual.rectFrame = null;
                    refreshActiveRect();
                });
            };

            items.forEach((item) => {
                item.onMouseEnter = (event) => {
                    pointer.x = event.clientX;
                    pointer.y = event.clientY;
                    pointer.visible = true;
                    setActiveItem(item);
                };
                item.onMouseLeave = (event) => {
                    pointer.x = event.clientX;
                    pointer.y = event.clientY;
                    clearActiveItem(item);
                };
                item.element.addEventListener('mouseenter', item.onMouseEnter);
                item.element.addEventListener('mouseleave', item.onMouseLeave);
            });

            document.addEventListener('mousemove', updatePointer, { passive: true });
            window.addEventListener('pointerdown', onPointerDown);
            window.addEventListener('pointerup', onPointerUp);
            window.addEventListener('mouseleave', onPointerLeaveWindow);
            window.addEventListener('resize', scheduleRectRefresh, { passive: true });
            window.addEventListener('scroll', scheduleRectRefresh, { passive: true });

            cleanup = () => {
                if (visual.frame) window.cancelAnimationFrame(visual.frame);
                if (visual.rectFrame) window.cancelAnimationFrame(visual.rectFrame);
                window.clearTimeout(visual.detachTimer);
                document.removeEventListener('mousemove', updatePointer);
                window.removeEventListener('pointerdown', onPointerDown);
                window.removeEventListener('pointerup', onPointerUp);
                window.removeEventListener('mouseleave', onPointerLeaveWindow);
                window.removeEventListener('resize', scheduleRectRefresh);
                window.removeEventListener('scroll', scheduleRectRefresh);
                document.documentElement.classList.remove('has-magnetic-cursor');
                cursor.remove();

                items.forEach((item) => {
                    item.element.removeEventListener('mouseenter', item.onMouseEnter);
                    item.element.removeEventListener('mouseleave', item.onMouseLeave);
                    item.element.classList.remove('bp-magnetic', 'is-magnetic-active', 'is-magnetic-inside');
                    item.surfaceElement?.classList.remove('bp-magnetic-surface', 'is-magnetic-active', 'is-magnetic-inside');
                    item.element.style.removeProperty('--bp-magnetic-x');
                    item.element.style.removeProperty('--bp-magnetic-y');
                    item.surfaceElement?.style.removeProperty('--bp-magnetic-x');
                    item.surfaceElement?.style.removeProperty('--bp-magnetic-y');
                    item.surfaceElement?.style.removeProperty('--bp-magnetic-radius');
                });
            };
        };

        setup();
        window.addEventListener('resize', setup, { passive: true });
        motionQuery.addEventListener?.('change', setup);
        pointerQuery.addEventListener?.('change', setup);
    };

    const closeMenu = () => {
        if (!header || !menuToggle) return;
        header.classList.remove('is-open');
        document.body.classList.remove('nav-open');
        menuToggle.setAttribute('aria-expanded', 'false');
    };

    const openModal = () => {
        if (!modal) return;
        lastFocusedElement = document.activeElement instanceof HTMLElement ? document.activeElement : null;
        modal.classList.add('is-open');
        modal.classList.remove('is-sent');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        closeMenu();
        setPageInert(true);

        window.setTimeout(focusFirstModalElement, 80);
    };

    const closeModal = (restoreFocus = true) => {
        if (!modal) return;
        modal.classList.remove('is-open', 'is-sent');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');
        setPageInert(false);
        leadForm?.reset();

        if (restoreFocus && lastFocusedElement?.isConnected) {
            lastFocusedElement.focus();
        }
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

    phoneInputs.forEach((input) => {
        input.addEventListener('focus', () => {
            maskPhoneInput(input);
        });

        input.addEventListener('input', (event) => {
            maskPhoneInput(input, event.inputType);
        });

        input.addEventListener('paste', () => {
            window.requestAnimationFrame(() => maskPhoneInput(input));
        });

        input.addEventListener('blur', () => {
            if (!getPhoneDigits(input.value).length) {
                input.value = '';
                phoneMaskState.delete(input);
            }
        });
    });

    leadForm?.addEventListener('submit', (event) => {
        event.preventDefault();
        modal?.classList.add('is-sent');

        window.setTimeout(closeModal, 2600);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Tab') {
            trapModalFocus(event);
            return;
        }

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
    initMagneticCursor();
    setActiveSection();
})();
