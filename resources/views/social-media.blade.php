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
        <section class="social-media-intro">
            <h1 class="social-media-title">
                <span>Connect with</span>
                <span>us</span>
            </h1>
            <p class="social-media-description">
                Follow our latest updates, projects, and experiments across social platforms.
            </p>
        </section>

        <section class="social-media-list" aria-label="Social media links">
            @forelse ($links as $link)
                <a href="{{ $link->url }}" target="_blank" rel="noopener"
                   class="social-link-item{{ $link->isValid() ? '' : ' social-link-item--invalid' }}"
                   aria-label="Visit {{ strtoupper($link->platform) }}">
                    <span class="social-link-label">{{ strtoupper($link->platform) }}</span>
                    <span class="social-link-logo" aria-hidden="true">
                        @include('partials.social-logo', ['platform' => $link->platform, 'valid' => $link->isValid()])
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
