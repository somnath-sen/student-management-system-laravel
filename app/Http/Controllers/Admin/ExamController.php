<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('subjects')->get();
        $selectedCourseId = $request->query('course_id', $courses->first()->id ?? null);

        $selectedCourse = $courses->firstWhere('id', $selectedCourseId);
        $subjects = $selectedCourse ? $selectedCourse->subjects : collect();

        $exams = collect();
        if ($selectedCourseId) {
            $exams = Exam::where('course_id', $selectedCourseId)->orderBy('exam_date')->get();
        }

        return view('admin.exams.index', compact('courses', 'subjects', 'exams', 'selectedCourseId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:255',
            'exam_date' => 'required|date',
            'exam_time' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Exam::create($validated);

        return back()->with('success', 'Exam scheduled successfully.');
    }

    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'subject_name' => 'required|string|max:255',
            'subject_code' => 'nullable|string|max:255',
            'exam_date' => 'required|date',
            'exam_time' => 'required|string|max:255',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $exam->update($validated);

        return back()->with('success', 'Exam updated successfully.');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();
        return back()->with('success', 'Exam deleted successfully.');
    }

    public function toggle(Exam $exam)
    {
        $exam->update(['is_active' => !$exam->is_active]);
        return back()->with('success', 'Exam visibility toggled.');
    }
}
