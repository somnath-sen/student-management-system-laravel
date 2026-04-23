<?php

namespace App\Services;

use App\Models\Student;
use App\Models\Attendance;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * AttendancePredictionService
 *
 * Analyses a student's attendance history and produces:
 *  - Current stats (total, present, percentage)
 *  - Risk classification: safe / at_risk / critical
 *  - Prediction: will they clear 75% if current rate continues?
 *  - Simulation: classes needed to reach 75%
 *  - Smart, human-readable insights (rule-based + optional Gemini enrichment)
 */
class AttendancePredictionService
{
    private const THRESHOLD = 75; // Minimum required attendance %

    // ─────────────────────────────────────────────────
    //  1. Core Stats
    // ─────────────────────────────────────────────────

    public function calculateAttendance(int $studentId): array
    {
        $records  = Attendance::where('student_id', $studentId)->get();
        $total    = $records->count();
        $present  = $records->where('present', true)->count();
        $absent   = $total - $present;
        $pct      = $total > 0 ? round(($present / $total) * 100, 2) : 0;

        return [
            'total'    => $total,
            'present'  => $present,
            'absent'   => $absent,
            'pct'      => $pct,
        ];
    }

    // ─────────────────────────────────────────────────
    //  2. Risk Classification
    // ─────────────────────────────────────────────────

    public function classifyRisk(float $pct): string
    {
        if ($pct >= self::THRESHOLD) return 'safe';
        if ($pct >= 60)             return 'at_risk';
        return 'critical';
    }

    // ─────────────────────────────────────────────────
    //  3. Subject-wise breakdown
    // ─────────────────────────────────────────────────

    public function subjectBreakdown(int $studentId): array
    {
        $student = Student::find($studentId);
        $subjects = Subject::where('course_id', $student?->course_id)->get();

        $breakdown = [];
        foreach ($subjects as $subject) {
            $total   = Attendance::where('student_id', $studentId)->where('subject_id', $subject->id)->count();
            $present = Attendance::where('student_id', $studentId)->where('subject_id', $subject->id)->where('present', true)->count();
            $pct     = $total > 0 ? round(($present / $total) * 100, 2) : 0;
            $breakdown[] = [
                'subject' => $subject->name,
                'total'   => $total,
                'present' => $present,
                'pct'     => $pct,
                'risk'    => $this->classifyRisk($pct),
            ];
        }

        return $breakdown;
    }

    // ─────────────────────────────────────────────────
    //  4. Prediction: if current rate continues
    // ─────────────────────────────────────────────────

    /**
     * Predict attendance % after N more classes
     * assuming the student continues at the current rate.
     */
    public function predictFutureAttendance(int $studentId, int $futureClasses = 10): array
    {
        $stats = $this->calculateAttendance($studentId);

        if ($stats['total'] === 0) {
            return [
                'current_pct'    => 0,
                'predicted_pct'  => 0,
                'future_classes' => $futureClasses,
                'message'        => 'No attendance data available yet.',
            ];
        }

        $rate           = $stats['pct'] / 100;                                      // current attendance rate
        $futurePresent  = round($futureClasses * $rate);
        $newPresent     = $stats['present'] + $futurePresent;
        $newTotal       = $stats['total']   + $futureClasses;
        $predictedPct   = round(($newPresent / $newTotal) * 100, 2);

        return [
            'current_pct'    => $stats['pct'],
            'predicted_pct'  => $predictedPct,
            'future_classes' => $futureClasses,
            'future_present' => $futurePresent,
        ];
    }

    // ─────────────────────────────────────────────────
    //  5. Simulation: attend next X classes continuously
    // ─────────────────────────────────────────────────

    /**
     * How many more classes must the student attend *continuously*
     * to reach the 75% threshold?
     * Returns -1 if already safe, else the number needed.
     */
    public function simulateImprovement(int $studentId): array
    {
        $stats = $this->calculateAttendance($studentId);

        if ($stats['pct'] >= self::THRESHOLD) {
            return [
                'already_safe'      => true,
                'classes_needed'    => 0,
                'out_of'            => 0,
                'message'           => 'You are already above the required threshold. Keep it up!',
            ];
        }

        // Binary search for minimum consecutive attendance needed
        $total    = $stats['total'];
        $present  = $stats['present'];

        // Try attending next 1..300 classes in a row
        for ($attend = 1; $attend <= 300; $attend++) {
            $newPct = (($present + $attend) / ($total + $attend)) * 100;
            if ($newPct >= self::THRESHOLD) {
                // How many of the next classes we'd need (at 100% for these, then random)
                return [
                    'already_safe'   => false,
                    'classes_needed' => $attend,
                    'out_of'         => $attend,   // consecutive — attend all of them
                    'message'        => "Attend the next {$attend} consecutive class(es) to reach 75%.",
                ];
            }
        }

        // Edge case: not recoverable in 300 classes (very low base)
        return [
            'already_safe'   => false,
            'classes_needed' => 999,
            'out_of'         => 999,
            'message'        => 'Attendance is critically low. Contact your academic advisor immediately.',
        ];
    }

    // ─────────────────────────────────────────────────
    //  6. Rule-based Smart Insights (always available)
    // ─────────────────────────────────────────────────

    public function generateInsights(int $studentId): array
    {
        $stats      = $this->calculateAttendance($studentId);
        $risk       = $this->classifyRisk($stats['pct']);
        $prediction = $this->predictFutureAttendance($studentId, 10);
        $simulation = $this->simulateImprovement($studentId);
        $breakdown  = $this->subjectBreakdown($studentId);

        $insights    = [];
        $suggestions = [];

        // ── Current status ──────────────────────────
        if ($stats['total'] === 0) {
            $insights[]    = '📋 No attendance records found yet.';
            $suggestions[] = 'Attend your first classes to begin tracking.';
            return compact('insights', 'suggestions');
        }

        if ($risk === 'safe') {
            $insights[] = "✅ Your attendance is {$stats['pct']}% — above the required 75% threshold. You are exam-eligible!";
        } elseif ($risk === 'at_risk') {
            $insights[] = "⚠️ Your attendance is {$stats['pct']}% — below the required 75%. You are at risk of losing exam eligibility.";
        } else {
            $insights[] = "🚨 Your attendance is critically low at {$stats['pct']}%. Immediate attention required to avoid disqualification.";
        }

        // ── Trend prediction ────────────────────────
        if ($prediction['predicted_pct'] < self::THRESHOLD && $risk !== 'safe') {
            $insights[] = "📉 If your current pattern continues over the next 10 classes, your attendance will be {$prediction['predicted_pct']}% — still below 75%.";
        } elseif ($prediction['predicted_pct'] >= self::THRESHOLD && $risk !== 'safe') {
            $insights[] = "📈 Good news! If you attend the next 10 classes consistently, your projected attendance will reach {$prediction['predicted_pct']}%.";
        }

        // ── Improvement plan ────────────────────────
        if (!$simulation['already_safe']) {
            if ($simulation['classes_needed'] < 999) {
                $insights[]    = "🎯 You need to attend the next {$simulation['classes_needed']} consecutive class(es) to reach 75%.";
                $suggestions[] = "Attend all {$simulation['classes_needed']} upcoming classes without any absence.";
                $suggestions[] = 'Set a daily reminder to attend classes.';
                $suggestions[] = 'Inform your parents or guardian about your attendance situation.';
            } else {
                $insights[]    = '🚨 Your attendance deficit is very high. Recovery may require special consideration.';
                $suggestions[] = 'Visit the academic office immediately for a condonation or special case review.';
            }
        } else {
            $suggestions[] = 'Keep maintaining your attendance streak. Aim for 85%+ for a comfortable buffer.';
            $suggestions[] = 'Avoid unnecessary absences, especially before exams.';
        }

        // ── Subject-level weak spots ─────────────────
        $weakSubs = array_filter($breakdown, fn($s) => $s['risk'] !== 'safe' && $s['total'] > 0);
        if (!empty($weakSubs)) {
            $names = implode(', ', array_column($weakSubs, 'subject'));
            $insights[]    = "📚 Low attendance in: {$names}.";
            $suggestions[] = "Focus on improving attendance in: {$names}.";
        }

        return compact('insights', 'suggestions');
    }

    // ─────────────────────────────────────────────────
    //  7. Gemini AI — enriched motivational summary
    // ─────────────────────────────────────────────────

    public function generateAIMessage(int $studentId, string $studentName): ?string
    {
        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) return null;

        $stats      = $this->calculateAttendance($studentId);
        $simulation = $this->simulateImprovement($studentId);
        $risk       = $this->classifyRisk($stats['pct']);
        $riskLabel  = ['safe' => 'Safe', 'at_risk' => 'At Risk', 'critical' => 'Critical'][$risk];

        $prompt = <<<PROMPT
You are an encouraging academic mentor inside a Student Management System.
Write a SHORT (3–4 sentences), warm and motivational message directly addressed to the student.
Use the student's real data below. Do NOT use markdown or bullet points — plain flowing text only.

Student: {$studentName}
Current Attendance: {$stats['pct']}%
Status: {$riskLabel}
Consecutive classes needed to reach 75%: {$simulation['classes_needed']}
PROMPT;

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->timeout(15)
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                    [
                        'contents' => [['parts' => [['text' => $prompt]]]],
                        'generationConfig' => ['temperature' => 0.8, 'maxOutputTokens' => 200],
                    ]
                );

            if ($response->successful()) {
                return $response->json('candidates.0.content.parts.0.text');
            }
        } catch (\Exception $e) {
            Log::warning('AttendancePrediction Gemini error: ' . $e->getMessage());
        }

        return null;
    }

    // ─────────────────────────────────────────────────
    //  8. Full evaluation package for a student
    // ─────────────────────────────────────────────────

    public function evaluate(int $studentId, string $studentName = ''): array
    {
        $stats      = $this->calculateAttendance($studentId);
        $risk       = $this->classifyRisk($stats['pct']);
        $prediction = $this->predictFutureAttendance($studentId, 10);
        $simulation = $this->simulateImprovement($studentId);
        $breakdown  = $this->subjectBreakdown($studentId);
        $generated  = $this->generateInsights($studentId);
        $aiMessage  = $this->generateAIMessage($studentId, $studentName);

        return array_merge($stats, [
            'risk'       => $risk,
            'prediction' => $prediction,
            'simulation' => $simulation,
            'breakdown'  => $breakdown,
            'insights'   => $generated['insights'],
            'suggestions'=> $generated['suggestions'],
            'ai_message' => $aiMessage,
        ]);
    }
}
