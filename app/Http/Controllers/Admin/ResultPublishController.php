<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mark;
use App\Models\Subject;

class ResultPublishController extends Controller
{
    /**
     * Show locked subjects for publishing
     */
    public function index()
    {
        $subjects = Subject::whereHas('marks', function ($q) {
            $q->where('is_locked', true);
        })->with(['course'])->get();

        return view('admin.results.index', compact('subjects'));
    }

    /**
     * Publish result
     */
    public function publish(Subject $subject)
    {
        Mark::where('subject_id', $subject->id)
            ->where('is_locked', true)
            ->update(['is_published' => true]);

        return back()->with('success', 'Result published successfully.');
    }

    /**
     * Unpublish result
     */
    public function unpublish(Subject $subject)
    {
        Mark::where('subject_id', $subject->id)
            ->update(['is_published' => false]);

        return back()->with('success', 'Result unpublished successfully.');
    }
}
