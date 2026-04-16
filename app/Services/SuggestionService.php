<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Mark;
use App\Models\Student;
use App\Models\Suggestion;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SuggestionService
{
    // Thresholds
    private const WEAK_MARKS       = 50;
    private const VERY_WEAK_MARKS  = 40;
    private const LOW_ATTENDANCE   = 75;
    private const POOR_ATTENDANCE  = 60;

    // ──────────────────────────────────────────────────────────────────────────
    // PUBLIC API
    // ──────────────────────────────────────────────────────────────────────────

    /**
     * Analyse a student's per-subject marks + attendance and return structured data.
     */
    public function analyzePerformance(int $userId): array
    {
        $user    = User::find($userId);
        $student = $user?->student;

        if (! $student) {
            return [];
        }

        // -- Marks (one row per subject) --
        $marks = Mark::with('subject')
            ->where('student_id', $student->id)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->get()
            ->keyBy('subject_id');

        // -- Attendance grouped by subject --
        $attendanceRows = Attendance::where('student_id', $student->id)
            ->whereHas('subject', function ($q) use ($student) {
                $q->where('course_id', $student->course_id);
            })
            ->selectRaw('subject_id, COUNT(*) as total, SUM(present) as present')
            ->groupBy('subject_id')
            ->get()
            ->keyBy('subject_id');

        // Build union of all subject IDs touched in either table
        $subjectIds = $marks->keys()->merge($attendanceRows->keys())->unique();

        $analysis = [];

        foreach ($subjectIds as $subjectId) {
            $mark       = $marks->get($subjectId);
            $attendance = $attendanceRows->get($subjectId);

            $subjectName = $mark?->subject?->name
                ?? $attendance?->subject?->name
                ?? "Subject #{$subjectId}";

            // Marks percentage
            $marksPct = 0;
            if ($mark && $mark->total_marks > 0) {
                $marksPct = round(($mark->marks_obtained / $mark->total_marks) * 100, 1);
            }

            // Attendance percentage
            $attPct = 0;
            if ($attendance && $attendance->total > 0) {
                $attPct = round(($attendance->present / $attendance->total) * 100, 1);
            }

            // Determine level
            $level = $this->classifyLevel($marksPct, $attPct);

            $analysis[] = [
                'subject_id'   => $subjectId,
                'subject_name' => $subjectName,
                'marks_pct'    => $marksPct,
                'marks_obtained' => $mark?->marks_obtained ?? null,
                'total_marks'  => $mark?->total_marks ?? null,
                'att_pct'      => $attPct,
                'att_present'  => $attendance?->present ?? null,
                'att_total'    => $attendance?->total ?? null,
                'level'        => $level,
            ];
        }

        // Sort: weakest first
        usort($analysis, fn($a, $b) => $this->levelWeight($a['level']) <=> $this->levelWeight($b['level']));

        return $analysis;
    }

    /**
     * Return only Weak + Very Weak subjects.
     */
    public function getWeakSubjects(int $userId): array
    {
        return array_filter(
            $this->analyzePerformance($userId),
            fn($s) => in_array($s['level'], ['Weak', 'Very Weak'])
        );
    }

    /**
     * Generate (and cache) AI-powered suggestions for the student.
     * Falls back to rule-based tips if Gemini is unavailable.
     */
    public function generateSuggestions(int $userId): array
    {
        $analysis     = $this->analyzePerformance($userId);
        $overallLevel = $this->computeOverallLevel($analysis);
        $suggestions  = $this->callGemini($userId, $analysis) ?? $this->ruleBased($analysis);

        // Cache in DB (upsert so only one row per user)
        Suggestion::updateOrCreate(
            ['user_id' => $userId],
            [
                'analysis_json'    => $analysis,
                'suggestions_json' => $suggestions,
                'overall_level'    => $overallLevel,
                'generated_at'     => now(),
            ]
        );

        return [
            'analysis'      => $analysis,
            'suggestions'   => $suggestions,
            'overall_level' => $overallLevel,
        ];
    }

    // ──────────────────────────────────────────────────────────────────────────
    // PRIVATE HELPERS
    // ──────────────────────────────────────────────────────────────────────────

    private function classifyLevel(float $marksPct, float $attPct): string
    {
        if ($marksPct < self::VERY_WEAK_MARKS) {
            return 'Very Weak';
        }
        if ($marksPct < self::WEAK_MARKS || $attPct < self::POOR_ATTENDANCE) {
            return 'Weak';
        }
        if ($marksPct < 75 || $attPct < self::LOW_ATTENDANCE) {
            return 'Average';
        }
        return 'Strong';
    }

    private function levelWeight(string $level): int
    {
        return match ($level) {
            'Very Weak' => 0,
            'Weak'      => 1,
            'Average'   => 2,
            'Strong'    => 3,
            default     => 2,
        };
    }

    private function computeOverallLevel(array $analysis): string
    {
        if (empty($analysis)) {
            return 'Average';
        }
        $avgMarks = array_sum(array_column($analysis, 'marks_pct')) / count($analysis);
        $avgAtt   = array_sum(array_column($analysis, 'att_pct')) / count($analysis);
        return $this->classifyLevel($avgMarks, $avgAtt);
    }

    /**
     * Call Gemini API and parse suggestions from response.
     */
    private function callGemini(int $userId, array $analysis): ?array
    {
        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey) || empty($analysis)) {
            return null;
        }

        $user = User::find($userId);

        // Build a structured prompt
        $subjectLines = array_map(function ($s) {
            return "- {$s['subject_name']}: Marks={$s['marks_pct']}%, Attendance={$s['att_pct']}%, Level={$s['level']}";
        }, $analysis);

        $prompt = <<<PROMPT
You are an expert academic mentor AI for a student management system called EdFlow.

Student: {$user->name}

Academic Performance Report:
{$this->joinLines($subjectLines)}

Based on this data, generate a JSON array of exactly 6 personalized, actionable study suggestions.
Each suggestion must be a JSON object with these fields:
- "type": one of "study", "attendance", "warning", "tip", "schedule", "motivation"
- "title": a short bold title (max 6 words)
- "message": a specific, helpful recommendation (2-3 sentences, mention subject names where relevant)
- "priority": "high", "medium", or "low"

Return ONLY valid JSON array, no markdown, no explanation. Example format:
[{"type":"study","title":"Focus on weak subjects","message":"...","priority":"high"}]
PROMPT;

        try {
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->timeout(20)
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                    [
                        'contents' => [[
                            'parts' => [['text' => $prompt]],
                        ]],
                        'generationConfig' => [
                            'temperature'     => 0.7,
                            'maxOutputTokens' => 1000,
                        ],
                    ]
                );

            if ($response->failed()) {
                Log::error('SuggestionService Gemini error: ' . $response->body());
                return null;
            }

            $data = $response->json();
            $raw  = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Strip markdown code fences if present
            $raw = preg_replace('/^```(?:json)?\s*/i', '', trim($raw));
            $raw = preg_replace('/\s*```$/', '', $raw);

            $parsed = json_decode($raw, true);

            if (! is_array($parsed)) {
                Log::warning('SuggestionService: Gemini response was not valid JSON.');
                return null;
            }

            return $parsed;
        } catch (\Exception $e) {
            Log::error('SuggestionService exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Rule-based fallback suggestions when Gemini is unavailable.
     */
    private function ruleBased(array $analysis): array
    {
        $suggestions = [];

        foreach ($analysis as $subject) {
            $name = $subject['subject_name'];

            if ($subject['level'] === 'Very Weak') {
                $suggestions[] = [
                    'type'     => 'warning',
                    'title'    => "Urgent: {$name}",
                    'message'  => "Your performance in {$name} is critically low at {$subject['marks_pct']}%. You risk failing this subject. Focus intensively and seek teacher help immediately.",
                    'priority' => 'high',
                ];
            } elseif ($subject['level'] === 'Weak') {
                $suggestions[] = [
                    'type'     => 'study',
                    'title'    => "Improve in {$name}",
                    'message'  => "You scored {$subject['marks_pct']}% in {$name}. Dedicate at least 2 hours daily to this subject and practice past exam questions to improve.",
                    'priority' => 'high',
                ];
            }

            if ($subject['att_pct'] < self::LOW_ATTENDANCE && $subject['att_pct'] > 0) {
                $suggestions[] = [
                    'type'     => 'attendance',
                    'title'    => "Attendance Alert: {$name}",
                    'message'  => "Your attendance in {$name} is {$subject['att_pct']}%, which is below the 75% requirement. Missing more classes may affect your eligibility for exams.",
                    'priority' => 'high',
                ];
            }
        }

        // Add generic tips if few suggestions
        if (count($suggestions) < 3) {
            $suggestions[] = [
                'type'     => 'schedule',
                'title'    => 'Build a Study Schedule',
                'message'  => 'Create a daily timetable allocating specific hours for each subject. Consistency over intensity leads to the best results.',
                'priority' => 'medium',
            ];
            $suggestions[] = [
                'type'     => 'tip',
                'title'    => 'Use Active Recall',
                'message'  => 'Instead of re-reading notes, test yourself on the material. Use flashcards or practice tests to strengthen memory retention.',
                'priority' => 'medium',
            ];
            $suggestions[] = [
                'type'     => 'motivation',
                'title'    => 'Stay Consistent',
                'message'  => 'Progress is built day by day. Even 45 minutes of focused study each day compounds into major improvements by exam time.',
                'priority' => 'low',
            ];
        }

        return array_slice($suggestions, 0, 6);
    }

    private function joinLines(array $lines): string
    {
        return implode("\n", $lines);
    }
}
