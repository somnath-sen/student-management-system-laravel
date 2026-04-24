<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teachers = [
            // Demo Account
            [
                'name' => 'Dr. Amit Sharma', 'email' => 'teacher@edflow.com',
                'employee_id' => 'EMP-1001', 'phone' => '+91 9800001001',
                'qualification' => 'Ph.D. in Computer Science, IIT Delhi',
                'experience' => '12 Years', 'subjects' => ['CS201', 'CS301'],
            ],
            [
                'name' => 'Prof. Sneha Verma', 'email' => 'sneha.verma@edflow.com',
                'employee_id' => 'EMP-1002', 'phone' => '+91 9800001002',
                'qualification' => 'M.Tech in Software Engineering, NIT Trichy',
                'experience' => '8 Years', 'subjects' => ['CS202', 'CS302'],
            ],
            [
                'name' => 'Dr. Rajesh Kumar', 'email' => 'rajesh.kumar@edflow.com',
                'employee_id' => 'EMP-1003', 'phone' => '+91 9800001003',
                'qualification' => 'MBA, Ph.D. in Management, IIM Ahmedabad',
                'experience' => '15 Years', 'subjects' => ['MGT101', 'OB201'],
            ],
            [
                'name' => 'Prof. Priya Singh', 'email' => 'priya.singh.f@edflow.com',
                'employee_id' => 'EMP-1004', 'phone' => '+91 9800001004',
                'qualification' => 'M.Com, CA (ICAI), PGDM Finance',
                'experience' => '5 Years', 'subjects' => ['ACC102', 'ECO101'],
            ],
            [
                'name' => 'Dr. Vikram Rathore', 'email' => 'vikram.rathore@edflow.com',
                'employee_id' => 'EMP-1005', 'phone' => '+91 9800001005',
                'qualification' => 'Ph.D. in Applied Physics, Jadavpur University',
                'experience' => '20 Years', 'subjects' => ['PHY101', 'PHY201', 'PHY301'],
            ],
            [
                'name' => 'Dr. Anita Desai', 'email' => 'anita.desai@edflow.com',
                'employee_id' => 'EMP-1006', 'phone' => '+91 9800001006',
                'qualification' => 'M.Sc & Ph.D. in Physics, Calcutta University',
                'experience' => '6 Years', 'subjects' => ['PHY102', 'PHY202'],
            ],
            [
                'name' => 'Mr. Karan Malhotra', 'email' => 'karan.malhotra@edflow.com',
                'employee_id' => 'EMP-1007', 'phone' => '+91 9800001007',
                'qualification' => 'M.Tech in IT, IIIT Hyderabad',
                'experience' => '7 Years', 'subjects' => ['CS303', 'MKT301'],
            ],
        ];

        foreach ($teachers as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id'  => 2,
                ]
            );

            $teacher = Teacher::firstOrCreate(
                ['employee_id' => $data['employee_id']],
                [
                    'user_id'       => $user->id,
                    'phone'         => $data['phone'],
                    'qualification' => $data['qualification'],
                    'experience'    => $data['experience'],
                ]
            );

            foreach ($data['subjects'] as $code) {
                $subject = Subject::where('subject_code', $code)->first();
                if ($subject) {
                    DB::table('subject_teacher')->updateOrInsert([
                        'subject_id' => $subject->id,
                        'teacher_id' => $teacher->id,
                    ]);
                }
            }
        }
    }
}
