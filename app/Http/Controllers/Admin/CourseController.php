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
        $courses = Course::latest()->paginate(15);
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
            'course_code' => 'required|string|max:50|unique:courses,course_code',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Course::create($request->only('course_code', 'name', 'description'));

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
            'course_code' => 'required|string|max:50|unique:courses,course_code,' . $course->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $course->update($request->only('course_code', 'name', 'description'));

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

    // Bulk Delete Courses
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'course_ids' => 'required|array',
            'course_ids.*' => 'exists:courses,id',
        ]);

        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($request->course_ids as $id) {
            $course = Course::find($id);
            if ($course) {
                // Dependency check: Cannot delete if course has enrolled students
                if ($course->students()->exists()) {
                    $skippedCount++;
                } else {
                    $course->delete();
                    $deletedCount++;
                }
            }
        }

        return response()->json([
            'success' => true,
            'deleted' => $deletedCount,
            'skipped' => $skippedCount,
            'message' => $skippedCount > 0 
                ? "{$deletedCount} deleted, {$skippedCount} skipped due to enrolled students." 
                : "{$deletedCount} courses deleted successfully."
        ]);
    }
}
