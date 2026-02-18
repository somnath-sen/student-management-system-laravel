<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Subject;
use App\Services\PerformanceService;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $subjects = $teacher->subjects;

        return view('teacher.performance.index', compact('subjects'));
    }

    public function show(Subject $subject, PerformanceService $performanceService)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher->subjects->contains($subject)) {
            abort(403);
        }

        $students = Student::where('course_id', $subject->course_id)
            ->with('user')
            ->get();

        $analytics = [];

        foreach ($students as $student) {
            $analytics[$student->id] =
                $performanceService->calculate($student);
        }

        return view('teacher.performance.show', compact(
            'subject',
            'students',
            'analytics'
        ));
    }
}
