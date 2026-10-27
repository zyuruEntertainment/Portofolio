<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <meta
        name="description"
        content="Projects by zyuruEntertainment."
    >

    <title>Projects | zyuruEntertainment</title>

    <script>
        (() => {
            let theme = "auto";

            try {
                theme = localStorage.getItem("zyuru-theme") || "auto";
            } catch {}

            const systemDark = window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches;

            const activeTheme = theme === "auto"
                ? (systemDark ? "dark" : "light")
                : theme;

            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.activeTheme = activeTheme;
            document.documentElement.style.colorScheme = activeTheme;
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
</head>

<body>
    <div class="site-shell">

        <header class="header">
            <a
                class="wordmark"
                href="{{ url('/') }}"
                aria-label="zyuruEntertainment homepage"
            >
                zyuruEntertainment
            </a>

            <button
                class="theme-toggle"
                id="themeToggle"
                type="button"
                aria-label="Switch color theme"
                title="Switch color theme"
            >
                <svg
                    id="themeIcon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
                    <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
                    <path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>
                </svg>
            </button>
        </header>

        <main class="projects-main">
            <p class="projects-empty">
                this page is empty
            </p>
        </main>

        <footer class="footer">
            <span>
                © <span id="year">2026</span> zyuruEntertainment
            </span>

            <span class="footer-label">
                GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY
            </span>
        </footer>

    </div>

    <script>
        const root = document.documentElement;
        const toggle = document.getElementById("themeToggle");
        const icon = document.getElementById("themeIcon");
        const themeColor = document.querySelector(
            'meta[name="theme-color"]'
        );

        const sunIcon = `
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
            <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
            <path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>
        `;

        const moonIcon = `
            <path d="M20.9 13A9 9 0 0 1 11 3.1
                9 9 0 1 0 20.9 13Z"></path>
        `;

        const systemTheme = window.matchMedia(
            "(prefers-color-scheme: dark)"
        );

        function applyTheme(theme) {
            const activeTheme = theme === "auto"
                ? (systemTheme.matches ? "dark" : "light")
                : theme;

            root.dataset.theme = theme;
            root.dataset.activeTheme = activeTheme;
            root.style.colorScheme = activeTheme;

            themeColor.content = activeTheme === "dark"
                ? "#0b0b0b"
                : "#ffffff";

            icon.innerHTML = activeTheme === "dark"
                ? moonIcon
                : sunIcon;

            toggle.title = `Theme: ${theme}`;

            toggle.setAttribute(
                "aria-label",
                `Current theme: ${theme}. Switch theme`
            );
        }

        toggle.addEventListener("click", () => {
            const next = root.dataset.activeTheme === "light"
                ? "dark"
                : "light";

            try {
                localStorage.setItem("zyuru-theme", next);
            } catch {}

            applyTheme(next);
        });

        systemTheme.addEventListener("change", () => {
            if (root.dataset.theme === "auto") {
                applyTheme("auto");
            }
        });

        document.getElementById("year").textContent =
            new Date().getFullYear();

        applyTheme(root.dataset.theme || "auto");
    </script>
</body>
</html>
