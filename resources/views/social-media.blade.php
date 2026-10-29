<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Social media links by zyuruEntertainment.">
    <title>Social Media | zyuruEntertainment</title>
    @include('partials.theme-init')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/social-media.css') }}">
</head>
<body>
<div class="site-shell">
    <header class="header">
        <a class="wordmark" href="{{ url('/') }}" aria-label="zyuruEntertainment homepage">zyuruEntertainment</a>
        <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">
            @include('partials.theme-icon')
        </button>
    </header>

    <main class="social-media-main">
        <section class="social-media-intro" aria-labelledby="social-media-title">
            <h1 class="social-media-title" id="social-media-title">
                <span>Connect with</span>
                <span>us</span>
            </h1>
            <p class="social-media-description">
                Follow our latest updates, projects, and experiments across social platforms.
            </p>
            <a class="discover-button social-media-back-link" href="{{ route('explore') }}">
                <span>Back to Explore</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 19 19 5"></path>
                    <path d="M6 5h13v13"></path>
                </svg>
            </a>
        </section>

        <section class="social-media-list" aria-label="Social media links">
            @forelse ($links as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener"
                   class="social-media-card{{ $link->isValid() ? '' : ' social-media-card--invalid' }}"
                   aria-label="Visit {{ ucfirst($link->platform) }}">
                    <span class="social-media-card-top">
                        <span class="social-media-logo-frame">
                            @include('partials.social-logo', ['platform' => $link->platform, 'valid' => $link->isValid()])
                        </span>
                        <span class="social-media-card-arrow" aria-hidden="true">↗</span>
                    </span>
                    <span class="social-media-card-copy">
                        <strong>{{ ucfirst($link->platform) }}</strong>
                        <span>Follow our updates and new work on {{ ucfirst($link->platform) }}.</span>
                    </span>
                </a>
            @empty
                <p class="social-media-empty">No social links available yet.</p>
            @endforelse
        </section>
    </main>

    <footer class="footer">
        <span>© <span id="year">2026</span> zyuruEntertainment</span>
        <span class="footer-label">GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY</span>
    </footer>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
</body>
</html>
