<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $attendances = Attendance::with('subject')
            ->where('student_id', $student->id)
            ->orderBy('date', 'desc')
            ->get();

        return view('student.attendance.index', compact('attendances'));
    }
}
