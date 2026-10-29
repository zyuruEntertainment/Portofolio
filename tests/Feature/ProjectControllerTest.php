<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_page_lists_projects_with_parseable_preview_data(): void
    {
        $project = $this->createProject();

        $response = $this->get(route('projects'));

        $response->assertOk()
            ->assertSee($project->title)
            ->assertSee($project->short_description)
            ->assertSee('id="modalCancel"', false)
            ->assertDontSee('project-modal-close')
            ->assertDontSee('id="modalMedia"', false);

        $pattern = '/<script type="application\/json"[^>]*id="project-data-'.$project->id.'"[^>]*>(.*?)<\/script>/s';
        $this->assertSame(1, preg_match($pattern, $response->getContent(), $matches));

        $data = json_decode($matches[1], true, flags: JSON_THROW_ON_ERROR);

        $this->assertSame($project->title, $data['title']);
        $this->assertSame($project->short_description, $data['description']);
        $this->assertSame(route('projects.show', $project->slug), $data['detailUrl']);
        $this->assertSame(false, array_key_exists('preview', $data));
    }

    public function test_project_detail_renders_database_content_and_a_valid_github_link(): void
    {
        $project = $this->createProject();

        $this->get(route('projects.show', $project->slug))
            ->assertOk()
            ->assertSee($project->title)
            ->assertSee($project->short_description)
            ->assertSee($project->full_description)
            ->assertSee($project->status)
            ->assertSee('Back to Projects')
            ->assertSee('href="'.route('projects').'"', false)
            ->assertSee('class="discover-button project-action project-action-secondary"', false)
            ->assertSee('View on GitHub')
            ->assertSee('href="'.$project->github_url.'"', false);
    }

    public function test_project_detail_hides_an_invalid_github_link(): void
    {
        $project = $this->createProject(['github_url' => 'https://example.com/owner/repo']);

        $this->get(route('projects.show', $project->slug))
            ->assertOk()
            ->assertDontSee('View on GitHub');
    }

    public function test_project_pages_escape_project_supplied_markup(): void
    {
        $project = $this->createProject([
            'title' => '</script><script>alert("title")</script>',
            'short_description' => '<img src=x onerror=alert(1)>',
            'full_description' => '<script>alert("description")</script>',
        ]);

        $this->get(route('projects'))
            ->assertOk()
            ->assertDontSee('</script><script>alert("title")</script>', false)
            ->assertDontSee('<img src=x onerror=alert(1)>', false)
            ->assertSee('&lt;/script&gt;&lt;script&gt;alert(&quot;title&quot;)&lt;/script&gt;', false)
            ->assertSee('&lt;img src=x onerror=alert(1)&gt;', false);

        $this->get(route('projects.show', $project->slug))
            ->assertOk()
            ->assertDontSee('<script>alert("description")</script>', false)
            ->assertSee('&lt;script&gt;alert(&quot;description&quot;)&lt;/script&gt;', false);
    }

    public function test_missing_project_slug_returns_not_found(): void
    {
        $this->get(route('projects.show', 'missing-project'))
            ->assertNotFound();
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
}
