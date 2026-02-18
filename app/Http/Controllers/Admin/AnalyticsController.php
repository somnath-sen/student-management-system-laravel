<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Services\PerformanceService;
use Illuminate\Support\Facades\Response;

class AnalyticsController extends Controller
{
    public function index(PerformanceService $performanceService)
    {
        $students = Student::with('course')->get();

        $totalStudents = $students->count();

        $overallScore = 0;
        $atRisk = 0;
        $passCount = 0;

        $coursePerformance = [];

        foreach ($students as $student) {

            $performance = $performanceService->calculate($student);

            $overallScore += $performance['performanceScore'];

            if ($performance['performanceScore'] < 50) {
                $atRisk++;
            }

            if ($performance['performanceScore'] >= 50) {
                $passCount++;
            }

            $courseName = $student->course->name ?? 'Unknown';

            $coursePerformance[$courseName][] =
                $performance['performanceScore'];
        }

        $averageScore = $totalStudents > 0
            ? round($overallScore / $totalStudents, 2)
            : 0;

        $passRate = $totalStudents > 0
            ? round(($passCount / $totalStudents) * 100, 2)
            : 0;

        // Course wise average
        $courseAverages = [];

        foreach ($coursePerformance as $course => $scores) {
            $courseAverages[$course] =
                round(array_sum($scores) / count($scores), 2);
        }

        arsort($courseAverages);

        $topCourse = key($courseAverages);

        return view('admin.analytics.index', compact(
            'averageScore',
            'passRate',
            'atRisk',
            'courseAverages',
            'topCourse'
        ));
    }
    public function export()
    {
        $courses = \App\Models\Course::with('subjects.marks')->get();
        
        // Prepare CSV Data
        $csvData = "Course Name,Subject,Average Score\n";
        
        foreach ($courses as $course) {
            foreach ($course->subjects as $subject) {
                $avg = $subject->marks->avg('marks_obtained') ?? 0;
                $csvData .= "{$course->name},{$subject->name},{$avg}\n";
            }
        }

        // Return Download Response
        return Response::make($csvData, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="analytics_report.csv"',
        ]);
    }
}
