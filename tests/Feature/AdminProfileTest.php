<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\AdminProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminProfileTest extends TestCase
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
            'name' => 'Zyuru',
            'description' => 'Independent developer.',
            'overview' => 'Building ideas into reality.',
        ], $overrides);
    }

    public function test_public_profile_page_shows_the_current_profile(): void
    {
        AdminProfile::create($this->validPayload());

        $this->get(route('profile'))
            ->assertOk()
            ->assertSee('Zyuru')
            ->assertSee('Independent developer.')
            ->assertSee('Building ideas into reality.');
    }

    public function test_guest_cannot_update_the_profile(): void
    {
        $this->put(route('admin.profile.update'), $this->validPayload())
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseCount('admin_profiles', 0);
    }

    public function test_admin_can_create_the_profile_when_it_does_not_exist(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')
            ->put(route('admin.profile.update'), $this->validPayload());

        $response->assertRedirect(
            route('admin.dashboard', ['section' => 'profile'])
        );
        $this->assertDatabaseCount('admin_profiles', 1);
        $this->assertDatabaseHas('admin_profiles', [
            'name' => 'Zyuru',
            'description' => 'Independent developer.',
            'overview' => 'Building ideas into reality.',
        ]);
    }

    public function test_admin_updates_the_existing_profile_instead_of_creating_a_duplicate(): void
    {
        $admin = $this->createAdmin();

        // Simulate a profile that was not inserted with id 1.
        DB::table('admin_profiles')->insert([
            'id' => 5,
            'name' => 'Old name',
            'description' => 'Old description.',
            'overview' => 'Old overview.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAs($admin, 'admin')
            ->put(route('admin.profile.update'), $this->validPayload());

        $response->assertRedirect(
            route('admin.dashboard', ['section' => 'profile'])
        );
        $this->assertDatabaseCount('admin_profiles', 1);
        $this->assertDatabaseHas('admin_profiles', [
            'id' => 5,
            'name' => 'Zyuru',
        ]);
    }

    public function test_profile_fields_are_validated(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')
            ->from(route('admin.profile.edit'))
            ->put(route('admin.profile.update'), [
                'name' => '',
                'description' => '',
                'overview' => '',
            ]);

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHasErrors(['name', 'description', 'overview']);
        $this->assertDatabaseCount('admin_profiles', 0);
    }

    public function test_uploading_a_new_icon_replaces_and_removes_the_old_file(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('profile-icons/old.png', 'old image');

        $admin = $this->createAdmin();

        AdminProfile::create($this->validPayload([
            'icon_path' => 'profile-icons/old.png',
        ]));

        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='
        );

        $response = $this->actingAs($admin, 'admin')->put(
            route('admin.profile.update'),
            $this->validPayload([
                'icon' => UploadedFile::fake()->createWithContent('new.png', $png),
            ])
        );

        $response->assertRedirect(
            route('admin.dashboard', ['section' => 'profile'])
        );

        $profile = AdminProfile::current();

        $this->assertNotSame('profile-icons/old.png', $profile->icon_path);
        Storage::disk('public')->assertExists($profile->icon_path);
        Storage::disk('public')->assertMissing('profile-icons/old.png');
    }

    public function test_replacing_an_icon_does_not_remove_a_file_outside_the_profile_icon_directory(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('projects/logos/keep.png', 'project logo');

        $admin = $this->createAdmin();
        AdminProfile::create($this->validPayload([
            'icon_path' => 'profile-icons/../projects/logos/keep.png',
        ]));

        $png = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='
        );

        $this->actingAs($admin, 'admin')->put(
            route('admin.profile.update'),
            $this->validPayload([
                'icon' => UploadedFile::fake()->createWithContent('new.png', $png),
            ])
        )->assertRedirect(route('admin.dashboard', ['section' => 'profile']));

        Storage::disk('public')->assertExists('projects/logos/keep.png');
    }

    public function test_non_image_icons_are_rejected(): void
    {
        Storage::fake('public');

        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')
            ->from(route('admin.profile.edit'))
            ->put(route('admin.profile.update'), $this->validPayload([
                'icon' => UploadedFile::fake()->createWithContent(
                    'notes.txt',
                    'not an image'
                ),
            ]));

        $response->assertRedirect(route('admin.profile.edit'));
        $response->assertSessionHasErrors('icon');
        $this->assertDatabaseCount('admin_profiles', 0);
    }
}
