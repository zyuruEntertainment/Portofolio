<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\SocialLink;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSocialLinkControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAdmin(): Admin
    {
        return Admin::create([
            'name' => 'Admin Zyuru',
            'email' => 'admin@zyuru.com',
            'password' => 'secret-password',
        ]);
    }

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'platform' => 'github',
            'url' => 'https://github.com/zyuru',
            'sort_order' => 0,
        ], $overrides);
    }

    public function test_guest_cannot_access_social_links_index(): void
    {
        $this->get(route('admin.dashboard', ['section' => 'social-media']))
            ->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_social_links_index(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.dashboard', ['section' => 'social-media']))
            ->assertOk();
    }

    public function test_admin_can_create_a_social_link(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->post(route('admin.social-links.store'), $this->validPayload())
            ->assertRedirect(route('admin.dashboard', ['section' => 'social-media']));

        $this->assertDatabaseCount('social_links', 1);
        $this->assertDatabaseHas('social_links', [
            'platform' => 'github',
            'url' => 'https://github.com/zyuru',
            'sort_order' => 0,
            'is_active' => true,
        ]);
    }

    public function test_admin_can_edit_a_social_link(): void
    {
        $admin = $this->createAdmin();
        $link = SocialLink::create($this->validPayload());

        $this->actingAs($admin, 'admin')
            ->put(route('admin.social-links.update', $link), $this->validPayload([
                'url' => 'https://github.com/zyuru-updated',
            ]))
            ->assertRedirect(route('admin.dashboard', ['section' => 'social-media']));

        $this->assertDatabaseHas('social_links', [
            'id' => $link->id,
            'url' => 'https://github.com/zyuru-updated',
        ]);
    }

    public function test_admin_can_delete_a_social_link(): void
    {
        $admin = $this->createAdmin();
        $link = SocialLink::create($this->validPayload());

        $this->actingAs($admin, 'admin')
            ->delete(route('admin.social-links.destroy', $link))
            ->assertRedirect(route('admin.dashboard', ['section' => 'social-media']));

        $this->assertDatabaseMissing('social_links', ['id' => $link->id]);
    }

    public function test_admin_cannot_create_a_social_link_with_invalid_url_for_platform(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.social-links.create'))
            ->post(route('admin.social-links.store'), $this->validPayload([
                'platform' => 'github',
                'url' => 'https://example.com/not-github',
            ]))
            ->assertRedirect(route('admin.social-links.create'))
            ->assertSessionHasErrors(['url' => 'The link does not match the selected social media platform.']);

        $this->assertDatabaseCount('social_links', 0);
    }

    public function test_admin_cannot_create_a_social_link_using_a_lookalike_host(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.social-links.create'))
            ->post(route('admin.social-links.store'), $this->validPayload([
                'platform' => 'facebook',
                'url' => 'https://www.facebook.com.attacker.example/zyuru',
            ]))
            ->assertRedirect(route('admin.social-links.create'))
            ->assertSessionHasErrors('url');

        $this->assertDatabaseCount('social_links', 0);
    }

    public function test_admin_cannot_use_a_different_platform_host(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.social-links.create'))
            ->post(route('admin.social-links.store'), $this->validPayload([
                'platform' => 'facebook',
                'url' => 'https://github.com/zyuru',
            ]))
            ->assertRedirect(route('admin.social-links.create'))
            ->assertSessionHasErrors('url');

        $this->assertDatabaseCount('social_links', 0);
    }

    public function test_admin_cannot_create_a_social_link_over_http(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.social-links.create'))
            ->post(route('admin.social-links.store'), $this->validPayload([
                'url' => 'http://github.com/zyuru',
            ]))
            ->assertRedirect(route('admin.social-links.create'))
            ->assertSessionHasErrors('url');

        $this->assertDatabaseCount('social_links', 0);
    }

    public function test_admin_social_link_validation_handles_array_input_without_server_error(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.social-links.create'))
            ->post(route('admin.social-links.store'), [
                'platform' => ['facebook'],
                'url' => ['https://facebook.com/zyuru'],
            ])
            ->assertRedirect(route('admin.social-links.create'))
            ->assertSessionHasErrors(['platform', 'url']);

        $this->assertDatabaseCount('social_links', 0);
    }

    public function test_admin_cannot_create_a_social_link_with_invalid_url(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->from(route('admin.social-links.create'))
            ->post(route('admin.social-links.store'), $this->validPayload([
                'url' => 'not-a-url',
            ]))
            ->assertRedirect(route('admin.social-links.create'))
            ->assertSessionHasErrors(['url']);

        $this->assertDatabaseCount('social_links', 0);
    }

    public function test_social_link_sort_order_defaults_to_next_available(): void
    {
        $admin = $this->createAdmin();
        SocialLink::create($this->validPayload(['sort_order' => 0]));
        SocialLink::create($this->validPayload(['sort_order' => 1, 'platform' => 'twitter', 'url' => 'https://x.com/zyuru']));

        $payload = $this->validPayload([
            'platform' => 'instagram',
            'url' => 'https://www.instagram.com/zyuru',
        ]);
        unset($payload['sort_order']);

        $this->actingAs($admin, 'admin')
            ->post(route('admin.social-links.store'), $payload);

        $this->assertDatabaseHas('social_links', [
            'platform' => 'instagram',
            'sort_order' => 2,
        ]);
    }
}
