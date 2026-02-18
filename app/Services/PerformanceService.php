<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Mark;

class PerformanceService
{
    public function calculate($student)
    {
        // Attendance
        $totalClasses = Attendance::where('student_id', $student->id)->count();

        $presentCount = Attendance::where('student_id', $student->id)
            ->where('present', 1)
            ->count();

        $attendancePercentage = $totalClasses > 0
            ? round(($presentCount / $totalClasses) * 100, 2)
            : 0;

        // Marks
        $marks = Mark::where('student_id', $student->id)->get();

        $totalObtained = $marks->sum('marks_obtained');
        $totalMarks = $marks->sum('total_marks');

        $marksPercentage = $totalMarks > 0
            ? round(($totalObtained / $totalMarks) * 100, 2)
            : 0;

        // Final Performance Score (Weighted)
        $performanceScore =
            round(($attendancePercentage * 0.3) +
            ($marksPercentage * 0.7), 2);

        // Category
        if ($performanceScore >= 85) {
            $category = "Excellent";
            $color = "green";
        } elseif ($performanceScore >= 70) {
            $category = "Good";
            $color = "blue";
        } elseif ($performanceScore >= 50) {
            $category = "Average";
            $color = "yellow";
        } else {
            $category = "Needs Improvement";
            $color = "red";
        }

        return [
            'attendancePercentage' => $attendancePercentage,
            'marksPercentage' => $marksPercentage,
            'performanceScore' => $performanceScore,
            'category' => $category,
            'color' => $color,
        ];
    }
}
