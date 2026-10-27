<script>
    (() => {
        let preference = 'auto';

        try {
            preference = localStorage.getItem('zyuru-theme') || 'auto';
        } catch {}

        if (!['light', 'dark', 'auto'].includes(preference)) {
            preference = 'auto';
        }

        const active = preference === 'auto'
            ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')
            : preference;
        const root = document.documentElement;

        root.dataset.theme = preference;
        root.dataset.activeTheme = active;
        root.style.colorScheme = active;

        const themeColor = document.querySelector('meta[name="theme-color"]');
        if (themeColor) themeColor.content = active === 'dark' ? '#0b0b0b' : '#ffffff';
    })();
</script>
