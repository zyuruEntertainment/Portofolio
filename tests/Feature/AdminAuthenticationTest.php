<?php

namespace Tests\Feature;

use App\Models\Admin;
use Database\Seeders\AdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
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

    public function test_guests_are_redirected_to_the_admin_login_page(): void
    {
        $this->get(route('admin.dashboard'))
            ->assertRedirect(route('admin.login'));

        $this->get(route('admin.profile.edit'))
            ->assertRedirect(route('admin.login'));
    }

    public function test_signed_in_admins_are_redirected_away_from_the_login_page(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('admin.login'))
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_log_in_with_valid_credentials(): void
    {
        $admin = $this->createAdmin();

        $response = $this->post(route('admin.login.submit'), [
            'email' => $admin->email,
            'password' => 'secret-password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    public function test_admin_cannot_log_in_with_invalid_credentials(): void
    {
        $admin = $this->createAdmin();

        $response = $this->from(route('admin.login'))->post(
            route('admin.login.submit'),
            [
                'email' => $admin->email,
                'password' => 'wrong-password',
            ]
        );

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest('admin');
    }

    public function test_login_attempts_are_throttled(): void
    {
        $admin = $this->createAdmin();

        for ($attempt = 0; $attempt < 5; $attempt++) {
            $this->from(route('admin.login'))->post(
                route('admin.login.submit'),
                [
                    'email' => $admin->email,
                    'password' => 'wrong-password',
                ]
            )->assertSessionHasErrors('email');
        }

        $response = $this->from(route('admin.login'))->post(
            route('admin.login.submit'),
            [
                'email' => $admin->email,
                'password' => 'secret-password',
            ]
        );

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHasErrors('email');
        $this->assertStringContainsString(
            'Too many login attempts',
            session('errors')->first('email')
        );
        $this->assertGuest('admin');
    }

    public function test_admin_can_log_out(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')
            ->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }

    public function test_admin_seeder_does_not_reset_an_existing_password(): void
    {
        $this->seed(AdminSeeder::class);

        $admin = Admin::query()
            ->where('email', 'admin@zyuru.com')
            ->firstOrFail();

        $this->assertTrue(Hash::check('[removed]', $admin->password));

        $admin->update(['password' => 'changed-password']);

        $this->seed(AdminSeeder::class);

        $this->assertDatabaseCount('admins', 1);
        $this->assertTrue(
            Hash::check('changed-password', $admin->fresh()->password)
        );
    }
}
