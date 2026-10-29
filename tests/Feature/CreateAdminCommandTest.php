<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateAdminCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_account_is_created_with_normalized_email_and_a_password_hash(): void
    {
        $password = 'Development-Admin-42!';

        $this->artisan('admin:create', [
            'email' => ' ADMIN@ZYURU.COM ',
            '--name' => 'Admin Zyuru',
        ])
            ->expectsQuestion('Admin password', $password)
            ->expectsQuestion('Confirm admin password', $password)
            ->expectsOutputToContain('Administrator account created.')
            ->assertExitCode(0);

        $this->assertDatabaseHas('admins', [
            'email' => 'admin@zyuru.com',
            'name' => 'Admin Zyuru',
        ]);
        $this->assertTrue(Hash::check($password, Admin::query()->firstOrFail()->password));

        $this->post(route('admin.login.submit'), [
            'email' => 'admin@zyuru.com',
            'password' => $password,
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs(Admin::query()->firstOrFail(), 'admin');
    }

    public function test_existing_admin_password_is_not_reset(): void
    {
        $admin = Admin::create([
            'name' => 'Existing Admin',
            'email' => 'admin@zyuru.com',
            'password' => 'Existing-Password-42!',
        ]);

        $this->artisan('admin:create', ['email' => 'ADMIN@ZYURU.COM'])
            ->expectsOutputToContain('Its password was not changed.')
            ->assertExitCode(0);

        $this->assertDatabaseCount('admins', 1);
        $this->assertTrue(Hash::check('Existing-Password-42!', $admin->fresh()->password));
    }

    public function test_production_admin_password_requires_mixed_case_numbers_and_symbols(): void
    {
        $this->app['env'] = 'production';

        $this->artisan('admin:create', [
            'email' => 'admin@zyuru.com',
            '--name' => 'Admin Zyuru',
        ])
            ->expectsQuestion('Admin password', 'weak-password-only')
            ->expectsQuestion('Confirm admin password', 'weak-password-only')
            ->assertExitCode(1);

        $this->assertDatabaseCount('admins', 0);
    }
}
