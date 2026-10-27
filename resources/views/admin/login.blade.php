<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Admin Login | zyuruEntertainment</title>

    <script>
        (() => {
            let theme = "auto";

            try {
                theme = localStorage.getItem("zyuru-theme") || "auto";
            } catch {}

            const dark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const active = theme === "auto" ? (dark ? "dark" : "light") : theme;

            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.activeTheme = active;
            document.documentElement.style.colorScheme = active;
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-polish.css') }}">
</head>
<body>
<div class="site-shell admin-shell admin-shell--login">

    <header class="header admin-header admin-header--login">
        <a class="wordmark" href="{{ url('/') }}" aria-label="zyuruEntertainment homepage">
            zyuruEntertainment
        </a>

        <button class="theme-toggle" id="themeToggle" type="button"
            aria-label="Switch color theme" title="Switch color theme">
            <svg id="themeIcon" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                stroke-linejoin="round" aria-hidden="true">
                <circle cx="12" cy="12" r="4"></circle>
                <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
                <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
                <path d="m4.93 19.07 1.42-1.42m11.3-11.3 1.42-1.42"></path>
            </svg>
        </button>
    </header>

    <main class="admin-login-main">
        <section class="admin-login-intro">
            <p class="eyebrow">Private workspace</p>

            <h1 class="admin-login-title">
                A little space
                <span>to manage things.</span>
            </h1>

            <p class="admin-login-description">
                Sign in to manage the content behind zyuruEntertainment.
                Your projects and public profile stay in one place.
            </p>

            <div class="admin-login-caption">
                <span class="explore-caption-dot"></span>
                <span>Administrator access only</span>
            </div>
        </section>

        <section class="admin-login-form-section" aria-labelledby="login-heading">
            <div class="admin-login-form-heading">
                <p class="eyebrow">Welcome back</p>
                <h2 id="login-heading">Sign in</h2>
                <p>Use your administrator credentials to continue.</p>
            </div>

            @if ($errors->has('email') || $errors->has('password'))
                <div class="admin-login-error" role="alert">
                    {{ $errors->first('email') ?: $errors->first('password') }}
                </div>
            @endif

            <form class="admin-login-form" method="POST"
                action="{{ route('admin.login.submit') }}">
                @csrf

                <div class="field-group">
                    <label for="email">Email address</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        autocomplete="username"
                        placeholder="Enter your email"
                        required
                        autofocus
                    >
                </div>

                <div class="field-group">
                    <label for="password">Password</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        autocomplete="current-password"
                        placeholder="Enter your password"
                        required
                    >
                </div>

                <div class="admin-login-options">
                    <label class="admin-remember">
                        <input type="checkbox" name="remember" value="1">
                        <span>Remember me</span>
                    </label>

                    <a href="{{ url('/') }}">
                        Back to website <span aria-hidden="true">↗</span>
                    </a>
                </div>

                <button type="submit" class="primary-button admin-login-submit">
                    Sign in
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.7" stroke-linecap="round"
                        stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M13 6l6 6-6 6"></path>
                    </svg>
                </button>
            </form>

            <p class="admin-login-note">
                This area is reserved for the site administrator.
            </p>
        </section>
    </main>

    <footer class="footer">
        <span>© <span id="year">2026</span> zyuruEntertainment</span>
        <span class="footer-label">
            GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY
        </span>
    </footer>
</div>

<script>
    const root = document.documentElement;
    const toggle = document.getElementById("themeToggle");
    const themeColor = document.querySelector('meta[name="theme-color"]');
    const icon = document.getElementById("themeIcon");

    const sunIcon = `
        <circle cx="12" cy="12" r="4"></circle>
        <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
        <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
        <path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>
    `;

    const moonIcon = `
        <path d="M20.9 13A9 9 0 0 1 11 3.1 9 9 0 1 0 20.9 13Z"></path>
    `;

    const systemTheme = window.matchMedia("(prefers-color-scheme: dark)");

    function applyTheme(theme) {
        const active = theme === "auto"
            ? (systemTheme.matches ? "dark" : "light")
            : theme;

        root.dataset.theme = theme;
        root.dataset.activeTheme = active;
        root.style.colorScheme = active;
        themeColor.content = active === "dark" ? "#0b0b0b" : "#ffffff";
        icon.innerHTML = active === "dark" ? moonIcon : sunIcon;
    }

    toggle.addEventListener("click", () => {
        const next = root.dataset.activeTheme === "light" ? "dark" : "light";

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

    document.getElementById("year").textContent = new Date().getFullYear();
    applyTheme(root.dataset.theme || "auto");
</script>
</body>
</html>
