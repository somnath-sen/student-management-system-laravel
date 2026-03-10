<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) {
            abort(403, 'Student profile not found.');
        }

        // Fetch all attendance records
        $attendances = Attendance::where('student_id', $student->id)
                                 ->with('subject')
                                 ->orderBy('date', 'desc')
                                 ->get();

        // Prepare data specifically for the Heatmap Calendar
        // We need an array where the Key is the Date (Y-m-d) and Value is the Status (1 or 0)
        $calendarData = [];
        foreach ($attendances as $record) {
            // If they have multiple subjects in one day, if ANY are absent, we mark the whole day as an issue (0).
            // Otherwise, it stays present (1).
            $dateString = \Carbon\Carbon::parse($record->date)->format('Y-m-d');
            
            if (!isset($calendarData[$dateString])) {
                $calendarData[$dateString] = $record->present; 
            } elseif ($record->present == 0) {
                $calendarData[$dateString] = 0; // Overwrite to absent if they missed a class that day
            }
        }

        return view('student.attendance.index', compact('attendances', 'calendarData'));
    }
}
