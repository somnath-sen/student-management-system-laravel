<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\Subject;

class AcademicStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $academicData = [
            [
                'name' => 'B.Tech Computer Science & Engineering',
                'course_code' => 'BTECH-CSE',
                'description' => 'A comprehensive 4-year undergraduate program covering software engineering, algorithms, AI, and systems programming.',
                'subjects' => [
                    ['name' => 'Data Structures and Algorithms', 'subject_code' => 'CS201'],
                    ['name' => 'Database Management Systems', 'subject_code' => 'CS202'],
                    ['name' => 'Artificial Intelligence', 'subject_code' => 'CS301'],
                    ['name' => 'Operating Systems', 'subject_code' => 'CS302'],
                    ['name' => 'Computer Networks', 'subject_code' => 'CS303'],
                ]
            ],
            [
                'name' => 'Bachelor of Business Administration',
                'course_code' => 'BBA-GEN',
                'description' => 'A 3-year foundational program focused on business principles, management, economics, and organizational behavior.',
                'subjects' => [
                    ['name' => 'Principles of Management', 'subject_code' => 'MGT101'],
                    ['name' => 'Financial Accounting', 'subject_code' => 'ACC102'],
                    ['name' => 'Organizational Behavior', 'subject_code' => 'OB201'],
                    ['name' => 'Marketing Strategy', 'subject_code' => 'MKT301'],
                    ['name' => 'Business Economics', 'subject_code' => 'ECO101'],
                ]
            ],
            [
                'name' => 'B.Sc Physics (Honours)',
                'course_code' => 'BSC-PHY',
                'description' => 'A rigorous 3-year science program delving into quantum mechanics, electromagnetism, and classical physics.',
                'subjects' => [
                    ['name' => 'Classical Mechanics', 'subject_code' => 'PHY101'],
                    ['name' => 'Electromagnetism', 'subject_code' => 'PHY102'],
                    ['name' => 'Quantum Mechanics', 'subject_code' => 'PHY201'],
                    ['name' => 'Thermodynamics', 'subject_code' => 'PHY202'],
                    ['name' => 'Solid State Physics', 'subject_code' => 'PHY301'],
                ]
            ],
        ];

        foreach ($academicData as $data) {
            $course = Course::firstOrCreate(
                ['course_code' => $data['course_code']],
                [
                    'name' => $data['name'],
                    'description' => $data['description'],
                    'admit_cards_published' => true,
                ]
            );

            foreach ($data['subjects'] as $subjectData) {
                Subject::firstOrCreate(
                    ['subject_code' => $subjectData['subject_code']],
                    [
                        'course_id' => $course->id,
                        'name' => $subjectData['name'],
                    ]
                );
            }
        }
    }
}
