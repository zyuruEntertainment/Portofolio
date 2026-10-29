<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>{{ $link->exists ? 'Edit' : 'Add' }} Social Link | Admin</title>
    @include('partials.theme-init')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-polish.css') }}">
    <link rel="stylesheet" href="{{ asset('css/social-links.css') }}">
</head>
<body>
<div class="site-shell admin-shell admin-shell--editor">
    <header class="header admin-header">
        <a class="wordmark" href="{{ route('admin.dashboard', ['section' => 'social-media']) }}">zyuruEntertainment</a>
        <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">
            @include('partials.theme-icon')
        </button>
    </header>

    <main class="editor-main">
        <section class="edit-profile-heading">
            <p class="eyebrow">Social link settings</p>
            <h1>{{ $link->exists ? 'Edit social link.' : 'Add social link.' }}</h1>
        </section>

        <form class="profile-edit-form" method="POST"
              action="{{ $link->exists ? route('admin.social-links.update', $link) : route('admin.social-links.store') }}">
            @csrf
            @if ($link->exists) @method('PUT') @endif

            <div class="form-field">
                <label for="platform">Platform</label>
                <select id="platform" name="platform" required>
                    @foreach (\App\Models\SocialLink::$platforms as $platform => $base)
                        <option value="{{ $platform }}" @selected(old('platform', $link->platform) === $platform)>
                            {{ strtoupper($platform) }}
                        </option>
                    @endforeach
                </select>
                @error('platform') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="url">Link URL</label>
                <input id="url" name="url" type="url" value="{{ old('url', $link->url) }}" maxlength="2048" required
                       placeholder="https://...">
                <small class="field-hint">Paste the profile or channel URL for this platform.</small>
                @error('url') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button class="primary-button" type="submit">Save link</button>
                <a class="ghost-button" href="{{ route('admin.dashboard', ['section' => 'social-media']) }}">Cancel</a>
            </div>
        </form>
    </main>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
</body>
</html>
