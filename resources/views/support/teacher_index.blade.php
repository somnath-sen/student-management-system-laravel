@extends('layouts.teacher')
@section('title', 'My Support & Doubts')

@section('content')
<style>
.sp-wrap { max-width: 860px; margin: 0 auto; padding: 24px 20px 60px; }
.sp-hero { background: linear-gradient(135deg, #30D158 0%, #34C759 50%, #25A244 100%); border-radius:24px;padding:32px 32px 28px;margin-bottom:28px;position:relative;overflow:hidden; }
.sp-hero::before { content:'';position:absolute;top:-40px;right:-40px;width:200px;height:200px;background:rgba(255,255,255,0.08);border-radius:50%; }
.sp-hero-title { font-size:1.5rem;font-weight:800;color:#fff;letter-spacing:-0.035em;margin-bottom:6px;position:relative;z-index:1; }
.sp-hero-sub   { font-size:0.82rem;color:rgba(255,255,255,0.78);position:relative;z-index:1;margin-bottom:22px; }
.sp-ask-btn { display:inline-flex;align-items:center;gap:9px;padding:12px 24px;border-radius:100px;background:rgba(255,255,255,0.2);border:1.5px solid rgba(255,255,255,0.4);color:#fff;font-size:0.88rem;font-weight:700;cursor:pointer;transition:all 0.22s ease;backdrop-filter:blur(8px);position:relative;z-index:1; }
.sp-ask-btn:hover { background:rgba(255,255,255,0.35);transform:translateY(-2px); }

/* Inline form */
.sp-ask-form { background:var(--bg-2,#fff);border-radius:22px;border:1.5px solid rgba(48,209,88,0.2);padding:26px 28px;margin-bottom:28px;box-shadow:0 8px 32px rgba(48,209,88,0.1);display:none; }
.sp-ask-form.open { display:block;animation:fadeSlideIn 0.3s ease; }
@keyframes fadeSlideIn { from{opacity:0;transform:translateY(-12px);}to{opacity:1;transform:translateY(0);} }
.sp-form-title { font-size:1rem;font-weight:800;color:var(--text-primary,#1C1C1E);letter-spacing:-0.025em;margin-bottom:20px;display:flex;align-items:center;gap:10px; }
.sp-form-field { margin-bottom:16px; }
.sp-form-label { font-size:0.72rem;font-weight:600;color:var(--text-secondary,rgba(60,60,67,0.6));margin-bottom:7px;display:block;text-transform:uppercase;letter-spacing:0.06em; }
.sp-form-input, .sp-form-textarea { width:100%;border:1.5px solid rgba(60,60,67,0.15);border-radius:14px;padding:13px 16px;font-size:0.88rem;font-family:inherit;background:var(--bg,#F9F9FB);color:var(--text-primary,#1C1C1E);outline:none;transition:all 0.18s; }
.sp-form-input:focus, .sp-form-textarea:focus { border-color:#30D158;background:var(--bg-2,#fff);box-shadow:0 0 0 3px rgba(48,209,88,0.1); }
.sp-form-textarea { resize:vertical;min-height:110px; }
.sp-form-row { display:flex;gap:10px;margin-top:4px;flex-wrap:wrap; }
.sp-form-submit { flex:1;min-width:140px;padding:13px 24px;border-radius:14px;background:linear-gradient(135deg,#30D158,#34C759);color:#fff;font-size:0.88rem;font-weight:700;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;box-shadow:0 4px 14px rgba(48,209,88,0.3); }
.sp-form-submit:hover { transform:translateY(-2px);box-shadow:0 8px 24px rgba(48,209,88,0.4); }
.sp-form-cancel { padding:13px 20px;border-radius:14px;background:rgba(60,60,67,0.06);color:rgba(60,60,67,0.6);font-size:0.85rem;font-weight:600;border:none;cursor:pointer;transition:all 0.18s; }
.sp-form-success { display:none;text-align:center;padding:24px;background:rgba(48,209,88,0.06);border-radius:16px;border:1px solid rgba(48,209,88,0.2); }
.sp-form-success-icon { font-size:2.5rem;color:#30D158;margin-bottom:12px; }

/* Stats */
.sp-stats { display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:28px; }
.sp-stat { background:var(--bg-2,#fff);border:1px solid rgba(60,60,67,0.1);border-radius:18px;padding:18px 16px;text-align:center;transition:all 0.2s; }
.sp-stat:hover { transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,0.08); }
.sp-stat-num { font-size:1.9rem;font-weight:800;letter-spacing:-0.04em; }
.sp-stat-lbl { font-size:0.65rem;font-weight:600;text-transform:uppercase;letter-spacing:0.07em;color:rgba(60,60,67,0.5);margin-top:4px; }

.sp-section-head { display:flex;align-items:center;justify-content:space-between;margin-bottom:16px; }
.sp-section-title { font-size:1rem;font-weight:800;color:var(--text-primary,#1C1C1E);letter-spacing:-0.025em; }

.sp-ticket { background:var(--bg-2,#fff);border:1.5px solid rgba(60,60,67,0.1);border-radius:22px;overflow:hidden;transition:all 0.25s cubic-bezier(0.34,1.56,0.64,1);margin-bottom:14px; }
.sp-ticket:hover { transform:translateY(-2px);box-shadow:0 10px 32px rgba(0,0,0,0.09); }
.sp-ticket.is-solved     { border-color:rgba(52,199,89,0.3); }
.sp-ticket.is-in_progress{ border-color:rgba(48,209,88,0.25); }
.sp-ticket-top { padding:20px 22px; }
.sp-ticket-header { display:flex;align-items:flex-start;justify-content:space-between;gap:12px;margin-bottom:10px; }
.sp-ticket-subject { font-size:0.95rem;font-weight:800;color:var(--text-primary,#1C1C1E);letter-spacing:-0.02em; }
.sp-ticket-question { font-size:0.82rem;color:rgba(60,60,67,0.65);line-height:1.6;margin-bottom:18px; }

.sp-pill { font-size:0.6rem;font-weight:700;padding:4px 12px;border-radius:100px;text-transform:uppercase;letter-spacing:0.06em;flex-shrink:0;display:flex;align-items:center;gap:5px; }
.sp-pill-submitted  { background:rgba(0,122,255,0.1);color:#007AFF; }
.sp-pill-in_progress{ background:rgba(48,209,88,0.12);color:#30D158; }
.sp-pill-solved     { background:rgba(52,199,89,0.12);color:#30D158; }

.sp-timeline { display:flex;align-items:center;gap:0;margin-bottom:16px;padding:14px 18px;background:rgba(60,60,67,0.03);border-radius:14px;border:1px solid rgba(60,60,67,0.07); }
.sp-step { display:flex;flex-direction:column;align-items:center;gap:6px;flex-shrink:0; }
.sp-step-dot { width:32px;height:32px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:0.75rem;font-weight:700;transition:all 0.4s cubic-bezier(0.34,1.56,0.64,1); }
.sp-step-dot.done   { background:linear-gradient(135deg,#30D158,#34C759);color:#fff;box-shadow:0 4px 14px rgba(52,199,89,0.4); }
.sp-step-dot.active { background:linear-gradient(135deg,#30D158,#25A244);color:#fff;box-shadow:0 4px 14px rgba(48,209,88,0.4);animation:spStepPulseG 2s infinite; }
.sp-step-dot.pending{ background:rgba(60,60,67,0.08);color:rgba(60,60,67,0.3);border:1.5px solid rgba(60,60,67,0.12); }
@keyframes spStepPulseG { 0%,100%{box-shadow:0 4px 14px rgba(52,199,89,0.4);transform:scale(1);}50%{box-shadow:0 4px 24px rgba(52,199,89,0.7);transform:scale(1.08);} }
.sp-step-label { font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:rgba(60,60,67,0.4);text-align:center;line-height:1.2;white-space:nowrap; }
.sp-step-label.done-lbl  { color:#30D158; }
.sp-step-label.active-lbl{ color:#30D158; }
.sp-connector { flex:1;height:3px;border-radius:100px;margin:0 6px;margin-bottom:18px;transition:all 0.6s ease; }
.sp-connector.done   { background:linear-gradient(90deg,#30D158,#34C759); }
.sp-connector.active { background:linear-gradient(90deg,#30D158,rgba(48,209,88,0.3)); }
.sp-connector.pending{ background:rgba(60,60,67,0.1); }

.sp-reply-wrap { border-top:1px solid rgba(60,60,67,0.07);padding:16px 22px;background:linear-gradient(135deg,rgba(48,209,88,0.04),rgba(52,199,89,0.02)); }
.sp-reply-label { font-size:0.62rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:#30D158;margin-bottom:10px;display:flex;align-items:center;gap:6px; }
.sp-reply-bubble { background:var(--bg-2,#fff);border:1.5px solid rgba(48,209,88,0.2);border-radius:6px 18px 18px 18px;padding:14px 18px;font-size:0.85rem;color:var(--text-primary,#1C1C1E);line-height:1.65;box-shadow:0 4px 14px rgba(48,209,88,0.08); }
.sp-reply-time { font-size:0.65rem;color:rgba(60,60,67,0.4);margin-top:8px;display:flex;align-items:center;gap:4px; }
.sp-solved-banner { background:linear-gradient(135deg,rgba(52,199,89,0.08),rgba(48,209,88,0.04));border-top:1px solid rgba(52,199,89,0.15);padding:12px 22px;display:flex;align-items:center;gap:10px;font-size:0.8rem;font-weight:600;color:#30D158; }
.sp-ticket-footer { display:flex;align-items:center;gap:10px;flex-wrap:wrap;border-top:1px solid rgba(60,60,67,0.06);padding:10px 22px;background:rgba(60,60,67,0.02); }
.sp-ticket-footer-time { font-size:0.65rem;color:rgba(60,60,67,0.4); }
.sp-ticket-id { font-size:0.65rem;color:rgba(60,60,67,0.35); }

.sp-pulse { display:inline-block;width:7px;height:7px;border-radius:50%; }
.sp-pulse.submitted  { background:#007AFF;animation:spPA 2s infinite; }
.sp-pulse.in_progress{ background:#30D158;animation:spPA 1.4s infinite; }
.sp-pulse.solved     { background:#30D158; }
@keyframes spPA { 0%,100%{opacity:1;transform:scale(1);}50%{opacity:0.5;transform:scale(0.85);} }

.sp-empty { text-align:center;padding:64px 20px;background:var(--bg-2,#fff);border-radius:24px;border:1.5px dashed rgba(60,60,67,0.15); }
.sp-empty-icon { width:72px;height:72px;border-radius:22px;background:linear-gradient(135deg,rgba(48,209,88,0.1),rgba(52,199,89,0.1));display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:1.8rem;color:#30D158; }
.sp-live-badge { display:flex;align-items:center;gap:6px;font-size:0.65rem;font-weight:600;color:#30D158;padding:4px 12px;background:rgba(52,199,89,0.1);border-radius:100px; }
.sp-live-dot { width:6px;height:6px;background:#30D158;border-radius:50%;animation:spPA 1.5s infinite; }

/* ── Chat Thread ── */
.sp-chat-log { display:flex;flex-direction:column;gap:12px;padding:16px 22px 6px;background:rgba(60,60,67,0.02);border-top:1px solid rgba(60,60,67,0.06);max-height:380px;overflow-y:auto;scroll-behavior:smooth; }
.sp-chat-log::-webkit-scrollbar{width:3px;}.sp-chat-log::-webkit-scrollbar-thumb{background:rgba(60,60,67,0.15);border-radius:100px;}
.sp-chat-admin-wrap { display:flex;align-items:flex-end;gap:8px; }
.sp-chat-admin-av { width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#30D158,#34C759);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.65rem;flex-shrink:0; }
.sp-chat-admin-bubble { background:var(--bg-2,#fff);border:1.5px solid rgba(48,209,88,0.2);border-radius:16px 16px 16px 4px;padding:12px 16px;max-width:76%;font-size:0.84rem;line-height:1.65;color:var(--text-primary,#1C1C1E);box-shadow:0 3px 10px rgba(48,209,88,0.08); }
.sp-chat-admin-lbl { font-size:0.6rem;font-weight:700;color:#30D158;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.06em; }
.sp-chat-user-wrap { display:flex;align-items:flex-end;justify-content:flex-end;gap:8px; }
.sp-chat-user-bubble { background:linear-gradient(135deg,#30D158,#34C759);color:#fff;border-radius:16px 16px 4px 16px;padding:12px 16px;max-width:76%;font-size:0.84rem;line-height:1.65;box-shadow:0 3px 12px rgba(52,199,89,0.3); }
.sp-chat-user-lbl { font-size:0.6rem;font-weight:700;opacity:0.8;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.06em; }
.sp-chat-time { font-size:0.6rem;margin-top:5px;opacity:0.65;display:flex;align-items:center;gap:3px; }
/* ── User Reply Bar ── */
.sp-user-reply-bar { border-top:1px solid rgba(60,60,67,0.07);padding:14px 22px 18px;background:rgba(48,209,88,0.02); }
.sp-user-reply-label { font-size:0.7rem;font-weight:700;color:#30D158;margin-bottom:8px;display:flex;align-items:center;gap:6px;text-transform:uppercase;letter-spacing:0.06em; }
.sp-user-reply-row { display:flex;gap:10px;align-items:flex-end; }
.sp-user-reply-textarea { flex:1;border:1.5px solid rgba(48,209,88,0.2);border-radius:14px;padding:11px 14px;font-size:0.85rem;font-family:inherit;background:var(--bg,#F9F9FB);color:var(--text-primary,#1C1C1E);resize:none;min-height:62px;max-height:140px;outline:none;transition:border-color 0.18s;line-height:1.6; }
.sp-user-reply-textarea:focus { border-color:#30D158;box-shadow:0 0 0 3px rgba(48,209,88,0.1); }
.sp-user-reply-btn { padding:11px 20px;border-radius:14px;background:linear-gradient(135deg,#30D158,#34C759);color:#fff;font-size:0.82rem;font-weight:700;border:none;cursor:pointer;display:inline-flex;align-items:center;gap:7px;flex-shrink:0;box-shadow:0 4px 12px rgba(52,199,89,0.3);transition:all 0.18s; }
.sp-user-reply-btn:hover { opacity:0.9;transform:translateY(-1px); }
.sp-user-reply-btn:disabled { opacity:0.5;cursor:not-allowed;transform:none; }
@keyframes spChatIn { from{opacity:0;transform:translateY(8px);}to{opacity:1;transform:translateY(0);} }
.sp-chat-bubble-new { animation:spChatIn 0.25s ease; }
</style>

<div class="sp-wrap">

    <div class="sp-hero">
        <div class="sp-hero-title"><i class="fa-solid fa-circle-question" style="margin-right:10px;opacity:0.85;"></i>My Support & Doubts</div>
        <div class="sp-hero-sub">Submit questions and track their status in real-time</div>
        <button class="sp-ask-btn" onclick="toggleAskForm()">
            <i class="fa-solid fa-plus" id="askBtnIcon"></i>
            <span id="askBtnText">Ask a New Doubt</span>
        </button>
    </div>

    <div class="sp-ask-form" id="askForm">
        <div class="sp-form-title"><i class="fa-solid fa-paper-plane" style="color:#30D158;"></i> Ask a New Doubt</div>
        <div id="formContent">
            <form id="supportForm" onsubmit="submitDoubt(event)">
                @csrf
                <div class="sp-form-field">
                    <label class="sp-form-label">Subject / Topic</label>
                    <input type="text" class="sp-form-input" id="doubSubject" name="subject" placeholder="e.g. Maths Chapter 5 doubt" maxlength="255" required>
                </div>
                <div class="sp-form-field">
                    <label class="sp-form-label">Describe Your Doubt</label>
                    <textarea class="sp-form-textarea" id="doubQuestion" name="question" placeholder="Write your question in detail..." maxlength="5000" required rows="5"></textarea>
                </div>
                <div class="sp-form-row">
                    <button type="submit" class="sp-form-submit" id="submitBtn"><i class="fa-solid fa-paper-plane"></i> Submit Doubt</button>
                    <button type="button" class="sp-form-cancel" onclick="toggleAskForm()">Cancel</button>
                </div>
            </form>
        </div>
        <div class="sp-form-success" id="formSuccess">
            <div class="sp-form-success-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div style="font-size:1rem;font-weight:800;color:var(--text-primary,#1C1C1E);margin-bottom:6px;">Doubt Submitted!</div>
            <div style="font-size:0.82rem;color:rgba(60,60,67,0.6);margin-bottom:18px;">Our support team will review and reply shortly.</div>
            <button onclick="window.location.reload()" class="sp-form-submit" style="max-width:200px;margin:0 auto;"><i class="fa-solid fa-rotate-right"></i> View All Doubts</button>
        </div>
    </div>

    @php
        $totalCount   = $tickets->count();
        $pendingCount = $tickets->where('status','submitted')->count();
        $ipCount      = $tickets->where('status','in_progress')->count();
        $doneCount    = $tickets->where('status','solved')->count();
    @endphp
    <div class="sp-stats">
        <div class="sp-stat"><div class="sp-stat-num" style="color:var(--text-primary,#1C1C1E);">{{ $totalCount }}</div><div class="sp-stat-lbl">Total</div></div>
        <div class="sp-stat"><div class="sp-stat-num" style="color:#FF9F0A;">{{ $pendingCount + $ipCount }}</div><div class="sp-stat-lbl">Open</div></div>
        <div class="sp-stat"><div class="sp-stat-num" style="color:#30D158;">{{ $doneCount }}</div><div class="sp-stat-lbl">Solved</div></div>
    </div>

    <div class="sp-section-head">
        <div class="sp-section-title">My Doubts</div>
        <div class="sp-live-badge"><span class="sp-live-dot"></span> Live Updates</div>
    </div>

    @if($tickets->isEmpty())
        <div class="sp-empty">
            <div class="sp-empty-icon"><i class="fa-solid fa-inbox"></i></div>
            <p style="font-size:1.05rem;font-weight:800;color:var(--text-primary,#1C1C1E);letter-spacing:-0.025em;margin-bottom:8px;">No doubts yet</p>
            <p style="font-size:0.82rem;color:rgba(60,60,67,0.55);margin-bottom:24px;">Ask your first question!</p>
            <button class="sp-ask-btn" onclick="toggleAskForm()" style="background:linear-gradient(135deg,#30D158,#25A244);border:none;padding:14px 28px;font-size:0.9rem;">
                <i class="fa-solid fa-paper-plane"></i> Ask Your First Doubt
            </button>
        </div>
    @else
        <div id="ticketContainer">
            @foreach($tickets as $ticket)
            @php $step = $ticket->status_step; @endphp
            <div class="sp-ticket is-{{ $ticket->status }}" id="sp-ticket-{{ $ticket->id }}" data-status="{{ $ticket->status }}">
                <div class="sp-ticket-top">
                    <div class="sp-ticket-header">
                        <div class="sp-ticket-subject">{{ $ticket->subject }}</div>
                        <span class="sp-pill sp-pill-{{ $ticket->status }}">
                            <span class="sp-pulse {{ $ticket->status }}"></span>
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                    <div class="sp-ticket-question">{{ Str::limit($ticket->question, 200) }}</div>
                    <div class="sp-timeline">
                        <div class="sp-step">
                            <div class="sp-step-dot done"><i class="fa-solid fa-check" style="font-size:0.7rem;"></i></div>
                            <div class="sp-step-label done-lbl">Submitted</div>
                        </div>
                        <div class="sp-connector {{ $step >= 1 ? ($step >= 2 ? 'done' : 'active') : 'pending' }}"></div>
                        <div class="sp-step">
                            <div class="sp-step-dot {{ $step >= 2 ? 'done' : ($step >= 1 ? 'active' : 'pending') }}">
                                <i class="fa-solid fa-hourglass-half" style="font-size:0.7rem;"></i>
                            </div>
                            <div class="sp-step-label {{ $step >= 2 ? 'done-lbl' : ($step >= 1 ? 'active-lbl' : '') }}">In Progress</div>
                        </div>
                        <div class="sp-connector {{ $step >= 2 ? 'done' : 'pending' }}"></div>
                        <div class="sp-step">
                            <div class="sp-step-dot {{ $step >= 2 ? 'done' : 'pending' }}">
                                <i class="fa-solid fa-check-circle" style="font-size:0.7rem;"></i>
                            </div>
                            <div class="sp-step-label {{ $step >= 2 ? 'done-lbl' : '' }}">Solved</div>
                        </div>
                    </div>
                </div>
                {{-- ── Chat Thread ── --}}
                @php $msgs = $ticket->messages ?? collect(); @endphp
                <div class="sp-chat-log" id="sp-log-{{ $ticket->id }}">
                    @foreach($msgs as $msg)
                        @if($msg->sender_role === 'admin')
                            <div class="sp-chat-admin-wrap sp-chat-msg" data-msg-id="{{ $msg->id }}">
                                <div class="sp-chat-admin-av"><i class="fa-solid fa-shield-halved"></i></div>
                                <div class="sp-chat-admin-bubble">
                                    <div class="sp-chat-admin-lbl">Support Team</div>
                                    {{ $msg->body }}
                                    <div class="sp-chat-time"><i class="fa-regular fa-clock"></i> {{ $msg->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @else
                            <div class="sp-chat-user-wrap sp-chat-msg" data-msg-id="{{ $msg->id }}">
                                <div class="sp-chat-user-bubble">
                                    <div class="sp-chat-user-lbl">You replied</div>
                                    {{ $msg->body }}
                                    <div class="sp-chat-time" style="color:rgba(255,255,255,0.65)"><i class="fa-regular fa-clock"></i> {{ $msg->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @if($msgs->isEmpty() && $ticket->admin_reply)
                        <div class="sp-chat-admin-wrap">
                            <div class="sp-chat-admin-av"><i class="fa-solid fa-shield-halved"></i></div>
                            <div class="sp-chat-admin-bubble">
                                <div class="sp-chat-admin-lbl">Support Team</div>
                                {{ $ticket->admin_reply }}
                                <div class="sp-chat-time"><i class="fa-regular fa-clock"></i> {{ $ticket->replied_at?->diffForHumans() ?? '' }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- ── User Reply Input (only if chat enabled by admin AND ticket open) ── --}}
                @if($chatEnabled && $ticket->status !== 'solved')
                    <div class="sp-user-reply-bar" id="sp-reply-bar-{{ $ticket->id }}">
                        <div class="sp-user-reply-label"><i class="fa-solid fa-reply"></i> Reply to Support</div>
                        <div class="sp-user-reply-row">
                            <textarea class="sp-user-reply-textarea" id="sp-reply-text-{{ $ticket->id }}" placeholder="Type your follow-up message… Ctrl+Enter to send" rows="3"></textarea>
                            <button class="sp-user-reply-btn" id="sp-reply-btn-{{ $ticket->id }}" onclick="userSendMessage({{ $ticket->id }})">
                                <i class="fa-solid fa-paper-plane"></i> Send
                            </button>
                        </div>
                    </div>
                @elseif($ticket->status !== 'solved')
                    <div class="sp-chat-offline-banner" id="sp-offline-bar-{{ $ticket->id }}" style="border-top:1px solid rgba(60,60,67,0.07);padding:14px 22px;background:rgba(255,159,10,0.04);display:flex;align-items:center;gap:10px;">
                        <i class="fa-solid fa-comment-slash" style="color:#FF9F0A;font-size:1rem;"></i>
                        <span style="font-size:0.82rem;font-weight:600;color:#FF9F0A;">Chat is currently offline.</span>
                        <span style="font-size:0.75rem;color:rgba(60,60,67,0.5);">Our support team will review your doubts and reply when chat is enabled.</span>
                    </div>
                @endif
                @if($ticket->status === 'solved')
                    <div class="sp-solved-banner"><i class="fa-solid fa-circle-check" style="font-size:1rem;"></i><span>This doubt has been resolved!</span></div>
                @endif
                <div class="sp-ticket-footer">
                    <span class="sp-ticket-id">#{{ $ticket->id }}</span>
                    <span style="color:rgba(60,60,67,0.2);font-size:0.7rem;">•</span>
                    <span class="sp-ticket-footer-time"><i class="fa-regular fa-clock" style="margin-right:3px;"></i>{{ $ticket->created_at->diffForHumans() }}</span>
                    @if($ticket->messages?->count() > 0)
                        <span style="font-size:0.65rem;color:#30D158;font-weight:600;"><i class="fa-solid fa-comments" style="margin-right:3px;"></i>{{ $ticket->messages->count() }} message{{ $ticket->messages->count() > 1 ? 's' : '' }}</span>
                    @elseif(!$ticket->admin_reply)
                        <span style="margin-left:auto;font-size:0.65rem;color:rgba(60,60,67,0.45);"><i class="fa-solid fa-hourglass" style="margin-right:3px;"></i>Awaiting reply</span>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<script>
const CSRF_TKN = '{{ csrf_token() }}';
const lastMsgIds = {};
let CHAT_ENABLED_GLOBAL = {{ $chatEnabled ? 'true' : 'false' }};

let askFormOpen = false;
function toggleAskForm() {
    askFormOpen = !askFormOpen;
    const form = document.getElementById('askForm');
    const icon = document.getElementById('askBtnIcon');
    const txt  = document.getElementById('askBtnText');
    form.classList.toggle('open', askFormOpen);
    if (icon) icon.className = askFormOpen ? 'fa-solid fa-xmark' : 'fa-solid fa-plus';
    if (txt)  txt.textContent = askFormOpen ? 'Close Form' : 'Ask a New Doubt';
    if (askFormOpen) form.scrollIntoView({ behavior:'smooth', block:'start' });
}
function submitDoubt(event) {
    event.preventDefault();
    const subject  = document.getElementById('doubSubject').value.trim();
    const question = document.getElementById('doubQuestion').value.trim();
    const btn      = document.getElementById('submitBtn');
    if (!subject || !question) return;
    btn.disabled = true;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Submitting...';
    fetch('/support/tickets', {
        method: 'POST',
        headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TKN,'Accept':'application/json' },
        body: JSON.stringify({ subject, question }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('formContent').style.display = 'none';
            document.getElementById('formSuccess').style.display = 'block';
        } else { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit Doubt'; }
    })
    .catch(() => { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit Doubt'; });
}
function userSendMessage(ticketId) {
    if (!CHAT_ENABLED_GLOBAL) { return; }
    const textarea = document.getElementById('sp-reply-text-' + ticketId);
    const btn      = document.getElementById('sp-reply-btn-' + ticketId);
    const text     = textarea?.value?.trim();
    if (!text) return;
    btn.disabled = true; btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
    fetch('/support/tickets/' + ticketId + '/message', {
        method: 'POST',
        headers: { 'Content-Type':'application/json','X-CSRF-TOKEN':CSRF_TKN,'Accept':'application/json' },
        body: JSON.stringify({ body: text }),
    })
    .then(r => {
        if (r.status === 403) {
            CHAT_ENABLED_GLOBAL = false;
            hideAllReplyBars();
            return { success: false };
        }
        return r.json();
    })
    .then(data => { if (data.success) { textarea.value = ''; appendUserBubble(ticketId, data.message); } })
    .catch(() => {})
    .finally(() => { btn.disabled = false; btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Send'; });
}
function hideAllReplyBars() {
    document.querySelectorAll('.sp-user-reply-bar').forEach(bar => { bar.style.display = 'none'; });
    document.querySelectorAll('.sp-chat-offline-banner').forEach(b => { b.style.display = 'flex'; });
}
function ensureChatLog(id) {
    let log = document.getElementById('sp-log-' + id);
    if (!log) {
        const ticket = document.getElementById('sp-ticket-' + id);
        const bar = document.getElementById('sp-reply-bar-' + id);
        log = document.createElement('div'); log.className = 'sp-chat-log'; log.id = 'sp-log-' + id;
        if (bar) ticket.insertBefore(log, bar); else ticket.appendChild(log);
    }
    return log;
}
function appendUserBubble(id, msg) {
    const log = ensureChatLog(id);
    const w = document.createElement('div');
    w.className = 'sp-chat-user-wrap sp-chat-msg sp-chat-bubble-new'; w.dataset.msgId = msg.id || 0;
    w.innerHTML = `<div class="sp-chat-user-bubble"><div class="sp-chat-user-lbl">You replied</div>${escH(msg.body)}<div class="sp-chat-time" style="color:rgba(255,255,255,0.65)"><i class="fa-regular fa-clock"></i> Just now</div></div>`;
    log.appendChild(w); log.scrollTop = log.scrollHeight;
    lastMsgIds[id] = Math.max(lastMsgIds[id] || 0, msg.id || 0);
}
function appendAdminBubble(id, msg) {
    const log = ensureChatLog(id);
    const w = document.createElement('div');
    w.className = 'sp-chat-admin-wrap sp-chat-msg sp-chat-bubble-new'; w.dataset.msgId = msg.id || 0;
    w.innerHTML = `<div class="sp-chat-admin-av"><i class="fa-solid fa-shield-halved"></i></div><div class="sp-chat-admin-bubble"><div class="sp-chat-admin-lbl">Support Team</div>${escH(msg.body)}<div class="sp-chat-time"><i class="fa-regular fa-clock"></i> ${msg.time_human || 'Just now'}</div></div>`;
    log.appendChild(w); log.scrollTop = log.scrollHeight;
    lastMsgIds[id] = Math.max(lastMsgIds[id] || 0, msg.id || 0);
}
function escH(str) { const d = document.createElement('div'); d.textContent = str; return d.innerHTML; }
document.addEventListener('keydown', e => {
    if (e.ctrlKey && e.key === 'Enter' && document.activeElement?.classList.contains('sp-user-reply-textarea')) {
        const id = document.activeElement.id.replace('sp-reply-text-', '');
        userSendMessage(parseInt(id));
    }
});
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.sp-chat-msg').forEach(el => {
        const ticketEl = el.closest('[id^="sp-ticket-"]');
        if (!ticketEl) return;
        const tId = parseInt(ticketEl.id.replace('sp-ticket-', ''));
        lastMsgIds[tId] = Math.max(lastMsgIds[tId] || 0, parseInt(el.dataset.msgId || 0));
    });
    setInterval(() => {
        const ticketEls = document.querySelectorAll('[id^="sp-ticket-"]');
        ticketEls.forEach(ticketEl => {
            const tId = parseInt(ticketEl.id.replace('sp-ticket-', ''));
            if (!tId || ticketEl.dataset.status === 'solved') return;
            fetch('/support/tickets/' + tId + '/messages', {
                headers: { 'Accept':'application/json', 'X-CSRF-TOKEN': CSRF_TKN }
            })
            .then(r => r.json())
            .then(data => {
                if (!data.messages) return;
                // React to admin toggling chat on/off mid-session
                if (typeof data.chat_enabled_global !== 'undefined') {
                    const wasEnabled = CHAT_ENABLED_GLOBAL;
                    CHAT_ENABLED_GLOBAL = data.chat_enabled_global;
                    if (!wasEnabled && CHAT_ENABLED_GLOBAL) {
                        window.location.reload();
                        return;
                    } else if (wasEnabled && !CHAT_ENABLED_GLOBAL) {
                        hideAllReplyBars();
                    }
                }
                const known = lastMsgIds[tId] || 0;
                data.messages.forEach(msg => {
                    if (msg.id > known) {
                        const ex = document.querySelector(`#sp-log-${tId} [data-msg-id="${msg.id}"]`);
                        if (!ex) {
                            if (msg.sender_role === 'admin') {
                                appendAdminBubble(tId, msg);
                                const card = document.getElementById('sp-ticket-' + tId);
                                if (card) { card.style.borderColor='#30D158'; card.style.boxShadow='0 0 0 3px rgba(52,199,89,0.15)'; setTimeout(()=>{card.style.borderColor='';card.style.boxShadow='';},3000); }
                            } else { appendUserBubble(tId, msg); }
                        }
                        lastMsgIds[tId] = Math.max(lastMsgIds[tId] || 0, msg.id);
                    }
                });
            }).catch(() => {});
        });
    }, 8000);
});
</script>
@endsection
