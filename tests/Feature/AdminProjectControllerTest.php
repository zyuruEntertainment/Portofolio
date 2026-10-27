<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_a_project(): void
    {
        $this->post(route('admin.projects.store'), $this->validPayload())
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_admin_creates_projects_with_unique_slugs_and_stored_logos(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.projects.store'), $this->validPayload([
                'title' => 'Portfolio Project',
                'logo' => $this->logoUpload(),
            ]))
            ->assertRedirect(route('admin.dashboard', ['section' => 'projects']));

        $this->actingAs($admin, 'admin')
            ->post(route('admin.projects.store'), $this->validPayload([
                'title' => 'Portfolio Project',
                'logo' => $this->logoUpload(),
            ]))
            ->assertRedirect(route('admin.dashboard', ['section' => 'projects']));

        $this->assertDatabaseCount('projects', 2);
        $this->assertDatabaseHas('projects', ['slug' => 'portfolio-project']);
        $this->assertDatabaseHas('projects', ['slug' => 'portfolio-project-2']);

        foreach (Project::query()->get() as $project) {
            Storage::disk('public')->assertExists($project->logo_path);
        }
    }

    public function test_admin_edits_project_content_without_changing_its_slug_or_existing_media(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/logos/current.png', 'logo');
        Storage::disk('public')->put('projects/previews/current.png', 'preview');
        $admin = $this->createAdmin();
        $project = $this->createProject([
            'logo_path' => 'projects/logos/current.png',
            'preview_path' => 'projects/previews/current.png',
            'preview_type' => 'image',
        ]);

        $this->actingAs($admin, 'admin')
            ->put(route('admin.projects.update', $project), $this->validPayload([
                'short_description' => 'Updated project description.',
            ]))
            ->assertRedirect(route('admin.dashboard', ['section' => 'projects']));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'slug' => 'portfolio-project',
            'short_description' => 'Updated project description.',
            'logo_path' => 'projects/logos/current.png',
            'preview_path' => 'projects/previews/current.png',
        ]);
        Storage::disk('public')->assertExists('projects/logos/current.png');
        Storage::disk('public')->assertExists('projects/previews/current.png');

        $this->get(route('projects.show', $project->fresh()->slug))
            ->assertOk()
            ->assertSee('Updated project description.');
    }

    public function test_admin_cannot_create_a_project_with_a_non_github_url(): void
    {
        Storage::fake('public');
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.projects.create'))
            ->post(route('admin.projects.store'), $this->validPayload([
                'github_url' => 'https://example.com/owner/repo',
                'logo' => $this->logoUpload(),
            ]))
            ->assertRedirect(route('admin.projects.create'))
            ->assertSessionHasErrors([
                'github_url' => 'The github url field format is invalid.',
            ]);

        $this->assertDatabaseCount('projects', 0);
    }

    public function test_admin_deletes_project_and_its_media(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/logos/delete.png', 'logo');
        Storage::disk('public')->put('projects/previews/delete.mp4', 'preview');
        $admin = $this->createAdmin();
        $project = $this->createProject([
            'logo_path' => 'projects/logos/delete.png',
            'preview_path' => 'projects/previews/delete.mp4',
            'preview_type' => 'video',
        ]);

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.dashboard', ['section' => 'projects']));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        Storage::disk('public')->assertMissing('projects/logos/delete.png');
        Storage::disk('public')->assertMissing('projects/previews/delete.mp4');
        $this->get(route('projects.show', $project->slug))->assertNotFound();
    }

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name' => 'Admin Zyuru',
            'email' => 'admin@zyuru.com',
            'password' => 'secret-password',
        ]);
    }

    private function createProject(array $overrides = []): Project
    {
        return Project::create(array_merge([
            'title' => 'Portfolio Project',
            'slug' => 'portfolio-project',
            'short_description' => 'A short project description.',
            'full_description' => 'A longer project description.',
            'logo_path' => 'projects/logos/logo.png',
            'preview_path' => null,
            'preview_type' => null,
            'status' => 'Released',
            'github_url' => 'https://github.com/zyuru/portfolio-project',
        ], $overrides));
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'title' => 'Portfolio Project',
            'short_description' => 'A short project description.',
            'full_description' => 'A longer project description.',
            'status' => 'Released',
            'github_url' => 'https://github.com/zyuru/portfolio-project',
        ], $overrides);
    }

    private function logoUpload(): UploadedFile
    {
        $contents = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII=',
            true
        );

        return UploadedFile::fake()->createWithContent('logo.png', $contents);
    }
}
