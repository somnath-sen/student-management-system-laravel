<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdmitCardController extends Controller
{
    public function show()
    {
        $student = Auth::user()->student->load('course');
        
        // CHECK IF PUBLISHED
        if (!$student->course->admit_cards_published) {
            return view('student.admit-card.pending');
        }

        // Fetch the active exam schedule from the database
        $exams = \App\Models\Exam::where('course_id', $student->course_id)
            ->where('is_active', true)
            ->orderBy('exam_date')
            ->get();

        return view('student.admit-card.show', compact('student', 'exams'));
    }
}