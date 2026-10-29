<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Change Password | Admin | zyuruEntertainment</title>

    @include('partials.theme-init')

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
                        <button type="submit" class="dropdown-logout" role="menuitem">
                            Log out
                        </button>
                    </form>
                </div>
            </div>

            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">@include('partials.theme-icon')</button>
        </div>
    </header>

    <main class="editor-main">
        <section class="edit-profile-heading">
            <p class="eyebrow">Account security</p>
            <h1>Change password.</h1>
            <p>Update the password used to access this admin account.</p>
        </section>

        @if (session('status'))
            <div class="status-message" role="status">{{ session('status') }}</div>
        @endif

        <form class="profile-edit-form"
              method="POST"
              action="{{ route('admin.password.update') }}">
            @csrf
            @method('PUT')

            <div class="field-group">
                <label for="current_password">Current password</label>
                <input id="current_password"
                       name="current_password"
                       type="password"
                       autocomplete="current-password"
                       required>
                @error('current_password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="field-group">
                <label for="password">New password</label>
                <input id="password"
                       name="password"
                       type="password"
                       autocomplete="new-password"
                       minlength="12"
                       required>
                <p class="field-hint">Use at least 12 characters.</p>
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="field-group">
                <label for="password_confirmation">Confirm new password</label>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       autocomplete="new-password"
                       minlength="12"
                       required>
                @error('password_confirmation')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <a class="ghost-button" href="{{ route('admin.dashboard', ['section' => 'profile']) }}">
                    Cancel
                </a>
                <button class="primary-button" type="submit">Save password</button>
            </div>
        </form>
    </main>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
<script>
    const userToggle = document.querySelector('.admin-user-toggle');
    const userMenu = document.querySelector('.admin-user-menu');

    userToggle?.addEventListener('click', () => {
        const isOpen = userMenu.classList.toggle('is-open');
        userToggle.setAttribute('aria-expanded', String(isOpen));
    });
</script>
</body>
</html>
