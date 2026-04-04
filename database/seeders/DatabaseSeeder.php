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

        // 2. Core Admin
        User::firstOrCreate(
            ['email' => 'admin@edflow.com'],
            ['name' => 'System Admin', 'password' => Hash::make('password'), 'role_id' => 1]
        );

        // 3. Courses & Subjects
        $courses = \App\Models\Course::factory(3)->create();
        $subjects = collect();
        foreach ($courses as $course) {
            $courseSubjects = \App\Models\Subject::factory(5)->create(['course_id' => $course->id]);
            $subjects = $subjects->merge($courseSubjects);
        }

        // 4. Teachers
        $teachers = collect();
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Teacher $i",
                'email' => "teacher$i@edflow.com",
                'password' => Hash::make('password'),
                'role_id' => 2,
            ]);
            $teacher = \App\Models\Teacher::create([
                'user_id' => $user->id,
                'employee_id' => 'TCH-' . (1000 + $i),
                'phone' => '123456789' . $i,
                'qualification' => 'M.Sc Computer Science',
                'experience' => ($i + 2) . ' Years',
            ]);
            $teachers->push($teacher);

            // Assign to random subjects
            $assignedSubjects = $subjects->random(rand(2, 4));
            foreach ($assignedSubjects as $sub) {
                // Assuming a pivot or direct link exists. 
                // Based on previous research, subject has teacher_id or subject_teacher table?
                // Looking at migrations: 2026_02_04_193500_create_subject_teacher_table.php exists.
                \DB::table('subject_teacher')->insert([
                    'subject_id' => $sub->id,
                    'teacher_id' => $teacher->id,
                ]);
            }
        }

        // 5. Students & History
        for ($i = 1; $i <= 50; $i++) {
            $course = $courses->random();
            $user = User::create([
                'name' => "Student $i",
                'email' => "student$i@edflow.com",
                'password' => Hash::make('password'),
                'role_id' => 3,
            ]);

            $student = \App\Models\Student::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
                'roll_number' => 'ED-' . (1000 + $i),
                'parent_name' => 'Parent ' . $i,
                'emergency_phone' => '987654321' . $i,
                'blood_group' => 'O+',
                'home_address' => 'Fake Street ' . $i,
                'last_lat' => 22.5726,
                'last_lng' => 88.3639,
                'location_updated_at' => now(),
            ]);

            // Attendance History (Last 30 days)
            $studentSubjects = $subjects->where('course_id', $course->id);
            foreach ($studentSubjects as $sub) {
                for ($d = 0; $d < 30; $d++) {
                    $date = now()->subDays($d);
                    if ($date->isWeekend()) continue;

                    \App\Models\Attendance::create([
                        'student_id' => $student->id,
                        'subject_id' => $sub->id,
                        'teacher_id' => $teachers->random()->id,
                        'date' => $date->format('Y-m-d'),
                        'present' => rand(0, 10) > 1, // 90% attendance
                    ]);
                }

                // Marks
                \App\Models\Mark::create([
                    'student_id' => $student->id,
                    'subject_id' => $sub->id,
                    'teacher_id' => $teachers->random()->id,
                    'marks_obtained' => rand(40, 100),
                    'total_marks' => 100,
                    'is_locked' => true,
                ]);
            }

            // Fees
            $fee = \App\Models\Fee::create([
                'course_id' => $course->id,
                'title' => 'Semester Fee - ' . now()->format('Y'),
                'amount' => rand(2000, 5000),
                'due_date' => now()->addMonths(2),
            ]);

            if (rand(0, 1)) {
                \App\Models\FeePayment::create([
                    'user_id' => $user->id,
                    'fee_id' => $fee->id,
                    'amount_paid' => $fee->amount,
                    'payment_method' => 'UPI',
                    'transaction_id' => 'TXN-' . Str::upper(Str::random(10)),
                    'status' => 'Paid',
                ]);
            }

            // Gamification
            $xp = rand(200, 4800);
            \App\Models\GamificationStat::create([
                'user_id' => $user->id,
                'total_points' => $xp,
                'level' => floor($xp / 1000) + 1,
                'current_streak' => rand(1, 15),
                'last_login_date' => now()->subDays(rand(0, 2)),
            ]);

            // Random Badges
            $randomBadges = \App\Models\Badge::where('points_required', '<=', $xp)->get();
            if ($randomBadges->count() > 0) {
                $user->badges()->attach($randomBadges->pluck('id'));
            }
        }

        // 6. Notices
        \App\Models\Notice::factory(12)->create([
            'user_id' => User::where('role_id', 1)->first()->id
        ]);
    }
}