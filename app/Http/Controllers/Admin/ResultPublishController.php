<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Subject;
use App\Services\TelegramService;


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

        // ── Telegram Notifications ───────────────────────────────────────────
        try {
            $telegram = app(TelegramService::class);
            $students = Student::with(['user', 'parents'])
                ->where('course_id', $course->id)
                ->get();

            foreach ($students as $student) {
                if ($student->user && $student->user->telegram_chat_id) {
                    $telegram->sendMessage(
                        $student->user->telegram_chat_id,
                        "🎉 *Result Published!*\n\nHello {$student->user->name},\n\nYour exam results for *{$course->name}* have been published.\n\nLog in to EdFlow to check your results and download your marksheet.",
                        'result_published',
                        'student',
                        $student->user->id
                    );
                }
                foreach ($student->parents as $parent) {
                    if ($parent->telegram_chat_id) {
                        $telegram->sendMessage(
                            $parent->telegram_chat_id,
                            "🎉 *Exam Results Published*\n\nDear Parent,\n\nThe exam results for *{$student->user->name}* in *{$course->name}* have been published.\n\nPlease log in to EdFlow to view the results.",
                            'result_published',
                            'parent',
                            $parent->id
                        );
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('[ResultPublish] Telegram dispatch failed: ' . $e->getMessage());
        }

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
