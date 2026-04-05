<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Attendance;
use App\Models\Mark;
use App\Models\Subject;
use App\Models\BroadcastMessage;
use App\Models\MessageRead;

class DashboardController extends Controller
{
    public function index()
    {
        $parent = Auth::user();
        
        // Eager load children with their course
        $children = $parent->children()->with(['course', 'user'])->get();
        
        // Prepare analytics for each child
        $childrenData = $children->map(function($child) {
            
            // 1. Attendance Analytics
            $attendances = Attendance::where('student_id', $child->id)->get();
            $totalClasses = $attendances->count();
            $presentClasses = $attendances->where('present', true)->count();
            
            $attendancePercentage = $totalClasses > 0 ? round(($presentClasses / $totalClasses) * 100) : 0;
            
            $attendanceStatus = 'green';
            if ($attendancePercentage < 60) {
                $attendanceStatus = 'red';
            } elseif ($attendancePercentage < 80) {
                $attendanceStatus = 'yellow';
            }
            if ($totalClasses == 0) {
                $attendanceStatus = 'gray'; // No data
            }

            // 2. Marks Analytics
            // Group marks by subject and get latest or average
            $marks = Mark::where('student_id', $child->id)->with('subject')->get();
            $subjectScores = [];
            foreach ($marks as $mark) {
                if ($mark->subject) {
                    // Store the sum/count to find average percentage per subject
                    if (!isset($subjectScores[$mark->subject_id])) {
                        $subjectScores[$mark->subject_id] = [
                            'name' => $mark->subject->name,
                            'total_marks' => 0,
                            'total_max' => 0,
                        ];
                    }
                    $subjectScores[$mark->subject_id]['total_marks'] += $mark->marks_obtained;
                    $subjectScores[$mark->subject_id]['total_max'] += $mark->max_marks;
                }
            }
            
            $computedScores = [];
            $totalObtained = 0;
            $totalMax = 0;
            foreach ($subjectScores as $score) {
                $percentage = $score['total_max'] > 0 ? round(($score['total_marks'] / $score['total_max']) * 100) : 0;
                $computedScores[] = [
                    'name' => $score['name'],
                    'percentage' => $percentage
                ];
                $totalObtained += $score['total_marks'];
                $totalMax += $score['total_max'];
            }
            
            $overallPerformance = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100) : 0;

            // 3. Emergency & Notifications
            // For broadcast notifications
            // Count unread broadcasts
            $unreadCount = $child->unreadBroadcastCount();

            // Emergency data directly from student model (last_lat, last_lng, location_updated_at)
            $emergencyData = null;
            if ($child->last_lat && $child->last_lng) {
                $emergencyData = [
                    'lat'         => $child->last_lat,
                    'lng'         => $child->last_lng,
                    'map_link'    => "https://www.google.com/maps?q={$child->last_lat},{$child->last_lng}",
                    'updated_at'  => $child->location_updated_at ? $child->location_updated_at->diffForHumans() : 'Unknown Time'
                ];
            }

            // Panic / SOS state
            $panicData = null;
            if ($child->is_panicking) {
                $lat  = $child->panic_lat  ?? $child->last_lat;
                $lng  = $child->panic_lng  ?? $child->last_lng;
                $panicData = [
                    'lat'          => $lat,
                    'lng'          => $lng,
                    'map_link'     => $lat && $lng ? "https://www.google.com/maps?q={$lat},{$lng}" : null,
                    'triggered_at' => $child->panic_triggered_at ? $child->panic_triggered_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') : 'Unknown Time',
                    'time_ago'     => $child->panic_triggered_at ? $child->panic_triggered_at->diffForHumans() : 'just now',
                ];
            }

            return [
                'student'             => $child,
                'attendance_percentage'=> $attendancePercentage,
                'attendance_status'   => $attendanceStatus,
                'subject_scores'      => $computedScores,
                'overall_performance' => $overallPerformance,
                'unread_broadcasts'   => $unreadCount,
                'emergency_data'      => $emergencyData,
                'is_panicking'        => $child->is_panicking,
                'panic_data'          => $panicData,
            ];
        });

        return view('parent.dashboard', compact('childrenData'));
    }
}
