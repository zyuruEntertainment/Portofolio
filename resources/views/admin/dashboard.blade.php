<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#ffffff">
    <title>Admin Dashboard | zyuruEntertainment</title>

    @include('partials.theme-init')

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-polish.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
    <link rel="stylesheet" href="{{ asset('css/social-links.css') }}">
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

            <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">@include('partials.theme-icon')</button>
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
                            <p class="dashboard-description">Manage your portfolio projects.</p>
                        </div>
                        <a class="primary-button" href="{{ route('admin.projects.create') }}">Add Project</a>
                    </div>
                    @if ($projects->isEmpty())
                        <p class="projects-empty">No project</p>
                    @else
                        <div class="project-list">
                            @foreach ($projects as $project)
                                <article class="project-row" tabindex="0" role="button" data-project="{{ $project->id }}" aria-label="Preview {{ $project->title }}">
                                    <img src="{{ asset('storage/'.$project->logo_path) }}" alt="" class="project-logo">
                                    <div class="project-row-copy"><h2>{{ $project->title }}</h2><p>{{ $project->status }}</p></div>
                                    <div class="project-row-actions">
                                        <a class="ghost-button" href="{{ route('admin.projects.edit', $project) }}" data-no-preview>Edit</a>
                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" data-no-preview data-confirm="Delete this project?">@csrf @method('DELETE')<button class="ghost-button" type="submit">Delete</button></form>
                                    </div>
                                </article>
                                <template id="project-data-{{ $project->id }}">{{ json_encode(['title'=>$project->title,'status'=>$project->status,'description'=>$project->short_description,'logo'=>asset('storage/'.$project->logo_path),'preview'=>$project->preview_path ? asset('storage/'.$project->preview_path) : null,'type'=>$project->preview_type,'url'=>route('projects.show',$project->slug)]) }}</template>
                            @endforeach
                        </div>
                    @endif
                    <div class="project-modal" id="projectModal" aria-hidden="true"><div class="project-modal-backdrop" data-close></div><section class="project-modal-panel" role="dialog" aria-modal="true" aria-labelledby="modalTitle" tabindex="-1"><button type="button" class="project-modal-close" data-close aria-label="Close">×</button><img class="project-modal-logo" id="modalLogo" alt=""><h2 id="modalTitle"></h2><p id="modalStatus"></p><p id="modalDescription"></p><div id="modalMedia"></div><div class="project-modal-actions"><a class="primary-button" id="modalDetails">View Details</a><button type="button" class="ghost-button" data-close>Back</button></div></section></div>
                </section>

            {{-- SOCIAL MEDIA SECTION --}}
            @else

                @include('admin.social-links.index', ['links' => $socialLinks])

            @endif

        </main>
    </div>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
<script nonce="{{ request()->attributes->get('csp_nonce') }}">
(() => {
    const userToggle = document.querySelector('.admin-user-toggle');
    const dropdown = document.querySelector('.admin-dropdown');
    if (!userToggle || !dropdown) return;
    userToggle.addEventListener('click', () => {
        const open = dropdown.classList.toggle('is-open');
        userToggle.setAttribute('aria-expanded', String(open));
    });
    document.addEventListener('click', (event) => {
        if (!event.target.closest('.admin-user-menu')) {
            dropdown.classList.remove('is-open');
            userToggle.setAttribute('aria-expanded', 'false');
        }
    });
})();
</script>
<script nonce="{{ request()->attributes->get('csp_nonce') }}">
(() => {
 const modal=document.getElementById('projectModal'); if(!modal)return; const panel=modal.querySelector('.project-modal-panel'); let previous=null;
 function close(){modal.classList.remove('is-open');modal.setAttribute('aria-hidden','true');document.body.classList.remove('modal-open');if(previous)previous.focus();}
 function open(row){const data=JSON.parse(document.getElementById('project-data-'+row.dataset.project).textContent);previous=row;document.getElementById('modalTitle').textContent=data.title;document.getElementById('modalStatus').textContent=data.status;document.getElementById('modalDescription').textContent=data.description;document.getElementById('modalLogo').src=data.logo;document.getElementById('modalDetails').href=data.url;const media=document.getElementById('modalMedia');media.replaceChildren();if(data.preview){const el=document.createElement(data.type==='video'?'video':'img');el.src=data.preview;if(el.tagName==='VIDEO'){el.controls=true;el.playsInline=true;}else el.alt=data.title+' preview';media.append(el);}modal.classList.add('is-open');modal.setAttribute('aria-hidden','false');document.body.classList.add('modal-open');panel.focus();}
 document.querySelectorAll('.project-row').forEach(row=>{row.addEventListener('click',e=>{if(e.target.closest('[data-no-preview]'))return;open(row)});row.addEventListener('keydown',e=>{if((e.key==='Enter'||e.key===' ')&&e.target===row){e.preventDefault();open(row)}})});modal.querySelectorAll('[data-close]').forEach(el=>el.addEventListener('click',close));document.addEventListener('keydown',e=>{if(e.key==='Escape'&&modal.classList.contains('is-open'))close();if(e.key==='Tab'&&modal.classList.contains('is-open')){const items=[...panel.querySelectorAll('a,button')];if(e.shiftKey&&document.activeElement===items[0]){e.preventDefault();items.at(-1).focus()}else if(!e.shiftKey&&document.activeElement===items.at(-1)){e.preventDefault();items[0].focus()}}});
})();
</script>
</body>
</html>
