<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Student;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NoticeController extends Controller
{
    public function index()
    {
        // Fetch all notices, newest first
        $notices = Notice::with('author')->latest()->get();
        return view('admin.notices.index', compact('notices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'content' => 'required|string',
        ]);

        Notice::create([
            'title'    => $request->title,
            'category' => $request->category,
            'content'  => $request->content,
            'user_id'  => Auth::id(),
        ]);

        // ── Telegram Notifications ───────────────────────────────────────────
        try {
            $telegram = app(TelegramService::class);
            $title    = $request->title;

            // Notify all connected students
            User::where('role_id', 3)->whereNotNull('telegram_chat_id')->each(function ($user) use ($telegram, $title) {
                $telegram->sendMessage(
                    $user->telegram_chat_id,
                    "📢 *New Academic Notice*\n\n*{$title}*\n\nA new notice has been posted by the administration. Log in to EdFlow to read the full details.",
                    'notice',
                    'student',
                    $user->id
                );
            });

            // Notify all connected parents
            User::where('role_id', 4)->whereNotNull('telegram_chat_id')->each(function ($user) use ($telegram, $title) {
                $telegram->sendMessage(
                    $user->telegram_chat_id,
                    "📢 *Institution Notice*\n\n*{$title}*\n\nA new notice has been posted by the administration regarding your child. Log in to EdFlow for details.",
                    'notice',
                    'parent',
                    $user->id
                );
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::warning('[Notice] Telegram dispatch failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Notice broadcasted successfully!');

    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return back()->with('success', 'Notice removed from the board.');
    }
}