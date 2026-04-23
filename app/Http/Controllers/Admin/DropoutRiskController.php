<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\RiskLog;
use App\Services\DropoutRiskService;
use Illuminate\Http\Request;

class DropoutRiskController extends Controller
{
    public function __construct(protected DropoutRiskService $riskService) {}

    public function index(Request $request)
    {
        // Re-evaluate all students on page load (cached by updateOrCreate within same day)
        // For large datasets you'd schedule this; here we run live for accuracy.
        $students = Student::with(['user', 'course'])->get();

        foreach ($students as $student) {
            $log = RiskLog::where('student_id', $student->id)->first();
            // Only re-evaluate if no log exists or it's older than 30 minutes
            if (! $log || $log->last_evaluated_at?->lt(now()->subMinutes(30))) {
                $this->riskService->evaluate($student->id);
            }
        }

        // Build the query from risk_logs joined with students
        $query = RiskLog::with(['student', 'student.user', 'student.course'])
            ->join('students', 'risk_logs.student_id', '=', 'students.id')
            ->join('users', 'students.user_id', '=', 'users.id')
            ->select('risk_logs.*');

        // Filter by risk level
        if ($request->filled('risk_level')) {
            $query->where('risk_logs.risk_level', $request->risk_level);
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('students.course_id', $request->course_id);
        }

        // Sort
        $sort = $request->get('sort', 'asc'); // asc = worst first (low score = high risk)
        $query->orderBy('risk_logs.risk_score', $sort);

        $riskLogs = $query->paginate(20)->withQueryString();

        // Summary counts
        $highRiskCount = RiskLog::where('risk_level', 'high_risk')->count();
        $atRiskCount   = RiskLog::where('risk_level', 'at_risk')->count();
        $safeCount     = RiskLog::where('risk_level', 'safe')->count();

        $courses = \App\Models\Course::orderBy('name')->get();

        return view('admin.dropout-risk.index', compact(
            'riskLogs', 'highRiskCount', 'atRiskCount', 'safeCount', 'courses'
        ));
    }

    public function show(Student $student)
    {
        // Always fresh eval on detail view
        $log = $this->riskService->evaluate($student->id);
        $student->load(['user', 'course', 'parents']);

        return view('admin.dropout-risk.show', compact('student', 'log'));
    }

    public function reevaluate(Student $student)
    {
        $this->riskService->evaluate($student->id);
        return redirect()->back()->with('success', 'Risk score re-evaluated successfully.');
    }

    public function reevaluateAll()
    {
        $this->riskService->evaluateAll();
        return redirect()->route('admin.dropout-risk.index')->with('success', 'All students re-evaluated successfully.');
    }
}
