<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Mark;
use App\Models\Attendance;
use App\Mail\ReportCardMail;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportCardController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'course'])->get();
        return view('admin.report-cards.index', compact('students'));
    }

    public function show($id)
    {
        $student = Student::with(['user', 'course', 'parents'])->findOrFail($id);
        
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

        return view('admin.report-cards.show', compact('student', 'marks', 'totalClasses', 'attendedClasses', 'attendancePercentage'));
    }

    public function updateRemark(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        $request->validate([
            'report_card_remark' => 'nullable|string|max:1000',
        ]);

        $student->update([
            'report_card_remark' => $request->report_card_remark,
        ]);

        return redirect()->route('admin.report-cards.show', $id)->with('success', 'Remark updated successfully.');
    }

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

    public function generatePDF($id)
    {
        $student = Student::with(['user', 'course'])->findOrFail($id);
        $data = $this->getPdfData($student);

        $pdf = Pdf::loadView('pdf.report-card', $data)->setPaper('A4');
        return $pdf->download('Report_Card_' . $student->roll_number . '.pdf');
    }

    public function sendToParent($id)
    {
        $student = Student::with(['user', 'course', 'parents'])->findOrFail($id);
        
        if ($student->parents->isEmpty()) {
            return redirect()->back()->with('error', 'No parent linked to this student.');
        }

        $data = $this->getPdfData($student);
        $pdf = Pdf::loadView('pdf.report-card', $data)->setPaper('A4');
        $pdfContent = $pdf->output();

        foreach ($student->parents as $parent) {
            Mail::to($parent->email)->send(new ReportCardMail($student, $pdfContent));
        }

        return redirect()->route('admin.report-cards.show', $id)->with('success', 'Report card sent to parent(s) successfully.');
    }
}
