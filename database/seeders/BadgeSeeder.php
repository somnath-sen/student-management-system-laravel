<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $badges = [
            [
                'name' => 'First Step',
                'icon' => '<i class="fa-solid fa-shoe-prints text-blue-500"></i>',
                'description' => 'Earned 100 XP to start your journey.',
                'points_required' => 100,
            ],
            [
                'name' => 'Perfect Attendance',
                'icon' => '<i class="fa-solid fa-calendar-check text-emerald-500"></i>',
                'description' => 'Earned 500 XP through participation.',
                'points_required' => 500,
            ],
            [
                'name' => 'Scholar',
                'icon' => '<i class="fa-solid fa-book-open text-purple-500"></i>',
                'description' => 'Earned 1000 XP and reached Level 2.',
                'points_required' => 1000,
            ],
            [
                'name' => 'Legend',
                'icon' => '<i class="fa-solid fa-crown text-amber-500"></i>',
                'description' => 'Earned 5000 XP. You are a true EdFlow Legend.',
                'points_required' => 5000,
            ],
        ];

        foreach ($badges as $badge) {
            \App\Models\Badge::updateOrCreate(['name' => $badge['name']], $badge);
        }
    }
}
