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

    <main class="projects-main projects-listing">
        <section class="projects-intro">
            <p class="eyebrow">Selected work</p>
            <h1 class="explore-title">Projects<span>.</span></h1>
            <p class="explore-description">A selection of projects built with curiosity and care.</p>
        </section>

        <div class="projects-grid">
            @forelse ($projects as $project)
                <button type="button" class="public-project-card" data-project="{{ $project->id }}" aria-label="Preview {{ $project->title }}">
                    <span class="public-project-card-top">
                        <img class="project-logo" src="{{ asset('storage/'.$project->logo_path) }}" alt="">
                        <span class="project-status">{{ $project->status }}</span>
                    </span>
                    <span class="public-project-card-bottom">
                        <span>
                            <strong>{{ $project->title }}</strong>
                            <span class="public-project-description">{{ $project->short_description }}</span>
                        </span>
                        <span class="project-card-arrow" aria-hidden="true">↗</span>
                    </span>
                </button>
                <template id="project-data-{{ $project->id }}">{{ json_encode([
                    'title' => $project->title,
                    'status' => $project->status,
                    'description' => $project->short_description,
                    'logo' => asset('storage/'.$project->logo_path),
                    'preview' => $project->preview_path ? asset('storage/'.$project->preview_path) : null,
                    'type' => $project->preview_type,
                    'url' => route('projects.show', $project->slug),
                ]) }}</template>
            @empty
                <p class="projects-empty">No projects yet.</p>
            @endforelse
        </div>
    </main>

    <div class="project-modal" id="projectModal" aria-hidden="true">
        <div class="project-modal-backdrop" data-close></div>
        <section class="project-modal-panel" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1">
            <button type="button" class="project-modal-close" data-close aria-label="Close">×</button>
            <img class="project-modal-logo" id="modalLogo" alt="">
            <h2 id="modalTitle"></h2>
            <p id="modalStatus"></p>
            <p id="modalDescription"></p>
            <div id="modalMedia"></div>
            <div class="project-modal-actions">
                <a class="primary-button" id="modalDetails">View Details</a>
                <button type="button" class="ghost-button" data-close>Back</button>
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
        let previousFocus = null;

        function closeModal() {
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.classList.remove('modal-open');
            previousFocus?.focus();
        }

        function openModal(card) {
            const project = JSON.parse(document.getElementById(`project-data-${card.dataset.project}`).textContent);
            previousFocus = card;
            document.getElementById('modalTitle').textContent = project.title;
            document.getElementById('modalStatus').textContent = project.status;
            document.getElementById('modalDescription').textContent = project.description;
            document.getElementById('modalLogo').src = project.logo;
            document.getElementById('modalDetails').href = project.url;

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
            card.addEventListener('click', () => openModal(card));
        });
        modal.querySelectorAll('[data-close]').forEach((element) => {
            element.addEventListener('click', closeModal);
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
            if (event.key !== 'Tab' || !modal.classList.contains('is-open')) return;

            const focusable = [...panel.querySelectorAll('a, button')];
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
