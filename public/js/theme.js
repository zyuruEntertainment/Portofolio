(() => {
    const root = document.documentElement;
    const toggle = document.getElementById('themeToggle');
    const themeColor = document.querySelector('meta[name="theme-color"]');
    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)');

    function applyTheme(preference) {
        if (!['light', 'dark', 'auto'].includes(preference)) preference = 'auto';

        const active = preference === 'auto'
            ? (systemTheme.matches ? 'dark' : 'light')
            : preference;

        root.dataset.theme = preference;
        root.dataset.activeTheme = active;
        root.style.colorScheme = active;

        if (themeColor) {
            themeColor.content = active === 'dark' ? '#0b0b0b' : '#ffffff';
        }

        if (toggle) {
            const next = active === 'light' ? 'dark' : 'light';
            toggle.title = `Switch to ${next} theme`;
            toggle.setAttribute('aria-label', `Switch to ${next} theme`);
        }
    }

    if (toggle) {
        toggle.addEventListener('click', () => {
            const next = root.dataset.activeTheme === 'light' ? 'dark' : 'light';

            try {
                localStorage.setItem('zyuru-theme', next);
            } catch {}

            applyTheme(next);
        });
    }

    systemTheme.addEventListener('change', () => {
        if (root.dataset.theme === 'auto') applyTheme('auto');
    });

    window.addEventListener('storage', (event) => {
        if (event.key === 'zyuru-theme') applyTheme(event.newValue || 'auto');
    });

    const year = document.getElementById('year');
    if (year) year.textContent = new Date().getFullYear();

    applyTheme(root.dataset.theme || 'auto');
})();
