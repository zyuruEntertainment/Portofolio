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
        $email = config('services.admin.email');
        $password = config('services.admin.password');

        if (! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return;
        }

        if (! is_string($password) || mb_strlen($password) < 16) {
            return;
        }

        Admin::firstOrCreate(
            ['email' => $email],
            [
                'name' => 'Admin Zyuru',
                'password' => $password,
            ]
        );
    }
}
