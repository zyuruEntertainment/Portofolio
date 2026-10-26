<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <meta
        name="description"
        content="zyuruEntertainment is an independent developer brand exploring game development, software engineering, and creative technology."
    >

    <title>zyuruEntertainment | Building Ideas into Reality</title>

    <script>
        (() => {
            let theme = "auto";

            try {
                theme = localStorage.getItem("zyuru-theme") || "auto";
            } catch {
                // Use the system theme when storage is unavailable.
            }

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
                    <path d="m4.93 19.07 1.42-1.42m11.3-11.3 1.42-1.42"></path>
                </svg>
            </button>
        </header>

        <main class="hero">
            <section class="hero-content">
                <h1 class="hero-title">
                    Building ideas
                    <span>into reality.</span>
                </h1>

                <p class="hero-description">
                    An independent developer exploring game development,
                    software engineering, and creative technology.
                    Turning curiosity into projects, experiments,
                    and meaningful digital experiences.
                </p>

                <div class="hero-actions">
                    <a
                        class="discover-button"
                        href="{{ url('/explore') }}"
                        aria-label="Explore the website"
                    >
                        <span>Discover</span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M5 19 19 5"></path>
                            <path d="M6 5h13v13"></path>
                        </svg>
                    </a>
                </div>
            </section>

            <section class="hero-visual" aria-label="zyuru logo">
                <div class="logo-stage">
                    <div class="logo-shadow"></div>

                    <div class="logo-object">
                        <div class="logo-face">
                            <img
                                class="logo-image logo-image--light"
                                src="{{ asset('asset/img/icon/light_logo.png') }}"
                                alt="zyuru logo for light theme"
                                draggable="false"
                            >

                            <img
                                class="logo-image logo-image--dark"
                                src="{{ asset('asset/img/icon/dark_logo.png') }}"
                                alt="zyuru logo for dark theme"
                                draggable="false"
                            >
                        </div>
                    </div>
                </div>
            </section>
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
            <path d="m4.93 19.07 1.42-1.42m11.3-11.3 1.42-1.42"></path>
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
            const current = root.dataset.activeTheme;
            const next = current === "light" ? "dark" : "light";

            try {
                localStorage.setItem("zyuru-theme", next);
            } catch {
                // Theme switching still works for this session.
            }

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