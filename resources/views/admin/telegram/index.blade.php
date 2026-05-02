@extends('layouts.admin')

@section('title', 'Telegram Notifications')

@section('content')
<div class="space-y-7 animate-content page-content-fade">

    {{-- ─── Page Header ───────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg border border-white/20"
                 style="background: linear-gradient(135deg, #2AABEE, #229ED9);">
                <i class="fa-brands fa-telegram text-white text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight leading-tight">Telegram Notifications</h1>
                <p class="text-sm text-slate-500 font-medium mt-0.5">Bot control panel · Real-time delivery analytics · Broadcast center</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            {{-- Global Enable / Disable Toggle --}}
            <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl px-4 py-2.5 shadow-sm">
                <div class="flex flex-col">
                    <span class="text-xs font-black text-slate-600 uppercase tracking-wider">Notifications</span>
                    <span id="toggle-status-label" class="text-[10px] font-black {{ $telegramEnabled ? 'text-sky-500' : 'text-slate-400' }}">
                        {{ $telegramEnabled ? 'ENABLED' : 'DISABLED' }}
                    </span>
                </div>
                <label class="relative inline-flex items-center cursor-pointer" id="telegram-toggle-label">
                    <input type="checkbox" id="telegram-global-toggle" class="sr-only peer"
                           {{ $telegramEnabled ? 'checked' : '' }}>
                    <div class="w-12 h-6 bg-slate-200 rounded-full peer peer-focus:outline-none
                                peer-checked:after:translate-x-full peer-checked:after:border-white
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:border-slate-300 after:border after:rounded-full
                                after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500 shadow-inner"></div>
                </label>
            </div>
            <a href="{{ route('admin.telegram.logs') }}"
               class="inline-flex items-center gap-2 bg-slate-900 text-white px-4 py-2.5 rounded-xl text-sm font-bold shadow-sm hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-list-check"></i> All Logs
            </a>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="flex items-center gap-3 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-3.5 rounded-xl shadow-sm">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            <span class="font-semibold text-sm">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="flex items-center gap-3 bg-red-50 border border-red-200 text-red-800 px-5 py-3.5 rounded-xl shadow-sm">
            <i class="fa-solid fa-circle-xmark text-red-500"></i>
            <span class="font-semibold text-sm">{{ session('error') }}</span>
        </div>
    @endif

    {{-- ─── Stats Cards ─────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-5 gap-4">

        {{-- Connected Students --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center text-sky-500 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-graduation-cap text-sm"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Students</span>
            </div>
            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $connectedStudents }}</p>
            <p class="text-[11px] font-bold text-slate-400 mt-1">Connected <span class="text-slate-300">/ {{ $totalStudents }} total</span></p>
            <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-sky-400 rounded-full" style="width: {{ $totalStudents > 0 ? round(($connectedStudents/$totalStudents)*100) : 0 }}%"></div>
            </div>
        </div>

        {{-- Connected Parents --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center text-violet-500 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-users text-sm"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Parents</span>
            </div>
            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ $connectedParents }}</p>
            <p class="text-[11px] font-bold text-slate-400 mt-1">Connected <span class="text-slate-300">/ {{ $totalParents }} total</span></p>
            <div class="mt-3 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-violet-400 rounded-full" style="width: {{ $totalParents > 0 ? round(($connectedParents/$totalParents)*100) : 0 }}%"></div>
            </div>
        </div>

        {{-- Sent Today --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-paper-plane text-sm"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Today</span>
            </div>
            <p class="text-3xl font-black text-emerald-600 tracking-tight">{{ $sentToday }}</p>
            <p class="text-[11px] font-bold text-slate-400 mt-1">Messages Sent</p>
        </div>

        {{-- Failed Today --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">Failed</span>
            </div>
            <p class="text-3xl font-black text-red-500 tracking-tight">{{ $failedToday }}</p>
            <p class="text-[11px] font-bold text-slate-400 mt-1">Today's Failures</p>
        </div>

        {{-- Total Delivered --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-all hover:-translate-y-0.5 group col-span-2 md:col-span-1">
            <div class="flex items-center justify-between mb-4">
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center text-amber-500 group-hover:scale-110 transition-transform">
                    <i class="fa-solid fa-chart-bar text-sm"></i>
                </div>
                <span class="text-[10px] font-black text-slate-400 uppercase tracking-wider">All Time</span>
            </div>
            <p class="text-3xl font-black text-slate-900 tracking-tight">{{ number_format($totalSent) }}</p>
            <p class="text-[11px] font-bold text-slate-400 mt-1">Total Delivered</p>
        </div>
    </div>

    {{-- ─── Main Action Panels ───────────────────────────────────────────── --}}
    <div class="grid lg:grid-cols-2 gap-6">

        {{-- Broadcast Form --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-sky-50 flex items-center justify-center text-sky-500">
                    <i class="fa-solid fa-bullhorn text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Broadcast Message</h2>
                    <p class="text-xs text-slate-400 font-medium">Send to all students, parents, or everyone</p>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.telegram.broadcast') }}" class="p-6 space-y-5">
                @csrf
                <div>
                    <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2.5">Target Audience</label>
                    <div class="grid grid-cols-3 gap-2.5">
                        @foreach(['students' => ['🎓','Students'], 'parents' => ['👨‍👩‍👧','Parents'], 'all' => ['📡','Everyone']] as $value => $opts)
                        <label class="cursor-pointer">
                            <input type="radio" name="target" value="{{ $value }}" class="sr-only peer" {{ $value === 'students' ? 'checked' : '' }}>
                            <div class="text-center p-3 rounded-xl border-2 border-slate-100 peer-checked:border-sky-400 peer-checked:bg-sky-50 transition-all text-sm font-bold text-slate-500 peer-checked:text-sky-600 hover:border-sky-200">
                                <div class="text-base mb-1">{{ $opts[0] }}</div>
                                <div class="text-[11px] font-black">{{ $opts[1] }}</div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2.5">Message
                        <span class="normal-case text-slate-300 font-medium ml-1">(Markdown supported)</span>
                    </label>
                    <textarea name="message" rows="5" required maxlength="4000"
                              placeholder="Type your broadcast message here...&#10;&#10;Markdown: *bold*, _italic_, [link](url)"
                              class="w-full rounded-xl border border-slate-200 p-4 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-sky-400 focus:border-transparent outline-none resize-none transition-all bg-slate-50 focus:bg-white"></textarea>
                </div>
                <button type="submit"
                        class="w-full py-3 rounded-xl font-black text-sm text-white shadow hover:shadow-md hover:-translate-y-0.5 active:scale-[0.98] transition-all"
                        style="background: linear-gradient(135deg, #2AABEE, #229ED9);">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Send Broadcast
                </button>
            </form>
        </div>

        {{-- Right column: Test Message + Event Reference --}}
        <div class="space-y-5">

            {{-- Test Message --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-50 flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                        <i class="fa-solid fa-flask-vial text-sm"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-extrabold text-slate-800">Send Test Message</h2>
                        <p class="text-xs text-slate-400 font-medium">Verify bot is working for any chat ID</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.telegram.test') }}" class="p-6 space-y-4">
                    @csrf
                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">Telegram Chat ID</label>
                        <div class="flex gap-2">
                            <input type="text" name="chat_id" required placeholder="e.g. 1234567890"
                                   class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-400 focus:border-transparent outline-none transition-all bg-slate-50 focus:bg-white">
                            <button type="submit"
                                    class="px-4 py-2.5 rounded-xl font-black text-sm text-white bg-emerald-500 hover:bg-emerald-600 shadow hover:shadow-md transition-all active:scale-95">
                                <i class="fa-solid fa-satellite-dish"></i>
                            </button>
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1.5">💡 User can find their ID by messaging <span class="font-mono font-bold">@userinfobot</span> on Telegram</p>
                    </div>
                    <div>
                        <label class="text-xs font-black text-slate-500 uppercase tracking-wider block mb-2">Custom Message <span class="normal-case font-medium text-slate-300">(optional)</span></label>
                        <textarea name="message" rows="3" maxlength="4000"
                                  placeholder="Leave blank for default test message..."
                                  class="w-full rounded-xl border border-slate-200 p-3 text-sm font-medium text-slate-700 focus:ring-2 focus:ring-emerald-400 focus:border-transparent outline-none resize-none transition-all bg-slate-50 focus:bg-white"></textarea>
                    </div>
                </form>
            </div>

            {{-- Webhook Status + Auto-Trigger Reference --}}
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
                <h3 class="text-sm font-black text-slate-700 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-bolt text-amber-400"></i> Auto-Trigger Events
                </h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([
                        ['📊', 'Attendance',       'Student + parent on mark'],
                        ['⚠️', 'Low Attendance',   'When below 75%'],
                        ['🎉', 'Results',           'On result publish'],
                        ['💰', 'Fee Added/Due',     'New fee + daily 9AM'],
                        ['📢', 'Admin Notice',      'Broadcast to all'],
                        ['🚨', 'Emergency SOS',     'Instant to parents'],
                    ] as [$icon, $label, $desc])
                    <div class="flex items-start gap-2.5 p-3 bg-slate-50 rounded-xl hover:bg-sky-50 transition-colors">
                        <span class="text-base leading-none mt-0.5">{{ $icon }}</span>
                        <div>
                            <p class="text-[11px] font-black text-slate-700">{{ $label }}</p>
                            <p class="text-[9px] text-slate-400 mt-0.5 leading-relaxed">{{ $desc }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Webhook URL display --}}
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-2">Active Webhook</p>
                    <div class="flex items-center gap-2 bg-slate-900 rounded-xl px-3 py-2.5 overflow-hidden">
                        <i class="fa-solid fa-link text-sky-400 text-xs flex-shrink-0"></i>
                        <span class="text-[10px] font-mono text-slate-400 truncate">{{ config('app.url') }}/telegram/webhook</span>
                        <span class="flex-shrink-0 w-2 h-2 rounded-full bg-emerald-400 animate-pulse ml-auto"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ─── Recent Delivery Logs ─────────────────────────────────────────── --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500">
                    <i class="fa-solid fa-clock-rotate-left text-sm"></i>
                </div>
                <div>
                    <h2 class="text-base font-extrabold text-slate-800">Recent Delivery Logs</h2>
                    <p class="text-xs text-slate-400 font-medium">Last 50 notification attempts</p>
                </div>
            </div>
            <a href="{{ route('admin.telegram.logs') }}"
               class="text-xs font-black text-sky-500 hover:text-sky-600 hover:underline transition-colors">
                View All →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#FDFBF7] text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-5 py-3.5">Recipient</th>
                        <th class="px-5 py-3.5">Role</th>
                        <th class="px-5 py-3.5">Event</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Message</th>
                        <th class="px-5 py-3.5">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($recentLogs as $log)
                    <tr class="hover:bg-[#FDFBF7] transition-colors group">
                        <td class="px-5 py-3.5">
                            <div class="text-sm font-bold text-slate-700">{{ $log->recipient?->name ?? 'N/A' }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $log->chat_id }}</div>
                        </td>
                        <td class="px-5 py-3.5">
                            @php $type = $log->recipient_type; @endphp
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase
                                {{ $type === 'student' ? 'bg-sky-50 text-sky-600' : ($type === 'parent' ? 'bg-violet-50 text-violet-600' : 'bg-slate-100 text-slate-500') }}">
                                {{ $type }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            @php
                                $eventMeta = [
                                    'attendance'       => ['📊', 'bg-sky-50 text-sky-700'],
                                    'low_attendance'   => ['⚠️', 'bg-amber-50 text-amber-700'],
                                    'result_published' => ['🎉', 'bg-violet-50 text-violet-700'],
                                    'fee_created'      => ['💰', 'bg-emerald-50 text-emerald-700'],
                                    'fee_reminder'     => ['💰', 'bg-emerald-50 text-emerald-700'],
                                    'notice'           => ['📢', 'bg-rose-50 text-rose-700'],
                                    'sos'              => ['🚨', 'bg-red-50 text-red-700'],
                                    'broadcast'        => ['📡', 'bg-indigo-50 text-indigo-700'],
                                    'test'             => ['🧪', 'bg-slate-100 text-slate-600'],
                                    'connect'          => ['✅', 'bg-emerald-50 text-emerald-700'],
                                    'welcome'          => ['👋', 'bg-slate-50 text-slate-600'],
                                    'error'            => ['❌', 'bg-red-50 text-red-600'],
                                ];
                                [$evIcon, $evClass] = $eventMeta[$log->event_type] ?? ['📩', 'bg-slate-100 text-slate-600'];
                            @endphp
                            <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg text-[10px] font-black {{ $evClass }}">
                                {{ $evIcon }} {{ ucwords(str_replace('_', ' ', $log->event_type)) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($log->status === 'sent')
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-black">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sent
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-red-50 text-red-700 text-[10px] font-black cursor-help" title="{{ $log->error_message }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 max-w-xs">
                            <p class="text-xs text-slate-600 truncate font-medium" title="{{ $log->message }}">
                                {{ Str::limit(strip_tags($log->message), 55) }}
                            </p>
                        </td>
                        <td class="px-5 py-3.5 text-[11px] text-slate-400 whitespace-nowrap font-medium">
                            {{ $log->created_at?->format('d M, h:i A') ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-2xl bg-slate-50 flex items-center justify-center">
                                    <i class="fa-brands fa-telegram text-3xl text-slate-300"></i>
                                </div>
                                <p class="text-slate-500 font-bold text-sm">No notification logs yet.</p>
                                <p class="text-[11px] text-slate-400">Connect a user and trigger an event, or send a test message above.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- Toast Notification --}}
<div id="toast-container" class="fixed bottom-6 right-6 z-[9999] flex flex-col gap-2 pointer-events-none"></div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('telegram-global-toggle');
    const label  = document.getElementById('toggle-status-label');

    if (!toggle) return;

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
                label.className   = `text-[10px] font-black ${enabled ? 'text-sky-500' : 'text-slate-400'}`;
                showToast(data.message, 'success');
            } else {
                this.checked = !this.checked;
                showToast('Failed to update setting.', 'error');
            }
        } catch (e) {
            this.checked = !this.checked;
            showToast('Network error — please try again.', 'error');
        }
    });

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast     = document.createElement('div');
        const bg        = type === 'success' ? 'bg-emerald-600' : 'bg-red-600';
        const icon      = type === 'success' ? 'fa-circle-check' : 'fa-circle-xmark';
        toast.className = `pointer-events-auto ${bg} text-white px-5 py-3 rounded-xl shadow-xl flex items-center gap-3 text-sm font-semibold transform translate-y-4 opacity-0 transition-all duration-300`;
        toast.innerHTML = `<i class="fa-solid ${icon}"></i><span>${message}</span>`;
        container.appendChild(toast);
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-4', 'opacity-0');
        });
        setTimeout(() => {
            toast.classList.add('opacity-0', 'scale-95');
            setTimeout(() => toast.remove(), 300);
        }, 3500);
    }
});
</script>
@endsection
