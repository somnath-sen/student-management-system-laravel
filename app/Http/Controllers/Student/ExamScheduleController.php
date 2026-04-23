<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamScheduleController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        
        $exams = Exam::where('course_id', $student->course_id)
            ->where('is_active', true)
            ->orderBy('exam_date')
            ->get();

        $nextExam = $exams->filter(function ($exam) {
            return $exam->exam_date->isFuture() || $exam->exam_date->isToday();
        })->first();

        return view('student.exams.index', compact('exams', 'nextExam'));
    }
}
