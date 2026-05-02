@extends('layouts.admin')

@section('title', 'Telegram Notifications — EdFlow Admin')

@section('content')

<div class="max-w-7xl mx-auto space-y-8">

    {{-- ─── Header ─────────────────────────────────────────────────── --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 animate-content">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl shadow-lg"
                     style="background: linear-gradient(135deg, #2AABEE, #229ED9);">
                    <i class="fa-brands fa-telegram text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Telegram Notifications</h1>
                    <p class="text-slate-500 font-medium text-sm">Manage and monitor real-time Telegram alerts for students & parents.</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            {{-- Global Toggle --}}
            <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-2xl px-5 py-3 shadow-sm">
                <span class="text-sm font-bold text-slate-600">Notifications</span>
                <label class="relative inline-flex items-center cursor-pointer" id="telegram-toggle-label">
                    <input type="checkbox" id="telegram-global-toggle" class="sr-only peer"
                           {{ $telegramEnabled ? 'checked' : '' }}>
                    <div class="w-14 h-7 bg-slate-300 rounded-full peer peer-focus:outline-none
                                peer-checked:after:translate-x-full peer-checked:after:border-white
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:border-slate-300 after:border after:rounded-full
                                after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-500 shadow-inner"></div>
                </label>
                <span id="toggle-status-label" class="text-xs font-black {{ $telegramEnabled ? 'text-blue-600' : 'text-slate-400' }}">
                    {{ $telegramEnabled ? 'ENABLED' : 'DISABLED' }}
                </span>
            </div>
            <a href="{{ route('admin.telegram.logs') }}"
               class="inline-flex items-center gap-2 bg-slate-800 text-white px-5 py-3 rounded-2xl text-sm font-bold shadow hover:bg-slate-700 transition-colors">
                <i class="fa-solid fa-list-check"></i> View All Logs
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-center gap-3 animate-content">
            <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-center gap-3 animate-content">
            <i class="fa-solid fa-circle-xmark text-red-500 text-lg"></i>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ─── Stats Grid ─────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 animate-content">
        {{-- Connected Students --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-11 h-11 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-graduation-cap text-xl"></i>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $connectedStudents }}</p>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Connected Students</p>
            <p class="text-[10px] text-slate-300 mt-1">of {{ $totalStudents }} total</p>
        </div>

        {{-- Connected Parents --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-11 h-11 rounded-2xl bg-violet-50 flex items-center justify-center text-violet-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-users text-xl"></i>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $connectedParents }}</p>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Connected Parents</p>
            <p class="text-[10px] text-slate-300 mt-1">of {{ $totalParents }} total</p>
        </div>

        {{-- Sent Today --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-11 h-11 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-paper-plane text-xl"></i>
            </div>
            <p class="text-3xl font-black text-emerald-600">{{ $sentToday }}</p>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Sent Today</p>
        </div>

        {{-- Failed Today --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="w-11 h-11 rounded-2xl bg-red-50 flex items-center justify-center text-red-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <p class="text-3xl font-black text-red-500">{{ $failedToday }}</p>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Failed Today</p>
        </div>

        {{-- Total Sent --}}
        <div class="bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow group col-span-2 md:col-span-1">
            <div class="w-11 h-11 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 mb-4 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-chart-bar text-xl"></i>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ $totalSent }}</p>
            <p class="text-xs font-bold text-slate-400 mt-1 uppercase tracking-wide">Total Delivered</p>
        </div>
    </div>

    {{-- ─── Two-column: Broadcast + Test Message ───────────────────────── --}}
    <div class="grid md:grid-cols-2 gap-6 animate-content" style="animation-delay:0.1s">

        {{-- Broadcast Form --}}
        <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-7 border-b border-slate-50 flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-500">
                    <i class="fa-solid fa-bullhorn"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Broadcast Message</h2>
                    <p class="text-xs text-slate-400 font-medium">Send to all connected students, parents, or everyone.</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.telegram.broadcast') }}" class="p-7 space-y-5">
                @csrf
                <div>
                    <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">Target Audience</label>
                    <div class="grid grid-cols-3 gap-2">
                        @foreach(['students' => ['🎓', 'Students'], 'parents' => ['👨‍👩‍👧', 'Parents'], 'all' => ['📡', 'Everyone']] as $value => $opts)
                        <label class="cursor-pointer">
                            <input type="radio" name="target" value="{{ $value }}" class="sr-only peer" {{ $value === 'students' ? 'checked' : '' }}>
                            <div class="text-center p-3 rounded-xl border-2 border-slate-100 peer-checked:border-blue-400 peer-checked:bg-blue-50 transition-all text-sm font-bold text-slate-500 peer-checked:text-blue-600 hover:border-blue-200">
                                <div class="text-lg mb-1">{{ $opts[0] }}</div>
                                {{ $opts[1] }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">Message</label>
                    <textarea name="message" rows="5" required maxlength="4000"
                              placeholder="Type your broadcast message here... (Markdown supported)"
                              class="w-full rounded-2xl border border-slate-200 p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-blue-400 focus:border-transparent outline-none resize-none transition-all bg-slate-50 focus:bg-white"></textarea>
                    <p class="text-[10px] text-slate-400 mt-1">Supports: *bold*, _italic_, [link](url)</p>
                </div>
                <button type="submit"
                        class="w-full py-3.5 rounded-2xl font-black text-sm text-white shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-95 transition-all"
                        style="background: linear-gradient(135deg, #2AABEE, #229ED9);">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Send Broadcast
                </button>
            </form>
        </div>

        {{-- Test Message + Event Types --}}
        <div class="space-y-5">
            {{-- Test Message Form --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="p-7 border-b border-slate-50 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <i class="fa-solid fa-flask-vial"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-black text-slate-800">Test Message</h2>
                        <p class="text-xs text-slate-400 font-medium">Send a test alert to any chat ID.</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.telegram.test') }}" class="p-7 space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">Telegram Chat ID</label>
                        <input type="text" name="chat_id" required placeholder="e.g. 1234567890"
                               class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-400 focus:border-transparent outline-none transition-all bg-slate-50 focus:bg-white">
                        <p class="text-[10px] text-slate-400 mt-1">User can find their chat ID by messaging @userinfobot on Telegram.</p>
                    </div>
                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">Custom Message (optional)</label>
                        <textarea name="message" rows="3" maxlength="4000"
                                  placeholder="Leave blank for default test message..."
                                  class="w-full rounded-2xl border border-slate-200 p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-400 focus:border-transparent outline-none resize-none transition-all bg-slate-50 focus:bg-white"></textarea>
                    </div>
                    <button type="submit"
                            class="w-full py-3 rounded-2xl font-black text-sm text-white shadow hover:shadow-lg hover:-translate-y-0.5 active:scale-95 transition-all bg-emerald-500 hover:bg-emerald-600">
                        <i class="fa-solid fa-satellite-dish mr-2"></i> Send Test Message
                    </button>
                </form>
            </div>

            {{-- Notification Event Quick Reference --}}
            <div class="bg-white rounded-3xl border border-slate-100 shadow-sm p-6">
                <h3 class="text-sm font-black text-slate-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-amber-500"></i> Auto-Trigger Events
                </h3>
                <div class="space-y-2">
                    @foreach([
                        ['📊', 'Attendance Marked', 'Sent to student + parents when attendance is recorded', 'blue'],
                        ['⚠️', 'Low Attendance (<75%)', 'Triggered on marking & daily at 9:00 AM', 'amber'],
                        ['🎉', 'Result Published', 'Sent when admin publishes results for a course', 'violet'],
                        ['💰', 'Fee Added/Due', 'Sent on new fee creation + daily reminders', 'emerald'],
                        ['📢', 'Admin Notice', 'Sent to all when a new notice is posted', 'rose'],
                        ['🚨', 'Emergency SOS', 'Instant alert to parents when student triggers SOS', 'red'],
                    ] as [$icon, $label, $desc, $color])
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 hover:bg-{{ $color }}-50 transition-colors">
                        <span class="text-lg leading-none mt-0.5">{{ $icon }}</span>
                        <div>
                            <p class="text-xs font-black text-slate-700">{{ $label }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Recent Delivery Logs ─────────────────────────────────────── --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden animate-content" style="animation-delay:0.2s">
        <div class="p-7 border-b border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-500">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-800">Recent Delivery Logs</h2>
                    <p class="text-xs text-slate-400 font-medium">Last 50 notification attempts</p>
                </div>
            </div>
            <a href="{{ route('admin.telegram.logs') }}" class="text-xs font-black text-blue-500 hover:underline">View All →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/80 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4">Recipient</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Time</th>
                        <th class="px-6 py-4">Message</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentLogs as $log)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-700">
                                {{ $log->recipient?->name ?? 'N/A' }}
                            </div>
                            <div class="text-[10px] text-slate-400">{{ $log->chat_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @php $type = $log->recipient_type; @endphp
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase
                                {{ $type === 'student' ? 'bg-blue-50 text-blue-600' : ($type === 'parent' ? 'bg-violet-50 text-violet-600' : 'bg-slate-100 text-slate-500') }}">
                                {{ $type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $eventIcons = [
                                    'attendance'       => ['📊', 'bg-blue-50 text-blue-600'],
                                    'low_attendance'   => ['⚠️', 'bg-amber-50 text-amber-600'],
                                    'result_published' => ['🎉', 'bg-violet-50 text-violet-600'],
                                    'fee_created'      => ['💰', 'bg-emerald-50 text-emerald-600'],
                                    'fee_reminder'     => ['💰', 'bg-emerald-50 text-emerald-600'],
                                    'notice'           => ['📢', 'bg-rose-50 text-rose-600'],
                                    'sos'              => ['🚨', 'bg-red-50 text-red-600'],
                                    'broadcast'        => ['📡', 'bg-indigo-50 text-indigo-600'],
                                    'test'             => ['🧪', 'bg-slate-100 text-slate-600'],
                                    'connect'          => ['✅', 'bg-emerald-50 text-emerald-600'],
                                ];
                                $eventData = $eventIcons[$log->event_type] ?? ['📩', 'bg-slate-100 text-slate-500'];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-black {{ $eventData[1] }}">
                                {{ $eventData[0] }} {{ str_replace('_', ' ', $log->event_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($log->status === 'sent')
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sent
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-red-50 text-red-600 text-[10px] font-black" title="{{ $log->error_message }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-[11px] text-slate-400 font-medium whitespace-nowrap">
                            {{ $log->created_at?->format('d M, h:i A') ?? '—' }}
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-xs text-slate-600 truncate font-medium" title="{{ $log->message }}">
                                {{ Str::limit(strip_tags($log->message), 60) }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <i class="fa-brands fa-telegram text-5xl text-slate-200"></i>
                                <p class="text-slate-400 font-bold">No notification logs yet.</p>
                                <p class="text-[10px] text-slate-300 uppercase tracking-widest">Send your first message above!</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Toast Container --}}
<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('telegram-global-toggle');
    const label  = document.getElementById('toggle-status-label');

    toggle.addEventListener('change', async function () {
        const enabled = this.checked;
        try {
            const res = await fetch('{{ route('admin.telegram.toggle') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ enabled: enabled ? 1 : 0 }),
            });
            const data = await res.json();
            if (data.success) {
                label.textContent = enabled ? 'ENABLED' : 'DISABLED';
                label.className = `text-xs font-black ${enabled ? 'text-blue-600' : 'text-slate-400'}`;
                showToast(data.message, 'success');
            } else {
                this.checked = !this.checked;
                showToast('Failed to update setting.', 'error');
            }
        } catch (e) {
            this.checked = !this.checked;
            showToast('Network error.', 'error');
        }
    });

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast     = document.createElement('div');
        const bg        = type === 'success' ? 'bg-emerald-500' : 'bg-red-500';
        const icon      = type === 'success' ? 'fa-check-circle' : 'fa-triangle-exclamation';
        toast.className = `${bg} text-white px-5 py-3 rounded-xl shadow-xl flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
        toast.innerHTML = `<i class="fa-solid ${icon}"></i><span class="font-medium text-sm">${message}</span>`;
        container.appendChild(toast);
        setTimeout(() => toast.classList.remove('translate-y-10', 'opacity-0'), 10);
        setTimeout(() => {
            toast.classList.add('opacity-0', 'scale-95');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }
});
</script>

@endsection
