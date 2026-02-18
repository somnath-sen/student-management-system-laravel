<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display list
     */
    public function index()
    {
        $subjects = Subject::with('course')->latest()->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $courses = Course::all();
        return view('admin.subjects.create', compact('courses'));
    }

    /**
     * Store subject
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:255',
        ]);

        Subject::create([
            'course_id' => $request->course_id,
            'name'      => $request->name,
        ]);

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject created successfully.');
    }

    /**
     * Show edit form
     */
    public function edit(Subject $subject)
    {
        $courses = Course::all();
        return view('admin.subjects.edit', compact('subject', 'courses'));
    }

    /**
     * Update subject
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name'      => 'required|string|max:255',
        ]);

        $subject->update([
            'course_id' => $request->course_id,
            'name'      => $request->name,
        ]);

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject updated successfully.');
    }

    /**
     * Delete subject
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()
            ->route('admin.subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}
