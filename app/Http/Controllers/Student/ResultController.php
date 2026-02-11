<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $marks = Mark::with(['subject', 'teacher.user'])
            ->where('student_id', $student->id)
            ->get();

        $totalObtained = $marks->sum('marks_obtained');
        $totalMarks    = $marks->sum('total_marks');

        $percentage = $totalMarks > 0
            ? round(($totalObtained / $totalMarks) * 100, 2)
            : 0;

        return view('student.results.index', compact(
            'marks',
            'totalObtained',
            'totalMarks',
            'percentage'
        ));
    }
}
