<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <title>Explore | zyuruEntertainment</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/explore.css') }}">
</head>
<body>
    <header class="site-header">
        <a class="wordmark" href="{{ url('/') }}"
           aria-label="zyuruEntertainment homepage">
            zyuruEntertainment
        </a>

        <button class="theme-toggle" id="themeToggle"
                type="button" aria-label="Toggle theme">
            <span class="theme-toggle-icon" aria-hidden="true"></span>
        </button>
    </header>

    <main class="explore-main">
        <section class="explore-content">
            <div class="explore-heading">
                <h1>Find your way around<span>.</span></h1>

                <p>
                    A little more about what I do, what I build,
                    and the things I'm exploring.
                </p>
            </div>

            <nav class="explore-links" aria-label="Explore pages">
                <a class="explore-link" href="{{ url('/about') }}">
                    <span class="explore-link-number">01</span>
                    <span class="explore-link-title">About</span>
                    <span class="explore-link-arrow" aria-hidden="true">↗</span>
                </a>

                <a class="explore-link" href="{{ url('/projects') }}">
                    <span class="explore-link-number">02</span>
                    <span class="explore-link-title">Projects</span>
                    <span class="explore-link-arrow" aria-hidden="true">↗</span>
                </a>

                <a class="explore-link" href="{{ url('/contact') }}">
                    <span class="explore-link-number">03</span>
                    <span class="explore-link-title">Contact</span>
                    <span class="explore-link-arrow" aria-hidden="true">↗</span>
                </a>
            </nav>

            <div class="explore-footer">
                <span>Independent developer</span>
                <span class="explore-footer-line"></span>
                <span>Explore <span id="currentYear"></span></span>
            </div>
        </section>
    </main>

    <script>
        const themeToggle = document.getElementById('themeToggle');
        const savedTheme = localStorage.getItem('zyuru-theme');

        if (savedTheme) {
            document.documentElement.dataset.theme = savedTheme;
        }

        function updateThemeIcon() {
            const isDark =
                document.documentElement.dataset.theme === 'dark';

            themeToggle.setAttribute(
                'aria-label',
                isDark ? 'Switch to light theme' : 'Switch to dark theme'
            );
        }

        updateThemeIcon();

        themeToggle.addEventListener('click', () => {
            const isDark =
                document.documentElement.dataset.theme === 'dark';

            const nextTheme = isDark ? 'light' : 'dark';

            document.documentElement.dataset.theme = nextTheme;
            localStorage.setItem('zyuru-theme', nextTheme);

            updateThemeIcon();
        });

        document.getElementById('currentYear').textContent =
            new Date().getFullYear();
    </script>
</body>
</html>
