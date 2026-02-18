<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\PerformanceService;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    public function index(PerformanceService $performanceService)
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $performance = $performanceService->calculate($student);

        return view('student.performance.index', compact(
            'student',
            'performance'
        ));
    }
}
