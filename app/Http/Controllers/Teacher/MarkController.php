<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MarkController extends Controller
{
    /**
     * List teacher subjects (Marks dashboard)
     */
    public function index()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $subjects = $teacher->subjects;

        return view('teacher.marks.index', compact('subjects'));
    }

    /**
     * Show create marks form (first time entry)
     */
    public function create()
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        $subjects = $teacher->subjects;

        return view('teacher.marks.create', compact('subjects'));
    }

    /**
     * Store marks (first entry or overwrite-safe)
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'marks'      => 'required|array',
        ]);

        $teacher = Auth::user()->teacher;

        // Subject must belong to teacher
        $subject = $teacher->subjects()
            ->where('subjects.id', $request->subject_id)
            ->firstOrFail();

        // Prevent editing if locked
        $locked = Mark::where('subject_id', $subject->id)
            ->where('teacher_id', $teacher->id)
            ->where('is_locked', true)
            ->exists();

        if ($locked) {
            abort(403, 'Result is locked and cannot be modified.');
        }

        $students = Student::where('course_id', $subject->course_id)->get();

        foreach ($students as $student) {
            if (! isset($request->marks[$student->id])) {
                continue;
            }

            Mark::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                ],
                [
                    'teacher_id'     => $teacher->id,
                    'marks_obtained' => $request->marks[$student->id],
                    'total_marks'    => 100,
                    'is_locked'      => false,
                ]
            );
        }

        return redirect()
            ->route('teacher.marks.index')
            ->with('success', 'Marks saved successfully.');
    }

    /**
     * Edit existing marks
     */
    public function edit(Subject $subject)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher->subjects->contains($subject)) {
            abort(403, 'Unauthorized access.');
        }

        $students = Student::where('course_id', $subject->course_id)
            ->with('user')
            ->get();

        $marks = Mark::where('subject_id', $subject->id)
            ->where('teacher_id', $teacher->id)
            ->get()
            ->keyBy('student_id');

        $isLocked = $marks->isNotEmpty() && $marks->first()->is_locked;

        return view('teacher.marks.edit', compact(
            'subject',
            'students',
            'marks',
            'isLocked'
        ));
    }

    /**
     * Update marks (only if not locked)
     */
    public function update(Request $request, Subject $subject)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher->subjects->contains($subject)) {
            abort(403, 'Unauthorized access.');
        }

        $locked = Mark::where('subject_id', $subject->id)
            ->where('teacher_id', $teacher->id)
            ->where('is_locked', true)
            ->exists();

        if ($locked) {
            abort(403, 'Result is locked and cannot be updated.');
        }

        $request->validate([
            'marks' => 'required|array',
        ]);

        foreach ($request->marks as $studentId => $value) {
            Mark::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'subject_id' => $subject->id,
                ],
                [
                    'teacher_id'     => $teacher->id,
                    'marks_obtained' => $value,
                    'total_marks'    => 100,
                ]
            );
        }

        return redirect()
            ->route('teacher.marks.index')
            ->with('success', 'Marks updated successfully.');
    }

    /**
     * 🔒 Lock result (no more edits allowed)
     */
    public function lock(Subject $subject)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher->subjects->contains($subject)) {
            abort(403, 'Unauthorized access.');
        }

        Mark::where('subject_id', $subject->id)
            ->where('teacher_id', $teacher->id)
            ->update(['is_locked' => true]);

        return redirect()
            ->route('teacher.marks.index')
            ->with('success', 'Result locked successfully.');
    }
}
