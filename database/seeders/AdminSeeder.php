<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Only create the account when it is missing so re-seeding never
        // silently resets a password that has already been changed.
        Admin::firstOrCreate(
            ['email' => 'admin@zyuru.com'],
            [
                'name' => 'Admin Zyuru',
                'password' => '[removed]',
            ]
        );
    }
}
