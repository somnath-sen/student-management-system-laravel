<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Services\AttendancePredictionService;
use Illuminate\Http\Request;

class AttendanceRiskController extends Controller
{
    public function __construct(protected AttendancePredictionService $service) {}

    public function index(Request $request)
    {
        $students = Student::with(['user', 'course'])->get();

        // Build enriched list with risk data
        $evaluated = $students->map(function ($student) {
            $stats = $this->service->calculateAttendance($student->id);
            $risk  = $this->service->classifyRisk($stats['pct']);
            return [
                'student'    => $student,
                'pct'        => $stats['pct'],
                'total'      => $stats['total'],
                'present'    => $stats['present'],
                'absent'     => $stats['absent'],
                'risk'       => $risk,
            ];
        });

        // Filter
        if ($request->filled('risk')) {
            $evaluated = $evaluated->filter(fn($r) => $r['risk'] === $request->risk);
        }

        // Sort by pct ascending (worst first)
        $evaluated = $evaluated->sortBy('pct')->values();

        $highCount     = $evaluated->filter(fn($r) => $r['risk'] === 'critical')->count();
        $atRiskCount   = $evaluated->filter(fn($r) => $r['risk'] === 'at_risk')->count();
        $safeCount     = $evaluated->filter(fn($r) => $r['risk'] === 'safe')->count();

        $courses = \App\Models\Course::orderBy('name')->get();

        return view('admin.attendance-risk.index', compact(
            'evaluated', 'highCount', 'atRiskCount', 'safeCount', 'courses'
        ));
    }

    public function show(Student $student)
    {
        $data = $this->service->evaluate($student->id, $student->user->name);
        $student->load(['user', 'course']);
        return view('admin.attendance-risk.show', array_merge(['student' => $student], $data));
    }
}
