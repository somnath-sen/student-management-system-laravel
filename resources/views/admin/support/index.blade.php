@extends('layouts.admin')
@section('title', 'Support Center')

@section('content')
    <style>
        /* ═══════════════════════════════════════════════════════════
           ADMIN SUPPORT CENTER — Full Chat UI
        ═══════════════════════════════════════════════════════════ */

        .adm-sp-wrap { max-width: 1100px; margin: 0 auto; padding: 0 2px 48px; }

        /* ── Header ── */
        .adm-sp-hdr { display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:12px; }
        .adm-sp-hdr-title { font-size:1.45rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.035em; }
        .adm-sp-hdr-sub { font-size:0.78rem;color:var(--text-secondary);margin-top:3px; }

        /* ── Stats Grid ── */
        .adm-sp-stats { display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px; }
        @media(max-width:700px){ .adm-sp-stats { grid-template-columns:repeat(2,1fr); } }
        .adm-stat {
            background:var(--surface);backdrop-filter:blur(20px);
            border:1px solid var(--border);border-radius:18px;padding:20px 22px;
            transition:all 0.2s;cursor:default;
        }
        .adm-stat:hover { transform:translateY(-2px);box-shadow:var(--shadow-lg); }
        .adm-stat-icon { width:38px;height:38px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1rem;margin-bottom:12px;flex-shrink:0; }
        .adm-stat-num { font-size:2rem;font-weight:800;letter-spacing:-0.04em;line-height:1; }
        .adm-stat-lbl { font-size:0.68rem;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:var(--text-muted);margin-top:5px; }

        /* ── Filter Chips ── */
        .adm-filter-bar { display:flex;gap:8px;margin-bottom:22px;flex-wrap:wrap; }
        .adm-chip {
            padding:7px 18px;border-radius:100px;font-size:0.78rem;font-weight:600;
            border:1.5px solid var(--border);cursor:pointer;transition:all 0.18s;
            text-decoration:none;color:var(--text-secondary);background:var(--surface);
            display:inline-flex;align-items:center;gap:6px;
        }
        .adm-chip:hover { border-color:var(--accent);color:var(--accent); }
        .adm-chip.active { background:var(--accent);color:#fff;border-color:var(--accent); }
        .adm-chip-dot { width:7px;height:7px;border-radius:50%;flex-shrink:0; }

        /* ── Ticket Card ── */
        .adm-ticket {
            background:var(--surface);backdrop-filter:blur(20px);
            border:1px solid var(--border);border-radius:22px;overflow:hidden;
            margin-bottom:16px;transition:all 0.22s cubic-bezier(0.25,0.46,0.45,0.94);
        }
        .adm-ticket:hover { transform:translateY(-2px);box-shadow:var(--shadow-lg); }
        .adm-ticket.status-in_progress { border-left:4px solid #FF9F0A; }
        .adm-ticket.status-submitted   { border-left:4px solid #007AFF; }
        .adm-ticket.status-solved      { border-left:4px solid #30D158;opacity:0.85; }
        .adm-ticket.status-solved:hover{ opacity:1; }

        /* ── Ticket Header (click to expand) ── */
        .adm-ticket-hdr {
            padding:18px 22px 16px;display:flex;align-items:flex-start;gap:14px;
            cursor:pointer;
        }
        .adm-avatar {
            width:42px;height:42px;border-radius:13px;
            background:linear-gradient(135deg,var(--accent),var(--accent-2));
            display:flex;align-items:center;justify-content:center;
            color:#fff;font-weight:800;font-size:1rem;flex-shrink:0;
            box-shadow:0 3px 10px var(--accent-glow);
        }
        .adm-ticket-info { flex:1;min-width:0; }
        .adm-ticket-name { font-size:0.88rem;font-weight:800;color:var(--text-primary); }
        .adm-ticket-email { font-size:0.68rem;color:var(--text-muted); }
        .adm-role-badge {
            font-size:0.55rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;
            padding:2px 8px;border-radius:100px;margin-left:6px;
        }
        .role-student   { background:rgba(0,122,255,0.12);color:#007AFF; }
        .role-teacher   { background:rgba(48,209,88,0.12);color:#30D158; }
        .role-parent    { background:rgba(88,86,214,0.12);color:#5856D6; }
        .adm-ticket-subject { font-size:0.92rem;font-weight:700;color:var(--text-primary);margin-top:8px; }

        /* Status Pill */
        .adm-status-pill {
            font-size:0.62rem;font-weight:700;padding:5px 13px;border-radius:100px;
            text-transform:uppercase;letter-spacing:0.06em;display:inline-flex;align-items:center;gap:5px;
            flex-shrink:0;align-self:flex-start;
        }
        .pill-submitted  { background:rgba(0,122,255,0.1);color:#007AFF; }
        .pill-in_progress{ background:rgba(255,159,10,0.12);color:#FF9F0A; }
        .pill-solved     { background:rgba(52,199,89,0.1);color:#30D158; }

        /* Pulse dot */
        .adm-pulse { display:inline-block;width:6px;height:6px;border-radius:50%; }
        .adm-pulse.submitted  { background:#007AFF;animation:adm-pulse-a 2s infinite; }
        .adm-pulse.in_progress{ background:#FF9F0A;animation:adm-pulse-a 1.4s infinite; }
        .adm-pulse.solved     { background:#30D158; }
        @keyframes adm-pulse-a { 0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.5;transform:scale(0.75);} }

        /* ── Chat Panel ── */
        .adm-chat-panel {
            border-top:1px solid var(--divider);
            display:none;
        }
        .adm-chat-panel.open { display:flex;flex-direction:column; }

        /* ── Chat Log ── */
        .adm-chat-log {
            padding:20px 22px 12px;
            display:flex;flex-direction:column;gap:14px;
            background:linear-gradient(180deg,var(--bg) 0%,var(--surface) 100%);
            max-height:480px;overflow-y:auto;scroll-behavior:smooth;
        }
        .adm-chat-log::-webkit-scrollbar { width:4px; }
        .adm-chat-log::-webkit-scrollbar-track { background:transparent; }
        .adm-chat-log::-webkit-scrollbar-thumb { background:var(--border);border-radius:100px; }

        /* ── Original Question Bubble ── */
        .chat-question-wrap { display:flex;align-items:flex-end;gap:10px;justify-content:flex-end; }
        .chat-question-bubble {
            background:linear-gradient(135deg,#007AFF,#5AC8FA);
            color:#fff;border-radius:18px 18px 4px 18px;padding:14px 18px;
            max-width:72%;font-size:0.85rem;line-height:1.65;
            box-shadow:0 4px 16px rgba(0,122,255,0.25);
        }
        .chat-q-label { font-size:0.62rem;font-weight:700;opacity:0.78;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em; }
        .chat-q-time  { font-size:0.62rem;color:rgba(255,255,255,0.65);margin-top:6px;text-align:right; }

        /* ── User reply bubble (same person, but replying after admin) ── */
        .chat-user-wrap  { display:flex;align-items:flex-end;gap:10px;justify-content:flex-end; }
        .chat-user-bubble {
            background:linear-gradient(135deg,#34C759,#30D158);
            color:#fff;border-radius:18px 18px 4px 18px;padding:14px 18px;
            max-width:72%;font-size:0.85rem;line-height:1.65;
            box-shadow:0 4px 14px rgba(52,199,89,0.3);
        }
        .chat-user-label { font-size:0.62rem;font-weight:700;opacity:0.85;margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em; }
        .chat-user-time  { font-size:0.62rem;color:rgba(255,255,255,0.65);margin-top:6px;text-align:right; }

        /* ── Admin reply bubble ── */
        .chat-admin-wrap { display:flex;align-items:flex-end;gap:10px; }
        .chat-admin-avatar {
            width:32px;height:32px;border-radius:50%;
            background:linear-gradient(135deg,var(--accent),var(--accent-2));
            display:flex;align-items:center;justify-content:center;
            color:#fff;font-weight:800;font-size:0.7rem;flex-shrink:0;
            box-shadow:0 2px 8px var(--accent-glow);
        }
        .chat-admin-bubble {
            background:var(--bg-2);border:1.5px solid var(--border);
            border-radius:18px 18px 18px 4px;padding:14px 18px;
            max-width:72%;font-size:0.85rem;line-height:1.65;color:var(--text-primary);
            box-shadow:0 4px 14px rgba(0,0,0,0.06);
        }
        .chat-admin-label { font-size:0.62rem;font-weight:700;color:var(--accent);margin-bottom:5px;text-transform:uppercase;letter-spacing:0.05em; }
        .chat-admin-time  { font-size:0.62rem;color:var(--text-muted);margin-top:6px; }

        /* ── Chat Input Box ── */
        .adm-chat-input-bar {
            padding:16px 22px 20px;border-top:1px solid var(--divider);
            background:var(--surface);
        }
        .adm-chat-input-label {
            font-size:0.72rem;font-weight:600;color:var(--text-secondary);margin-bottom:8px;
            display:flex;align-items:center;gap:6px;
        }
        .adm-chat-input-row { display:flex;gap:10px;align-items:flex-end; }
        .adm-chat-textarea {
            flex:1;border:1.5px solid var(--border);border-radius:14px;
            padding:13px 16px;font-size:0.85rem;font-family:inherit;
            background:var(--bg);color:var(--text-primary);
            resize:none;min-height:68px;max-height:160px;
            transition:border-color 0.18s;outline:none;
            line-height:1.6;
        }
        .adm-chat-textarea:focus { border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-soft); }
        .adm-chat-send-btn {
            padding:13px 22px;border-radius:14px;font-size:0.82rem;font-weight:700;
            border:none;cursor:pointer;transition:all 0.2s;
            background:var(--accent);color:#fff;
            display:inline-flex;align-items:center;gap:7px;flex-shrink:0;
            box-shadow:0 4px 14px var(--accent-glow);
        }
        .adm-chat-send-btn:hover { opacity:0.9;transform:translateY(-1px); }
        .adm-chat-send-btn:disabled { opacity:0.55;cursor:not-allowed;transform:none; }

        /* Quick action row below textarea */
        .adm-action-row {
            display:flex;gap:8px;margin-top:12px;align-items:center;flex-wrap:wrap;
        }
        .adm-btn {
            padding:9px 20px;border-radius:12px;font-size:0.8rem;font-weight:700;
            border:none;cursor:pointer;transition:all 0.2s;
            display:inline-flex;align-items:center;gap:7px;
        }
        .adm-btn-solved {
            background:linear-gradient(135deg,rgba(52,199,89,0.15),rgba(48,209,88,0.12));
            color:#30D158;border:1px solid rgba(52,199,89,0.25);
        }
        .adm-btn-solved:hover { background:linear-gradient(135deg,#30D158,#34C759);color:#fff;border-color:transparent;box-shadow:0 4px 14px rgba(52,199,89,0.4); }
        .adm-email-toggle { display:flex;align-items:center;gap:7px;font-size:0.75rem;color:var(--text-secondary);cursor:pointer;margin-left:auto; }
        .adm-email-toggle input { width:15px;height:15px;cursor:pointer;accent-color:var(--accent); }

        /* ── Ticket footer meta ── */
        .adm-ticket-footer { display:flex;align-items:center;gap:10px;padding:10px 22px;flex-wrap:wrap;border-top:1px solid var(--divider); }
        .adm-ticket-meta-time { font-size:0.65rem;color:var(--text-muted); }
        .adm-ticket-id { font-size:0.65rem;color:var(--text-muted); }
        .adm-expand-hint { margin-left:auto;font-size:0.72rem;color:var(--accent);font-weight:600;display:flex;align-items:center;gap:4px; }
        .adm-expand-chevron { transition:transform 0.25s ease;display:inline-block;font-size:0.6rem; }
        .adm-expand-chevron.rotated { transform:rotate(180deg); }

        /* ── Solved closed card ── */
        .adm-solved-badge {
            display:flex;align-items:center;gap:8px;padding:12px 22px;
            background:linear-gradient(135deg,rgba(52,199,89,0.07),rgba(48,209,88,0.03));
            border-top:1px solid rgba(52,199,89,0.12);
            font-size:0.78rem;font-weight:600;color:#30D158;
        }

        /* ── Chat divider ── */
        .chat-divider {
            display:flex;align-items:center;gap:10px;margin:4px 0;
        }
        .chat-divider-line { flex:1;height:1px;background:var(--divider); }
        .chat-divider-text { font-size:0.6rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.07em;white-space:nowrap; }

        /* ── Empty state ── */
        .adm-empty { text-align:center;padding:72px 20px; }
        .adm-empty-icon {
            width:72px;height:72px;border-radius:22px;
            background:var(--border-2);display:flex;align-items:center;justify-content:center;
            margin:0 auto 18px;font-size:1.8rem;color:var(--text-muted);
        }

        /* ── Solved & End Chat modal ── */
        .adm-solve-overlay {
            position:fixed;inset:0;z-index:10000;
            background:rgba(0,0,0,0.45);backdrop-filter:blur(10px);
            display:flex;align-items:center;justify-content:center;padding:20px;
            opacity:0;pointer-events:none;transition:opacity 0.28s ease;
        }
        .adm-solve-overlay.show { opacity:1;pointer-events:all; }
        .adm-solve-modal {
            background:var(--bg-2);border-radius:24px;width:100%;max-width:480px;
            padding:32px;box-shadow:0 32px 80px rgba(0,0,0,0.25);
            transform:translateY(30px) scale(0.96);
            transition:all 0.32s cubic-bezier(0.25,0.46,0.45,0.94);
            opacity:0;
        }
        .adm-solve-overlay.show .adm-solve-modal { transform:translateY(0) scale(1);opacity:1; }
        .adm-reply-textarea {
            width:100%;border:1.5px solid var(--border);border-radius:14px;
            padding:13px 16px;font-size:0.85rem;font-family:inherit;
            background:var(--bg);color:var(--text-primary);
            resize:vertical;min-height:100px;max-height:220px;
            transition:border-color 0.18s;outline:none;
        }
        .adm-reply-textarea:focus { border-color:var(--accent);box-shadow:0 0 0 3px var(--accent-soft); }

        @keyframes slideInToast {
            from { opacity:0;transform:translateY(20px); }
            to   { opacity:1;transform:translateY(0); }
        }
        @keyframes msgSlideIn {
            from { opacity:0;transform:translateY(10px); }
            to   { opacity:1;transform:translateY(0); }
        }
        .chat-bubble-new { animation:msgSlideIn 0.28s ease; }

        /* Live dot */
        .chat-live-dot { width:8px;height:8px;border-radius:50%;background:#30D158;display:inline-block;animation:adm-pulse-a 1.5s infinite;margin-right:4px; }
    </style>

    <div class="adm-sp-wrap">

        {{-- ── Header ── --}}
        <div class="adm-sp-hdr">
            <div>
                <div class="adm-sp-hdr-title">
                    <i class="fa-solid fa-headset" style="color:var(--accent);margin-right:10px;"></i>Support Center
                </div>
                <div class="adm-sp-hdr-sub" id="chatStatusSubtitle">
                    Review, reply and resolve user doubts &amp; queries —
                    <span id="chatStatusText" style="font-weight:700;{{ $chatEnabled ? 'color:#30D158;' : 'color:#FF9F0A;' }}">
                        {{ $chatEnabled ? 'User chat is ON' : 'User chat is OFF' }}
                    </span>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                @if($openCount > 0)
                    <span style="background:rgba(255,59,48,0.1);color:#FF3B30;font-size:0.75rem;font-weight:700;padding:7px 16px;border-radius:100px;display:flex;align-items:center;gap:6px;">
                        <span style="width:7px;height:7px;border-radius:50%;background:#FF3B30;display:inline-block;animation:adm-pulse-a 1.4s infinite;"></span>
                        {{ $openCount }} Open {{ Str::plural('Ticket', $openCount) }}
                    </span>
                @endif

                {{-- ── Chat Toggle Button ── --}}
                <button
                    id="chatToggleBtn"
                    onclick="toggleChatAccess()"
                    data-enabled="{{ $chatEnabled ? '1' : '0' }}"
                    style="
                        display:inline-flex;align-items:center;gap:8px;
                        padding:8px 18px;border-radius:100px;font-size:0.78rem;font-weight:700;
                        border:none;cursor:pointer;transition:all 0.22s ease;
                        {{ $chatEnabled
                            ? 'background:rgba(52,199,89,0.12);color:#30D158;box-shadow:0 0 0 1.5px rgba(52,199,89,0.3);'
                            : 'background:rgba(255,159,10,0.12);color:#FF9F0A;box-shadow:0 0 0 1.5px rgba(255,159,10,0.3);'
                        }}
                    "
                    title="{{ $chatEnabled ? 'Click to disable user chat' : 'Click to enable user chat' }}"
                >
                    <span id="chatToggleIcon" style="width:32px;height:18px;border-radius:100px;display:inline-flex;align-items:center;padding:2px 3px;transition:all 0.22s;{{ $chatEnabled ? 'background:#30D158;justify-content:flex-end;' : 'background:rgba(60,60,67,0.2);justify-content:flex-start;' }}">
                        <span style="width:14px;height:14px;border-radius:50%;background:#fff;display:inline-block;box-shadow:0 1px 4px rgba(0,0,0,0.2);"></span>
                    </span>
                    <span id="chatToggleLabel">{{ $chatEnabled ? 'Chat ON' : 'Chat OFF' }}</span>
                    <i class="fa-solid fa-spinner fa-spin" id="chatToggleSpinner" style="display:none;font-size:0.7rem;"></i>
                </button>

            </div>
        </div>

        {{-- ── Stats ── --}}
        <div class="adm-sp-stats">
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:rgba(60,60,67,0.08);color:var(--text-secondary);">
                    <i class="fa-solid fa-ticket"></i>
                </div>
                <div class="adm-stat-num" style="color:var(--text-primary);">{{ $tickets->count() }}</div>
                <div class="adm-stat-lbl">Total Tickets</div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:rgba(0,122,255,0.1);color:#007AFF;">
                    <i class="fa-solid fa-circle-dot"></i>
                </div>
                <div class="adm-stat-num" style="color:#007AFF;">{{ $submittedCount }}</div>
                <div class="adm-stat-lbl">Submitted</div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:rgba(255,159,10,0.12);color:#FF9F0A;">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
                <div class="adm-stat-num" style="color:#FF9F0A;">{{ $inProgressCount }}</div>
                <div class="adm-stat-lbl">In Progress</div>
            </div>
            <div class="adm-stat">
                <div class="adm-stat-icon" style="background:rgba(52,199,89,0.1);color:#30D158;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="adm-stat-num" style="color:#30D158;">{{ $solvedCount }}</div>
                <div class="adm-stat-lbl">Resolved</div>
            </div>
        </div>

        {{-- ── Filter Bar ── --}}
        <div class="adm-filter-bar">
            <a href="{{ route('admin.support.index') }}" class="adm-chip {{ $status === 'all' ? 'active' : '' }}">
                <i class="fa-solid fa-list" style="font-size:0.7rem;"></i> All
            </a>
            <a href="{{ route('admin.support.index', ['status' => 'submitted']) }}" class="adm-chip {{ $status === 'submitted' ? 'active' : '' }}">
                <span class="adm-chip-dot" style="background:#007AFF;animation:adm-pulse-a 2s infinite;"></span> Submitted
            </a>
            <a href="{{ route('admin.support.index', ['status' => 'in_progress']) }}" class="adm-chip {{ $status === 'in_progress' ? 'active' : '' }}">
                <span class="adm-chip-dot" style="background:#FF9F0A;animation:adm-pulse-a 1.4s infinite;"></span> In Progress
            </a>
            <a href="{{ route('admin.support.index', ['status' => 'solved']) }}" class="adm-chip {{ $status === 'solved' ? 'active' : '' }}">
                <span class="adm-chip-dot" style="background:#30D158;"></span> Solved
            </a>
        </div>

        {{-- ── Tickets ── --}}
        @if($tickets->isEmpty())
            <div class="adm-empty">
                <div class="adm-empty-icon"><i class="fa-solid fa-inbox"></i></div>
                <p style="font-size:1rem;font-weight:700;color:var(--text-primary);">No tickets found</p>
                <p style="font-size:0.82rem;color:var(--text-muted);margin-top:6px;">No support tickets match the current filter.</p>
            </div>
        @else
            @foreach($tickets as $ticket)
            @php
                $role     = $ticket->user?->role?->name ?? 'student';
                $initials = strtoupper(substr($ticket->user?->name ?? 'U', 0, 1));
                $msgs     = $ticket->messages; // already eager-loaded
            @endphp
            <div class="adm-ticket status-{{ $ticket->status }}" id="adm-ticket-{{ $ticket->id }}">

                {{-- ── Ticket Header (click to expand) ── --}}
                <div class="adm-ticket-hdr" onclick="toggleTicket({{ $ticket->id }})">
                    <div class="adm-avatar">{{ $initials }}</div>
                    <div class="adm-ticket-info">
                        <div style="display:flex;align-items:center;flex-wrap:wrap;gap:6px;">
                            <span class="adm-ticket-name">{{ $ticket->user?->name ?? 'Unknown User' }}</span>
                            <span class="adm-role-badge role-{{ $role }}">{{ ucfirst($role) }}</span>
                        </div>
                        <div class="adm-ticket-email">{{ $ticket->user?->email ?? '' }}</div>
                        <div class="adm-ticket-subject">{{ $ticket->subject }}</div>
                    </div>
                    <span class="adm-status-pill pill-{{ $ticket->status }}">
                        <span class="adm-pulse {{ $ticket->status }}"></span>
                        {{ $ticket->status_label }}
                    </span>
                </div>

                {{-- ── Chat Panel ── --}}
                <div class="adm-chat-panel" id="adm-chat-{{ $ticket->id }}">

                    {{-- Chat log --}}
                    <div class="adm-chat-log" id="adm-log-{{ $ticket->id }}">

                        {{-- Original question bubble ── always first ── --}}
                        <div class="chat-question-wrap">
                            <div class="chat-question-bubble">
                                <div class="chat-q-label">{{ $ticket->user?->name ?? 'User' }} — original question</div>
                                {{ $ticket->question }}
                                <div class="chat-q-time">{{ $ticket->created_at->format('d M Y, h:i A') }}</div>
                            </div>
                        </div>

                        {{-- If there are no chat messages yet but legacy admin_reply exists --}}
                        @if($msgs->isEmpty() && $ticket->admin_reply)
                            <div class="chat-divider">
                                <div class="chat-divider-line"></div>
                                <div class="chat-divider-text">Previous reply</div>
                                <div class="chat-divider-line"></div>
                            </div>
                            <div class="chat-admin-wrap">
                                <div class="chat-admin-avatar">A</div>
                                <div class="chat-admin-bubble">
                                    <div class="chat-admin-label"><i class="fa-solid fa-shield-halved" style="margin-right:4px;"></i>Admin replied</div>
                                    {{ $ticket->admin_reply }}
                                    <div class="chat-admin-time"><i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ $ticket->replied_at?->format('d M Y, h:i A') ?? '' }}</div>
                                </div>
                            </div>
                        @endif

                        {{-- Dynamic chat messages from support_messages table --}}
                        @foreach($msgs as $msg)
                            @if($msg->sender_role === 'admin')
                                <div class="chat-admin-wrap chat-msg-item" data-msg-id="{{ $msg->id }}">
                                    <div class="chat-admin-avatar">A</div>
                                    <div class="chat-admin-bubble">
                                        <div class="chat-admin-label"><i class="fa-solid fa-shield-halved" style="margin-right:4px;"></i>Admin · {{ $msg->sender?->name ?? 'Admin' }}</div>
                                        {{ $msg->body }}
                                        <div class="chat-admin-time"><i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ $msg->created_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                </div>
                            @else
                                <div class="chat-user-wrap chat-msg-item" data-msg-id="{{ $msg->id }}">
                                    <div class="chat-user-bubble">
                                        <div class="chat-user-label">{{ $msg->sender?->name ?? 'User' }} replied</div>
                                        {{ $msg->body }}
                                        <div class="chat-user-time">{{ $msg->created_at->format('d M Y, h:i A') }}</div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    </div>{{-- /adm-chat-log --}}

                    {{-- ── Chat Input (only if not solved) ── --}}
                    @if($ticket->status !== 'solved')
                        <div class="adm-chat-input-bar" id="adm-input-bar-{{ $ticket->id }}">
                            <div class="adm-chat-input-label">
                                <i class="fa-solid fa-comment-dots" style="color:var(--accent);"></i>
                                Reply to <strong>{{ $ticket->user?->name ?? 'User' }}</strong>
                                <span style="margin-left:auto;font-size:0.65rem;color:var(--text-muted);">Ticket #{{ $ticket->id }}</span>
                            </div>
                            <div class="adm-chat-input-row">
                                <textarea
                                    class="adm-chat-textarea"
                                    id="adm-chat-text-{{ $ticket->id }}"
                                    placeholder="Type your reply here… Press Ctrl+Enter to send"
                                    rows="3"></textarea>
                                <button
                                    class="adm-chat-send-btn"
                                    id="adm-send-btn-{{ $ticket->id }}"
                                    onclick="adminSendMessage({{ $ticket->id }})">
                                    <i class="fa-solid fa-paper-plane"></i> Send
                                </button>
                            </div>
                            <div class="adm-action-row">
                                <button type="button" class="adm-btn adm-btn-solved"
                                    onclick="openSolveModal({{ $ticket->id }}, '{{ addslashes($ticket->user?->name ?? 'User') }}')"
                                    id="adm-btn-solve-{{ $ticket->id }}">
                                    <i class="fa-solid fa-circle-check"></i> Solved &amp; End Chat
                                </button>
                                <label class="adm-email-toggle" for="adm-email-{{ $ticket->id }}">
                                    <input type="checkbox" id="adm-email-{{ $ticket->id }}" checked>
                                    <span>Send email on solve</span>
                                    <i class="fa-solid fa-envelope" style="color:var(--accent);font-size:0.8rem;"></i>
                                </label>
                            </div>
                        </div>
                    @else
                        <div class="adm-solved-badge">
                            <i class="fa-solid fa-circle-check" style="font-size:1rem;"></i>
                            <span>This ticket was resolved and chat ended</span>
                            <span style="margin-left:auto;font-size:0.65rem;color:#30D158;opacity:0.7;">{{ $ticket->replied_at?->diffForHumans() }}</span>
                        </div>
                    @endif

                </div>{{-- /adm-chat-panel --}}

                {{-- ── Ticket Footer ── --}}
                <div class="adm-ticket-footer" onclick="toggleTicket({{ $ticket->id }})" style="cursor:pointer;">
                    <span class="adm-ticket-id">#{{ $ticket->id }}</span>
                    <span style="color:var(--border);font-size:0.7rem;">•</span>
                    <span class="adm-ticket-meta-time">
                        <i class="fa-regular fa-clock" style="margin-right:3px;"></i>
                        {{ $ticket->created_at->diffForHumans() }}
                    </span>
                    @if($msgs->isNotEmpty())
                        <span style="font-size:0.65rem;color:#30D158;font-weight:600;">
                            <i class="fa-solid fa-comments" style="margin-right:3px;"></i>{{ $msgs->count() }} message{{ $msgs->count() > 1 ? 's' : '' }}
                        </span>
                    @elseif($ticket->admin_reply)
                        <span style="font-size:0.65rem;color:#007AFF;font-weight:600;">
                            <i class="fa-solid fa-reply" style="margin-right:3px;"></i>Replied {{ $ticket->replied_at?->diffForHumans() }}
                        </span>
                    @endif
                    <div class="adm-expand-hint" id="adm-hint-{{ $ticket->id }}">
                        {{ $ticket->status !== 'solved' ? 'Click to chat' : 'View chat' }}
                        <i class="fa-solid fa-chevron-down adm-expand-chevron" id="adm-chev-{{ $ticket->id }}"></i>
                    </div>
                </div>

            </div>
            @endforeach
        @endif

    </div>

    {{-- ═══════════════════════════════════════════
         SOLVED & END CHAT MODAL
    ═══════════════════════════════════════════ --}}
    <div class="adm-solve-overlay" id="solveOverlay" onclick="closeSolveModal(event)">
        <div class="adm-solve-modal" id="solveModal">
            <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;">
                <div style="width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,rgba(52,199,89,0.15),rgba(48,209,88,0.1));display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#30D158;flex-shrink:0;">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div>
                    <div style="font-size:1.1rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.025em;">Solved &amp; End Chat</div>
                    <div style="font-size:0.78rem;color:var(--text-secondary);margin-top:2px;">Mark this ticket as fully resolved and lock the chat</div>
                </div>
                <button onclick="closeSolveModal()" style="margin-left:auto;width:30px;height:30px;border-radius:50%;background:var(--border-2);border:none;cursor:pointer;color:var(--text-muted);font-size:0.85rem;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <div style="margin-bottom:20px;">
                <label style="font-size:0.75rem;font-weight:600;color:var(--text-secondary);display:block;margin-bottom:8px;">
                    <i class="fa-solid fa-comment" style="margin-right:5px;color:#30D158;"></i>
                    Closing message (sent as final reply)
                </label>
                <textarea id="solveMsg" class="adm-reply-textarea" placeholder="e.g. Your issue has been fully resolved! Let us know if you need any further help." rows="3"></textarea>
            </div>

            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <label style="display:flex;align-items:center;gap:7px;font-size:0.8rem;color:var(--text-secondary);cursor:pointer;">
                    <input type="checkbox" id="solveEmailCheck" checked style="accent-color:#30D158;width:15px;height:15px;">
                    Notify user by email
                </label>
            </div>

            <div style="display:flex;gap:10px;">
                <button onclick="closeSolveModal()" style="flex:1;padding:12px;border-radius:14px;background:var(--border-2);border:none;cursor:pointer;font-weight:600;font-size:0.85rem;color:var(--text-secondary);">
                    Cancel
                </button>
                <button id="solveConfirmBtn" onclick="confirmSolve()" style="flex:2;padding:12px;border-radius:14px;background:linear-gradient(135deg,#30D158,#34C759);border:none;cursor:pointer;font-weight:700;font-size:0.88rem;color:#fff;display:flex;align-items:center;justify-content:center;gap:8px;box-shadow:0 4px 16px rgba(52,199,89,0.35);transition:all 0.2s;">
                    <i class="fa-solid fa-circle-check"></i> Confirm Resolved
                </button>
            </div>
        </div>
    </div>

    <script>
    /* ══════════════════════════════════════════════════
       ADMIN SUPPORT PANEL — LIVE CHAT JAVASCRIPT
    ══════════════════════════════════════════════════ */

    const CSRF = '{{ csrf_token() }}';
    let solveTargetTicketId = null;

    /* ── Track last known message IDs per ticket for polling ── */
    const lastMsgIds = {};

    /* ── Toggle ticket expand ── */
    function toggleTicket(id) {
        const panel = document.getElementById('adm-chat-' + id);
        const chev  = document.getElementById('adm-chev-' + id);
        if (!panel) return;
        const isOpen = panel.classList.contains('open');
        panel.classList.toggle('open');
        if (chev) chev.classList.toggle('rotated', !isOpen);

        // Scroll to bottom of chat log when opening
        if (!isOpen) {
            setTimeout(() => scrollChatLog(id), 80);
            // Init last msg id tracking
            const items = document.querySelectorAll('#adm-log-' + id + ' .chat-msg-item');
            const lastItem = items[items.length - 1];
            lastMsgIds[id] = lastItem ? parseInt(lastItem.dataset.msgId || 0) : 0;
        }
    }

    function scrollChatLog(id) {
        const log = document.getElementById('adm-log-' + id);
        if (log) log.scrollTop = log.scrollHeight;
    }

    /* ── Admin send message ── */
    function adminSendMessage(ticketId) {
        const textarea = document.getElementById('adm-chat-text-' + ticketId);
        const btn      = document.getElementById('adm-send-btn-' + ticketId);
        const text     = textarea?.value?.trim();

        if (!text) { showToast('Please write a message first.', 'error'); return; }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sending…';

        fetch('/admin/support/' + ticketId + '/message', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ body: text }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                textarea.value = '';
                appendAdminBubble(ticketId, data.message);
                if (data.ticket?.status) updateTicketStatusUI(ticketId, data.ticket.status);
                showToast('✓ Message sent!', 'success');
            } else {
                showToast(data.error || 'Failed to send message.', 'error');
            }
        })
        .catch(() => showToast('Network error.', 'error'))
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send';
        });
    }

    /* ── Append an admin bubble dynamically ── */
    function appendAdminBubble(ticketId, msg) {
        const log = document.getElementById('adm-log-' + ticketId);
        if (!log) return;
        const wrap = document.createElement('div');
        wrap.className = 'chat-admin-wrap chat-msg-item chat-bubble-new';
        wrap.dataset.msgId = msg.id || 0;
        wrap.innerHTML = `
            <div class="chat-admin-avatar">A</div>
            <div class="chat-admin-bubble">
                <div class="chat-admin-label"><i class="fa-solid fa-shield-halved" style="margin-right:4px;"></i>Admin · ${escHtml(msg.sender_name || 'Admin')}</div>
                ${escHtml(msg.body)}
                <div class="chat-admin-time"><i class="fa-regular fa-clock" style="margin-right:3px;"></i>${msg.time || 'Just now'}</div>
            </div>`;
        log.appendChild(wrap);
        log.scrollTop = log.scrollHeight;
        lastMsgIds[ticketId] = Math.max(lastMsgIds[ticketId] || 0, msg.id || 0);
    }

    /* ── Append a user bubble dynamically (for new polled messages) ── */
    function appendUserBubble(ticketId, msg) {
        const log = document.getElementById('adm-log-' + ticketId);
        if (!log) return;
        const wrap = document.createElement('div');
        wrap.className = 'chat-user-wrap chat-msg-item chat-bubble-new';
        wrap.dataset.msgId = msg.id || 0;
        wrap.innerHTML = `
            <div class="chat-user-bubble">
                <div class="chat-user-label">${escHtml(msg.sender_name || 'User')} replied</div>
                ${escHtml(msg.body)}
                <div class="chat-user-time">${msg.time || ''}</div>
            </div>`;
        log.appendChild(wrap);
        log.scrollTop = log.scrollHeight;
        lastMsgIds[ticketId] = Math.max(lastMsgIds[ticketId] || 0, msg.id || 0);
    }

    /* ── Update status UI ── */
    function updateTicketStatusUI(ticketId, status) {
        const card = document.getElementById('adm-ticket-' + ticketId);
        if (!card) return;
        card.className = 'adm-ticket status-' + status;
        const pill = card.querySelector('.adm-status-pill');
        if (pill) {
            const labels = { submitted:'Submitted', in_progress:'In Progress', solved:'Solved' };
            pill.className = 'adm-status-pill pill-' + status;
            pill.innerHTML = `<span class="adm-pulse ${status}"></span>${labels[status] || status}`;
        }
        card.style.boxShadow = '0 0 0 3px rgba(52,199,89,0.2)';
        setTimeout(() => { card.style.boxShadow = ''; }, 2500);
    }

    /* ── Polling: check for new messages on all open chat panels ── */
    function pollOpenTickets() {
        document.querySelectorAll('.adm-chat-panel.open').forEach(panel => {
            const id = parseInt(panel.id.replace('adm-chat-', ''));
            if (!id) return;

            fetch('/admin/support/' + id + '/messages', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.messages) return;
                const knownId = lastMsgIds[id] || 0;
                data.messages.forEach(msg => {
                    if (msg.id > knownId) {
                        if (msg.sender_role === 'admin') {
                            // Only append if not already rendered (admin's own messages are appended immediately)
                            const existing = document.querySelector(`#adm-log-${id} [data-msg-id="${msg.id}"]`);
                            if (!existing) appendAdminBubble(id, msg);
                        } else {
                            const existing = document.querySelector(`#adm-log-${id} [data-msg-id="${msg.id}"]`);
                            if (!existing) {
                                appendUserBubble(id, msg);
                                showToast(`💬 New reply from user on ticket #${id}`, 'success');
                            }
                        }
                        lastMsgIds[id] = Math.max(lastMsgIds[id] || 0, msg.id);
                    }
                });
            })
            .catch(() => {});
        });
    }

    // Poll every 8 seconds
    setInterval(pollOpenTickets, 8000);

    /* ── Ctrl+Enter to send ── */
    document.addEventListener('keydown', function(e) {
        if (e.ctrlKey && e.key === 'Enter') {
            const active = document.activeElement;
            if (active && active.classList.contains('adm-chat-textarea')) {
                const id = active.id.replace('adm-chat-text-', '');
                adminSendMessage(parseInt(id));
            }
        }
    });

    /* ── Solved & End Chat modal ── */
    function openSolveModal(ticketId, userName) {
        solveTargetTicketId = ticketId;
        document.getElementById('solveMsg').value = '';
        document.getElementById('solveOverlay').classList.add('show');
        document.body.style.overflow = 'hidden';
        setTimeout(() => document.getElementById('solveMsg').focus(), 320);
    }

    function closeSolveModal(e) {
        if (e && e.target && e.target.id !== 'solveOverlay') return;
        document.getElementById('solveOverlay').classList.remove('show');
        document.body.style.overflow = '';
        solveTargetTicketId = null;
    }

    function confirmSolve() {
        const id         = solveTargetTicketId;
        const msg        = document.getElementById('solveMsg').value.trim();
        const sendEmail  = document.getElementById('solveEmailCheck').checked ? 1 : 0;
        const confirmBtn = document.getElementById('solveConfirmBtn');

        if (!id) return;
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Resolving…';

        fetch('/admin/support/' + id + '/close', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ closing_message: msg || null, send_email: sendEmail }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('solveOverlay').classList.remove('show');
                document.body.style.overflow = '';
                updateTicketStatusUI(id, 'solved');

                // Append closing message bubble
                if (msg) {
                    appendAdminBubble(id, {
                        id: 0,
                        sender_name: 'Admin',
                        body: msg,
                        time: 'Just now',
                    });
                }

                // Replace input bar with solved badge
                const bar = document.getElementById('adm-input-bar-' + id);
                if (bar) {
                    bar.outerHTML = `
                        <div class="adm-solved-badge">
                            <i class="fa-solid fa-circle-check" style="font-size:1rem;"></i>
                            <span>This ticket was resolved and chat ended</span>
                            <span style="margin-left:auto;font-size:0.65rem;color:#30D158;opacity:0.7;">just now</span>
                        </div>`;
                }

                showToast('✅ Ticket resolved & chat ended!', 'success');
            } else {
                showToast('Failed to close ticket.', 'error');
            }
        })
        .catch(() => showToast('Network error.', 'error'))
        .finally(() => {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i> Confirm Resolved';
            solveTargetTicketId = null;
        });
    }

    /* ── Toast ── */
    function showToast(msg, type) {
        const t = document.createElement('div');
        t.style.cssText = `
            position:fixed;bottom:30px;right:24px;z-index:99999;
            padding:14px 22px;border-radius:16px;font-size:0.85rem;font-weight:700;
            box-shadow:0 8px 32px rgba(0,0,0,0.18);
            background:${type === 'success' ? 'linear-gradient(135deg,#30D158,#34C759)' : '#FF3B30'};
            color:#fff;animation:slideInToast 0.3s ease-out;
            display:flex;align-items:center;gap:8px;min-width:200px;
        `;
        t.innerHTML = msg;
        document.body.appendChild(t);
        setTimeout(() => t.remove(), 4000);
    }

    function escHtml(str) {
        const d = document.createElement('div');
        d.textContent = str;
        return d.innerHTML;
    }

    /* ── ESC key to close solve modal ── */
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') {
            document.getElementById('solveOverlay').classList.remove('show');
            document.body.style.overflow = '';
        }
    });

    /* ── Chat Access Toggle ── */
    function toggleChatAccess() {
        const btn      = document.getElementById('chatToggleBtn');
        const icon     = document.getElementById('chatToggleIcon');
        const label    = document.getElementById('chatToggleLabel');
        const spinner  = document.getElementById('chatToggleSpinner');
        const statusTx = document.getElementById('chatStatusText');

        const currentlyEnabled = btn.dataset.enabled === '1';
        const newValue = currentlyEnabled ? 0 : 1;

        // Show loading state
        spinner.style.display = 'inline-block';
        btn.style.opacity = '0.7';
        btn.style.pointerEvents = 'none';

        fetch('{{ route('admin.settings.update') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ key: 'support_chat_enabled', value: newValue }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                const isOn = newValue === 1;
                btn.dataset.enabled = isOn ? '1' : '0';

                // Update button appearance
                if (isOn) {
                    btn.style.background = 'rgba(52,199,89,0.12)';
                    btn.style.color      = '#30D158';
                    btn.style.boxShadow  = '0 0 0 1.5px rgba(52,199,89,0.3)';
                    icon.style.background          = '#30D158';
                    icon.style.justifyContent      = 'flex-end';
                    label.textContent              = 'Chat ON';
                    if (statusTx) { statusTx.textContent = 'User chat is ON'; statusTx.style.color = '#30D158'; }
                    btn.title = 'Click to disable user chat';
                    showToast('✅ User chat is now <strong>ENABLED</strong> — students, teachers & parents can chat.', 'success');
                } else {
                    btn.style.background = 'rgba(255,159,10,0.12)';
                    btn.style.color      = '#FF9F0A';
                    btn.style.boxShadow  = '0 0 0 1.5px rgba(255,159,10,0.3)';
                    icon.style.background          = 'rgba(60,60,67,0.2)';
                    icon.style.justifyContent      = 'flex-start';
                    label.textContent              = 'Chat OFF';
                    if (statusTx) { statusTx.textContent = 'User chat is OFF'; statusTx.style.color = '#FF9F0A'; }
                    btn.title = 'Click to enable user chat';
                    showToast('🔇 User chat is now <strong>DISABLED</strong> — reply inputs are hidden for users.', 'error');
                }
            } else {
                showToast('Failed to update chat setting.', 'error');
            }
        })
        .catch(() => showToast('Network error. Try again.', 'error'))
        .finally(() => {
            spinner.style.display  = 'none';
            btn.style.opacity      = '1';
            btn.style.pointerEvents = 'auto';
        });
    }
    </script>
@endsection