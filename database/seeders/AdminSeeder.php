<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = Role::where('name', 'admin')->value('id') ?? 1;

        $admins = [
            // Primary demo admin
            [
                'email' => 'admin@edflow.com',
                'name'  => 'System Administrator',
            ],
            // Secondary admin for demo flexibility
            [
                'email' => 'demo.admin@edflow.com',
                'name'  => 'Demo Admin',
            ],
        ];

        foreach ($admins as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id'  => $adminRoleId,
                ]
            );
        }
    }
}
