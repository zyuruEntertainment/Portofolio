<!DOCTYPE html>
<html lang="en" data-theme="auto" data-active-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#ffffff">
    <title>{{ $project->exists ? 'Edit' : 'Add' }} Project | Admin</title>
    @include('partials.theme-init')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-polish.css') }}">
    <link rel="stylesheet" href="{{ asset('css/projects.css') }}">
</head>
<body>
<div class="site-shell admin-shell admin-shell--editor">
    <header class="header admin-header">
        <a class="wordmark" href="{{ route('admin.dashboard', ['section' => 'projects']) }}">zyuruEntertainment</a>
        <button class="theme-toggle" id="themeToggle" type="button" aria-label="Switch theme">
            @include('partials.theme-icon')
        </button>
    </header>

    <main class="editor-main">
        <a class="editor-back-link" href="{{ route('admin.dashboard', ['section' => 'projects']) }}">← Back to projects</a>
        <section class="edit-profile-heading">
            <p class="eyebrow">Project settings</p>
            <h1>{{ $project->exists ? 'Edit project.' : 'Add project.' }}</h1>
        </section>

        <form class="profile-edit-form" method="POST" enctype="multipart/form-data"
              action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}">
            @csrf
            @if ($project->exists) @method('PUT') @endif

            <div class="form-field">
                <label for="title">Project title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $project->title) }}" maxlength="120" required>
                @error('title') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="short_description">Short description</label>
                <input id="short_description" name="short_description" type="text" value="{{ old('short_description', $project->short_description) }}" maxlength="300" required>
                @error('short_description') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="full_description">Full description</label>
                <textarea id="full_description" name="full_description" required>{{ old('full_description', $project->full_description) }}</textarea>
                @error('full_description') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="github_url">GitHub repository URL</label>
                <input id="github_url" name="github_url" type="url" value="{{ old('github_url', $project->github_url) }}" maxlength="2048" required>
                @error('github_url') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="status">Project status</label>
                <select id="status" name="status" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected(old('status', $project->status) === $status)>{{ $status }}</option>
                    @endforeach
                </select>
                @error('status') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="logo">Project logo {{ $project->exists ? '(optional)' : '' }}</label>
                @if ($project->logo_path)
                    <img class="form-media-preview" src="{{ asset('storage/'.$project->logo_path) }}" alt="Current project logo">
                @endif
                <input id="logo" name="logo" type="file" accept="image/jpeg,image/png,image/webp" @required(!$project->exists)>
                <img class="form-media-preview" id="logoPreview" alt="Selected logo preview" hidden>
                @error('logo') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-field">
                <label for="preview">Project preview (image or MP4 video)</label>
                @if ($project->preview_path)
                    <p>Current preview: <a href="{{ asset('storage/'.$project->preview_path) }}" target="_blank" rel="noopener">Open</a></p>
                    <label class="preview-remove"><input type="checkbox" name="remove_preview" value="1"> Remove current preview</label>
                @endif
                <input id="preview" name="preview" type="file" accept="image/jpeg,image/png,image/webp,video/mp4">
                <div id="previewContainer"></div>
                @error('preview') <small class="field-error">{{ $message }}</small> @enderror
            </div>

            <div class="form-actions">
                <button class="primary-button" type="submit">Save project</button>
                <a class="ghost-button" href="{{ route('admin.dashboard', ['section' => 'projects']) }}">Cancel</a>
            </div>
        </form>
    </main>
</div>

<script src="{{ asset('js/theme.js') }}" defer></script>
<script>
    const logoInput = document.getElementById('logo');
    const logoPreview = document.getElementById('logoPreview');
    const previewInput = document.getElementById('preview');
    const previewContainer = document.getElementById('previewContainer');

    logoInput.addEventListener('change', () => {
        const file = logoInput.files?.[0];
        if (!file) return;
        logoPreview.src = URL.createObjectURL(file);
        logoPreview.hidden = false;
    });

    previewInput.addEventListener('change', () => {
        const file = previewInput.files?.[0];
        previewContainer.replaceChildren();
        if (!file) return;

        const media = document.createElement(file.type.startsWith('video/') ? 'video' : 'img');
        media.src = URL.createObjectURL(file);
        media.className = 'form-media-preview';

        if (media instanceof HTMLVideoElement) {
            media.controls = true;
            media.playsInline = true;
        } else {
            media.alt = 'Selected project preview';
        }

        previewContainer.append(media);
    });
</script>
</body>
</html>
