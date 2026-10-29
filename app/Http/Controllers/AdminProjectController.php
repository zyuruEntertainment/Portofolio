<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminProjectController extends Controller
{
    private const STATUSES = ['In Development', 'Released', 'On Hold', 'Archived'];

    public function create(): View
    {
        return view('admin.projects.form', ['project' => new Project, 'statuses' => self::STATUSES]);
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', compact('project') + ['statuses' => self::STATUSES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request, true);
        $logoPath = $request->file('logo')->store('projects/logos', 'public');

        if (! is_string($logoPath)) {
            return back()
                ->withErrors(['logo' => 'The project logo could not be uploaded. Please try again.'])
                ->withInput();
        }

        $previewPath = null;

        if ($request->hasFile('preview')) {
            $previewPath = $request->file('preview')->store('projects/previews', 'public');

            if (! is_string($previewPath)) {
                $this->deleteProjectMedia($logoPath);

                return back()
                    ->withErrors(['preview' => 'The project preview could not be uploaded. Please try again.'])
                    ->withInput();
            }
        }

        $data['logo_path'] = $logoPath;
        $data['preview_path'] = $previewPath;
        $data['preview_type'] = $request->hasFile('preview')
            ? ($request->file('preview')->getMimeType() === 'video/mp4' ? 'video' : 'image')
            : null;
        $data['slug'] = Project::uniqueSlug($data['title']);
        Project::create($data);

        return $this->backToProjects('Project created successfully.');
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, false);
        $oldLogo = $project->logo_path;
        $oldPreview = $project->preview_path;
        $data['slug'] = Project::uniqueSlug($data['title'], $project);

        if ($request->hasFile('logo')) {
            $newLogoPath = $request->file('logo')->store('projects/logos', 'public');

            if (! is_string($newLogoPath)) {
                return back()
                    ->withErrors(['logo' => 'The project logo could not be uploaded. Please try again.'])
                    ->withInput();
            }

            $data['logo_path'] = $newLogoPath;
        }

        if ($request->boolean('remove_preview')) {
            $data['preview_path'] = null;
        }

        if ($request->hasFile('preview')) {
            $newPreviewPath = $request->file('preview')->store('projects/previews', 'public');

            if (! is_string($newPreviewPath)) {
                if (isset($data['logo_path'])) {
                    $this->deleteProjectMedia($data['logo_path']);
                }

                return back()
                    ->withErrors(['preview' => 'The project preview could not be uploaded. Please try again.'])
                    ->withInput();
            }

            $data['preview_path'] = $newPreviewPath;
            $data['preview_type'] = $request->file('preview')->getMimeType() === 'video/mp4' ? 'video' : 'image';
        } elseif ($request->boolean('remove_preview')) {
            $data['preview_type'] = null;
        }
        $project->update($data);
        if (isset($data['logo_path']) && $oldLogo !== $data['logo_path']) {
            $this->deleteProjectMedia($oldLogo);
        }
        if (isset($data['preview_path']) && $oldPreview && $oldPreview !== $data['preview_path']) {
            $this->deleteProjectMedia($oldPreview);
        }
        if (array_key_exists('preview_path', $data) && $data['preview_path'] === null && $oldPreview) {
            $this->deleteProjectMedia($oldPreview);
        }

        return $this->backToProjects('Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $paths = array_filter([$project->logo_path, $project->preview_path]);
        $project->delete();
        foreach ($paths as $path) {
            $this->deleteProjectMedia($path);
        }

        return $this->backToProjects('Project deleted successfully.');
    }

    private function validated(Request $request, bool $creating): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'short_description' => ['required', 'string', 'max:300'],
            'full_description' => ['required', 'string'],
            'logo' => [$creating ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'preview' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,mp4', 'max:20480'],
            'remove_preview' => ['nullable', 'boolean'],
            'status' => ['required', 'in:'.implode(',', self::STATUSES)],
            'github_url' => ['required', 'url', 'regex:/^https:\/\/github\.com\/[A-Za-z0-9_.-]+\/[A-Za-z0-9_.-]+\/?$/i', 'max:2048'],
        ]);
    }

    private function deleteProjectMedia(?string $path): void
    {
        if (! is_string($path) || preg_match('/\Aprojects\/(?:logos|previews)\/[A-Za-z0-9_-][A-Za-z0-9._-]*\z/', $path) !== 1) {
            return;
        }

        Storage::disk('public')->delete($path);
    }

    private function backToProjects(string $message): RedirectResponse
    {
        return redirect()->route('admin.dashboard', ['section' => 'projects'])->with('status', $message);
    }
}
