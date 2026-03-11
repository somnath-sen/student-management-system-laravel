<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;

class TimetableController extends Controller
{
    public function index()
    {
        // Get the logged-in teacher's name
        $teacherName = Auth::user()->name;

        // Smart Query: Find all classes where the teacher_name contains this user's name
        // We use 'with("course")' so we can display which course they are teaching!
        $timetables = Timetable::with('course')
            ->where('teacher_name', 'LIKE', '%' . $teacherName . '%')
            ->orderBy('start_time')
            ->get()
            ->groupBy('day_of_week');

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return view('teacher.timetable.index', compact('timetables', 'days', 'teacherName'));
    }
}