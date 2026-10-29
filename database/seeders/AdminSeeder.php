<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = config('services.admin.email');
        $password = config('services.admin.password');

        if (! is_string($email)) {
            return;
        }

        $email = mb_strtolower(trim($email));

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false || mb_strlen($email) > 255) {
            return;
        }

        if (! is_string($password) || mb_strlen($password) < 16) {
            return;
        }

        if (app()->isProduction() && Validator::make(
            ['password' => $password],
            ['password' => [Password::min(16)->letters()->mixedCase()->numbers()->symbols()]]
        )->fails()) {
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
