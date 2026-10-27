<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Edit Profile | Admin | zyuruEntertainment</title>

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
<div class="site-shell admin-shell admin-shell--editor">

    <header class="header admin-header">
        <a class="wordmark"
           href="{{ route('admin.dashboard', ['section' => 'profile']) }}"
           aria-label="Back to admin dashboard">
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

    <main class="editor-main">
        <a class="editor-back-link"
           href="{{ route('admin.dashboard', ['section' => 'profile']) }}">
            ← Back to dashboard
        </a>

        <section class="edit-profile-heading">
            <p class="eyebrow">Profile settings</p>
            <h1>Edit profile.</h1>
            <p>
                Update the photo, description, and overview shown
                on your public profile.
            </p>
        </section>

        @if (session('status'))
            <div class="status-message" role="status">
                {{ session('status') }}
            </div>
        @endif

        <form class="profile-edit-form"
              method="POST"
              action="{{ route('admin.profile.update') }}"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="icon-upload-row">
                <div class="icon-preview" id="iconPreview">
                    @if ($profile?->icon_path)
                        <img
                            src="{{ asset('storage/' . $profile->icon_path) }}"
                            alt="Current profile photo">
                    @else
                        <span>Photo</span>
                    @endif
                </div>

                <div class="icon-upload-control">
                    <label for="icon">Profile photo</label>
                    <input id="icon"
                           name="icon"
                           type="file"
                           accept="image/png,image/jpeg,image/webp">

                    <p class="field-hint">
                        PNG, JPG, or WebP. Maximum 2 MB.
                    </p>

                    @error('icon')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="field-group">
                <label for="name">Name</label>
                <input id="name"
                       name="name"
                       type="text"
                       maxlength="100"
                       value="{{ old('name', $profile?->name) }}"
                       placeholder="Enter profile name"
                       required>

                @error('name')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="field-group">
                <label for="description">Description</label>
                <textarea id="description"
                          name="description"
                          rows="3"
                          maxlength="500"
                          placeholder="Write a short description"
                          required>{{ old('description', $profile?->description) }}</textarea>

                @error('description')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="field-group">
                <label for="overview">Overview</label>
                <textarea id="overview"
                          name="overview"
                          rows="7"
                          maxlength="5000"
                          placeholder="Write the profile overview"
                          required>{{ old('overview', $profile?->overview) }}</textarea>

                @error('overview')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a class="ghost-button"
                   href="{{ route('admin.dashboard', ['section' => 'profile']) }}">
                    Cancel
                </a>

                <button class="primary-button" type="submit">
                    Save profile
                </button>
            </div>
        </form>
    </main>
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

    document.getElementById("icon").addEventListener("change", (event) => {
        const file = event.target.files?.[0];

        if (!file) return;

        const preview = document.getElementById("iconPreview");
        const imageUrl = URL.createObjectURL(file);

        preview.innerHTML = "";

        const image = document.createElement("img");
        image.src = imageUrl;
        image.alt = "Selected profile photo preview";

        image.onload = () => URL.revokeObjectURL(imageUrl);

        preview.appendChild(image);
    });
</script>
</body>
</html>
