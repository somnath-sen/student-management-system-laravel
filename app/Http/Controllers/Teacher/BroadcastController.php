<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\BroadcastMessage;
use App\Models\Subject;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    /**
     * Show broadcast panel for a specific subject.
     */
    public function index(Subject $subject)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            abort(403, 'Teacher profile not found.');
        }

        // Verify this teacher is actually assigned to this subject
        $owns = $teacher->subjects()->where('subjects.id', $subject->id)->exists();

        if (! $owns) {
            abort(403, 'You are not assigned to this subject.');
        }

        // Fetch all broadcast messages for this subject (latest first)
        $messages = BroadcastMessage::with(['teacher.user'])
            ->where('subject_id', $subject->id)
            ->latest()
            ->get();

        // Total students enrolled in this course (same course as the subject)
        $totalStudents = Student::where('course_id', $subject->course_id)->count();

        return view('teacher.broadcast.index', compact(
            'teacher',
            'subject',
            'messages',
            'totalStudents'
        ));
    }

    /**
     * Send a new broadcast message.
     */
    public function store(Request $request, Subject $subject)
    {
        // Detect AJAX / JSON request (our fetch sends Accept: application/json)
        $isJson = $request->wantsJson() || $request->ajax();

        $teacher = Auth::user()->teacher;

        if (! $teacher) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Teacher profile not found.'], 403);
            abort(403, 'Teacher profile not found.');
        }

        // Verify teacher ownership
        $owns = $teacher->subjects()->where('subjects.id', $subject->id)->exists();

        if (! $owns) {
            if ($isJson) return response()->json(['success' => false, 'error' => 'Unauthorized.'], 403);
            abort(403, 'You are not assigned to this subject.');
        }

        $validated = $request->validate([
            'message'      => 'required|string|min:1|max:2000',
            'is_important' => 'boolean',
        ]);

        $message = BroadcastMessage::create([
            'teacher_id'   => $teacher->id,
            'subject_id'   => $subject->id,
            'message'      => $validated['message'],
            'is_important' => $request->boolean('is_important'),
            'type'         => 'broadcast',
        ]);

        if ($isJson) {
            $message->load(['teacher.user']);
            $studentCount = Student::where('course_id', $subject->course_id)->count();

            return response()->json([
                'success'       => true,
                'message'       => $message,
                'teacher_name'  => $message->teacher->user->name ?? 'Teacher',
                'time'          => $message->created_at->diffForHumans(),
                'student_count' => $studentCount,
            ]);
        }

        return redirect()->route('teacher.broadcast.index', $subject->id)
            ->with('success', 'Message broadcast successfully!');
    }

    /**
     * Delete (recall) a broadcast message.
     */
    public function destroy(BroadcastMessage $message)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher || $message->teacher_id !== $teacher->id) {
            abort(403, 'Unauthorized action.');
        }

        $message->delete();

        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Message recalled successfully.');
    }

    /**
     * API: Return seen count for a specific message (for teacher polling).
     */
    public function seenCount(BroadcastMessage $message)
    {
        $teacher = Auth::user()->teacher;

        if (! $teacher || $message->teacher_id !== $teacher->id) {
            return response()->json(['count' => 0]);
        }

        return response()->json(['count' => $message->seenCount()]);
    }
}
