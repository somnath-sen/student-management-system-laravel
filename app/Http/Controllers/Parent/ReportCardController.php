<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Attendance;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    /**
     * Download report card PDF for a specific child.
     * Only available if results are published (is_locked = true).
     */
    public function download(Student $student)
    {
        $parent = Auth::user();

        // Verify this student is actually a child of the logged-in parent
        $isLinked = $parent->children()->where('students.id', $student->id)->exists();

        if (! $isLinked) {
            abort(403, 'You do not have permission to access this student\'s report card.');
        }

        // Check if results are published for this student's course
        $hasPublishedResults = Mark::where('student_id', $student->id)
            ->where('is_locked', true)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->exists();

        if (! $hasPublishedResults) {
            return redirect()->route('parent.dashboard')
                ->with('error', 'Report card for ' . ($student->user->name ?? 'this student') . ' is not available yet. Results have not been published.');
        }

        // Gather PDF data
        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->get();

        $attendances = Attendance::where('student_id', $student->id)->get();
        $totalClasses = $attendances->count();
        $attendedClasses = $attendances->where('present', true)->count();
        $attendancePercentage = $totalClasses > 0 ? round(($attendedClasses / $totalClasses) * 100, 2) : 0;

        $totalMarksObtained = $marks->sum('marks_obtained');
        $totalMaxMarks = $marks->sum('total_marks');
        $overallPercentage = $totalMaxMarks > 0 ? round(($totalMarksObtained / $totalMaxMarks) * 100, 2) : 0;

        // Rank calculation
        $courseStudents = Student::where('course_id', $student->course_id)->get();
        $studentTotals = [];
        foreach ($courseStudents as $cs) {
            $csTotal = Mark::where('student_id', $cs->id)->sum('marks_obtained');
            $studentTotals[$cs->id] = $csTotal;
        }
        arsort($studentTotals);
        $rank = array_search($student->id, array_keys($studentTotals)) + 1;

        $data = compact(
            'student', 'marks', 'totalClasses', 'attendedClasses',
            'attendancePercentage', 'totalMarksObtained', 'totalMaxMarks',
            'overallPercentage', 'rank'
        );

        $pdf = Pdf::loadView('pdf.report-card', $data)->setPaper('A4');
        return $pdf->download('Report_Card_' . $student->roll_number . '.pdf');
    }
}
