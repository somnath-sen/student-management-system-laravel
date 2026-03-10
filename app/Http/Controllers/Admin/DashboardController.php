<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Subject;
use App\Models\FeePayment;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Academic Quick Stats (Using your dedicated models)
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalCourses  = Course::count();
        $totalSubjects = Subject::count();

        // 2. Financial Quick Stats
        $totalRevenue = FeePayment::where('status', 'completed')->sum('amount_paid');

        // 3. Recent Activity (Latest 5 successful payments)
        $recentPayments = FeePayment::with('student', 'fee')
                                    ->where('status', 'completed')
                                    ->latest()
                                    ->take(5)
                                    ->get();

        // 4. Monthly Revenue Data for Chart.js (Current Year)
        $paymentsThisYear = FeePayment::where('status', 'completed')
                                      ->whereYear('created_at', date('Y'))
                                      ->get();

        // Prepare an array with 12 months set to 0
        $monthlyRevenue = array_fill(1, 12, 0); 
        
        foreach ($paymentsThisYear as $payment) {
            $month = (int)$payment->created_at->format('m');
            $monthlyRevenue[$month] += $payment->amount_paid;
        }
        
        // Extract just the values [Jan, Feb, Mar...] for the chart
        $revenueChartData = array_values($monthlyRevenue);

        return view('admin.dashboard', compact(
            'totalStudents', 
            'totalTeachers', 
            'totalCourses',
            'totalSubjects', 
            'totalRevenue',
            'recentPayments',
            'revenueChartData'
        ));
    }
}