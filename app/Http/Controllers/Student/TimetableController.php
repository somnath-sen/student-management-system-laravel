<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        // Fetch all classes for the student's course, ordered by time
        $timetables = Timetable::where('course_id', $student->course_id)
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        // We explicitly define the days to maintain the Monday-Friday column order
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return view('student.timetable.index', compact('timetables', 'days'));
    }
}