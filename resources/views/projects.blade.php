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
                <template id="project-data-{{ $project->id }}">{{ json_encode([
                    'title' => $project->title,
                    'status' => $project->status,
                    'description' => $project->short_description,
                    'logo' => asset('storage/'.$project->logo_path),
                    'preview' => $project->preview_path ? asset('storage/'.$project->preview_path) : null,
                    'type' => $project->preview_type,
                    'demoUrl' => null,
                    'detailUrl' => route('projects.show', $project->slug),
                ]) }}</template>
            @empty
                <p class="projects-empty">No projects yet.</p>
            @endforelse
        </section>
    </main>

    <div class="project-modal" id="projectModal" aria-hidden="true">
        <div class="project-modal-backdrop" data-close></div>
        <section class="project-modal-panel" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1">
            <button type="button" class="project-modal-close" data-close aria-label="Close preview">×</button>
            <span class="project-modal-logo-frame">
                <img class="project-modal-logo" id="modalLogo" alt="">
                <span class="project-modal-logo-fallback" id="modalLogoFallback" aria-hidden="true" hidden></span>
            </span>
            <p class="project-modal-status" id="modalStatus"></p>
            <h2 id="modalTitle"></h2>
            <p id="modalDescription"></p>
            <div id="modalMedia"></div>
            <div class="project-modal-actions">
                <a class="primary-button" id="modalView" target="_blank" rel="noopener noreferrer" hidden>View</a>
                <button class="primary-button" id="modalViewDisabled" type="button" disabled title="No live demo is available for this project">View</button>
                <a class="ghost-button" id="modalDetail">View Detail</a>
                <button class="ghost-button" id="modalCancel" type="button">Cancel</button>
            </div>
        </section>
    </div>

    <footer class="footer">
        <span>© <span id="year">2026</span> zyuruEntertainment</span>
        <span class="footer-label">GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY</span>
    </footer>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
<script>
    (() => {
        const modal = document.getElementById('projectModal');
        const panel = modal.querySelector('.project-modal-panel');
        const modalLogo = document.getElementById('modalLogo');
        let previousFocus = null;

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            previousFocus?.focus();
        }

        function openModal(card) {
            const dataElement = document.getElementById(`project-data-${card.dataset.project}`);
            if (!dataElement) return;

            const project = JSON.parse(dataElement.textContent);
            previousFocus = card;
            document.getElementById('modalTitle').textContent = project.title;
            document.getElementById('modalStatus').textContent = project.status;
            document.getElementById('modalDescription').textContent = project.description;
            document.getElementById('modalDetail').href = project.detailUrl;

            const fallback = document.getElementById('modalLogoFallback');
            fallback.textContent = project.title.slice(0, 1).toUpperCase();
            fallback.hidden = true;
            modalLogo.hidden = false;
            modalLogo.src = project.logo;
            modalLogo.alt = `${project.title} logo`;

            const view = document.getElementById('modalView');
            const disabledView = document.getElementById('modalViewDisabled');
            let demoUrl = null;
            try {
                const parsedUrl = new URL(project.demoUrl, window.location.origin);
                if (['http:', 'https:'].includes(parsedUrl.protocol) && project.demoUrl) {
                    demoUrl = parsedUrl.href;
                }
            } catch {}
            view.hidden = !demoUrl;
            disabledView.hidden = Boolean(demoUrl);
            if (demoUrl) view.href = demoUrl;

            const media = document.getElementById('modalMedia');
            media.replaceChildren();
            if (project.preview) {
                const element = document.createElement(project.type === 'video' ? 'video' : 'img');
                element.src = project.preview;
                if (element instanceof HTMLVideoElement) {
                    element.controls = true;
                    element.playsInline = true;
                } else {
                    element.alt = `${project.title} preview`;
                }
                media.append(element);
            }

            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.classList.add('modal-open');
            panel.focus();
        }

        document.querySelectorAll('.public-project-card').forEach((card) => {
            const logo = card.querySelector('.project-logo');
            const fallback = card.querySelector('.project-logo-fallback');
            logo.addEventListener('error', () => {
                logo.hidden = true;
                fallback.hidden = false;
            }, { once: true });
            card.addEventListener('click', () => openModal(card));
        });

        modalLogo.addEventListener('error', () => {
            modalLogo.hidden = true;
            document.getElementById('modalLogoFallback').hidden = false;
        });
        modal.querySelectorAll('[data-close], #modalCancel').forEach((element) => {
            element.addEventListener('click', closeModal);
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            if (event.key !== 'Tab' || !modal.classList.contains('is-open')) return;

            const focusable = [...panel.querySelectorAll('a, button')]
                .filter((element) => !element.hidden && !element.disabled);
            if (event.shiftKey && document.activeElement === focusable[0]) {
                event.preventDefault();
                focusable.at(-1).focus();
            } else if (!event.shiftKey && document.activeElement === focusable.at(-1)) {
                event.preventDefault();
                focusable[0].focus();
            }
        });
    })();
</script>
</body>
</html>
