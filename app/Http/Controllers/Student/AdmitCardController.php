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

        // Dynamically build the exam schedule based on the student's actual course subjects
        $subjects = $student->course->subjects;
        $exams = [];
        $startDate = \Carbon\Carbon::parse('15 May 2026');

        foreach ($subjects as $index => $subject) {
            $codePrefix = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $subject->name), 0, 3));
            $exams[] = [
                'date'    => $startDate->copy()->addDays($index * 3)->format('d M Y'),
                'time'    => '10:00 AM - 01:00 PM',
                'subject' => $subject->name,
                'code'    => $subject->subject_code ?? ($codePrefix . '-40' . ($index + 1)),
            ];
        }

        return view('student.admit-card.show', compact('student', 'exams'));
    }
}