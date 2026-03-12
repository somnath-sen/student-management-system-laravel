<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Only create the roles if they do not already exist
        Role::firstOrCreate(['id' => 1], ['name' => 'admin']);
        Role::firstOrCreate(['id' => 2], ['name' => 'teacher']);
        Role::firstOrCreate(['id' => 3], ['name' => 'student']);

        // Only create the admin user if this email doesn't already exist
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'role_id' => 1,
            ]
        );
    }
}