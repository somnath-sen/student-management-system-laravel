<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Timetable;
use Illuminate\Http\Request;

class TimetableController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::all();
        
        // If a course is selected via dropdown, use it. Otherwise, use the first course.
        $selectedCourse = $request->get('course_id') ? Course::find($request->get('course_id')) : $courses->first();
        
        $timetables = collect();
        if ($selectedCourse) {
            $timetables = Timetable::where('course_id', $selectedCourse->id)
                ->orderBy('start_time')
                ->get()
                ->groupBy('day_of_week');
        }

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        return view('admin.timetable.index', compact('courses', 'selectedCourse', 'timetables', 'days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'subject_name' => 'required|string|max:255',
            'teacher_name' => 'nullable|string|max:255',
            'room_number' => 'nullable|string|max:255',
            'color_theme' => 'required|string'
        ]);

        Timetable::create($request->all());

        return back()->with('success', 'Class successfully added to the routine!');
    }

    public function destroy(Timetable $timetable)
    {
        $timetable->delete();
        return back()->with('success', 'Class removed from the routine.');
    }
}