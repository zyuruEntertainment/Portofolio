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

    @include('partials.theme-init')

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

            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">@include('partials.theme-icon')</button>
        </header>

        {{-- Main content --}}
        <main class="explore-main">

            <section class="explore-intro">
                
                <h1 class="explore-title">
                    Explore what
                    <span>I create.</span>
                </h1>

                <p class="explore-description">
                    Get to know the developer, explore the projects, and discover where I share my work. Every idea is a step toward learning, creating, and turning concepts into reality.
                </p>

                <div class="explore-caption">
                    <span class="explore-caption-dot"></span>
                    <span>Independent developer</span>
                </div>

                <div class="explore-actions">
                    <a
                        class="discover-button"
                        href="{{ url('/') }}"
                        aria-label="Back to the homepage"
                    >
                        <span>Back to home</span>

                        <svg
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="1.7"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            aria-hidden="true"
                        >
                            <path d="M19 19 5 5"></path>
                            <path d="M18 5H5v13"></path>
                        </svg>
                    </a>
                </div>
            </section>

            {{-- Navigation previews: intentionally non-clickable --}}
            <section
                class="explore-navigation"
                aria-label="Explore sections"
            >

                {{-- Profile --}}
                <a href="{{ route('profile') }}" class="explore-card" aria-label="Open profile page">
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
                </a>

                {{-- Projects --}}
                <a href="{{ route('projects') }}"
                    class="explore-card"
                    aria-label="Open projects page">
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
                </a>

                {{-- Social Media --}}
                <a href="{{ route('social-media') }}"
                    class="explore-card"
                    aria-label="Open social media page">
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
                </a>

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
    <script src="{{ asset('js/theme.js') }}" defer></script>
</body>
</html>
