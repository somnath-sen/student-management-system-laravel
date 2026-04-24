<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Roles & Badges
        $this->call([
            RoleSeeder::class,
            BadgeSeeder::class,
        ]);

        // 2. Core Users
        $this->call([
            AdminSeeder::class,
        ]);

        // 3. Academic Structure (Courses & Subjects)
        $this->call([
            AcademicStructureSeeder::class,
        ]);

        // 4. Faculty & Students
        $this->call([
            TeacherSeeder::class,
            StudentSeeder::class,
            ParentSeeder::class,
        ]);

        // 5. Academic Data (Attendance, Marks, Fees, Exams)
        $this->call([
            AcademicDataSeeder::class,
        ]);

        // 6. Communications
        $this->call([
            NoticeSeeder::class,
        ]);
    }
}