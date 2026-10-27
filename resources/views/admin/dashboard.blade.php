<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Admin Dashboard | zyuruEntertainment</title>

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
    <div class="site-shell admin-shell">
        <header class="header admin-header">
            <a class="wordmark" href="{{ url('/') }}" aria-label="zyuruEntertainment homepage">
                zyuruEntertainment
            </a>

            <div class="admin-header-actions">
                <div class="admin-user-menu">
                    <button class="admin-user-toggle" type="button" aria-expanded="false" aria-label="Admin menu">
                        <span class="admin-avatar">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                        </span>
                        <span class="admin-label">{{ Auth::guard('admin')->user()->name ?? 'Admin' }}</span>
                    </button>

                    <div class="admin-dropdown" role="menu">
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-logout" role="menuitem">Logout</button>
                        </form>
                    </div>
                </div>

                <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch color theme" title="Switch color theme">
                    <svg id="themeIcon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="12" cy="12" r="4"></circle>
                        <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
                        <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
                        <path d="m4.93 19.07 1.42-1.42m11.3-11.3 1.42-1.42"></path>
                    </svg>
                </button>
            </div>
        </header>

        <div class="admin-layout">
            <aside class="admin-sidebar">
                <nav class="sidebar-nav" aria-label="Admin navigation">
                    <a href="{{ route('admin.profile.edit') }}" class="sidebar-item">Profile</a>
                    <a href="#" class="sidebar-item">Projects</a>
                    <a href="#" class="sidebar-item">Social Media</a>
                </nav>
            </aside>

            <main class="dashboard-main dashboard-main--empty">
                <section class="dashboard-hero dashboard-hero--empty">
                    <p class="eyebrow">Dashboard</p>
                    <h1>Welcome back, {{ Auth::guard('admin')->user()->name ?? 'Admin' }}.</h1>
                    <p>Manage updates, content, and the direction of the brand with clarity.</p>
                </section>
            </main>
        </div>
    </div>

    <script>
        const root = document.documentElement;
        const toggle = document.getElementById("themeToggle");
        const icon = document.getElementById("themeIcon");
        const themeColor = document.querySelector('meta[name="theme-color"]');

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

        const userToggle = document.querySelector(".admin-user-toggle");
        const dropdown = document.querySelector(".admin-dropdown");

        userToggle.addEventListener("click", () => {
            const isOpen = dropdown.classList.toggle("is-open");
            userToggle.setAttribute("aria-expanded", String(isOpen));
        });

        document.addEventListener("click", (event) => {
            if (!event.target.closest(".admin-user-menu")) {
                dropdown.classList.remove("is-open");
                userToggle.setAttribute("aria-expanded", "false");
            }
        });
    </script>
</body>
</html>

