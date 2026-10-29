<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminPasswordControllerTest extends TestCase
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

    public function test_guest_cannot_view_or_update_admin_password(): void
    {
        $this->get(route('admin.password.edit'))
            ->assertRedirect(route('admin.login'));

        $this->put(route('admin.password.update'), [
            'current_password' => 'secret-password',
            'password' => 'a-new-secure-password',
            'password_confirmation' => 'a-new-secure-password',
        ])->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_view_the_hidden_password_page(): void
    {
        $this->actingAs($this->createAdmin(), 'admin')
            ->get(route('admin.password.edit'))
            ->assertOk()
            ->assertSee('Change password.')
            ->assertSee('current_password');
    }

    public function test_admin_can_change_password_after_confirming_current_password(): void
    {
        $admin = $this->createAdmin();
        $newPassword = 'a-new-secure-password';

        $response = $this->actingAs($admin, 'admin')
            ->put(route('admin.password.update'), [
                'current_password' => 'secret-password',
                'password' => $newPassword,
                'password_confirmation' => $newPassword,
            ]);

        $response->assertRedirect(route('admin.password.edit'))
            ->assertSessionHas('status', 'Password updated successfully.');
        $this->assertTrue(Hash::check($newPassword, $admin->fresh()->password));
    }

    public function test_password_change_rejects_wrong_current_password(): void
    {
        $admin = $this->createAdmin();

        $response = $this->actingAs($admin, 'admin')
            ->from(route('admin.password.edit'))
            ->put(route('admin.password.update'), [
                'current_password' => 'wrong-password',
                'password' => 'a-new-secure-password',
                'password_confirmation' => 'a-new-secure-password',
            ]);

        $response->assertRedirect(route('admin.password.edit'))
            ->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('secret-password', $admin->fresh()->password));
    }

    public function test_password_change_rejects_short_reused_and_unconfirmed_passwords(): void
    {
        $admin = $this->createAdmin();
        $this->actingAs($admin, 'admin');

        foreach ([
            ['short', 'short'],
            ['secret-password', 'secret-password'],
            ['a-new-secure-password', 'different-confirmation'],
        ] as [$password, $confirmation]) {
            $response = $this->from(route('admin.password.edit'))
                ->put(route('admin.password.update'), [
                    'current_password' => 'secret-password',
                    'password' => $password,
                    'password_confirmation' => $confirmation,
                ]);

            $response->assertRedirect(route('admin.password.edit'))
                ->assertSessionHasErrors('password');
        }

        $this->assertTrue(Hash::check('secret-password', $admin->fresh()->password));
    }
}
