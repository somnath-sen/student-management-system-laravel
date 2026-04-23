<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    private function getPdfData($student)
    {
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

        // Calculate total marks and rank
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
        arsort($studentTotals); // sort descending
        $rank = array_search($student->id, array_keys($studentTotals)) + 1;

        return compact('student', 'marks', 'totalClasses', 'attendedClasses', 'attendancePercentage', 'totalMarksObtained', 'totalMaxMarks', 'overallPercentage', 'rank');
    }

    public function download()
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $data = $this->getPdfData($student);

        $pdf = Pdf::loadView('pdf.report-card', $data)->setPaper('A4');
        return $pdf->download('Report_Card_' . $student->roll_number . '.pdf');
    }
}
