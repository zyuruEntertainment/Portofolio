<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_can_run_more_than_once(): void
    {
        config([
            'services.admin.email' => 'admin@zyuru.com',
            'services.admin.password' => 'a secure test password',
        ]);

        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('admins', 1);
        $this->assertTrue(
            User::query()->where('email', 'test@example.com')->exists()
        );
        $this->assertTrue(
            Admin::query()->where('email', 'admin@zyuru.com')->exists()
        );
    }
}
