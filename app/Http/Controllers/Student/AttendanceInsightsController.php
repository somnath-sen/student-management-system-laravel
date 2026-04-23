<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Services\AttendancePredictionService;
use Illuminate\Support\Facades\Auth;

class AttendanceInsightsController extends Controller
{
    public function __construct(protected AttendancePredictionService $service) {}

    public function index()
    {
        $user    = Auth::user();
        $student = $user->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        $data = $this->service->evaluate($student->id, $user->name);

        return view('student.attendance.insights', array_merge(['student' => $student], $data));
    }
}
