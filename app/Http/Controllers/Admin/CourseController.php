<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::latest()->get();
        return view('admin.courses.index', compact('courses'));
    }

    // Show create form
    public function create()
    {
        return view('admin.courses.create');
    }

    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create($request->only('name', 'description'));

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course created successfully!');
    }
    // Show edit form
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    // Update course
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($request->only('name', 'description'));

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course updated successfully!');
    }

    // Delete course
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', 'Course deleted successfully!');
    }

}
