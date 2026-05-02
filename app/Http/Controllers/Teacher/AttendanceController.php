<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AttendanceController extends Controller
{
    public function create(Request $request)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        // Only load subjects assigned to THIS specific teacher
        $subjects = $teacher->subjects;

        // Capture user selections from the URL (if any)
        $selectedSubject = $request->subject_id ? Subject::find($request->subject_id) : null;
        $date = $request->date ?? date('Y-m-d');
        
        $students = collect();
        $existingAttendance = [];

        // ONLY load students if a subject is selected
        if ($selectedSubject) {
            
            // Only load students enrolled in the course associated with this subject
            $students = Student::with('user')
                ->where('course_id', $selectedSubject->course_id)
                ->get(); 

            // Fetch existing attendance to pre-fill the toggles if they already took attendance today
            $existingAttendance = Attendance::where('subject_id', $selectedSubject->id)
                                            ->where('date', $date)
                                            ->get()
                                            ->keyBy('student_id');
        }

        return view('teacher.attendance.create', compact('subjects', 'selectedSubject', 'date', 'students', 'existingAttendance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'date'       => 'required|date',
            'attendance' => 'required|array',
        ]);

        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        foreach ($request->attendance as $studentId => $present) {
            $attendance = Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'date'       => $request->date,
                ],
                [
                    'teacher_id' => $teacher->id,
                    'present'    => $present,
                ]
            );

            // Award XP if marked present
            if ($present) {
                $student = Student::find($studentId);
                if ($student && $student->user) {
                    $student->user->addXP(
                        50,
                        'Perfect Attendance',
                        "Earned 50 XP for attending class on " . $request->date . "!"
                    );
                }
            }
        }

        // ── Telegram Notifications ───────────────────────────────────────────
        try {
            $telegram = app(TelegramService::class);
            $date     = \Carbon\Carbon::parse($request->date)->format('d M Y');

            foreach ($request->attendance as $studentId => $present) {
                $student = Student::with(['user', 'parents'])->find($studentId);
                if (! $student) continue;

                // ── Attendance Recorded Notification ─────────────────────────
                if ($student->user && $student->user->telegram_chat_id) {
                    $status = $present ? '✅ Present' : '❌ Absent';
                    $telegram->sendMessage(
                        $student->user->telegram_chat_id,
                        "📊 *Attendance Recorded*\n\nHello {$student->user->name},\n\nYour attendance for *{$date}* has been marked: *{$status}*.",
                        'attendance',
                        'student',
                        $student->user->id
                    );
                }

                foreach ($student->parents as $parent) {
                    if ($parent->telegram_chat_id) {
                        $status = $present ? 'Present ✅' : 'Absent ❌';
                        $telegram->sendMessage(
                            $parent->telegram_chat_id,
                            "📊 *Attendance Update*\n\nDear Parent,\n\nYour child *{$student->user->name}* was marked *{$status}* on *{$date}*.",
                            'attendance',
                            'parent',
                            $parent->id
                        );
                    }
                }

                // ── Low Attendance Warning (< 75%) ────────────────────────────
                $total   = Attendance::where('student_id', $studentId)
                    ->whereHas('subject', fn($q) => $q->where('course_id', $student->course_id))
                    ->count();
                $presentCount = Attendance::where('student_id', $studentId)
                    ->whereHas('subject', fn($q) => $q->where('course_id', $student->course_id))
                    ->where('present', 1)->count();
                $pct = $total > 0 ? round(($presentCount / $total) * 100, 1) : 0;

                if ($pct < 75 && $total >= 5) {
                    if ($student->user && $student->user->telegram_chat_id) {
                        $telegram->sendMessage(
                            $student->user->telegram_chat_id,
                            "⚠️ *Low Attendance Warning*\n\nYour current attendance is *{$pct}%*, which is below the required *75%*.\n\nPlease attend classes regularly.",
                            'low_attendance',
                            'student',
                            $student->user->id
                        );
                    }
                    foreach ($student->parents as $parent) {
                        if ($parent->telegram_chat_id) {
                            $telegram->sendMessage(
                                $parent->telegram_chat_id,
                                "⚠️ *Low Attendance Warning*\n\nYour child *{$student->user->name}* has attendance *{$pct}%*, which is below 75%.",
                                'low_attendance',
                                'parent',
                                $parent->id
                            );
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('[Attendance] Telegram dispatch failed: ' . $e->getMessage());
        }


        // ✅ UX Improvement: Redirect back to the exact same class and date so they can verify it saved!
        return redirect()
            ->route('teacher.attendance.create', [
                'subject_id' => $request->subject_id, 
                'date' => $request->date
            ])
            ->with('success', 'Attendance saved successfully.');
    }
}