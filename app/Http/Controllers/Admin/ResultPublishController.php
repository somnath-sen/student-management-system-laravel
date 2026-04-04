<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Subject;

class ResultPublishController extends Controller
{
    /**
     * Show all courses that have marks entered
     */
    public function index()
    {
        $courses = Course::whereHas('subjects.marks')->with([
            'subjects' => fn($q) => $q->whereHas('marks'),
            'subjects.marks',
        ])->get();

        return view('admin.results.index', compact('courses'));
    }

    /**
     * Publish all marks for every subject in a course
     */
    public function publish(Course $course)
    {
        $subjectIds = Subject::where('course_id', $course->id)->pluck('id');

        Mark::whereIn('subject_id', $subjectIds)
            ->update(['is_locked' => true]);

        return back()->with('success', "Results for \"{$course->name}\" published successfully.");
    }

    /**
     * Unpublish all marks for every subject in a course
     */
    public function unpublish(Course $course)
    {
        $subjectIds = Subject::where('course_id', $course->id)->pluck('id');

        Mark::whereIn('subject_id', $subjectIds)
            ->update(['is_locked' => false]);

        return back()->with('success', "Results for \"{$course->name}\" unpublished successfully.");
    }
}
