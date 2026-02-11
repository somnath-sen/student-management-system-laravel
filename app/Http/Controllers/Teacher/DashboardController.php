<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $subjects = $teacher->subjects;

        return view('teacher.dashboard', compact('teacher', 'subjects'));
    }
}
