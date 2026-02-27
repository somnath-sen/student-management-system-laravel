<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StudyAIController extends Controller
{
    public function index()
    {
        $messages = ChatMessage::where('user_id', Auth::id())
            ->latest()
            ->take(50)
            ->get()
            ->reverse();

        return view('studyai.index', compact('messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $user = Auth::user();
        
        // 1. Get API Key (Using the one you provided as fallback)
        $apiKey = env('GEMINI_API_KEY', 'AIzaSyCf4S2EtiL2ibii-lcepXj7EhsrGfFEpOE');

        try {
            // 2. Call Gemini API (Switched to gemini-pro for better compatibility)
            $response = Http::withoutVerifying() 
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                    [
                        "contents" => [
                            [
                                "parts" => [
                                    [
                                        "text" => "You are a helpful academic assistant for a student named {$user->name}. Keep answers clear and concise. Question: " . $request->message
                                    ]
                                ]
                            ]
                        ]
                    ]
                );

            // 3. Debugging: Log if it fails
            if ($response->failed()) {
                Log::error('Gemini API Error: ' . $response->body());
                return response()->json(['error' => 'API Error: ' . $response->status() . ' - ' . $response->body()], 500);
            }

            $data = $response->json();
            
            // Check if candidates exist
            if (empty($data['candidates'])) {
                return response()->json(['error' => 'No response from AI. Try a different question.'], 500);
            }

            $aiText = $data['candidates'][0]['content']['parts'][0]['text'];

            // 4. Save to Database
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
            Log::error('Controller Error: ' . $e->getMessage());
            return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}