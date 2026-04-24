<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;
use App\Models\User;
use App\Models\Setting;

class NoticeSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role_id', 1)->first();
        if (!$admin) return;

        $notices = [
            [
                'title'    => 'Welcome to EdFlow Student Management System',
                'category' => 'General',
                'content'  => 'We warmly welcome all students, faculty, and parents to the EdFlow portal for the Autumn 2024 semester. Please complete your profile and review your assigned courses, timetable, and notices. For any technical assistance, contact the administration office.',
            ],
            [
                'title'    => 'Mid-Term Examination Schedule – Autumn 2024',
                'category' => 'Exam',
                'content'  => 'The Mid-Term examination schedule has been published. All examinations will be held in the designated halls between 10:00 AM – 1:00 PM. Admit cards are available for download from your student portal. Students must carry their ID card and admit card on the exam day.',
            ],
            [
                'title'    => 'Campus Closed – Diwali Holiday (October 31 – November 2)',
                'category' => 'Holiday',
                'content'  => 'The campus, including the library, laboratories, and administrative offices, will remain closed from October 31 to November 2 on account of Diwali festivities. Classes will resume on Monday, November 4. Wishing everyone a safe and happy Diwali!',
            ],
            [
                'title'    => 'URGENT: Scheduled System Maintenance Tonight',
                'category' => 'Urgent',
                'content'  => 'The EdFlow portal will be temporarily unavailable tonight from 11:00 PM to 2:00 AM for critical infrastructure maintenance. Please save all pending assignments and work before 10:45 PM. We apologize for the inconvenience.',
            ],
            [
                'title'    => 'Semester Fee Payment Deadline – October 25, 2024',
                'category' => 'General',
                'content'  => 'This is a formal reminder that the deadline for Autumn 2024 semester fee payment is October 25, 2024. Students with outstanding dues after the deadline will be charged a late fee of ₹500 per week. Pay online via UPI, Net Banking, or Debit Card through the Fee Tracker in your portal.',
            ],
            [
                'title'    => 'Annual Sports Day Registration Open',
                'category' => 'Event',
                'content'  => 'Registrations for the Annual Sports Day (December 14, 2024) are now open! Students can register for track & field, badminton, cricket, and chess events. Visit the Activities section in your portal to register. Last date to apply: November 30, 2024.',
            ],
            [
                'title'    => 'New AI Study Mentor Feature Launched',
                'category' => 'General',
                'content'  => 'We are excited to announce the launch of the AI Study Mentor feature in the student portal. Powered by Google Gemini, this feature provides personalised study recommendations, performance insights, and academic Q&A based on your course data. Access it from your dashboard today!',
            ],
        ];

        foreach ($notices as $notice) {
            Notice::firstOrCreate(
                ['title' => $notice['title']],
                [
                    'user_id'  => $admin->id,
                    'category' => $notice['category'],
                    'content'  => $notice['content'],
                ]
            );
        }

        // ── System Settings ───────────────────────────────────────────────
        $settings = [
            ['key' => 'college_name',    'value' => 'EdFlow College of Technology & Management'],
            ['key' => 'college_address', 'value' => 'Salt Lake, Sector V, Kolkata – 700091, West Bengal'],
            ['key' => 'college_phone',   'value' => '+91 33 2357 1234'],
            ['key' => 'college_email',   'value' => 'info@edflow.edu.in'],
            ['key' => 'principal_name',  'value' => 'Prof. Dr. Ashok Mukherjee'],
            ['key' => 'academic_year',   'value' => '2024-2025'],
            ['key' => 'results_published', 'value' => 'true'],
        ];

        foreach ($settings as $s) {
            Setting::updateOrCreate(['key' => $s['key']], ['value' => $s['value']]);
        }
    }
}
