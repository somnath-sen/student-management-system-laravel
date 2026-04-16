<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class MarksheetController extends Controller
{
    public function show()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->where('is_locked', true)
            ->get();

        return view('student.marksheet.show', compact('student', 'marks'));
    }

    public function download()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $hasMarks = Mark::where('student_id', $student->id)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->where('is_locked', true)
            ->exists();

        if (! $hasMarks) {
            return redirect()
                ->route('student.marksheet')
                ->with('error', 'Sorry, your result has not been published yet.');
        }

        $marks = Mark::where('student_id', $student->id)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->where('is_locked', true)
            ->with('subject')
            ->get();

        $pdf = Pdf::loadView('student.marksheet.pdf', compact('student', 'marks'))
            ->setPaper('A4');

        return $pdf->download('marksheet.pdf');
    }
}
