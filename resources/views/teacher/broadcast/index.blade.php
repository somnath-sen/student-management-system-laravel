@extends('layouts.teacher')

@section('title', 'Broadcast — ' . $subject->name)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .broadcast-wrap { font-family: 'Inter', sans-serif; }

    /* Animations */
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes pulseGlow {
        0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0); }
        50%       { box-shadow: 0 0 0 6px rgba(99,102,241,0.12); }
    }
    .animate-in      { animation: fadeSlideUp 0.55s cubic-bezier(0.16,1,0.3,1) both; }
    .delay-1         { animation-delay: 80ms; }
    .delay-2         { animation-delay: 160ms; }
    .delay-3         { animation-delay: 240ms; }
    .card-hover      { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .card-hover:hover{ transform: translateY(-3px); box-shadow: 0 12px 28px -6px rgba(0,0,0,0.08); }
    .send-btn        { transition: all 0.2s ease; }
    .send-btn:hover  { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(99,102,241,0.35); }
    .send-btn:active { transform: translateY(0); }
    .msg-card        { animation: fadeSlideUp 0.4s cubic-bezier(0.16,1,0.3,1) both; }
    .important-glow  { box-shadow: 0 0 0 2px rgba(245,158,11,0.25), 0 4px 16px rgba(245,158,11,0.1); }
    .delete-btn      { opacity: 0; transition: opacity 0.2s ease; }
    .msg-card:hover .delete-btn { opacity: 1; }
    .char-count      { transition: color 0.2s ease; }
    .textarea-focus  { transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    .textarea-focus:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); outline: none; }

    /* ── Success Toast ── */
    #successToast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        min-width: 320px;
        max-width: 400px;
        background: #ffffff;
        border: 1px solid #d1fae5;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: flex-start;
        gap: 14px;
        box-shadow: 0 20px 60px -10px rgba(16,185,129,0.25), 0 8px 20px -6px rgba(0,0,0,0.08);
        transform: translateX(calc(100% + 32px));
        opacity: 0;
        transition: transform 0.45s cubic-bezier(0.16,1,0.3,1), opacity 0.45s ease;
        pointer-events: none;
    }
    #successToast.show {
        transform: translateX(0);
        opacity: 1;
        pointer-events: auto;
    }
    #successToast.hide {
        transform: translateX(calc(100% + 32px));
        opacity: 0;
        pointer-events: none;
    }
    .toast-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(16,185,129,0.35);
    }
    .toast-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #10b981, #6366f1);
        border-radius: 0 0 16px 16px;
        width: 100%;
        transform-origin: left;
        animation: none;
    }
    .toast-progress.running {
        animation: shrink 3.5s linear forwards;
    }
    @keyframes shrink {
        from { transform: scaleX(1); }
        to   { transform: scaleX(0); }
    }
</style>

<div class="broadcast-wrap min-h-screen bg-[#FDFBF7] p-4 sm:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto">

        {{-- ── Breadcrumb ── --}}
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-6 animate-in">
            <a href="{{ route('teacher.dashboard') }}" class="hover:text-indigo-600 transition-colors font-medium">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-semibold">{{ $subject->name }} — Broadcast</span>
        </div>

        {{-- ── Page Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 gap-4 animate-in delay-1">
            <div>
                <p class="text-indigo-600 font-semibold tracking-wider uppercase text-xs mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                    Broadcast Panel
                </p>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $subject->name }}</h1>
                <p class="text-slate-500 text-sm mt-1">Send announcements to <span class="font-semibold text-slate-700">{{ $totalStudents }} student{{ $totalStudents != 1 ? 's' : '' }}</span> enrolled in this subject.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white border border-[#F0EBE1] px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 flex items-center gap-2 shadow-sm">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 inline-block"></span>
                    {{ $messages->count() }} message{{ $messages->count() != 1 ? 's' : '' }} sent
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

            {{-- ── LEFT: Compose Panel ── --}}
            <div class="lg:col-span-2 animate-in delay-2">
                <div class="bg-white rounded-2xl border border-[#F0EBE1] shadow-sm overflow-hidden sticky top-6">
                    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-6 py-4">
                        <h2 class="text-white font-bold text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            New Announcement
                        </h2>
                        <p class="text-indigo-100 text-xs mt-0.5">Broadcast to all enrolled students</p>
                    </div>

                    <div class="p-6">
                        @if(session('success'))
                            <div class="mb-4 px-4 py-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                {{ session('success') }}
                            </div>
                        @endif

                        <form id="broadcastForm" action="{{ route('teacher.broadcast.store', $subject->id) }}" method="POST">
                            @csrf

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Message</label>
                                <textarea
                                    id="messageInput"
                                    name="message"
                                    rows="6"
                                    maxlength="2000"
                                    placeholder="Type your announcement here..."
                                    class="textarea-focus w-full bg-[#FDFBF7] border border-[#E8E0D5] rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 resize-none leading-relaxed"
                                    required
                                ></textarea>
                                <div class="mt-1.5 flex justify-end">
                                    <span id="charCount" class="char-count text-xs text-slate-400">0 / 2000</span>
                                </div>
                                @error('message')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- Important toggle --}}
                            <label class="flex items-center gap-3 mb-5 cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" id="isImportant" name="is_important" value="1" class="sr-only peer">
                                    <div class="w-10 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:bg-amber-500 transition-colors duration-200"></div>
                                    <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform duration-200 peer-checked:translate-x-4 shadow-sm"></div>
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-slate-700 group-hover:text-amber-600 transition-colors">Mark as Important</span>
                                    <p class="text-xs text-slate-400">Displays an urgent badge on the message</p>
                                </div>
                            </label>

                            <button type="submit" id="sendBtn" class="send-btn w-full bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold py-3 px-6 rounded-xl flex items-center justify-center gap-2.5">
                                <svg id="sendIcon" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                                <span id="sendText">Send Broadcast</span>
                            </button>
                        </form>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="border-t border-[#F0EBE1] px-6 py-4 bg-[#FDFBF7] grid grid-cols-2 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-extrabold text-indigo-600">{{ $totalStudents }}</p>
                            <p class="text-xs text-slate-500 font-medium">Students</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-extrabold text-violet-600">{{ $messages->count() }}</p>
                            <p class="text-xs text-slate-500 font-medium">Broadcasts</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── RIGHT: Message History ── --}}
            <div class="lg:col-span-3 animate-in delay-3">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        Broadcast History
                    </h2>
                    <span class="text-xs font-medium text-slate-500 bg-white border border-[#F0EBE1] px-3 py-1.5 rounded-lg">Auto-refreshes every 5s</span>
                </div>

                <div id="messageList" class="space-y-4">
                    @forelse($messages as $msg)
                        <div class="msg-card bg-white rounded-2xl border {{ $msg->is_important ? 'border-amber-200 important-glow' : 'border-[#F0EBE1]' }} p-5 relative" data-message-id="{{ $msg->id }}">

                            {{-- Important badge --}}
                            @if($msg->is_important)
                                <div class="absolute top-4 right-4 flex items-center gap-1 bg-amber-50 text-amber-600 text-[10px] font-bold px-2 py-1 rounded-full border border-amber-200">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    IMPORTANT
                                </div>
                            @endif

                            {{-- Delete button --}}
                            <form action="{{ route('teacher.broadcast.destroy', $msg->id) }}" method="POST" class="delete-btn absolute bottom-4 right-4" data-confirm="Recall this message? Students will no longer see it.">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-colors" title="Recall Message">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>

                            {{-- Teacher Avatar + Info --}}
                            <div class="flex items-start gap-3 {{ $msg->is_important ? 'pr-24' : 'pr-10' }}">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                    {{ strtoupper(substr($msg->teacher->user->name ?? 'T', 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <span class="text-sm font-bold text-slate-900">{{ $msg->teacher->user->name ?? 'Teacher' }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-700 text-sm mt-2 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>
                                </div>
                            </div>

                            {{-- Footer stats --}}
                            <div class="mt-4 pt-3 border-t border-[#F5F0E8] flex items-center gap-4 text-xs text-slate-400">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <span class="seen-count font-semibold text-slate-600">{{ $msg->seenCount() }}</span> / {{ $totalStudents }} seen
                                </span>
                                <span>{{ $msg->created_at->format('d M Y, h:i A') }}</span>
                            </div>
                        </div>
                    @empty
                        <div id="emptyState" class="text-center py-20 bg-white rounded-2xl border border-dashed border-[#E8E0D5]">
                            <div class="w-16 h-16 bg-[#FDFBF7] rounded-full flex items-center justify-center mx-auto mb-4 border border-[#F0EBE1]">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                            </div>
                            <h3 class="text-lg font-bold text-slate-800 mb-1">No broadcasts yet</h3>
                            <p class="text-sm text-slate-500">Send your first announcement to all students in <span class="font-semibold">{{ $subject->name }}</span>.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>

{{-- ── Success Toast Popup ── --}}
<div id="successToast" role="alert" aria-live="polite">
    <div class="toast-icon">
        <svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-bold text-slate-900" id="toastTitle">Broadcast Sent!</p>
        <p class="text-xs text-slate-500 mt-0.5" id="toastSubtitle">Your announcement has been delivered to all students.</p>
    </div>
    <button onclick="hideToast()" class="self-start p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors flex-shrink-0" aria-label="Close">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
    </button>
    <div class="toast-progress" id="toastProgress"></div>
</div>

<script>
// ── Character counter ──────────────────────────────────────────────────────────
const input     = document.getElementById('messageInput');
const counter   = document.getElementById('charCount');
const MAX       = 2000;

input.addEventListener('input', () => {
    const len = input.value.length;
    counter.textContent = `${len} / ${MAX}`;
    counter.style.color = len > MAX * 0.85 ? (len >= MAX ? '#ef4444' : '#f59e0b') : '#94a3b8';
});

// ── AJAX Form Submit ───────────────────────────────────────────────────────────
const form    = document.getElementById('broadcastForm');
const sendBtn = document.getElementById('sendBtn');
const sendTxt = document.getElementById('sendText');
const msgList = document.getElementById('messageList');
const empty   = document.getElementById('emptyState');

form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const msg       = input.value.trim();
    const important = document.getElementById('isImportant').checked;

    if (!msg) { input.focus(); return; }

    sendBtn.disabled = true;
    sendTxt.textContent = 'Sending…';

    const formData = new FormData(form);

    try {
        const res  = await fetch(form.action, {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
            body   : formData,
        });
        const data = await res.json();

        if (data.success) {
            // Remove empty state if visible
            if (empty) empty.remove();

            // Prepend new message card
            const card = buildCard(data);
            msgList.insertAdjacentHTML('afterbegin', card);

            // Reset form
            input.value = '';
            counter.textContent = '0 / 2000';
            document.getElementById('isImportant').checked = false;

            // ✅ Show success toast
            const subtitle = data.message.is_important
                ? `⭐ Marked as Important — delivered to ${data.student_count} student${data.student_count != 1 ? 's' : ''}.`
                : `Delivered to ${data.student_count} student${data.student_count != 1 ? 's' : ''} in {{ $subject->name }}.`;
            showToast('Broadcast Sent!', subtitle);
        }
    } catch(err) {
        showToast('Send Failed', 'Please try again or refresh the page.', true);
    }

    sendBtn.disabled = false;
    sendTxt.textContent = 'Send Broadcast';
});

function buildCard(data) {
    const m = data.message;
    const importantBadge = m.is_important
        ? `<div class="absolute top-4 right-4 flex items-center gap-1 bg-amber-50 text-amber-600 text-[10px] font-bold px-2 py-1 rounded-full border border-amber-200">
               <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
               IMPORTANT
           </div>`
        : '';
    const borderCls = m.is_important ? 'border-amber-200 important-glow' : 'border-[#F0EBE1]';
    const prCls     = m.is_important ? 'pr-24' : 'pr-10';
    const initial   = (data.teacher_name || 'T').charAt(0).toUpperCase();
    const msgText   = m.message.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');

    return `
    <div class="msg-card bg-white rounded-2xl border ${borderCls} p-5 relative" data-message-id="${m.id}">
        ${importantBadge}
        <div class="flex items-start gap-3 ${prCls}">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                ${initial}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="text-sm font-bold text-slate-900">${data.teacher_name}</span>
                    <span class="text-[10px] text-slate-400 font-medium">${data.time}</span>
                </div>
                <p class="text-slate-700 text-sm mt-2 leading-relaxed whitespace-pre-wrap">${msgText}</p>
            </div>
        </div>
        <div class="mt-4 pt-3 border-t border-[#F5F0E8] flex items-center gap-4 text-xs text-slate-400">
            <span class="flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span class="seen-count font-semibold text-slate-600">0</span> / ${data.student_count} seen
            </span>
            <span>Just now</span>
        </div>
    </div>`;
}

// ── Auto Refresh Seen Counts Every 5s ─────────────────────────────────────────
setInterval(async () => {
    const cards = document.querySelectorAll('[data-message-id]');
    for (const card of cards) {
        const id  = card.dataset.messageId;
        try {
            const res  = await fetch(`/teacher/broadcast/message/${id}/seen-count`, { headers: { 'Accept': 'application/json' } });
            if (res.ok) {
                const data = await res.json();
                const sc   = card.querySelector('.seen-count');
                if (sc) sc.textContent = data.count;
            }
        } catch {}
    }
}, 5000);

// ── Toast Helper ──────────────────────────────────────────────────────────────
let toastTimer = null;

function showToast(title, subtitle, isError = false) {
    const toast    = document.getElementById('successToast');
    const icon     = toast.querySelector('.toast-icon');
    const progress = document.getElementById('toastProgress');

    document.getElementById('toastTitle').textContent    = title;
    document.getElementById('toastSubtitle').textContent = subtitle;

    // Error style
    if (isError) {
        toast.style.borderColor = '#fecaca';
        toast.style.boxShadow   = '0 20px 60px -10px rgba(239,68,68,0.25), 0 8px 20px -6px rgba(0,0,0,0.08)';
        icon.style.background   = 'linear-gradient(135deg, #ef4444, #dc2626)';
        icon.innerHTML = `<svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>`;
        progress.style.background = 'linear-gradient(90deg, #ef4444, #f59e0b)';
    } else {
        toast.style.borderColor = '#d1fae5';
        toast.style.boxShadow   = '0 20px 60px -10px rgba(16,185,129,0.25), 0 8px 20px -6px rgba(0,0,0,0.08)';
        icon.style.background   = 'linear-gradient(135deg, #10b981, #059669)';
        icon.innerHTML = `<svg width="20" height="20" fill="none" stroke="white" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>`;
        progress.style.background = 'linear-gradient(90deg, #10b981, #6366f1)';
    }

    // Clear existing timer
    if (toastTimer) { clearTimeout(toastTimer); }

    // Trigger show
    toast.classList.remove('hide');
    toast.classList.add('show');

    // Reset & restart progress bar
    progress.classList.remove('running');
    void progress.offsetWidth; // reflow to restart animation
    progress.classList.add('running');

    // Auto-hide after 3.5s
    toastTimer = setTimeout(hideToast, 3500);
}

function hideToast() {
    const toast    = document.getElementById('successToast');
    const progress = document.getElementById('toastProgress');
    toast.classList.remove('show');
    toast.classList.add('hide');
    progress.classList.remove('running');
    if (toastTimer) { clearTimeout(toastTimer); toastTimer = null; }
}
</script>

@endsection
