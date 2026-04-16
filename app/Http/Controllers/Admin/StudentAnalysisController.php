<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use Carbon\Carbon;

class StudentAnalysisController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::orderBy('name')->get();

        // Summary Cards
        $totalStudents = Student::count();
        $activeStudents = Student::where('status', 'active')->count();
        $droppedStudents = Student::where('status', 'dropped')->count();
        $completedStudents = Student::where('status', 'completed')->count();

        // Course-wise Analysis
        $courseStats = Student::selectRaw('course_id, 
                count(*) as total,
                sum(case when status = "active" then 1 else 0 end) as active,
                sum(case when status = "dropped" then 1 else 0 end) as dropped,
                sum(case when status = "completed" then 1 else 0 end) as completed
            ')
            ->groupBy('course_id')
            ->with('course')
            ->get();

        // Base query with relationships
        $query = Student::with(['user', 'course', 'parents']);

        // Filters
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('risk_level') && $request->risk_level === 'inactive_30_days') {
            $thirtyDaysAgo = Carbon::now()->subDays(30);
            $query->where(function($q) use ($thirtyDaysAgo) {
                $q->whereHas('user.gamificationStat', function($q2) use ($thirtyDaysAgo) {
                    $q2->whereNotNull('last_login_date')
                       ->where('last_login_date', '<', $thirtyDaysAgo);
                })->orWhereDoesntHave('user.gamificationStat');
            })->where('status', 'active');
        }

        // Get paginated results
        $students = $query->paginate(20)->withQueryString();

        return view('admin.student-analysis.index', compact(
            'courses', 
            'totalStudents', 
            'activeStudents', 
            'droppedStudents', 
            'completedStudents', 
            'courseStats',
            'students'
        ));
    }

    public function updateStatus(Request $request, Student $student)
    {
        $request->validate([
            'status' => 'required|in:active,dropped,completed'
        ]);

        $student->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Student status updated successfully.');
    }
}
