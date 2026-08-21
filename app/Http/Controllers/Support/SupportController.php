<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Mail\SupportReplyMail;
use App\Models\Setting;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SupportController extends Controller
{
    /**
     * Store a new support ticket (for authenticated users).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject'  => 'required|string|max:255',
            'question' => 'required|string|max:5000',
        ]);

        $ticket = SupportTicket::create([
            'user_id'  => auth()->id(),
            'subject'  => $validated['subject'],
            'question' => $validated['question'],
            'status'   => 'submitted',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Your doubt has been submitted successfully!',
                'ticket'  => [
                    'id'      => $ticket->id,
                    'subject' => $ticket->subject,
                    'status'  => $ticket->status,
                ],
            ]);
        }

        return back()->with('success', 'Your doubt has been submitted!');
    }

    /**
     * Dedicated support index page for any authenticated user role.
     */
    public function userSupportIndex(Request $request)
    {
        $user = auth()->user();

        $role = $user->role?->name
            ?? \DB::table('roles')->where('id', $user->role_id)->value('name')
            ?? 'student';

        $tickets = SupportTicket::where('user_id', $user->id)
            ->with(['messages.sender'])
            ->orderBy('created_at', 'desc')
            ->get();

        $chatEnabled = Setting::get('support_chat_enabled', false);

        $view = match ($role) {
            'teacher' => 'support.teacher_index',
            'parent'  => 'support.parent_index',
            default   => 'support.student_index',
        };

        return view($view, compact('tickets', 'chatEnabled'));
    }

    /**
     * List the authenticated user's own tickets (JSON or view).
     */
    public function myTickets(Request $request)
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($t) => [
                'id'          => $t->id,
                'subject'     => $t->subject,
                'question'    => $t->question,
                'status'      => $t->status,
                'status_step' => $t->status_step,
                'admin_reply' => $t->admin_reply,
                'replied_at'  => $t->replied_at?->diffForHumans(),
                'created_at'  => $t->created_at->format('d M, Y'),
            ]);

        if ($request->wantsJson()) {
            return response()->json(['tickets' => $tickets]);
        }

        return view('support.my_tickets', compact('tickets'));
    }

    /* ─────────────────────────────────────────────────────────
     |  CHAT MESSAGE METHODS
     ───────────────────────────────────────────────────────── */

    /**
     * Get all messages for a ticket (JSON — used by polling).
     * Accessible to both admin and ticket owner.
     */
    public function getMessages(SupportTicket $ticket)
    {
        $user = auth()->user();
        $role = $user->role?->name
            ?? \DB::table('roles')->where('id', $user->role_id)->value('name')
            ?? 'student';

        // Only admin or ticket owner may read messages
        if ($role !== 'admin' && $ticket->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        $messages = $ticket->messages()->with('sender')->get()->map(fn($m) => [
            'id'          => $m->id,
            'sender_role' => $m->sender_role,
            'sender_name' => $m->sender?->name ?? ($m->sender_role === 'admin' ? 'Admin' : 'User'),
            'body'        => $m->body,
            'time'        => $m->created_at->format('d M Y, h:i A'),
            'time_human'  => $m->created_at->diffForHumans(),
        ]);

        return response()->json([
            'messages'            => $messages,
            'status'              => $ticket->status,
            'chat_enabled'        => $ticket->chat_enabled,
            'chat_enabled_global' => (bool) Setting::get('support_chat_enabled', false),
        ]);
    }

    /**
     * Admin: post a new chat message on a ticket.
     */
    public function adminSendMessage(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        if ($ticket->status === 'solved') {
            return response()->json(['error' => 'This ticket is already resolved.'], 422);
        }

        $message = SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_id'   => auth()->id(),
            'sender_role' => 'admin',
            'body'        => $validated['body'],
        ]);

        // Move ticket to in_progress if still submitted
        if ($ticket->status === 'submitted') {
            $ticket->update(['status' => 'in_progress', 'replied_at' => now()]);
        }

        // Keep admin_reply in sync for backward-compat
        $ticket->update([
            'admin_reply' => $validated['body'],
            'replied_at'  => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'          => $message->id,
                'sender_role' => 'admin',
                'sender_name' => auth()->user()->name ?? 'Admin',
                'body'        => $message->body,
                'time'        => $message->created_at->format('d M Y, h:i A'),
                'time_human'  => 'Just now',
            ],
            'ticket' => [
                'status' => $ticket->fresh()->status,
            ],
        ]);
    }

    /**
     * User (student/teacher/parent): post a reply message on their ticket.
     */
    public function userSendMessage(Request $request, SupportTicket $ticket)
    {
        // Check if admin has enabled support chat globally
        if (!Setting::get('support_chat_enabled', false)) {
            return response()->json(['error' => 'Chat is currently disabled by admin.'], 403);
        }

        $user = auth()->user();

        // Only ticket owner may reply
        if ($ticket->user_id !== $user->id) {
            return response()->json(['error' => 'Forbidden'], 403);
        }

        if ($ticket->status === 'solved') {
            return response()->json(['error' => 'This ticket is already resolved.'], 422);
        }

        $validated = $request->validate([
            'body' => 'required|string|max:5000',
        ]);

        $message = SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_id'   => $user->id,
            'sender_role' => 'user',
            'body'        => $validated['body'],
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id'          => $message->id,
                'sender_role' => 'user',
                'sender_name' => $user->name,
                'body'        => $message->body,
                'time'        => $message->created_at->format('d M Y, h:i A'),
                'time_human'  => 'Just now',
            ],
        ]);
    }

    /* ─────────────────────────────────────────────────────────
     |  ADMIN METHODS
     ───────────────────────────────────────────────────────── */

    /**
     * Admin: list all support tickets.
     */
    public function adminIndex(Request $request)
    {
        $status = $request->get('status', 'all');

        $query = SupportTicket::with(['user', 'messages.sender'])
            ->orderByRaw("FIELD(status, 'in_progress', 'submitted', 'solved')")
            ->orderBy('created_at', 'desc');

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $tickets         = $query->get();
        $openCount       = SupportTicket::whereIn('status', ['submitted', 'in_progress'])->count();
        $solvedCount     = SupportTicket::where('status', 'solved')->count();
        $inProgressCount = SupportTicket::where('status', 'in_progress')->count();
        $submittedCount  = SupportTicket::where('status', 'submitted')->count();
        $chatEnabled     = Setting::get('support_chat_enabled', false);

        return view('admin.support.index', compact(
            'tickets', 'status', 'openCount', 'solvedCount', 'inProgressCount', 'submittedCount', 'chatEnabled'
        ));
    }

    /**
     * Admin: reply to a ticket (legacy endpoint — kept for compat).
     */
    public function adminReply(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'admin_reply' => 'required|string|max:5000',
            'new_status'  => 'required|in:in_progress,solved',
            'send_email'  => 'nullable|boolean',
        ]);

        $ticket->update([
            'admin_reply' => $validated['admin_reply'],
            'status'      => $validated['new_status'],
            'replied_at'  => now(),
        ]);

        if ($request->boolean('send_email') && $ticket->user?->email) {
            try {
                Mail::to($ticket->user->email)->send(new SupportReplyMail($ticket));
            } catch (\Exception $e) {
                \Log::warning('Support reply email failed: ' . $e->getMessage());
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Reply sent successfully!',
                'ticket'  => [
                    'id'          => $ticket->id,
                    'status'      => $ticket->status,
                    'admin_reply' => $ticket->admin_reply,
                    'replied_at'  => $ticket->replied_at?->diffForHumans(),
                ],
            ]);
        }

        return back()->with('success', 'Reply sent to ' . $ticket->user->name . '!');
    }

    /**
     * Admin: Close / resolve a ticket ("Solved & End Chat").
     */
    public function adminClose(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'closing_message' => 'nullable|string|max:5000',
            'send_email'      => 'nullable|boolean',
        ]);

        $closingMsg = $validated['closing_message']
                     ?? $ticket->admin_reply
                     ?? 'Your issue has been resolved. Thank you for contacting support!';

        $ticket->update([
            'status'      => 'solved',
            'admin_reply' => $closingMsg,
            'replied_at'  => now(),
        ]);

        // Add a closing system message in the thread
        SupportMessage::create([
            'ticket_id'   => $ticket->id,
            'sender_id'   => auth()->id(),
            'sender_role' => 'admin',
            'body'        => $closingMsg,
        ]);

        if ($request->boolean('send_email') && $ticket->user?->email) {
            try {
                Mail::to($ticket->user->email)->send(new SupportReplyMail($ticket));
            } catch (\Exception $e) {
                \Log::warning('Support close email failed: ' . $e->getMessage());
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Ticket resolved and closed!',
                'ticket'  => [
                    'id'          => $ticket->id,
                    'status'      => 'solved',
                    'admin_reply' => $ticket->admin_reply,
                    'replied_at'  => $ticket->replied_at?->diffForHumans(),
                ],
            ]);
        }

        return back()->with('success', 'Ticket #' . $ticket->id . ' has been resolved!');
    }

    /**
     * Admin: Get open ticket count (for badge polling).
     */
    public function adminCount()
    {
        return response()->json([
            'count' => SupportTicket::whereIn('status', ['submitted', 'in_progress'])->count(),
        ]);
    }
}
