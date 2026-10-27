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

    <main class="project-detail">
        <section class="project-detail-hero {{ $project->preview_path ? 'has-preview' : 'no-preview' }}">
            <div class="project-detail-copy">
                <img class="project-detail-logo" src="{{ asset('storage/'.$project->logo_path) }}" alt="{{ $project->title }} logo">
                <p class="eyebrow">{{ $project->status }}</p>
                <h1>{{ $project->title }}</h1>
                <p class="project-lead">{{ $project->short_description }}</p>
                <div class="project-detail-actions">
                    <a class="discover-button project-action project-action-secondary" href="{{ route('projects') }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M19 12H5"></path>
                            <path d="m12 19-7-7 7-7"></path>
                        </svg>
                        <span>Back to Projects</span>
                    </a>
                    @if ($project->githubRepositoryUrl())
                        <a class="discover-button project-action" href="{{ $project->githubRepositoryUrl() }}" target="_blank" rel="noopener noreferrer">
                            <span>View on GitHub</span>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M5 19 19 5"></path>
                                <path d="M6 5h13v13"></path>
                            </svg>
                        </a>
                    @endif
                </div>
            </div>

            @if ($project->preview_path)
                <aside class="project-detail-media" aria-label="Project preview">
                    @if ($project->preview_type === 'video')
                        <video src="{{ asset('storage/'.$project->preview_path) }}" controls playsinline></video>
                    @else
                        <img src="{{ asset('storage/'.$project->preview_path) }}" alt="{{ $project->title }} preview">
                    @endif
                </aside>
            @endif
        </section>

        <section class="project-detail-content" aria-label="Project details">
            <p class="eyebrow">Project details</p>
            <div class="project-full-description">{{ $project->full_description }}</div>
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
