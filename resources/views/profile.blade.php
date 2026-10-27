<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="{{ $profile?->description ?? 'The profile of zyuruEntertainment.' }}">
    <title>{{ $profile?->name ?? 'Profile' }} | zyuruEntertainment</title>

    @include('partials.theme-init')

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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

        <main class="profile-hero">
            <section class="profile-content" aria-labelledby="profileName">

                <h1 class="profile-title" id="profileName">
                    {{ $profile?->name ?? 'Profile coming soon' }}
                </h1>

                @if ($profile)
                    <p class="profile-description">{{ $profile->description }}</p>

                    <div class="profile-overview">{{ $profile->overview }}</div>
                @else
                    <p class="profile-description">
                        This profile has not been published yet.
                    </p>

                    <div class="profile-overview">
                        Information about the developer will appear here once it has been added.
                    </div>
                @endif

                <div class="profile-actions">
                    <a
                        class="discover-button"
                        href="{{ route('explore') }}"
                        aria-label="Back to Explore"
                    >
                        <span>Back to Explore</span>

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

            <section
                class="profile-visual"
                aria-label="{{ $profile?->name ?? 'zyuruEntertainment' }} profile photo"
            >
                <div class="profile-logo-stage">
                    <div class="profile-logo-shadow"></div>

                    <div class="profile-logo-object">
                        <div class="profile-logo-face">
                            @if ($profile?->icon_path)
                                <img
                                    class="profile-photo"
                                    src="{{ asset('storage/' . $profile->icon_path) }}"
                                    alt="{{ $profile->name }} profile photo"
                                    draggable="false"
                                >
                            @else
                                <div
                                    class="profile-placeholder"
                                    aria-label="Profile photo placeholder"
                                >
                                    ZE
                                </div>
                            @endif
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
