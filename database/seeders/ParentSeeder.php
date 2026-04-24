<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $parents = [
            ['name' => 'Rajesh Das',        'email' => 'parent@edflow.com',         'phone' => '+91 9876542001'],
            ['name' => 'Vikram Reddy',       'email' => 'vikram.reddy@edflow.com',   'phone' => '+91 9876542002'],
            ['name' => 'Sanjay Sharma',      'email' => 'sanjay.sharma@edflow.com',  'phone' => '+91 9876542003'],
            ['name' => 'Alok Gupta',         'email' => 'alok.gupta@edflow.com',     'phone' => '+91 9876542004'],
            ['name' => 'Kunal Singh',        'email' => 'kunal.singh@edflow.com',    'phone' => '+91 9876542005'],
            ['name' => 'Imran Khan',         'email' => 'imran.khan@edflow.com',     'phone' => '+91 9876542006'],
            ['name' => 'Tapan Banerjee',     'email' => 'tapan.banerjee@edflow.com', 'phone' => '+91 9876542007'],
            ['name' => 'Suresh Menon',       'email' => 'suresh.menon@edflow.com',   'phone' => '+91 9876542008'],
            ['name' => 'Mohan Pillai',       'email' => 'mohan.pillai@edflow.com',   'phone' => '+91 9876542009'],
            ['name' => 'Pranab Ghosh',       'email' => 'pranab.ghosh@edflow.com',   'phone' => '+91 9876542010'],
            ['name' => 'Debashish Bose',     'email' => 'debashish.bose@edflow.com', 'phone' => '+91 9876542011'],
            ['name' => 'Sourav Chatterjee',  'email' => 'sourav.chatterjee@edflow.com','phone' => '+91 9876542012'],
            ['name' => 'Gopal Nair',         'email' => 'gopal.nair@edflow.com',     'phone' => '+91 9876542013'],
        ];

        foreach ($parents as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id'  => 4,
                ]
            );
        }
    }
}
