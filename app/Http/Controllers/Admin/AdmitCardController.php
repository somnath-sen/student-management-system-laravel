<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class AdmitCardController extends Controller
{
    public function index()
    {
        // Get all courses and count how many students are in each
        $courses = Course::withCount('students')->get();
        return view('admin.admit-card.index', compact('courses'));
    }

    public function togglePublish(Course $course)
    {
        // Flip the boolean (if true make false, if false make true)
        $course->update(['admit_cards_published' => !$course->admit_cards_published]);
        
        $status = $course->admit_cards_published ? 'published' : 'revoked';
        return back()->with('success', "Admit cards successfully {$status} for {$course->name}.");
    }
}