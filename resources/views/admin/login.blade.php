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

            const systemDark = window.matchMedia("(prefers-color-scheme: dark)").matches;
            const activeTheme = theme === "auto" ? (systemDark ? "dark" : "light") : theme;

            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.activeTheme = activeTheme;
            document.documentElement.style.colorScheme = activeTheme;
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="site-shell admin-shell admin-shell--login">
        <header class="header admin-header admin-header--login">
            <a class="wordmark" href="{{ url('/') }}" aria-label="zyuruEntertainment homepage">
                zyuruEntertainment
            </a>

            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch color theme" title="Switch color theme">
                <svg id="themeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
                    <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
                    <path d="m4.93 19.07 1.42-1.42m11.3-11.3 1.42-1.42"></path>
                </svg>
            </button>
        </header>

        <main class="admin-main admin-main--login">
            <section class="admin-panel admin-panel--login">
                <div class="admin-panel-copy">
                    <p class="eyebrow">Admin access</p>
                    <h1>Sign in to your control panel.</h1>
                    <p>Manage projects, content, and the digital presence of zyuruEntertainment.</p>
                </div>

                <form class="admin-form" method="POST" action="{{ route('admin.login.submit') }}">
                    @csrf

                    <div class="field-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@zyuru.com" required autofocus>
                        @error('email')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field-group">
                        <label for="password">Password</label>
                        <input id="password" type="password" name="password" placeholder="Enter password" required>
                    </div>

                    <div class="form-row">
                        <label class="checkbox-wrap">
                            <input type="checkbox" name="remember" value="1">
                            <span>Remember me</span>
                        </label>
                        <a href="{{ url('/') }}">Back to website</a>
                    </div>

                    <button type="submit" class="primary-button">Login</button>
                </form>
            </section>
        </main>
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
            <path d="m4.93 19.07 1.42-1.42m11.3-11.3 1.42-1.42"></path>
        `;

        const moonIcon = `
            <path d="M20.9 13A9 9 0 0 1 11 3.1 9 9 0 1 0 20.9 13Z"></path>
        `;

        const systemTheme = window.matchMedia("(prefers-color-scheme: dark)");

        function applyTheme(theme) {
            const activeTheme = theme === "auto" ? (systemTheme.matches ? "dark" : "light") : theme;
            root.dataset.theme = theme;
            root.dataset.activeTheme = activeTheme;
            root.style.colorScheme = activeTheme;
            themeColor.content = activeTheme === "dark" ? "#0b0b0b" : "#ffffff";
            icon.innerHTML = activeTheme === "dark" ? moonIcon : sunIcon;
        }

        toggle.addEventListener("click", () => {
            const current = root.dataset.theme === "dark" ? "light" : "dark";
            localStorage.setItem("zyuru-theme", current);
            applyTheme(current);
        });

        applyTheme(root.dataset.theme || "auto");
    </script>
</body>
</html>
