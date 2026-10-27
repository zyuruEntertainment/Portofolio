<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <meta name="description" content="Projects by zyuruEntertainment.">
    <title>Projects | zyuruEntertainment</title>
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

    <main class="projects-main">
        <section class="projects-intro" aria-labelledby="projects-title">
            <h1 class="projects-title" id="projects-title">
                <span>Visit my</span>
                <span>project</span>
            </h1>
            <p class="projects-description">
                A collection of games, tools, and experiments built through creativity, exploration, and continuous learning.
            </p>
            <a class="discover-button projects-back-link" href="{{ route('explore') }}">
                <span>Back to Explore</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M5 19 19 5"></path>
                    <path d="M6 5h13v13"></path>
                </svg>
            </a>
        </section>

        <section class="projects-grid" aria-label="Projects">
            @forelse ($projects as $project)
                <button type="button" class="public-project-card" data-project="{{ $project->id }}" aria-label="Preview {{ $project->title }}">
                    <span class="public-project-card-top">
                        <span class="project-logo-frame">
                            <img class="project-logo" src="{{ asset('storage/'.$project->logo_path) }}" alt="">
                            <span class="project-logo-fallback" aria-hidden="true" hidden>{{ strtoupper(mb_substr($project->title, 0, 1)) }}</span>
                        </span>
                        <span class="project-status">{{ $project->status }}</span>
                    </span>
                    <span class="public-project-card-copy">
                        <strong>{{ $project->title }}</strong>
                        <span class="public-project-description">{{ $project->short_description }}</span>
                    </span>
                </button>
                @php
                    $projectPreviewData = [
                        'title' => $project->title,
                        'status' => $project->status,
                        'description' => $project->short_description,
                        'logo' => asset('storage/'.$project->logo_path),
                        'detailUrl' => route('projects.show', $project->slug),
                    ];
                @endphp
                <script type="application/json" id="project-data-{{ $project->id }}">@json($projectPreviewData)</script>
            @empty
                <p class="projects-empty">No projects yet.</p>
            @endforelse
        </section>
    </main>

    <div class="project-modal" id="projectModal" aria-hidden="true">
        <div class="project-modal-backdrop" data-close></div>
        <section class="project-modal-panel" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1">
            <span class="project-modal-logo-frame">
                <img class="project-modal-logo" id="modalLogo" alt="">
                <span class="project-modal-logo-fallback" id="modalLogoFallback" aria-hidden="true" hidden></span>
            </span>
            <p class="project-modal-status" id="modalStatus"></p>
            <h2 id="modalTitle"></h2>
            <p id="modalDescription"></p>
            <div class="project-modal-actions">
                <a class="discover-button project-action" id="modalDetail">
                    <span>View Detail</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 19 19 5"></path>
                        <path d="M6 5h13v13"></path>
                    </svg>
                </a>
                <button class="discover-button project-action project-action-secondary" id="modalCancel" type="button">Cancel</button>
            </div>
        </section>
    </div>

    <footer class="footer">
        <span>© <span id="year">2026</span> zyuruEntertainment</span>
        <span class="footer-label">GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY</span>
    </footer>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
<script src="{{ asset('js/projects.js') }}" defer></script>
</body>
</html>
