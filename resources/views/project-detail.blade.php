<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="{{ $project->short_description }}">
    <title>{{ $project->title }} | zyuruEntertainment</title>
    @include('partials.theme-init')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
</head>
<body>
<div class="site-shell">
    <header class="header">
        <a class="wordmark" href="{{ url('/') }}" aria-label="zyuruEntertainment homepage">zyuruEntertainment</a>
        <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">
            @include('partials.theme-icon')
        </button>
    </header>

    <main class="project-detail {{ $project->preview_path ? 'has-preview' : 'no-preview' }}">
        <section>
            <img class="project-detail-logo" src="{{ asset('storage/'.$project->logo_path) }}" alt="{{ $project->title }} logo">
            <p class="eyebrow">{{ $project->status }}</p>
            <h1>{{ $project->title }}</h1>
            <p class="project-lead">{{ $project->short_description }}</p>
            <div class="project-full-description">{{ $project->full_description }}</div>
            <div class="form-actions">
                <a class="ghost-button" href="{{ route('projects') }}">Back to Projects</a>
                <a class="primary-button" href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer">View on GitHub</a>
            </div>
        </section>

        @if ($project->preview_path)
            <aside class="project-detail-media" aria-label="Project preview">
                @if ($project->preview_type === 'video')
                    <video src="{{ asset('storage/'.$project->preview_path) }}" controls playsinline></video>
                @else
                    <img src="{{ asset('storage/'.$project->preview_path) }}" alt="{{ $project->title }} preview">
                @endif
            </aside>
        @endif
    </main>

    <footer class="footer">
        <span>© <span id="year">2026</span> zyuruEntertainment</span>
        <span class="footer-label">GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY</span>
    </footer>
</div>
<script src="{{ asset('js/theme.js') }}" defer></script>
</body>
</html>
