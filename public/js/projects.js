(() => {
    const modal = document.getElementById('projectModal');

    if (!modal) return;

    const panel = modal.querySelector('.project-modal-panel');
    const modalLogo = document.getElementById('modalLogo');
    const modalLogoFallback = document.getElementById('modalLogoFallback');
    let previousFocus = null;

    function closeModal() {
        if (!modal.classList.contains('is-open')) return;

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.classList.remove('modal-open');

        if (previousFocus?.isConnected) previousFocus.focus();
    }

    function openModal(card) {
        const dataElement = document.getElementById(`project-data-${card.dataset.project}`);

        if (!dataElement) return;

        const project = JSON.parse(dataElement.textContent);
        previousFocus = card;

        document.getElementById('modalTitle').textContent = project.title;
        document.getElementById('modalStatus').textContent = project.status;
        document.getElementById('modalDescription').textContent = project.description;
        document.getElementById('modalDetail').href = project.detailUrl;

        modalLogoFallback.textContent = project.title.slice(0, 1).toUpperCase();
        modalLogoFallback.hidden = true;
        modalLogo.hidden = false;
        modalLogo.src = project.logo;
        modalLogo.alt = `${project.title} logo`;

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.classList.add('modal-open');
        panel.focus();
    }

    document.querySelectorAll('.public-project-card').forEach((card) => {
        const logo = card.querySelector('.project-logo');
        const fallback = card.querySelector('.project-logo-fallback');

        logo.addEventListener('error', () => {
            logo.hidden = true;
            fallback.hidden = false;
        }, { once: true });

        card.addEventListener('click', () => openModal(card));
    });

    modalLogo.addEventListener('error', () => {
        modalLogo.hidden = true;
        modalLogoFallback.hidden = false;
    });

    modal.querySelectorAll('[data-close], #modalCancel').forEach((element) => {
        element.addEventListener('click', closeModal);
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('is-open')) {
            closeModal();
        }

        if (event.key !== 'Tab' || !modal.classList.contains('is-open')) return;

        const focusable = [...panel.querySelectorAll('a[href], button:not([disabled])')]
            .filter((element) => !element.hidden);

        if (document.activeElement !== panel && !panel.contains(document.activeElement)) {
            event.preventDefault();
            (event.shiftKey ? focusable.at(-1) : focusable[0]).focus();
        } else if (event.shiftKey && document.activeElement === panel) {
            event.preventDefault();
            focusable.at(-1).focus();
        } else if (event.shiftKey && document.activeElement === focusable[0]) {
            event.preventDefault();
            focusable.at(-1).focus();
        } else if (!event.shiftKey && document.activeElement === focusable.at(-1)) {
            event.preventDefault();
            focusable[0].focus();
        }
    });
})();
