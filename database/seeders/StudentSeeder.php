<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $btech = Course::where('course_code', 'BTECH-CSE')->first();
        $bba   = Course::where('course_code', 'BBA-GEN')->first();
        $bsc   = Course::where('course_code', 'BSC-PHY')->first();

        $students = [
            // ─── B.Tech CSE ──────────────────────────────────────────────────
            [
                'name' => 'Rahul Das', 'email' => 'student@edflow.com',
                'phone' => '+91 9876541001', 'gender' => 'Male',
                'course_id' => $btech->id ?? 1, 'roll_number' => 'CSE-2023-001',
                'parent_name' => 'Rajesh Das', 'parent_email' => 'parent@edflow.com',
                'parent_phone' => '+91 9876542001', 'emergency_phone' => '+91 9876542001',
                'blood_group' => 'B+', 'home_address' => 'Sector 5, Salt Lake, Kolkata - 700091',
            ],
            [
                'name' => 'Arjun Reddy', 'email' => 'arjun.reddy@edflow.com',
                'phone' => '+91 9876541002', 'gender' => 'Male',
                'course_id' => $btech->id ?? 1, 'roll_number' => 'CSE-2023-002',
                'parent_name' => 'Vikram Reddy', 'parent_email' => 'vikram.reddy@edflow.com',
                'parent_phone' => '+91 9876542002', 'emergency_phone' => '+91 9876542002',
                'blood_group' => 'O+', 'home_address' => 'New Town, Action Area 2, Kolkata - 700160',
            ],
            [
                'name' => 'Rohan Singh', 'email' => 'rohan.singh@edflow.com',
                'phone' => '+91 9876541005', 'gender' => 'Male',
                'course_id' => $btech->id ?? 1, 'roll_number' => 'CSE-2023-003',
                'parent_name' => 'Kunal Singh', 'parent_email' => 'kunal.singh@edflow.com',
                'parent_phone' => '+91 9876542005', 'emergency_phone' => '+91 9876542005',
                'blood_group' => 'B-', 'home_address' => 'Gariahat Road, Kolkata - 700029',
            ],
            [
                'name' => 'Karthik Menon', 'email' => 'karthik.menon@edflow.com',
                'phone' => '+91 9876541008', 'gender' => 'Male',
                'course_id' => $btech->id ?? 1, 'roll_number' => 'CSE-2023-004',
                'parent_name' => 'Suresh Menon', 'parent_email' => 'suresh.menon@edflow.com',
                'parent_phone' => '+91 9876542008', 'emergency_phone' => '+91 9876542008',
                'blood_group' => 'A+', 'home_address' => 'Park Circus, Kolkata - 700017',
            ],
            [
                'name' => 'Divya Pillai', 'email' => 'divya.pillai@edflow.com',
                'phone' => '+91 9876541009', 'gender' => 'Female',
                'course_id' => $btech->id ?? 1, 'roll_number' => 'CSE-2023-005',
                'parent_name' => 'Mohan Pillai', 'parent_email' => 'mohan.pillai@edflow.com',
                'parent_phone' => '+91 9876542009', 'emergency_phone' => '+91 9876542009',
                'blood_group' => 'AB+', 'home_address' => 'Elgin Road, Kolkata - 700020',
            ],
            [
                'name' => 'Saurav Ghosh', 'email' => 'saurav.ghosh@edflow.com',
                'phone' => '+91 9876541010', 'gender' => 'Male',
                'course_id' => $btech->id ?? 1, 'roll_number' => 'CSE-2023-006',
                'parent_name' => 'Pranab Ghosh', 'parent_email' => 'pranab.ghosh@edflow.com',
                'parent_phone' => '+91 9876542010', 'emergency_phone' => '+91 9876542010',
                'blood_group' => 'O-', 'home_address' => 'Jadavpur, Kolkata - 700032',
            ],
            // ─── BBA ──────────────────────────────────────────────────────────
            [
                'name' => 'Priya Sharma', 'email' => 'student.bba@edflow.com',
                'phone' => '+91 9876541003', 'gender' => 'Female',
                'course_id' => $bba->id ?? 2, 'roll_number' => 'BBA-2023-001',
                'parent_name' => 'Sanjay Sharma', 'parent_email' => 'sanjay.sharma@edflow.com',
                'parent_phone' => '+91 9876542003', 'emergency_phone' => '+91 9876542003',
                'blood_group' => 'A+', 'home_address' => 'Park Street, Kolkata - 700016',
            ],
            [
                'name' => 'Aisha Khan', 'email' => 'aisha.khan@edflow.com',
                'phone' => '+91 9876541006', 'gender' => 'Female',
                'course_id' => $bba->id ?? 2, 'roll_number' => 'BBA-2023-002',
                'parent_name' => 'Imran Khan', 'parent_email' => 'imran.khan@edflow.com',
                'parent_phone' => '+91 9876542006', 'emergency_phone' => '+91 9876542006',
                'blood_group' => 'O-', 'home_address' => 'Tollygunge, Kolkata - 700040',
            ],
            [
                'name' => 'Riya Bose', 'email' => 'riya.bose@edflow.com',
                'phone' => '+91 9876541011', 'gender' => 'Female',
                'course_id' => $bba->id ?? 2, 'roll_number' => 'BBA-2023-003',
                'parent_name' => 'Debashish Bose', 'parent_email' => 'debashish.bose@edflow.com',
                'parent_phone' => '+91 9876542011', 'emergency_phone' => '+91 9876542011',
                'blood_group' => 'A-', 'home_address' => 'Howrah, West Bengal - 711101',
            ],
            [
                'name' => 'Tanmoy Chatterjee', 'email' => 'tanmoy.chatterjee@edflow.com',
                'phone' => '+91 9876541012', 'gender' => 'Male',
                'course_id' => $bba->id ?? 2, 'roll_number' => 'BBA-2023-004',
                'parent_name' => 'Sourav Chatterjee', 'parent_email' => 'sourav.chatterjee@edflow.com',
                'parent_phone' => '+91 9876542012', 'emergency_phone' => '+91 9876542012',
                'blood_group' => 'B+', 'home_address' => 'Dumdum, Kolkata - 700028',
            ],
            // ─── B.Sc Physics ─────────────────────────────────────────────────
            [
                'name' => 'Neha Gupta', 'email' => 'student.bsc@edflow.com',
                'phone' => '+91 9876541004', 'gender' => 'Female',
                'course_id' => $bsc->id ?? 3, 'roll_number' => 'PHY-2023-001',
                'parent_name' => 'Alok Gupta', 'parent_email' => 'alok.gupta@edflow.com',
                'parent_phone' => '+91 9876542004', 'emergency_phone' => '+91 9876542004',
                'blood_group' => 'AB+', 'home_address' => 'Bhowanipore, Kolkata - 700025',
            ],
            [
                'name' => 'Souvik Banerjee', 'email' => 'souvik.banerjee@edflow.com',
                'phone' => '+91 9876541007', 'gender' => 'Male',
                'course_id' => $bsc->id ?? 3, 'roll_number' => 'PHY-2023-002',
                'parent_name' => 'Tapan Banerjee', 'parent_email' => 'tapan.banerjee@edflow.com',
                'parent_phone' => '+91 9876542007', 'emergency_phone' => '+91 9876542007',
                'blood_group' => 'O+', 'home_address' => 'Ballygunge, Kolkata - 700019',
            ],
            [
                'name' => 'Meera Nair', 'email' => 'meera.nair@edflow.com',
                'phone' => '+91 9876541013', 'gender' => 'Female',
                'course_id' => $bsc->id ?? 3, 'roll_number' => 'PHY-2023-003',
                'parent_name' => 'Gopal Nair', 'parent_email' => 'gopal.nair@edflow.com',
                'parent_phone' => '+91 9876542013', 'emergency_phone' => '+91 9876542013',
                'blood_group' => 'B+', 'home_address' => 'Lake Town, Kolkata - 700089',
            ],
        ];

        foreach ($students as $data) {
            if (!$data['course_id']) continue;

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name'     => $data['name'],
                    'password' => Hash::make('password'),
                    'role_id'  => 3,
                ]
            );

            $student = Student::firstOrCreate(
                ['roll_number' => $data['roll_number']],
                [
                    'user_id'        => $user->id,
                    'course_id'      => $data['course_id'],
                    'phone'          => $data['phone'],
                    'parent_name'    => $data['parent_name'],
                    'emergency_phone'=> $data['emergency_phone'],
                    'blood_group'    => $data['blood_group'],
                    'home_address'   => $data['home_address'],
                    'last_lat'       => 22.5726 + (rand(-50, 50) / 1000),
                    'last_lng'       => 88.3639 + (rand(-50, 50) / 1000),
                    'location_updated_at' => now()->subMinutes(rand(5, 120)),
                ]
            );

            // Link parent
            $parentUser = User::where('email', $data['parent_email'])->first();
            if ($parentUser) {
                DB::table('parent_student')->updateOrInsert([
                    'student_id' => $student->id,
                    'parent_id'  => $parentUser->id,
                ]);
            }
        }
    }
}
