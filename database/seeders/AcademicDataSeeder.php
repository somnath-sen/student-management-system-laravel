<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Fee;
use App\Models\Badge;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

/**
 * AcademicDataSeeder — Production-Optimised
 *
 * Uses bulk DB::upsert() / DB::insert() instead of per-row ORM calls.
 * Reduces database round-trips from ~3,000+ to ~30, making it safe for
 * remote cloud databases (Aiven, PlanetScale, etc.) on Render/Railway.
 */
class AcademicDataSeeder extends Seeder
{
    private array $profiles = [
        'student@edflow.com'           => ['type' => 'high',    'att' => 95, 'marks_range' => [85, 98]],
        'student.bba@edflow.com'       => ['type' => 'high',    'att' => 93, 'marks_range' => [82, 96]],
        'student.bsc@edflow.com'       => ['type' => 'high',    'att' => 90, 'marks_range' => [80, 94]],
        'arjun.reddy@edflow.com'       => ['type' => 'dropout', 'att' => 38, 'marks_range' => [18, 44]],
        'rohan.singh@edflow.com'       => ['type' => 'warning', 'att' => 58, 'marks_range' => [35, 55]],
        'aisha.khan@edflow.com'        => ['type' => 'average', 'att' => 72, 'marks_range' => [55, 72]],
        'karthik.menon@edflow.com'     => ['type' => 'average', 'att' => 78, 'marks_range' => [60, 78]],
        'divya.pillai@edflow.com'      => ['type' => 'average', 'att' => 82, 'marks_range' => [65, 83]],
        'saurav.ghosh@edflow.com'      => ['type' => 'warning', 'att' => 55, 'marks_range' => [30, 52]],
        'riya.bose@edflow.com'         => ['type' => 'average', 'att' => 76, 'marks_range' => [62, 80]],
        'tanmoy.chatterjee@edflow.com' => ['type' => 'average', 'att' => 70, 'marks_range' => [55, 74]],
        'souvik.banerjee@edflow.com'   => ['type' => 'average', 'att' => 80, 'marks_range' => [66, 85]],
        'meera.nair@edflow.com'        => ['type' => 'average', 'att' => 85, 'marks_range' => [70, 88]],
        'neha.gupta@edflow.com'        => ['type' => 'average', 'att' => 75, 'marks_range' => [58, 76]],
    ];

    public function run(): void
    {
        $students = Student::with('user')->get();
        $teachers = Teacher::all();

        if ($students->isEmpty() || $teachers->isEmpty()) return;

        $now          = Carbon::now()->toDateTimeString();
        $workingDays  = $this->buildWorkingDays();
        $teacherMap   = $this->buildTeacherMap();
        $defaultTId   = $teachers->first()->id;
        $allBadges    = Badge::all();
        $feeIds       = $this->seedCourseFees($now);

        $attendanceBulk = $marksBulk = $gamiBulk = [];
        $riskBulk = $suggestionBulk = $feePaymentBulk = $badgeUserBulk = [];

        foreach ($students as $student) {
            /** @var \App\Models\Student $student */
            if (!$student->user) continue;

            $profile = $this->profiles[$student->user->email]
                ?? ['type' => 'average', 'att' => 75, 'marks_range' => [55, 75]];

            $rows = $this->buildStudentRows(
                $student, $profile, $workingDays, $teacherMap, $defaultTId, $allBadges, $feeIds, $now
            );

            $attendanceBulk  = array_merge($attendanceBulk,  $rows['attendance']);
            $marksBulk       = array_merge($marksBulk,       $rows['marks']);
            $gamiBulk[]      = $rows['gami'];
            $badgeUserBulk   = array_merge($badgeUserBulk,   $rows['badges']);
            $riskBulk[]      = $rows['risk'];
            $suggestionBulk[]= $rows['suggestion'];
            if ($rows['feePayment']) $feePaymentBulk[] = $rows['feePayment'];

        }

        // ── BULK INSERT (skip if already exists) ────────────────────────────────

        // Attendance: upsert on (student_id, subject_id, date)
        foreach (array_chunk($attendanceBulk, 200) as $chunk) {
            DB::table('attendances')->upsert(
                $chunk,
                ['student_id', 'subject_id', 'date'],
                ['present', 'teacher_id', 'updated_at']
            );
        }

        // Marks: upsert on (student_id, subject_id)
        if (!empty($marksBulk)) {
            DB::table('marks')->upsert(
                $marksBulk,
                ['student_id', 'subject_id'],
                ['marks_obtained', 'total_marks', 'is_locked', 'teacher_id', 'updated_at']
            );
        }

        // Gamification: upsert on (user_id)
        if (!empty($gamiBulk)) {
            DB::table('gamification_stats')->upsert(
                $gamiBulk,
                ['user_id'],
                ['total_points', 'level', 'current_streak', 'last_login_date', 'updated_at']
            );
        }

        // Badge-User pivot: ignore duplicates
        if (!empty($badgeUserBulk)) {
            foreach (array_chunk($badgeUserBulk, 100) as $chunk) {
                DB::table('badge_user')->upsert(
                    $chunk,
                    ['user_id', 'badge_id'],
                    ['updated_at']
                );
            }
        }

        // Risk Logs: upsert on (student_id)
        if (!empty($riskBulk)) {
            DB::table('risk_logs')->upsert(
                $riskBulk,
                ['student_id'],
                ['risk_score', 'risk_level', 'attendance_score', 'marks_score',
                 'engagement_score', 'insights', 'suggestions', 'last_evaluated_at', 'updated_at']
            );
        }

        // AI Suggestions: upsert on (user_id)
        if (!empty($suggestionBulk)) {
            DB::table('suggestions')->upsert(
                $suggestionBulk,
                ['user_id'],
                ['overall_level', 'analysis_json', 'suggestions_json', 'generated_at', 'updated_at']
            );
        }

        // Fee Payments: upsert on (fee_id, user_id)
        if (!empty($feePaymentBulk)) {
            DB::table('fee_payments')->upsert(
                $feePaymentBulk,
                ['fee_id', 'user_id'],
                ['amount_paid', 'payment_method', 'transaction_id', 'status', 'updated_at']
            );
        }

        // ── Exams ─────────────────────────────────────────────────────────
        $examBulk = [];
        foreach (Course::with('subjects')->get() as $course) {
            foreach ($course->subjects as $i => $subject) {
                $examBulk[] = [
                    'course_id'    => $course->id,
                    'subject_code' => $subject->subject_code,
                    'subject_name' => $subject->name,
                    'exam_date'    => Carbon::now()->addDays(12 + $i * 2)->format('Y-m-d'),
                    'exam_time'    => '10:00',
                    'is_active'    => 1,
                    'created_at'   => $now,
                    'updated_at'   => $now,
                ];
            }
        }
        if (!empty($examBulk)) {
            DB::table('exams')->upsert(
                $examBulk,
                ['course_id', 'subject_code'],
                ['exam_date', 'exam_time', 'is_active', 'updated_at']
            );
        }

        // ── Timetable ─────────────────────────────────────────────────────
        $this->seedTimetable($now);

        // ── Broadcast Messages ────────────────────────────────────────────
        $this->seedBroadcasts($teachers, $now);
    }

    // ─── Helper: build list of working days ───────────────────────────────
    private function buildWorkingDays(): array
    {
        $days = [];
        for ($d = 60; $d >= 0; $d--) {
            $date = Carbon::now()->subDays($d);
            if (!$date->isWeekend()) {
                $days[] = $date->format('Y-m-d');
            }
        }
        return $days;
    }

    // ─── Helper: subject_id → teacher_id map ─────────────────────────────
    private function buildTeacherMap(): \Illuminate\Support\Collection
    {
        return DB::table('subject_teacher')
            ->get()
            ->groupBy('subject_id')
            ->map(fn($rows) => $rows->first()->teacher_id);
    }

    // ─── Helper: upsert course-level fees and return course_id→fee_id map ─
    private function seedCourseFees(string $now): array
    {
        $feeIds = [];
        foreach (Course::all() as $course) {
            $fee = Fee::firstOrCreate(
                ['course_id' => $course->id, 'title' => 'Semester Fee – Autumn 2024'],
                [
                    'amount'      => 45000.00,
                    'due_date'    => Carbon::now()->addDays(30)->format('Y-m-d'),
                    'description' => 'Includes tuition, lab, and library charges for Autumn 2024.',
                ]
            );
            $feeIds[$course->id] = $fee->id;
        }
        return $feeIds;
    }

    // ─── Helper: build all row-arrays for one student ─────────────────────
    private function buildStudentRows(
        Student $student,
        array   $profile,
        array   $workingDays,
        \Illuminate\Support\Collection $teacherMap,
        int     $defaultTeacherId,
        \Illuminate\Database\Eloquent\Collection $allBadges,
        array   $feeIds,
        string  $now
    ): array {
        $isHigh = $profile['type'] === 'high';
        $isDrop = $profile['type'] === 'dropout';
        $isWarn = $profile['type'] === 'warning';

        $attendance = [];
        $marks      = [];

        $courseSubjects = Subject::where('course_id', $student->course_id)->get();
        foreach ($courseSubjects as $subject) {
            $teacherId = $teacherMap[$subject->id] ?? $defaultTeacherId;
            foreach ($workingDays as $date) {
                $attendance[] = [
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'teacher_id' => $teacherId,
                    'date'       => $date,
                    'present'    => (rand(1, 100) <= $profile['att']) ? 1 : 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            [$min, $max] = $profile['marks_range'];
            $marks[] = [
                'student_id'     => $student->id,
                'subject_id'     => $subject->id,
                'teacher_id'     => $teacherId,
                'marks_obtained' => rand($min, $max),
                'total_marks'    => 100,
                'is_locked'      => 1,
                'created_at'     => $now,
                'updated_at'     => $now,
            ];
        }

        // Gamification
        $xp = $isHigh ? rand(3500, 5000)
                      : ($isDrop ? rand(50, 400)
                      : ($isWarn ? rand(400, 1200) : rand(1200, 2800)));

        $gami = [
            'user_id'         => $student->user_id,
            'total_points'    => $xp,
            'level'           => floor($xp / 1000) + 1,
            'current_streak'  => $isHigh ? rand(8, 20) : ($isDrop ? rand(0, 1) : rand(1, 5)),
            'last_login_date' => Carbon::now()->subHours(rand(1, 36))->toDateTimeString(),
            'created_at'      => $now,
            'updated_at'      => $now,
        ];

        $badges = [];
        foreach ($allBadges as $badge) {
            if ($badge->points_required <= $xp) {
                $badges[] = ['user_id' => $student->user_id, 'badge_id' => $badge->id, 'created_at' => $now, 'updated_at' => $now];
            }
        }

        // Risk
        $attScore   = min(100, $profile['att']);
        $markAvg    = ($profile['marks_range'][0] + $profile['marks_range'][1]) / 2;
        $marksScore = min(100, $markAvg);
        $engScore   = $isHigh ? rand(75, 95) : ($isDrop ? rand(10, 30) : rand(35, 70));
        $riskScore  = 100 - (($attScore + $marksScore + $engScore) / 3);
        $riskLevel  = $riskScore >= 60 ? 'high_risk' : ($riskScore >= 35 ? 'at_risk' : 'safe');

        $risk = [
            'student_id'       => $student->id,
            'risk_score'       => round($riskScore, 2),
            'risk_level'       => $riskLevel,
            'attendance_score' => round($attScore, 2),
            'marks_score'      => round($marksScore, 2),
            'engagement_score' => round($engScore, 2),
            'insights'         => json_encode($this->riskInsights($riskLevel)),
            'suggestions'      => json_encode($this->riskSuggestions($riskLevel)),
            'last_evaluated_at'=> $now,
            'created_at'       => $now,
            'updated_at'       => $now,
        ];

        $suggestion = [
            'user_id'          => $student->user_id,
            'overall_level'    => $isHigh ? 'excellent' : ($isDrop ? 'critical' : ($isWarn ? 'needs_improvement' : 'good')),
            'analysis_json'    => json_encode(['attendance' => $profile['att'], 'avg_marks' => round($markAvg, 1), 'engagement' => $engScore]),
            'suggestions_json' => json_encode($this->aiSuggestions($profile['type'], $markAvg)),
            'generated_at'     => $now,
            'created_at'       => $now,
            'updated_at'       => $now,
        ];

        $feePayment = null;
        $isPaid = $isHigh || (!$isDrop && rand(0, 3) > 0);
        if ($isPaid && isset($feeIds[$student->course_id])) {
            $feePayment = [
                'fee_id'         => $feeIds[$student->course_id],
                'user_id'        => $student->user_id,
                'amount_paid'    => 45000.00,
                'payment_method' => ['UPI', 'Net Banking', 'Debit Card'][array_rand(['UPI', 'Net Banking', 'Debit Card'])],
                'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
                'status'         => 'Paid',
                'created_at'     => $now,
                'updated_at'     => $now,
            ];
        }

        return compact('attendance', 'marks', 'gami', 'badges', 'risk', 'suggestion', 'feePayment');
    }

    private function seedTimetable(string $now): void
    {
        $rows = [
            ['BTECH-CSE', 'Monday',    '09:00', '10:30', 'Data Structures and Algorithms', 'Dr. Amit Sharma',    'Lab-301', '#6366f1'],
            ['BTECH-CSE', 'Monday',    '11:00', '12:30', 'Database Management Systems',   'Prof. Sneha Verma',  'CS-201',  '#22c55e'],
            ['BTECH-CSE', 'Tuesday',   '09:00', '10:30', 'Operating Systems',             'Prof. Sneha Verma',  'CS-202',  '#f59e0b'],
            ['BTECH-CSE', 'Tuesday',   '11:00', '12:30', 'Artificial Intelligence',       'Dr. Amit Sharma',    'CS-301',  '#8b5cf6'],
            ['BTECH-CSE', 'Wednesday', '09:00', '10:30', 'Computer Networks',             'Mr. Karan Malhotra', 'CS-303',  '#ef4444'],
            ['BTECH-CSE', 'Thursday',  '09:00', '10:30', 'Data Structures and Algorithms','Dr. Amit Sharma',    'Lab-301', '#6366f1'],
            ['BTECH-CSE', 'Friday',    '09:00', '10:30', 'Database Management Systems',   'Prof. Sneha Verma',  'CS-201',  '#22c55e'],
            ['BBA-GEN',   'Monday',    '10:00', '11:30', 'Principles of Management',      'Dr. Rajesh Kumar',   'BBA-101', '#f97316'],
            ['BBA-GEN',   'Monday',    '12:00', '13:30', 'Financial Accounting',          'Prof. Priya Singh',  'BBA-102', '#06b6d4'],
            ['BBA-GEN',   'Tuesday',   '10:00', '11:30', 'Organizational Behavior',       'Dr. Rajesh Kumar',   'BBA-103', '#84cc16'],
            ['BBA-GEN',   'Wednesday', '10:00', '11:30', 'Marketing Strategy',            'Mr. Karan Malhotra', 'BBA-201', '#ec4899'],
            ['BBA-GEN',   'Thursday',  '10:00', '11:30', 'Business Economics',            'Prof. Priya Singh',  'BBA-202', '#14b8a6'],
            ['BBA-GEN',   'Friday',    '10:00', '11:30', 'Principles of Management',      'Dr. Rajesh Kumar',   'BBA-101', '#f97316'],
            ['BSC-PHY',   'Monday',    '08:30', '10:00', 'Classical Mechanics',           'Dr. Vikram Rathore', 'PHY-101', '#3b82f6'],
            ['BSC-PHY',   'Tuesday',   '08:30', '10:00', 'Electromagnetism',              'Dr. Anita Desai',    'PHY-102', '#a855f7'],
            ['BSC-PHY',   'Wednesday', '08:30', '10:00', 'Quantum Mechanics',             'Dr. Vikram Rathore', 'PHY-201', '#10b981'],
            ['BSC-PHY',   'Thursday',  '08:30', '10:00', 'Thermodynamics',               'Dr. Anita Desai',    'PHY-202', '#f59e0b'],
            ['BSC-PHY',   'Friday',    '08:30', '10:00', 'Solid State Physics',           'Dr. Vikram Rathore', 'PHY-301', '#ef4444'],
        ];

        $bulk = [];
        foreach ($rows as [$code, $day, $start, $end, $sub, $teach, $room, $color]) {
            $course = Course::where('course_code', $code)->first();
            if (!$course) continue;
            $bulk[] = [
                'course_id'    => $course->id,
                'day_of_week'  => $day,
                'subject_name' => $sub,
                'start_time'   => $start,
                'end_time'     => $end,
                'teacher_name' => $teach,
                'room_number'  => $room,
                'color_theme'  => $color,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        if (!empty($bulk)) {
            DB::table('timetables')->upsert(
                $bulk,
                ['course_id', 'day_of_week', 'subject_name'],
                ['start_time', 'end_time', 'teacher_name', 'room_number', 'color_theme', 'updated_at']
            );
        }
    }

    private function seedBroadcasts($teachers, string $now): void
    {
        $data = [
            ['CS201',  'Reminder: Assignment 2 submission is due this Friday. Upload your solutions on the portal before 11:59 PM.', 1, 'assignment'],
            ['CS202',  'Lab session this Thursday is rescheduled to Room 304. Bring your ER Diagram drafts.', 0, 'info'],
            ['CS301',  'Mid-term syllabus has been uploaded. Covers Units 1-4 including Search Algorithms and Neural Nets.', 1, 'exam'],
            ['MGT101', 'Guest lecture by Mr. Ravi Goyal (Ex-CEO, FinServ India) this Wednesday. Attendance mandatory.', 1, 'event'],
            ['PHY101', 'Practical exam dates are out. Check the exam calendar for your slot details.', 0, 'exam'],
            ['PHY201', 'Formula sheet for Quantum Mechanics viva is available in the Resources section.', 0, 'info'],
        ];

        $teacherMap = DB::table('subject_teacher')->get()->groupBy('subject_id')->map(fn($r) => $r->first()->teacher_id);
        $defaultId  = $teachers->first()->id;

        $bulk = [];
        foreach ($data as [$code, $msg, $important, $type]) {
            $subject = DB::table('subjects')->where('subject_code', $code)->first();
            if (!$subject) continue;
            $bulk[] = [
                'teacher_id'   => $teacherMap[$subject->id] ?? $defaultId,
                'subject_id'   => $subject->id,
                'message'      => $msg,
                'is_important' => $important,
                'type'         => $type,
                'created_at'   => $now,
                'updated_at'   => $now,
            ];
        }

        if (!empty($bulk)) {
            DB::table('broadcast_messages')->upsert(
                $bulk,
                ['subject_id', 'message'],
                ['is_important', 'type', 'updated_at']
            );
        }
    }

    // ─── Helpers ──────────────────────────────────────────────────────────
    private function riskInsights(string $level): array
    {
        return match($level) {
            'high_risk' => [
                'Low attendance detected (below 40%)',
                'Multiple failing grades in core subjects',
                'No login activity in the past 7 days',
                'Zero assignment submissions in last 14 days',
            ],
            'at_risk' => [
                'Attendance below acceptable threshold (60%)',
                'Below-average scores in 2 or more subjects',
                'Low engagement with course materials',
            ],
            default => [
                'Attendance and performance are satisfactory',
                'Regular activity detected on the portal',
            ],
        };
    }

    private function riskSuggestions(string $level): array
    {
        return match($level) {
            'high_risk' => [
                'Immediately contact the student and their guardian',
                'Schedule a counselling session with the academic coordinator',
                'Place the student on a performance improvement plan (PIP)',
                'Notify the class teacher and Head of Department',
            ],
            'at_risk' => [
                'Send a formal attendance warning letter',
                'Assign a peer mentor to guide the student',
                'Follow up with additional study resources for weak subjects',
            ],
            default => [
                'Continue monitoring progress',
                'Encourage participation in college events and clubs',
            ],
        };
    }

    private function aiSuggestions(string $type, float $markAvg): array
    {
        return match($type) {
            'high' => [
                'Excellent performance! Consider applying for the merit scholarship.',
                'Explore advanced electives or research internship programs.',
                'Your profile is strong – start preparing for campus placements early.',
            ],
            'dropout' => [
                'Immediate intervention required. Please connect with your academic mentor.',
                'Re-plan your weekly schedule and set small, daily study goals.',
                'Your parents/guardians have been notified about your current performance.',
                'Use the AI Study Mentor chat for personalized academic support.',
            ],
            'warning' => [
                'Attendance is below 60%. Review bunk patterns and set reminders.',
                'Focus on ' . ($markAvg < 50 ? 'foundational concepts' : 'weak subject areas') . ' to boost your GPA.',
                'Set up daily study reminders in the portal to stay on track.',
            ],
            default => [
                'You are on track. Maintain consistency in attendance and submissions.',
                'Review your weakest subject scores and allocate extra revision time.',
                'Aim for 85%+ in the upcoming mid-term to secure a good grade.',
            ],
        };
    }
}
