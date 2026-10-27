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

            const dark = window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches;

            const active = theme === "auto"
                ? (dark ? "dark" : "light")
                : theme;

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
<div class="site-shell admin-shell">

    <header class="header admin-header">
        <a class="wordmark"
           href="{{ url('/') }}"
           aria-label="zyuruEntertainment homepage">
            zyuruEntertainment
        </a>

        <div class="admin-header-actions">
            <div class="admin-user-menu">
                <button class="admin-user-toggle"
                        type="button"
                        aria-expanded="false"
                        aria-label="Admin menu">

                    <span class="admin-avatar">
                        {{ strtoupper(substr(Auth::guard('admin')->user()->name ?? 'A', 0, 1)) }}
                    </span>

                    <span class="admin-label">
                        {{ Auth::guard('admin')->user()->name ?? 'Admin' }}
                    </span>

                    <svg class="admin-user-chevron"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="1.6"
                         stroke-linecap="round"
                         stroke-linejoin="round"
                         aria-hidden="true">
                        <path d="m7 10 5 5 5-5"></path>
                    </svg>
                </button>

                <div class="admin-dropdown" role="menu">
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit"
                                class="dropdown-logout"
                                role="menuitem">
                            Log out
                        </button>
                    </form>
                </div>
            </div>

            <button class="theme-toggle"
                    id="themeToggle"
                    type="button"
                    aria-label="Switch color theme"
                    title="Switch color theme">
                <svg id="themeIcon"
                     viewBox="0 0 24 24"
                     fill="none"
                     stroke="currentColor"
                     stroke-width="1.5"
                     stroke-linecap="round"
                     stroke-linejoin="round"
                     aria-hidden="true">
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
                    <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
                    <path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>
                </svg>
            </button>
        </div>
    </header>

    <div class="admin-layout">

        <aside class="admin-sidebar">
            <p class="sidebar-heading">Workspace</p>

            <nav class="sidebar-nav" aria-label="Admin navigation">

                <a href="{{ route('admin.dashboard', ['section' => 'profile']) }}"
                   class="sidebar-item {{ $section === 'profile' ? 'is-active' : '' }}"
                   @if ($section === 'profile') aria-current="page" @endif>
                    <span class="sidebar-item-number">01</span>
                    <span>Profile</span>
                    <span class="sidebar-arrow" aria-hidden="true">↗</span>
                </a>

                <a href="{{ route('admin.dashboard', ['section' => 'projects']) }}"
                   class="sidebar-item {{ $section === 'projects' ? 'is-active' : '' }}"
                   @if ($section === 'projects') aria-current="page" @endif>
                    <span class="sidebar-item-number">02</span>
                    <span>Projects</span>
                    <span class="sidebar-arrow" aria-hidden="true">↗</span>
                </a>

                <a href="{{ route('admin.dashboard', ['section' => 'social-media']) }}"
                   class="sidebar-item {{ $section === 'social-media' ? 'is-active' : '' }}"
                   @if ($section === 'social-media') aria-current="page" @endif>
                    <span class="sidebar-item-number">03</span>
                    <span>Social Media</span>
                    <span class="sidebar-arrow" aria-hidden="true">↗</span>
                </a>

            </nav>
        </aside>

        <main class="dashboard-main">

            @if (session('status'))
                <div class="status-message" role="status">
                    {{ session('status') }}
                </div>
            @endif

            {{-- PROFILE SECTION --}}
            @if ($section === 'profile')

                <section class="dashboard-section">

                    <div class="dashboard-section-heading">
                        <div>
                            <p class="eyebrow">Admin / Profile</p>
                            <h1 class="dashboard-title">Profile overview.</h1>
                            <p class="dashboard-description">
                                Manage the information displayed on your public profile.
                            </p>
                        </div>
                    </div>

                    <article class="profile-overview-card">

                        <div class="profile-overview-top">
                            <div class="profile-overview-avatar">
                                @if ($profile?->icon_path)
                                    <img
                                        src="{{ asset('storage/' . $profile->icon_path) }}"
                                        alt="{{ $profile->name ? $profile->name . ' profile photo' : 'Profile photo' }}">
                                @else
                                    <span>
                                        {{ strtoupper(substr($profile?->name ?? 'P', 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            <div class="profile-overview-identity">
                                <p class="profile-card-label">Public profile</p>

                                <h2>
                                    {{ $profile?->name ?: 'Your profile name' }}
                                </h2>

                                <p class="profile-overview-description">
                                    {{ $profile?->description ?: 'Your short description will appear here after you add it.' }}
                                </p>
                            </div>
                        </div>

                        <div class="profile-overview-divider"></div>

                        <div class="profile-overview-body">
                            <p class="profile-card-label">Overview</p>

                            @if ($profile?->overview)
                                <p class="profile-overview-text">{{ $profile->overview }}</p>
                            @else
                                <p class="profile-overview-text is-placeholder">
                                    No overview has been added yet.
                                    Edit your profile to add one.
                                </p>
                            @endif
                        </div>

                        <div class="profile-overview-actions">
                            <a class="primary-button"
                               href="{{ route('admin.profile.edit') }}">
                                <span>Edit profile</span>
                                <span aria-hidden="true">↗</span>
                            </a>
                        </div>

                    </article>
                </section>

            {{-- PROJECTS SECTION --}}
            @elseif ($section === 'projects')

                <section class="dashboard-section">
                    <div class="dashboard-section-heading">
                        <div>
                            <p class="eyebrow">Admin / Projects</p>
                            <h1 class="dashboard-title">Projects.</h1>
                            <p class="dashboard-description">
                                Review and manage the projects displayed in your portfolio.
                            </p>
                        </div>
                    </div>

                    <article class="dashboard-placeholder-card">
                        <div class="dashboard-placeholder-icon" aria-hidden="true">02</div>

                        <div class="dashboard-placeholder-copy">
                            <h2>Project management is coming next.</h2>
                            <p>
                                This dashboard section is ready, but project storage
                                and editing have not been connected yet.
                            </p>
                        </div>

                        <button class="ghost-button"
                                type="button"
                                disabled
                                aria-disabled="true">
                            Edit projects · Soon
                        </button>
                    </article>
                </section>

            {{-- SOCIAL MEDIA SECTION --}}
            @else

                <section class="dashboard-section">
                    <div class="dashboard-section-heading">
                        <div>
                            <p class="eyebrow">Admin / Social Media</p>
                            <h1 class="dashboard-title">Social media.</h1>
                            <p class="dashboard-description">
                                Manage the social links shown across your portfolio.
                            </p>
                        </div>
                    </div>

                    <article class="dashboard-placeholder-card">
                        <div class="dashboard-placeholder-icon" aria-hidden="true">03</div>

                        <div class="dashboard-placeholder-copy">
                            <h2>Social media management is coming next.</h2>
                            <p>
                                This section has its own dashboard view.
                                Editing will be enabled after its data and save flow
                                are implemented.
                            </p>
                        </div>

                        <button class="ghost-button"
                                type="button"
                                disabled
                                aria-disabled="true">
                            Edit social media · Soon
                        </button>
                    </article>
                </section>

            @endif

        </main>
    </div>
</div>

<script>
    const root = document.documentElement;
    const toggle = document.getElementById("themeToggle");
    const icon = document.getElementById("themeIcon");
    const themeColor = document.querySelector('meta[name="theme-color"]');

    const sunIcon = '<circle cx="12" cy="12" r="4"></circle><path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path><path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path><path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>';

    const moonIcon = '<path d="M20.9 13A9 9 0 0 1 11 3.1 9 9 0 1 0 20.9 13Z"></path>';

    const systemTheme = window.matchMedia("(prefers-color-scheme: dark)");

    function applyTheme(theme) {
        const active = theme === "auto"
            ? (systemTheme.matches ? "dark" : "light")
            : theme;

        root.dataset.theme = theme;
        root.dataset.activeTheme = active;
        root.style.colorScheme = active;

        themeColor.content = active === "dark"
            ? "#0b0b0b"
            : "#ffffff";

        icon.innerHTML = active === "dark" ? moonIcon : sunIcon;
    }

    toggle.addEventListener("click", () => {
        const next = root.dataset.activeTheme === "light"
            ? "dark"
            : "light";

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

    applyTheme(root.dataset.theme || "auto");

    const userToggle = document.querySelector(".admin-user-toggle");
    const dropdown = document.querySelector(".admin-dropdown");

    userToggle.addEventListener("click", () => {
        const open = dropdown.classList.toggle("is-open");
        userToggle.setAttribute("aria-expanded", String(open));
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
