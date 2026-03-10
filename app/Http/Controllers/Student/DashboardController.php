<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Subject;
use App\Models\Notice; // ✅ Notice model imported
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Logged-in user
        $user = Auth::user();

        // Student profile
        $student = $user->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        /*
        |--------------------------------------------------------------------------
        | Course & Subjects
        |--------------------------------------------------------------------------
        */

        $course = $student->course;

        // All subjects under student's course
        $subjects = Subject::where('course_id', $course->id)->get();

        /*
        |--------------------------------------------------------------------------
        | Attendance Summary
        |--------------------------------------------------------------------------
        */

        $totalClasses = Attendance::where('student_id', $student->id)->count();

        $presentCount = Attendance::where('student_id', $student->id)
            ->where('present', 1)
            ->count();

        $absentCount = $totalClasses - $presentCount;

        $attendancePercentage = $totalClasses > 0
            ? round(($presentCount / $totalClasses) * 100, 2)
            : 0;

        /*
        |--------------------------------------------------------------------------
        | Subject-wise Attendance
        |--------------------------------------------------------------------------
        */

        $subjectAttendance = Attendance::with('subject')
            ->where('student_id', $student->id)
            ->selectRaw('
                subject_id,
                COUNT(*) as total_classes,
                SUM(present) as present_count
            ')
            ->groupBy('subject_id')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Notice Board Feed (Campus Broadcasts)
        |--------------------------------------------------------------------------
        */
        
        // Fetch the 5 most recent notices to show on the dashboard widget
        $notices = Notice::with('author')->latest()->take(5)->get();

        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view('student.dashboard', compact(
            'student',
            'course',
            'subjects',
            'totalClasses',
            'presentCount',
            'absentCount',
            'attendancePercentage',
            'subjectAttendance',
            'notices' // ✅ Added notices to the view
        ));
    }
    // Add this new method
    public function showNotice(Notice $notice)
    {
        return view('student.notices.show', compact('notice'));
    }
}