<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

#[Signature('admin:create {email?} {--name=}')]
#[Description('Create an administrator account without resetting an existing password')]
class CreateAdmin extends Command
{
    public function handle(): int
    {
        $email = mb_strtolower(trim((string) ($this->argument('email') ?: $this->ask(
            'Admin email',
            'admin@zyuru.com'
        ))));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL) || mb_strlen($email) > 255) {
            $this->error('Enter a valid email address no longer than 255 characters.');

            return self::FAILURE;
        }

        $existingAdmin = Admin::query()->where('email', $email)->first();

        if ($existingAdmin) {
            $this->info('An administrator with this email already exists. Its password was not changed.');

            return self::SUCCESS;
        }

        $name = trim((string) ($this->option('name') ?: $this->ask('Admin name', 'Admin Zyuru')));

        if ($name === '' || mb_strlen($name) > 255) {
            $this->error('Enter an administrator name between 1 and 255 characters.');

            return self::FAILURE;
        }

        $password = $this->secret('Admin password');
        $confirmation = $this->secret('Confirm admin password');

        if (! is_string($password) || ! is_string($confirmation) || $password !== $confirmation) {
            $this->error('The password confirmation does not match.');

            return self::FAILURE;
        }

        $passwordRules = $this->laravel->isProduction()
            ? ['required', 'string', Password::min(16)->letters()->mixedCase()->numbers()->symbols()]
            : ['required', 'string', 'min:8', 'max:255'];

        $validator = Validator::make(['password' => $password], ['password' => $passwordRules]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $message) {
                $this->error($message);
            }

            return self::FAILURE;
        }

        $admin = Admin::query()->firstOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        $this->info($admin->wasRecentlyCreated
            ? 'Administrator account created.'
            : 'An administrator with this email already exists. Its password was not changed.');

        return self::SUCCESS;
    }
}
