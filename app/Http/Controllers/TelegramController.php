<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TelegramController extends Controller
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Generate a connect token and redirect user to Telegram bot.
     * Works for both student and parent users.
     */
    public function generateToken(Request $request)
    {
        $user = Auth::user();

        // Generate a unique short-lived token
        $token = Str::random(32);

        $user->update([
            'telegram_connect_token' => $token,
        ]);

        $botUsername = config('services.telegram.username', 'YourBotUsername');
        $botUrl      = "https://t.me/{$botUsername}?start={$token}";

        return redirect()->away($botUrl);
    }

    /**
     * Public webhook — receives all updates from Telegram.
     * Telegram sends a POST here when any user messages the bot.
     */
    public function webhook(Request $request)
    {
        $update = $request->all();

        // We only handle messages containing /start <token>
        $message = $update['message'] ?? null;
        if (! $message) {
            return response()->json(['ok' => true]);
        }

        $text   = $message['text'] ?? '';
        $chatId = (string) ($message['chat']['id'] ?? '');
        $from   = $message['from'] ?? [];

        // Must start with /start
        if (! str_starts_with($text, '/start')) {
            // Optionally send a welcome message
            if (! empty($chatId)) {
                $this->telegram->sendMessage(
                    $chatId,
                    "👋 Hello! Please connect your account from the *EdFlow dashboard* to receive notifications.",
                    'welcome'
                );
            }
            return response()->json(['ok' => true]);
        }

        // Extract token from: /start <token>
        $parts = explode(' ', $text, 2);
        $token = $parts[1] ?? null;

        if (empty($token)) {
            $this->telegram->sendMessage(
                $chatId,
                "⚠️ Invalid connect link. Please generate a new one from your EdFlow dashboard.",
                'error'
            );
            return response()->json(['ok' => true]);
        }

        // Find the user with this token
        $user = User::where('telegram_connect_token', $token)->first();

        if (! $user) {
            $this->telegram->sendMessage(
                $chatId,
                "❌ This connect link has expired or is invalid. Please generate a new one from your dashboard.",
                'error'
            );
            return response()->json(['ok' => true]);
        }

        // Save chat_id and clear the token
        $user->update([
            'telegram_chat_id'       => $chatId,
            'telegram_connect_token' => null,
            'telegram_connected_at'  => now(),
        ]);

        // Welcome message
        $this->telegram->sendMessage(
            $chatId,
            "✅ *Connected Successfully!*\n\nHello {$user->name}! Your EdFlow account is now linked to Telegram.\n\nYou'll receive notifications for:\n📊 Attendance updates\n🎉 Results published\n📢 Admin notices\n💰 Fee reminders\n🚨 Emergency alerts",
            'connect',
            $user->hasRole('parent') ? 'parent' : 'student',
            $user->id
        );

        Log::info("[TelegramController] User {$user->id} ({$user->name}) connected Telegram. Chat ID: {$chatId}");

        return response()->json(['ok' => true]);
    }

    /**
     * Disconnect Telegram from user's account.
     */
    public function disconnect(Request $request)
    {
        $user = Auth::user();

        $user->update([
            'telegram_chat_id'      => null,
            'telegram_connected_at' => null,
        ]);

        return back()->with('success', 'Telegram disconnected successfully.');
    }
}
