<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">

    <meta
        name="description"
        content="Projects by zyuruEntertainment."
    >

    <title>Projects | zyuruEntertainment</title>

    <script>
        (() => {
            let theme = "auto";

            try {
                theme = localStorage.getItem("zyuru-theme") || "auto";
            } catch {}

            const systemDark = window.matchMedia(
                "(prefers-color-scheme: dark)"
            ).matches;

            const activeTheme = theme === "auto"
                ? (systemDark ? "dark" : "light")
                : theme;

            document.documentElement.dataset.theme = theme;
            document.documentElement.dataset.activeTheme = activeTheme;
            document.documentElement.style.colorScheme = activeTheme;
        })();
    </script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
</head>

<body>
    <div class="site-shell">

        <header class="header">
            <a
                class="wordmark"
                href="{{ url('/') }}"
                aria-label="zyuruEntertainment homepage"
            >
                zyuruEntertainment
            </a>

            <button
                class="theme-toggle"
                id="themeToggle"
                type="button"
                aria-label="Switch color theme"
                title="Switch color theme"
            >
                <svg
                    id="themeIcon"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.5"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    aria-hidden="true"
                >
                    <circle cx="12" cy="12" r="4"></circle>
                    <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
                    <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
                    <path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>
                </svg>
            </button>
        </header>

        <main class="projects-main projects-listing">
            <section class="projects-intro"><p class="eyebrow">Selected work</p><h1 class="explore-title">Projects<span>.</span></h1><p class="explore-description">A selection of projects built with curiosity and care.</p></section>
            @forelse ($projects as $project)
                <button type="button" class="public-project-row" data-project="{{ $project->id }}"><img class="project-logo" src="{{ asset('storage/'.$project->logo_path) }}" alt=""><span class="public-project-copy"><strong>{{ $project->title }}</strong><small>{{ $project->status }}</small><span>{{ $project->short_description }}</span></span><span aria-hidden="true">↗</span></button>
                <template id="project-data-{{ $project->id }}">{{ json_encode(['title'=>$project->title,'status'=>$project->status,'description'=>$project->short_description,'logo'=>asset('storage/'.$project->logo_path),'preview'=>$project->preview_path ? asset('storage/'.$project->preview_path) : null,'type'=>$project->preview_type,'url'=>route('projects.show',$project->slug)]) }}</template>
            @empty <p class="projects-empty">No projects yet.</p>
            @endforelse
        </main>
        <div class="project-modal" id="projectModal" aria-hidden="true"><div class="project-modal-backdrop" data-close></div><section class="project-modal-panel" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1"><button type="button" class="project-modal-close" data-close aria-label="Close">×</button><img class="project-modal-logo" id="modalLogo" alt=""><h2 id="modalTitle"></h2><p id="modalStatus"></p><p id="modalDescription"></p><div id="modalMedia"></div><div class="project-modal-actions"><a class="primary-button" id="modalDetails">View Details</a><button type="button" class="ghost-button" data-close>Back</button></div></section></div>

        <footer class="footer">
            <span>
                © <span id="year">2026</span> zyuruEntertainment
            </span>

            <span class="footer-label">
                GAMES <i></i> SOFTWARE <i></i> TECHNOLOGY
            </span>
        </footer>

    </div>

    <script>
        const root = document.documentElement;
        const toggle = document.getElementById("themeToggle");
        const icon = document.getElementById("themeIcon");
        const themeColor = document.querySelector(
            'meta[name="theme-color"]'
        );

        const sunIcon = `
            <circle cx="12" cy="12" r="4"></circle>
            <path d="M12 2v2M12 20v2M2 12h2M20 12h2"></path>
            <path d="m4.93 4.93 1.42 1.42m11.3 11.3 1.42 1.42"></path>
            <path d="m4.93 19.07-1.42 1.42m11.3-11.3 1.42-1.42"></path>
        `;

        const moonIcon = `
            <path d="M20.9 13A9 9 0 0 1 11 3.1
                9 9 0 1 0 20.9 13Z"></path>
        `;

        const systemTheme = window.matchMedia(
            "(prefers-color-scheme: dark)"
        );

        function applyTheme(theme) {
            const activeTheme = theme === "auto"
                ? (systemTheme.matches ? "dark" : "light")
                : theme;

            root.dataset.theme = theme;
            root.dataset.activeTheme = activeTheme;
            root.style.colorScheme = activeTheme;

            themeColor.content = activeTheme === "dark"
                ? "#0b0b0b"
                : "#ffffff";

            icon.innerHTML = activeTheme === "dark"
                ? moonIcon
                : sunIcon;

            toggle.title = `Theme: ${theme}`;

            toggle.setAttribute(
                "aria-label",
                `Current theme: ${theme}. Switch theme`
            );
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

        document.getElementById("year").textContent =
            new Date().getFullYear();

        applyTheme(root.dataset.theme || "auto");
    </script>
    <script>
    (()=>{const modal=document.getElementById('projectModal');if(!modal)return;const panel=modal.querySelector('.project-modal-panel');let previous=null;function close(){modal.classList.remove('is-open');modal.setAttribute('aria-hidden','true');document.body.classList.remove('modal-open');previous?.focus()}function open(row){const d=JSON.parse(document.getElementById('project-data-'+row.dataset.project).textContent);previous=row;modal.querySelector('#modalTitle').textContent=d.title;modal.querySelector('#modalStatus').textContent=d.status;modal.querySelector('#modalDescription').textContent=d.description;modal.querySelector('#modalLogo').src=d.logo;modal.querySelector('#modalDetails').href=d.url;const media=modal.querySelector('#modalMedia');media.replaceChildren();if(d.preview){const el=document.createElement(d.type==='video'?'video':'img');el.src=d.preview;if(el.tagName==='VIDEO'){el.controls=true;el.playsInline=true}else el.alt=d.title+' preview';media.append(el)}modal.classList.add('is-open');modal.setAttribute('aria-hidden','false');document.body.classList.add('modal-open');panel.focus()}document.querySelectorAll('.public-project-row').forEach(r=>r.addEventListener('click',()=>open(r)));modal.querySelectorAll('[data-close]').forEach(e=>e.addEventListener('click',close));document.addEventListener('keydown',e=>{if(e.key==='Escape'&&modal.classList.contains('is-open'))close();if(e.key==='Tab'&&modal.classList.contains('is-open')){const a=[...panel.querySelectorAll('a,button')];if(e.shiftKey&&document.activeElement===a[0]){e.preventDefault();a.at(-1).focus()}else if(!e.shiftKey&&document.activeElement===a.at(-1)){e.preventDefault();a[0].focus()}}})})();
    </script>
</body>
</html>
