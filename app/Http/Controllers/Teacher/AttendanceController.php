<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function create()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        // Only teacher's subjects
        $subjects = $teacher->subjects;

        return view('teacher.attendance.create', compact('subjects'));
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

        Attendance::updateOrCreate(
            [
                'student_id' => $studentId,
                'subject_id' => $request->subject_id,
                'date'       => $request->date,
            ],
            [
                'teacher_id' => $teacher->id,   // ✅ IMPORTANT FIX
                'present'    => $present,
            ]
        );
    }

    return redirect()
        ->route('teacher.dashboard')
        ->with('success', 'Attendance saved successfully.');
}

}
