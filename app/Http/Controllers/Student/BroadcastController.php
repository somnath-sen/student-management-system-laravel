<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\BroadcastMessage;
use App\Models\MessageRead;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BroadcastController extends Controller
{
    /**
     * View messages for a subject (read-only student interface).
     */
    public function index(Subject $subject)
    {
        $student = Auth::user()->student;

        if (! $student) {
            abort(403, 'Student profile not found.');
        }

        // Verify the subject belongs to the student's course
        if ($subject->course_id !== $student->course_id) {
            abort(403, 'This subject is not part of your course.');
        }

        // All subjects for the student's current course only (for the subject switcher)
        $courseSubjects = Subject::where('course_id', $student->course_id)->get();

        // Fetch all messages latest first
        $messages = BroadcastMessage::with(['teacher.user'])
            ->where('subject_id', $subject->id)
            ->latest()
            ->get();

        // Mark all as seen in bulk
        foreach ($messages as $msg) {
            MessageRead::updateOrCreate(
                ['message_id' => $msg->id, 'student_id' => $student->id],
                ['seen' => true, 'seen_at' => now()]
            );
        }

        // Attach seen status to each message for the view
        $readMap = MessageRead::where('student_id', $student->id)
            ->whereIn('message_id', $messages->pluck('id'))
            ->pluck('seen', 'message_id');

        return view('student.broadcast.index', compact(
            'student',
            'subject',
            'messages',
            'readMap',
            'courseSubjects'
        ));
    }

    /**
     * AJAX: Mark a single message as seen.
     */
    public function markSeen(BroadcastMessage $message)
    {
        $student = Auth::user()->student;

        if (! $student) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        MessageRead::updateOrCreate(
            ['message_id' => $message->id, 'student_id' => $student->id],
            ['seen' => true, 'seen_at' => now()]
        );

        return response()->json(['success' => true]);
    }

    /**
     * AJAX: Return total unread broadcast message count (for badge polling).
     */
    public function unreadCount()
    {
        $student = Auth::user()->student;

        if (! $student) {
            return response()->json(['count' => 0]);
        }

        $count = $student->unreadBroadcastCount();

        return response()->json(['count' => $count]);
    }
}
