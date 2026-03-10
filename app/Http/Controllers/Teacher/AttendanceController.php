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
            
            // Note: If your students are linked to specific courses/subjects, 
            // you can filter them here like: Student::where('course_id', $selectedSubject->course_id)->with('user')->get();
            // For now, we load all students, but safely deferred until after a subject is chosen.
            $students = Student::with('user')->get(); 

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
            Attendance::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $request->subject_id,
                    'date'       => $request->date,
                ],
                [
                    'teacher_id' => $teacher->id,   // ✅ Securely logs WHO took the attendance
                    'present'    => $present,
                ]
            );
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