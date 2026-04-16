@extends('layouts.student')

@section('title', 'Messages — ' . $subject->name)

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap');

    .broadcast-wrap { font-family: 'Inter', sans-serif; }

    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes unreadPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(99,102,241,0.2); }
        50%       { box-shadow: 0 0 0 8px rgba(99,102,241,0); }
    }

    .animate-in { animation: fadeSlideUp 0.55s cubic-bezier(0.16,1,0.3,1) both; }
    .delay-1    { animation-delay: 80ms; }
    .delay-2    { animation-delay: 160ms; }

    .msg-card { animation: fadeSlideUp 0.4s cubic-bezier(0.16,1,0.3,1) both; transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .msg-card:hover { transform: translateY(-2px); box-shadow: 0 8px 28px -6px rgba(0,0,0,0.07); }

    .unread-card { animation: unreadPulse 2s ease-in-out 3; }
    .important-glow { box-shadow: 0 0 0 2px rgba(245,158,11,0.25), 0 4px 16px rgba(245,158,11,0.08); }

    .seen-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; }
    .seen-dot.unseen  { background: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,0.15); }
    .seen-dot.seen    { background: #22c55e; }

    .unread-stripe { border-left: 3px solid #6366f1; }
    .read-stripe   { border-left: 3px solid transparent; }
</style>

<div class="broadcast-wrap min-h-screen bg-[#FDFBF7] p-4 sm:p-6 lg:p-8">
    <div class="max-w-6xl mx-auto">

        {{-- ── Breadcrumb ── --}}
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-6 animate-in">
            <a href="{{ route('student.dashboard') }}" class="hover:text-indigo-600 transition-colors font-medium">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-800 font-semibold">{{ $subject->name }} — Messages</span>
        </div>

        <div class="flex flex-col lg:flex-row gap-6">

            {{-- ── Subject Switcher Sidebar ── --}}
            <aside class="lg:w-72 flex-shrink-0">
                <div class="bg-white rounded-2xl border border-[#F0EBE1] shadow-sm overflow-hidden sticky top-6">
                    <div class="px-5 py-4 border-b border-[#F0EBE1] bg-[#FDFBF7]">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5">My Course</p>
                        <h3 class="font-bold text-slate-800 text-sm">Switch Subject</h3>
                    </div>
                    <nav class="divide-y divide-slate-50">
                        @foreach($courseSubjects as $cs)
                            @php
                                $msgCount = \App\Models\BroadcastMessage::where('subject_id', $cs->id)->count();
                                $readCount = \App\Models\MessageRead::where('student_id', $student->id)
                                    ->whereHas('message', fn($q) => $q->where('subject_id', $cs->id))
                                    ->where('seen', true)->count();
                                $unread = max(0, $msgCount - $readCount);
                                $isActive = $cs->id === $subject->id;
                            @endphp
                            <a href="{{ route('student.broadcast.index', $cs->id) }}"
                               class="flex items-center gap-3 px-4 py-3.5 transition-colors group
                               {{ $isActive ? 'bg-indigo-50 border-l-[3px] border-indigo-500' : 'hover:bg-slate-50 border-l-[3px] border-transparent' }}">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-black flex-shrink-0 transition-all
                                    {{ $isActive ? 'bg-indigo-600 text-white shadow-sm' : 'bg-slate-100 text-slate-500 group-hover:bg-indigo-100 group-hover:text-indigo-600' }}">
                                    {{ strtoupper(substr($cs->name, 0, 2)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold truncate {{ $isActive ? 'text-indigo-700' : 'text-slate-700' }}">{{ $cs->name }}</p>
                                    <p class="text-[10px] text-slate-400 mt-0.5">{{ $msgCount }} announcement{{ $msgCount != 1 ? 's' : '' }}</p>
                                </div>
                                @if($unread > 0)
                                    <span class="flex-shrink-0 min-w-[20px] h-5 px-1.5 text-[9px] font-black text-white bg-indigo-600 rounded-full flex items-center justify-center shadow-sm">
                                        {{ $unread }}
                                    </span>
                                @elseif($msgCount > 0)
                                    <span class="text-emerald-400 text-xs flex-shrink-0">✓</span>
                                @endif
                            </a>
                        @endforeach
                    </nav>
                </div>
            </aside>

            {{-- ── Main Message Feed ── --}}
            <div class="flex-1 min-w-0">

                {{-- Page Header --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-4 animate-in delay-1">
                    <div>
                        <p class="text-indigo-600 font-semibold tracking-wider uppercase text-xs mb-1 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            Subject Announcements
                        </p>
                        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $subject->name }}</h1>
                        <p class="text-slate-500 text-sm mt-1">Teacher announcements are displayed here. You can read but not reply.</p>
                    </div>
                    <div class="flex items-center gap-3 flex-shrink-0">
                        <div class="bg-white border border-[#F0EBE1] px-4 py-2 rounded-xl text-sm font-semibold text-slate-700 flex items-center gap-2 shadow-sm">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                            {{ $messages->count() }} message{{ $messages->count() != 1 ? 's' : '' }}
                        </div>
                    </div>
                </div>

                {{-- Read-only notice --}}
                <div class="animate-in delay-2 mb-6 px-4 py-3 bg-indigo-50 border border-indigo-100 rounded-xl text-indigo-700 text-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span><strong>Read-only channel.</strong> Only teachers can post announcements here.</span>
                </div>

                {{-- Message Feed --}}
                <div class="space-y-4">
                    @forelse($messages as $i => $msg)
                        @php
                            $wasSeen   = $readMap[$msg->id] ?? false;
                            $important = $msg->is_important;
                        @endphp

                        <div class="msg-card bg-white rounded-2xl border
                            {{ $important ? 'border-amber-200 important-glow' : 'border-[#F0EBE1]' }}
                            {{ $wasSeen ? 'read-stripe' : 'unread-stripe' }}
                            p-5 relative overflow-hidden"
                            style="animation-delay: {{ $i * 60 }}ms"
                            data-msg-id="{{ $msg->id }}"
                        >

                            {{-- Unread glow overlay --}}
                            @if(!$wasSeen)
                                <div class="absolute inset-0 bg-gradient-to-r from-indigo-50/40 to-transparent pointer-events-none rounded-2xl"></div>
                            @endif

                            {{-- Important badge --}}
                            @if($important)
                                <div class="absolute top-4 right-4 flex items-center gap-1 bg-amber-50 text-amber-600 text-[10px] font-bold px-2.5 py-1 rounded-full border border-amber-200 z-10">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    IMPORTANT
                                </div>
                            @endif

                            <div class="flex items-start gap-3 {{ $important ? 'pr-28' : 'pr-4' }} relative z-10">
                                {{-- Teacher Avatar --}}
                                <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-indigo-500 to-violet-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0 shadow-sm">
                                    {{ strtoupper(substr($msg->teacher->user->name ?? 'T', 0, 1)) }}
                                </div>

                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2 flex-wrap mb-0.5">
                                        <span class="text-sm font-bold text-slate-900">{{ $msg->teacher->user->name ?? 'Teacher' }}</span>
                                        <span class="text-[10px] text-slate-400 font-medium bg-slate-50 px-2 py-0.5 rounded-full border border-slate-100">Teacher</span>
                                        <span class="text-[10px] text-slate-400">{{ $msg->created_at->diffForHumans() }}</span>
                                    </div>

                                    <p class="text-slate-700 text-sm mt-2 leading-relaxed whitespace-pre-wrap">{{ $msg->message }}</p>

                                    {{-- Footer --}}
                                    <div class="mt-3.5 flex items-center gap-4 text-xs">
                                        <span class="text-slate-400">{{ $msg->created_at->format('d M Y, h:i A') }}</span>

                                        {{-- Seen indicator --}}
                                        <span class="flex items-center gap-1.5 {{ $wasSeen ? 'text-emerald-600' : 'text-indigo-500' }}">
                                            <span class="seen-dot {{ $wasSeen ? 'seen' : 'unseen' }}"></span>
                                            @if($wasSeen)
                                                <span class="font-medium">Read</span>
                                            @else
                                                <span class="font-semibold">New</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-24 bg-white rounded-2xl border border-dashed border-[#E8E0D5]">
                            <div class="w-20 h-20 bg-[#FDFBF7] rounded-full flex items-center justify-center mx-auto mb-5 border border-[#F0EBE1]">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">No Announcements Yet</h3>
                            <p class="text-slate-500 text-sm max-w-sm mx-auto">Your teacher hasn't posted any announcements for <strong>{{ $subject->name }}</strong> yet. Check back later.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Back Button --}}
                <div class="mt-8 animate-in delay-2">
                    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 text-slate-600 hover:text-indigo-600 font-semibold text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Back to Dashboard
                    </a>
                </div>

            </div>{{-- end main feed --}}
        </div>{{-- end flex row --}}

    </div>
</div>



<script>
// Polling: update unread badge in nav every 5 seconds
function pollUnread() {
    fetch('{{ route("student.broadcast.unread") }}', {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(data => {
        const badge = document.getElementById('unread-broadcast-badge');
        if (badge) {
            badge.textContent = data.count;
            badge.style.display = data.count > 0 ? 'flex' : 'none';
        }
    })
    .catch(() => {});
}
setInterval(pollUnread, 5000);
</script>

@endsection
