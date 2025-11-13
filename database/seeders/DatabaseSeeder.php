<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Super Administrator',
            'user_type' => UserType::SUPER_ADMINISTRATOR,
            'email' => 'superadmin@example.com',
            'password' => Hash::make(config('users.default_admin_password', 'password')),
        ]);
    }
}
