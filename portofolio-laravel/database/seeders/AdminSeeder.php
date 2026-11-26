<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use InvalidArgumentException;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $name = env('ADMIN_NAME');
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (
            ! is_string($name) || trim($name) === ''
            || ! is_string($email) || filter_var($email, FILTER_VALIDATE_EMAIL) === false
            || ! is_string($password) || strlen($password) < 12
        ) {
            throw new InvalidArgumentException(
                'Set ADMIN_NAME, a valid ADMIN_EMAIL, and ADMIN_PASSWORD (at least 12 characters) in .env.'
            );
        }

        User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => trim($name),
                'password' => Hash::make($password),
            ],
        );
    }
}
