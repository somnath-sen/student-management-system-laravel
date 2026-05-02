<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        Log::info("[Telegram] Token generated for user {$user->id} ({$user->name}): {$token}");

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

        Log::info('[Telegram Webhook] Received update', $update);

        // We only handle messages
        $message = $update['message'] ?? null;
        if (! $message) {
            return response()->json(['ok' => true]);
        }

        $text   = trim($message['text'] ?? '');
        $chatId = (string) ($message['chat']['id'] ?? '');
        $from   = $message['from'] ?? [];

        // Must start with /start
        if (! str_starts_with($text, '/start')) {
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
        // Telegram sometimes sends "/start" with no token, or "/start TOKEN"
        $parts = explode(' ', $text, 2);
        $token = isset($parts[1]) ? trim($parts[1]) : null;

        Log::info("[Telegram Webhook] /start received. chatId={$chatId}, token=" . ($token ?? 'NULL'));

        if (empty($token)) {
            $this->telegram->sendMessage(
                $chatId,
                "⚠️ No connect token found. Please go to your *EdFlow dashboard* and click *Connect Telegram* to get a fresh link.",
                'error'
            );
            return response()->json(['ok' => true]);
        }

        // Find the user with this token (exact match)
        $user = User::where('telegram_connect_token', $token)->first();

        if (! $user) {
            Log::warning("[Telegram Webhook] No user found for token: {$token}");

            // Log all current tokens for debugging
            $allTokens = DB::table('users')
                ->whereNotNull('telegram_connect_token')
                ->select('id', 'name', 'telegram_connect_token')
                ->get();
            Log::warning('[Telegram Webhook] Current tokens in DB:', $allTokens->toArray());

            $this->telegram->sendMessage(
                $chatId,
                "❌ This connect link has expired or is invalid.\n\nPlease go to your *EdFlow dashboard* and click *Connect Telegram* again to get a fresh link.",
                'error'
            );
            return response()->json(['ok' => true]);
        }

        // Determine recipient type from role name (avoids hasRole() which doesn't exist)
        $roleName      = $user->role?->name
            ?? DB::table('roles')->where('id', $user->role_id)->value('name')
            ?? 'student';
        $recipientType = in_array($roleName, ['parent']) ? 'parent' : 'student';

        // Save chat_id and clear the token
        $user->update([
            'telegram_chat_id'       => $chatId,
            'telegram_connect_token' => null,
            'telegram_connected_at'  => now(),
        ]);

        Log::info("[Telegram Webhook] User {$user->id} ({$user->name}) connected. chatId={$chatId}, role={$roleName}");

        // Welcome message
        $this->telegram->sendMessage(
            $chatId,
            "✅ *Connected Successfully!*\n\nHello {$user->name}! Your EdFlow account is now linked to Telegram.\n\nYou'll receive notifications for:\n📊 Attendance updates\n🎉 Results published\n📢 Admin notices\n💰 Fee reminders\n🚨 Emergency alerts",
            'connect',
            $recipientType,
            $user->id
        );

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
