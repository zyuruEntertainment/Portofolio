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

    @include('partials.theme-init')

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

            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">@include('partials.theme-icon')</button>
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

    <script src="{{ asset('js/theme.js') }}" defer></script>
</body>
</html>