<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Mark;
use App\Models\Attendance;
use App\Models\RiskLog;
use Carbon\Carbon;

/**
 * DropoutRiskService
 *
 * Computes a weighted risk score (0–100) for each student:
 *   Attendance  40%
 *   Marks       40%
 *   Engagement  20%
 *
 * Risk Categories:
 *   >= 75  → safe
 *   50-74  → at_risk
 *   < 50   → high_risk
 */
class DropoutRiskService
{
    // ---------- Individual Scorers ----------

    /**
     * Score 0–100 based on attendance %.
     * 100% attendance = 100 score.  0% = 0 score.
     */
    public function calculateAttendanceScore(int $studentId): float
    {
        $total   = Attendance::where('student_id', $studentId)->count();
        $present = Attendance::where('student_id', $studentId)->where('present', true)->count();

        if ($total === 0) {
            // No records yet — treat as neutral (50)
            return 50.0;
        }

        return round(($present / $total) * 100, 2);
    }

    /**
     * Score 0–100 based on average marks percentage across all subjects.
     * No marks yet → neutral 50.
     */
    public function calculateMarksScore(int $studentId): float
    {
        $marks = Mark::where('student_id', $studentId)->get();

        if ($marks->isEmpty()) {
            return 50.0;
        }

        $totalObtained = $marks->sum('marks_obtained');
        $totalMax      = $marks->sum('total_marks');

        if ($totalMax == 0) {
            return 50.0;
        }

        return round(($totalObtained / $totalMax) * 100, 2);
    }

    /**
     * Score 0–100 based on last login activity.
     * Active today = 100.  >30 days = 0.  Linear decay in between.
     * Falls back to GamificationStat.last_login_date if last_login_at null.
     */
    public function calculateEngagementScore(int $studentId): float
    {
        $student = Student::with(['user', 'user.gamificationStat'])->find($studentId);

        if (! $student) {
            return 0.0;
        }

        // Prefer users.last_login_at; fallback to gamification_stats.last_login_date
        $lastLogin = $student->user->last_login_at
            ?? ($student->user->gamificationStat->last_login_date ?? null);

        if (! $lastLogin) {
            return 0.0;
        }

        $daysInactive = Carbon::parse($lastLogin)->diffInDays(now(), true);

        if ($daysInactive <= 0) return 100.0;
        if ($daysInactive >= 30) return 0.0;

        return round((1 - $daysInactive / 30) * 100, 2);
    }

    // ---------- Composite Scorer ----------

    /**
     * Compute final weighted risk score (higher = safer).
     */
    public function computeRiskScore(int $studentId): array
    {
        $attendanceScore  = $this->calculateAttendanceScore($studentId);
        $marksScore       = $this->calculateMarksScore($studentId);
        $engagementScore  = $this->calculateEngagementScore($studentId);

        $riskScore = ($attendanceScore * 0.40)
                   + ($marksScore      * 0.40)
                   + ($engagementScore * 0.20);

        return [
            'attendance_score'  => $attendanceScore,
            'marks_score'       => $marksScore,
            'engagement_score'  => $engagementScore,
            'risk_score'        => round($riskScore, 2),
        ];
    }

    // ---------- Classifier ----------

    public function classifyRisk(float $score): string
    {
        if ($score >= 75) return 'safe';
        if ($score >= 50) return 'at_risk';
        return 'high_risk';
    }

    // ---------- Insight Generator ----------

    public function generateInsights(int $studentId): array
    {
        $insights    = [];
        $suggestions = [];

        $attendancePct  = $this->calculateAttendanceScore($studentId);
        $marksPct       = $this->calculateMarksScore($studentId);
        $engagementScore = $this->calculateEngagementScore($studentId);

        // --- Attendance insights ---
        if ($attendancePct < 50) {
            $insights[]    = "⚠️ Critically low attendance ({$attendancePct}%). Immediate intervention required.";
            $suggestions[] = "Contact student immediately regarding attendance.";
        } elseif ($attendancePct < 75) {
            $insights[]    = "📉 Attendance is below the required threshold ({$attendancePct}%).";
            $suggestions[] = "Schedule a counseling session to discuss attendance issues.";
        } else {
            $insights[]    = "✅ Attendance is satisfactory ({$attendancePct}%).";
        }

        // --- Marks insights ---
        $failedSubjects = Mark::with('subject')
            ->where('student_id', $studentId)
            ->get()
            ->filter(fn($m) => $m->total_marks > 0 && ($m->marks_obtained / $m->total_marks) * 100 < 40);

        if ($failedSubjects->count() > 0) {
            $names = $failedSubjects->map(fn($m) => $m->subject->name)->join(', ');
            $insights[]    = "❌ Failing in {$failedSubjects->count()} subject(s): {$names}.";
            $suggestions[] = "Arrange remedial classes for the failing subjects.";
        }

        if ($marksPct < 50) {
            $insights[]    = "📊 Overall academic performance is critically low ({$marksPct}% average).";
            $suggestions[] = "Assign a mentor/tutor to improve academic performance.";
        } elseif ($marksPct < 70) {
            $insights[]    = "📝 Marks are below average ({$marksPct}% overall).";
            $suggestions[] = "Encourage student to seek help from teachers.";
        } else {
            $insights[]    = "✅ Academic performance is on track ({$marksPct}% average).";
        }

        // --- Engagement insights ---
        $student   = Student::with(['user', 'user.gamificationStat'])->find($studentId);
        $lastLogin = $student?->user?->last_login_at
                  ?? ($student?->user?->gamificationStat?->last_login_date ?? null);

        if (! $lastLogin) {
            $insights[]    = "🔴 No login activity has been recorded for this student.";
            $suggestions[] = "Verify the student's account credentials and encourage them to log in.";
        } else {
            $daysInactive = Carbon::parse($lastLogin)->diffInDays(now(), true);
            if ($daysInactive >= 14) {
                $insights[]    = "🔴 Student has been inactive for {$daysInactive} day(s). Last login: " . Carbon::parse($lastLogin)->format('d M Y') . ".";
                $suggestions[] = "Send a re-engagement email or SMS to the student and parents.";
            } elseif ($daysInactive >= 7) {
                $insights[]    = "🟡 Student has not logged in for {$daysInactive} day(s).";
                $suggestions[] = "Encourage daily login and class participation.";
            } else {
                $insights[]    = "✅ Student logged in recently (" . Carbon::parse($lastLogin)->diffForHumans() . ").";
            }
        }

        if (empty($suggestions)) {
            $suggestions[] = "Continue monitoring. Student appears stable.";
        }

        return compact('insights', 'suggestions');
    }

    // ---------- Persist & Retrieve ----------

    /**
     * Run full evaluation for one student and persist to risk_logs.
     */
    public function evaluate(int $studentId): RiskLog
    {
        $scores   = $this->computeRiskScore($studentId);
        $level    = $this->classifyRisk($scores['risk_score']);
        $generated = $this->generateInsights($studentId);

        return RiskLog::updateOrCreate(
            ['student_id' => $studentId],
            [
                'risk_score'        => $scores['risk_score'],
                'risk_level'        => $level,
                'attendance_score'  => $scores['attendance_score'],
                'marks_score'       => $scores['marks_score'],
                'engagement_score'  => $scores['engagement_score'],
                'insights'          => $generated['insights'],
                'suggestions'       => $generated['suggestions'],
                'last_evaluated_at' => now(),
            ]
        );
    }

    /**
     * Evaluate all students in bulk.
     */
    public function evaluateAll(): void
    {
        Student::all()->each(fn($s) => $this->evaluate($s->id));
    }
}
