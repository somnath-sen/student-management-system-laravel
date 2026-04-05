<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use App\Services\SuggestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function __construct(private SuggestionService $service) {}

    /**
     * Show the AI Suggestions full-page view.
     */
    public function index()
    {
        $user = Auth::user();

        // Load cached result, generate if missing or stale (> 24h)
        $cached = Suggestion::where('user_id', $user->id)->first();

        if (! $cached || ! $cached->generated_at || $cached->generated_at->diffInHours(now()) >= 24) {
            $result = $this->service->generateSuggestions($user->id);
        } else {
            $result = [
                'analysis'      => $cached->analysis_json    ?? [],
                'suggestions'   => $cached->suggestions_json ?? [],
                'overall_level' => $cached->overall_level    ?? 'Average',
            ];
        }

        $analysis      = $result['analysis'];
        $suggestions   = $result['suggestions'];
        $overallLevel  = $result['overall_level'];

        $weakSubjects  = array_filter($analysis, fn($s) => in_array($s['level'], ['Weak', 'Very Weak']));
        $generatedAt   = $cached?->generated_at ?? now();

        return view('student.suggestions.index', compact(
            'analysis',
            'suggestions',
            'overallLevel',
            'weakSubjects',
            'generatedAt'
        ));
    }

    /**
     * AJAX: Force-regenerate suggestions and return fresh JSON.
     */
    public function refresh(Request $request)
    {
        $user   = Auth::user();
        $result = $this->service->generateSuggestions($user->id);

        return response()->json([
            'success'       => true,
            'analysis'      => $result['analysis'],
            'suggestions'   => $result['suggestions'],
            'overall_level' => $result['overall_level'],
            'generated_at'  => now()->format('M d, Y H:i'),
        ]);
    }
}
