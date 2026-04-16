<?php

namespace App\Services;

use App\Models\User;
use App\Models\Timetable;
use App\Models\Notice;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Services\SuggestionService;

class AIStudyMentorService
{
    private SuggestionService $suggestionService;

    public function __construct(SuggestionService $suggestionService)
    {
        $this->suggestionService = $suggestionService;
    }

    /**
     * Get aggregated marks and attendance data for a student.
     */
    public function getStudentData(int $userId): array
    {
        $analysis = $this->suggestionService->analyzePerformance($userId);
        
        if (empty($analysis)) {
            return [
                'has_data' => false,
                'summary' => 'No academic data available yet.'
            ];
        }

        $formattedSubjects = [];
        $weakSubjects = [];
        $totalMarksPct = 0;
        $totalAttPct = 0;
        $count = count($analysis);

        foreach ($analysis as $subject) {
            $formattedSubjects[] = "- {$subject['subject_name']}: Marks: {$subject['marks_pct']}%, Attendance: {$subject['att_pct']}%, Status: {$subject['level']}";
            
            if (in_array($subject['level'], ['Weak', 'Very Weak'])) {
                $weakSubjects[] = $subject['subject_name'];
            }

            $totalMarksPct += $subject['marks_pct'];
            $totalAttPct   += $subject['att_pct'];
        }

        return [
            'has_data' => true,
            'summary' => implode("\n", $formattedSubjects),
            'weak_subjects' => empty($weakSubjects) ? 'None' : implode(", ", $weakSubjects),
            'avg_marks' => round($totalMarksPct / $count, 1),
            'avg_attendance' => round($totalAttPct / $count, 1),
        ];
    }

    /**
     * Get the student's weekly routine.
     */
    public function getRoutine(int $userId): string
    {
        $user = User::with('student.course')->find($userId);
        $student = $user?->student;

        if (!$student || !$student->course_id) {
            return "No registered course or routine found.";
        }

        $routine = Timetable::where('course_id', $student->course_id)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        if ($routine->isEmpty()) {
            return "No timetable available.";
        }

        $formatted = [];
        foreach ($routine as $class) {
            $day = $class->day_of_week;
            $time = $class->start_time->format('h:i A') . ' - ' . $class->end_time->format('h:i A');
            $formatted[] = "- {$day}: {$class->subject_name} with {$class->teacher_name} ({$time}, Room {$class->room_number})";
        }

        return implode("\n", $formatted);
    }

    /**
     * Get recent active notices.
     */
    public function getNotices(): string
    {
        $notices = Notice::latest()->take(3)->get();
        
        if ($notices->isEmpty()) {
            return "No recent notices.";
        }

        $formatted = [];
        foreach ($notices as $notice) {
            $date = $notice->created_at->format('M d, Y');
            $formatted[] = "- [{$date}] {$notice->title}: {$notice->content}";
        }

        return implode("\n", $formatted);
    }

    /**
     * Get Teacher data (subjects and schedule).
     */
    public function getTeacherData(User $user): string
    {
        $teacher = $user->teacher;
        if (!$teacher) return "No teacher records found.";

        $subjects = $teacher->subjects()->pluck('name')->toArray();
        $subjectsList = empty($subjects) ? "None" : implode(', ', $subjects);

        $routine = Timetable::with('course')->where('teacher_name', $user->name)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
            
        if ($routine->isEmpty()) {
            $routineText = "No classes scheduled.";
        } else {
            $formatted = [];
            foreach ($routine as $class) {
                $day = $class->day_of_week;
                $time = $class->start_time->format('h:i A') . ' - ' . $class->end_time->format('h:i A');
                $courseName = $class->course ? $class->course->name : 'Unknown Course';
                $formatted[] = "- {$day}: {$class->subject_name} for {$courseName} ({$time}, Room {$class->room_number})";
            }
            $routineText = implode("\n", $formatted);
        }

        return "Subjects taught: {$subjectsList}\n\nWeekly Schedule:\n{$routineText}";
    }

    /**
     * Build the structured prompt injecting all student context.
     */
    public function buildPrompt(User $user, string $question): string
    {
        // Only fetch deep context if the user is a student
        if ($user->role_id == 3) {
            $studentData = $this->getStudentData($user->id);
            $routine     = $this->getRoutine($user->id);
            $notices     = $this->getNotices();

            $context = "Student Data:\n";
            $context .= "- Name: {$user->name}\n";
            
            if ($studentData['has_data']) {
                $context .= "- Overall Avg Attendance: {$studentData['avg_attendance']}%\n";
                $context .= "- Overall Avg Marks: {$studentData['avg_marks']}%\n";
                $context .= "- Weak Subjects to Focus on: {$studentData['weak_subjects']}\n\n";
                $context .= "Detailed Subject Analysis:\n{$studentData['summary']}\n\n";
            } else {
                $context .= "- Academic Records: {$studentData['summary']}\n\n";
            }

            $context .= "Weekly Routine:\n{$routine}\n\n";
            $context .= "Recent Notices:\n{$notices}\n\n";

        } elseif ($user->role_id == 2) {
            $teacherData = $this->getTeacherData($user);
            $notices = $this->getNotices();

            $context = "Teacher Data:\n";
            $context .= "- Name: {$user->name}\n\n";
            $context .= "{$teacherData}\n\n";
            $context .= "Recent Notices:\n{$notices}\n\n";

        } else {
            // Setup generic context for parents
            $roleName = 'Parent';
            $context = "User context: Name: {$user->name}, Role: {$roleName}.\n\n";
        }

        $prompt = <<<PROMPT
You are 'StudyAI', an Advanced Context-Aware Mentor for the EdFlow Student Management System.
You should act as an encouraging, supportive, and intelligent mentor.
Your tone should be professional yet friendly and accessible. Use markdown formatting to make your responses look structured and beautiful. Keep answers very concise unless asked for a detailed explanation. Always prioritize answering the user's question directly.

Context about the user asking the question:
{$context}

User Question:
"{$question}"

Instructions:
Answer the question clearly based on the provided data if it relates to their academics, routine, or notices.
If the query is a general study or subject concept question (e.g., math, science, programming), provide a helpful educational explanation using your vast knowledge base. If their performance is weak in their query context, gently encourage them. Do NOT expose internal row IDs or overly raw technical data to the user.
PROMPT;

        return $prompt;
    }

    /**
     * Get the AI response using Gemini API.
     */
    public function getAIResponse(string $prompt): ?string
    {
        $apiKey = config('services.gemini.api_key');
        if (empty($apiKey)) {
            throw new \Exception('Gemini API key is missing in config.');
        }

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
                            'temperature' => 0.7,
                            'maxOutputTokens' => 1500,
                        ],
                    ]
                );

            if ($response->failed()) {
                $errorData = $response->json();
                $errorMsg = $errorData['error']['message'] ?? 'Unknown API Error';
                Log::error('Gemini API Integration Error: ' . $response->body());
                throw new \Exception("Google AI: " . $errorMsg);
            }

            $data = $response->json();
            
            if (empty($data['candidates'])) {
                throw new \Exception('Empty response from AI.');
            }

            return $data['candidates'][0]['content']['parts'][0]['text'];

        } catch (\Exception $e) {
            Log::error('AIStudyMentorService Exception: ' . $e->getMessage());
            throw $e;
        }
    }
}
