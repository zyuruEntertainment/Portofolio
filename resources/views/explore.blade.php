<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <meta
        name="description"
        content="Explore the profile, projects, and social media of zyuruEntertainment."
    >

    <title>Explore | zyuruEntertainment</title>

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
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
</head>

<body>
    <div class="site-shell">

        {{-- Header --}}
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

        {{-- Main content --}}
        <main class="explore-main">

            <section class="explore-intro">
                <p class="explore-eyebrow">
                    A LITTLE MORE ABOUT ME
                </p>

                <h1 class="explore-title">
                    Explore what
                    <span>I create.</span>
                </h1>

                <p class="explore-description">
                    Get to know the developer, explore the projects,
                    and discover the places where I share my work.
                    One step at a time, from ideas to reality.
                </p>

                <div class="explore-caption">
                    <span class="explore-caption-dot"></span>
                    <span>Independent developer</span>
                </div>
            </section>

            {{-- Navigation previews: intentionally non-clickable --}}
            <section
                class="explore-navigation"
                aria-label="Explore sections"
            >

                {{-- Profile --}}
                <div class="explore-card">
                    <div class="explore-card-top">
                        <span class="explore-card-number">
                            01
                        </span>

                        <svg
                            class="explore-card-icon"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <circle cx="12" cy="8" r="4"></circle>
                            <path d="M5 21v-2a7 7 0 0 1 14 0v2"></path>
                        </svg>
                    </div>

                    <div class="explore-card-bottom">
                        <div>
                            <h2 class="explore-card-title">
                                Profile
                            </h2>

                            <p class="explore-card-description">
                                The person behind the projects.
                            </p>
                        </div>

                        <span
                            class="explore-card-arrow"
                            aria-hidden="true"
                        >
                            ↗
                        </span>
                    </div>
                </div>

                {{-- Projects --}}
                <div class="explore-card">
                    <div class="explore-card-top">
                        <span class="explore-card-number">
                            02
                        </span>

                        <svg
                            class="explore-card-icon"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <rect x="3" y="4" width="18" height="16" rx="2"></rect>
                            <path d="M8 4v16M3 9h5M3 15h5"></path>
                        </svg>
                    </div>

                    <div class="explore-card-bottom">
                        <div>
                            <h2 class="explore-card-title">
                                Projects
                            </h2>

                            <p class="explore-card-description">
                                Games, software, and experiments.
                            </p>
                        </div>

                        <span
                            class="explore-card-arrow"
                            aria-hidden="true"
                        >
                            ↗
                        </span>
                    </div>
                </div>

                {{-- Social Media --}}
                <div class="explore-card">
                    <div class="explore-card-top">
                        <span class="explore-card-number">
                            03
                        </span>

                        <svg
                            class="explore-card-icon"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <circle cx="18" cy="5" r="3"></circle>
                            <circle cx="6" cy="12" r="3"></circle>
                            <circle cx="18" cy="19" r="3"></circle>
                            <path d="m8.7 10.7 6.6-4.4M8.7 13.3l6.6 4.4"></path>
                        </svg>
                    </div>

                    <div class="explore-card-bottom">
                        <div>
                            <h2 class="explore-card-title">
                                Social Media
                            </h2>

                            <p class="explore-card-description">
                                Updates, ideas, and things I share.
                            </p>
                        </div>

                        <span
                            class="explore-card-arrow"
                            aria-hidden="true"
                        >
                            ↗
                        </span>
                    </div>
                </div>

            </section>

        </main>

        {{-- Footer --}}
        <footer class="footer">
            <span>
                © <span id="year">2026</span> zyuruEntertainment
            </span>

            <span class="footer-label">
                GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY
            </span>
        </footer>

    </div>

    {{-- Theme controller: same behavior as the homepage --}}
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