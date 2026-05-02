<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Setting;
use App\Models\Student;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;

class TelegramNotificationController extends Controller
{
    protected TelegramService $telegram;

    public function __construct(TelegramService $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Main Telegram admin panel
     */
    public function index()
    {
        $totalStudents        = User::where('role_id', 3)->count(); // student role
        $connectedStudents    = User::where('role_id', 3)->whereNotNull('telegram_chat_id')->count();
        $totalParents         = User::where('role_id', 4)->count(); // parent role
        $connectedParents     = User::where('role_id', 4)->whereNotNull('telegram_chat_id')->count();

        $sentToday    = NotificationLog::where('status', 'sent')
            ->whereDate('sent_at', today())
            ->count();
        $failedToday  = NotificationLog::where('status', 'failed')
            ->whereDate('created_at', today())
            ->count();
        $totalSent    = NotificationLog::where('status', 'sent')->count();

        $recentLogs = NotificationLog::with('recipient')
            ->latest()
            ->take(50)
            ->get();

        $telegramEnabled = Setting::get('telegram_enabled', true);

        return view('admin.telegram.index', compact(
            'totalStudents',
            'connectedStudents',
            'totalParents',
            'connectedParents',
            'sentToday',
            'failedToday',
            'totalSent',
            'recentLogs',
            'telegramEnabled'
        ));
    }

    /**
     * Toggle Telegram notifications on/off
     */
    public function toggle(Request $request)
    {
        $value = $request->boolean('enabled');
        Setting::set('telegram_enabled', $value);

        return response()->json([
            'success' => true,
            'enabled' => $value,
            'message' => 'Telegram notifications ' . ($value ? 'enabled' : 'disabled') . '.',
        ]);
    }

    /**
     * Broadcast a custom message to all connected users
     */
    public function broadcast(Request $request)
    {
        $request->validate([
            'message'    => 'required|string|max:4096',
            'target'     => 'required|in:students,parents,all',
        ]);

        $message = $request->input('message');
        $target  = $request->input('target');

        $recipients = [];

        if (in_array($target, ['students', 'all'])) {
            User::where('role_id', 3)
                ->whereNotNull('telegram_chat_id')
                ->each(function ($user) use (&$recipients) {
                    $recipients[] = [
                        'chat_id' => $user->telegram_chat_id,
                        'type'    => 'student',
                        'user_id' => $user->id,
                    ];
                });
        }

        if (in_array($target, ['parents', 'all'])) {
            User::where('role_id', 4)
                ->whereNotNull('telegram_chat_id')
                ->each(function ($user) use (&$recipients) {
                    $recipients[] = [
                        'chat_id' => $user->telegram_chat_id,
                        'type'    => 'parent',
                        'user_id' => $user->id,
                    ];
                });
        }

        $results = $this->telegram->sendBulk($recipients, "📢 *Admin Broadcast*\n\n{$message}", 'broadcast');

        return back()->with('success',
            "Broadcast complete! Sent: {$results['sent']}, Failed: {$results['failed']}, Skipped: {$results['skipped']}."
        );
    }

    /**
     * Send a test message to a specific chat_id
     */
    public function sendTest(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|string',
            'message' => 'nullable|string|max:4096',
        ]);

        $chatId  = $request->input('chat_id');
        $message = $request->input('message', '✅ *Test Notification*\n\nThis is a test message from your EdFlow admin panel. Telegram notifications are working correctly!');

        $success = $this->telegram->sendMessage($chatId, $message, 'test', 'admin');

        if ($success) {
            return back()->with('success', "✅ Test message sent successfully to chat ID: {$chatId}");
        }

        return back()->with('error', "❌ Failed to send test message to chat ID: {$chatId}. Check logs for details.");
    }

    /**
     * Paginated notification logs
     */
    public function logs(Request $request)
    {
        $logs = NotificationLog::with('recipient')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->event_type, fn($q) => $q->where('event_type', $request->event_type))
            ->latest()
            ->paginate(25);

        return view('admin.telegram.logs', compact('logs'));
    }
}
