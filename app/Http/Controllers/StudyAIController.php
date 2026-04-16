<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Services\AIStudyMentorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StudyAIController extends Controller
{
    private AIStudyMentorService $aiService;

    public function __construct(AIStudyMentorService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->latest()
            ->take(100)
            ->get()
            ->reverse();

        $todayChatsCount = ChatMessage::where('user_id', Auth::id())
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->count();
            
        $chatLimit = 20; // Daily generic limit indicator matching free tier bursts

        $layout = Auth::user()->role_id == 2
            ? 'layouts.teacher'
            : 'layouts.student';

        return view('studyai.index', compact('messages', 'layout', 'todayChatsCount', 'chatLimit'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();

        try {
            // Build Contextual Prompt
            $prompt = $this->aiService->buildPrompt($user, $request->message);

            // Fetch AI Response
            $aiText = $this->aiService->getAIResponse($prompt);

            if (!$aiText) {
                return response()->json(['error' => 'No response generated.'], 500);
            }

            // Save to Database
            $chat = ChatMessage::create([
                'user_id' => $user->id,
                'message' => $request->message,
                'response' => $aiText, 
            ]);

            return response()->json([
                'message' => $chat->message,
                'response' => $chat->response,
            ]);

        } catch (\Exception $e) {
            Log::error('StudyAIController Error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}