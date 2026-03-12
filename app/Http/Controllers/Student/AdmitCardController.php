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

        // Mock upcoming exam schedule for the presentation
        $exams = [
            ['date' => '15 May 2026', 'time' => '10:00 AM - 01:00 PM', 'subject' => 'Data Structures & Algorithms', 'code' => 'MCA-401'],
            ['date' => '18 May 2026', 'time' => '10:00 AM - 01:00 PM', 'subject' => 'Advanced Web Technologies', 'code' => 'MCA-402'],
            ['date' => '21 May 2026', 'time' => '10:00 AM - 01:00 PM', 'subject' => 'Artificial Intelligence & ML', 'code' => 'MCA-403'],
            ['date' => '24 May 2026', 'time' => '10:00 AM - 01:00 PM', 'subject' => 'Cloud Computing', 'code' => 'MCA-404'],
            ['date' => '27 May 2026', 'time' => '10:00 AM - 01:00 PM', 'subject' => 'Software Engineering', 'code' => 'MCA-405'],
        ];

        return view('student.admit-card.show', compact('student', 'exams'));
    }
}