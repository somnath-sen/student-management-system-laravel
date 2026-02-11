<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DetailsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $student = $user->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $course = $student->course;
        $subjects = $course ? $course->subjects : collect();

        return view('student.details', compact(
            'user',
            'student',
            'course',
            'subjects'
        ));
    }
}
