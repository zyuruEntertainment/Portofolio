<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Explore zyuruEntertainment profile, projects, and social media.">

    <title>Explore | zyuruEntertainment</title>

    <script>
        (() => {
            let theme = "auto";

            try {
                theme = localStorage.getItem("zyuru-theme") || "auto";
            } catch {}

            const dark = window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches;

            const active = theme === "auto"
                ? (dark ? "dark" : "light")
                : theme;

            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.activeTheme = active;
            document.documentElement.style.colorScheme = active;
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
</head>

<body>
    <div class="site-shell explore-shell">
        <header class="header">
            <a class="wordmark" href="{{ url('/') }}" aria-label="Homepage">
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

        <main class="explore-main">
            <div class="explore-layout">
                <section class="explore-content">
                    <div class="explore-intro">
                        <span class="explore-eyebrow">
                            DISCOVER / ZYURU
                        </span>

                        <h1 class="explore-title">
                            Find your
                            <span>way around.</span>
                        </h1>

                        <p class="explore-description">
                            Explore my profile, discover the projects I build,
                            and find me across social platforms. A place to learn
                            more about my work, ideas, and journey in technology.
                        </p>
                    </div>

                    <nav class="explore-list" aria-label="Explore sections">
                        <button
                            class="explore-item"
                            type="button"
                            aria-disabled="true"
                            title="Profile section coming soon"
                        >
                            <span class="explore-number">01</span>

                            <span class="explore-item-content">
                                <span class="explore-item-title">Profile</span>
                                <span class="explore-item-description">
                                    Learn more about me and what I do.
                                </span>
                            </span>

                            <svg
                                class="explore-arrow"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M7 17 17 7M7 7h10v10"></path>
                            </svg>
                        </button>

                        <button
                            class="explore-item"
                            type="button"
                            aria-disabled="true"
                            title="Projects section coming soon"
                        >
                            <span class="explore-number">02</span>

                            <span class="explore-item-content">
                                <span class="explore-item-title">Projects</span>
                                <span class="explore-item-description">
                                    Explore my software, games, and experiments.
                                </span>
                            </span>

                            <svg
                                class="explore-arrow"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M7 17 17 7M7 7h10v10"></path>
                            </svg>
                        </button>

                        <button
                            class="explore-item"
                            type="button"
                            aria-disabled="true"
                            title="Social media section coming soon"
                        >
                            <span class="explore-number">03</span>

                            <span class="explore-item-content">
                                <span class="explore-item-title">Social Media</span>
                                <span class="explore-item-description">
                                    Find my other profiles and social platforms.
                                </span>
                            </span>

                            <svg
                                class="explore-arrow"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.6"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                aria-hidden="true"
                            >
                                <path d="M7 17 17 7M7 7h10v10"></path>
                            </svg>
                        </button>
                    </nav>

                    <p class="explore-note">
                        <span class="explore-note-dot"></span>
                        More sections are currently in development.
                    </p>
                </section>

                <aside class="explore-visual" aria-label="About my work">
                    <div class="visual-topline">
                        <span>CREATIVE TECHNOLOGY</span>
                        <span class="visual-status">
                            <span></span>
                            IN PROGRESS
                        </span>
                    </div>

                    <div class="visual-art" aria-hidden="true">
                        <div class="orbit orbit-one"></div>
                        <div class="orbit orbit-two"></div>

                        <div class="visual-cross visual-cross-top">+</div>
                        <div class="visual-cross visual-cross-bottom">+</div>

                        <div class="visual-core">
                            <span class="core-bracket core-bracket-top"></span>
                            <span class="core-symbol">&lt;/&gt;</span>
                            <span class="core-bracket core-bracket-bottom"></span>
                        </div>

                        <span class="visual-coordinate coordinate-left">
                            01 / CREATE
                        </span>
                        <span class="visual-coordinate coordinate-right">
                            02 / BUILD
                        </span>
                    </div>

                    <div class="visual-caption">
                        <span class="visual-index">FIELD NOTES / 001</span>
                        <h2>Ideas into reality.</h2>
                        <p>
                            Building games, exploring software,
                            and learning by making things work.
                        </p>
                    </div>

                    <div class="visual-tags" aria-label="Areas of interest">
                        <span>GAME DEVELOPMENT</span>
                        <span>SOFTWARE</span>
                        <span>EXPERIMENTS</span>
                    </div>
                </aside>
            </div>
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
            const active = theme === "auto"
                ? (systemTheme.matches ? "dark" : "light")
                : theme;

            root.dataset.theme = theme;
            root.dataset.activeTheme = active;
            root.style.colorScheme = active;

            themeColor.content = active === "dark"
                ? "#0b0b0b"
                : "#ffffff";

            icon.innerHTML = active === "dark" ? moonIcon : sunIcon;
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
