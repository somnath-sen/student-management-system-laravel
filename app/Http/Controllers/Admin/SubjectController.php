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
        $subjects = Subject::with('course')->latest()->paginate(15);
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show create form
     */
    public function create()
    {
        $courses = Course::orderBy('name')->limit(500)->get();
        return view('admin.subjects.create', compact('courses'));
    }

    /**
     * Store subject
     */
    public function store(Request $request)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code',
            'name'         => 'required|string|max:255',
        ]);

        Subject::create([
            'course_id'    => $request->course_id,
            'subject_code' => $request->subject_code,
            'name'         => $request->name,
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
        $courses = Course::orderBy('name')->limit(500)->get();
        return view('admin.subjects.edit', compact('subject', 'courses'));
    }

    /**
     * Update subject
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'course_id'    => 'required|exists:courses,id',
            'subject_code' => 'required|string|max:50|unique:subjects,subject_code,' . $subject->id,
            'name'         => 'required|string|max:255',
        ]);

        $subject->update([
            'course_id'    => $request->course_id,
            'subject_code' => $request->subject_code,
            'name'         => $request->name,
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
