@extends('layouts.admin')

@section('title', 'Telegram Notification Logs')

@section('content')
<div class="space-y-6 animate-content page-content-fade">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shadow"
                 style="background: linear-gradient(135deg, #2AABEE, #229ED9);">
                <i class="fa-solid fa-clock-rotate-left text-white"></i>
            </div>
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Notification Logs</h1>
                <p class="text-sm text-slate-500 font-medium mt-0.5">Full Telegram delivery history</p>
            </div>
        </div>
        <a href="{{ route('admin.telegram.index') }}"
           class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors self-start sm:self-auto">
            <i class="fa-solid fa-arrow-left text-xs"></i> Back to Panel
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-5">
        <form method="GET" class="flex flex-wrap gap-3 items-end">
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">Status</label>
                <select name="status" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-sky-400 outline-none bg-slate-50">
                    <option value="">All Statuses</option>
                    <option value="sent"   {{ request('status') === 'sent'   ? 'selected' : '' }}>✅ Sent</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>❌ Failed</option>
                </select>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-wider block mb-1.5">Event Type</label>
                <select name="event_type" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-sky-400 outline-none bg-slate-50">
                    <option value="">All Events</option>
                    @foreach(['attendance','low_attendance','result_published','fee_created','fee_reminder','notice','sos','broadcast','test','connect'] as $evt)
                    <option value="{{ $evt }}" {{ request('event_type') === $evt ? 'selected' : '' }}>
                        {{ ucwords(str_replace('_', ' ', $evt)) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit"
                        class="px-4 py-2.5 rounded-xl text-sm font-bold text-white shadow hover:shadow-md transition-all"
                        style="background: linear-gradient(135deg, #2AABEE, #229ED9);">
                    <i class="fa-solid fa-filter mr-1.5"></i> Filter
                </button>
                <a href="{{ route('admin.telegram.logs') }}"
                   class="px-4 py-2.5 rounded-xl bg-slate-100 text-slate-600 text-sm font-bold hover:bg-slate-200 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-[#FDFBF7] text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-5 py-3.5">#</th>
                        <th class="px-5 py-3.5">Recipient</th>
                        <th class="px-5 py-3.5">Role</th>
                        <th class="px-5 py-3.5">Event</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Message Preview</th>
                        <th class="px-5 py-3.5">Sent At</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-[#FDFBF7] transition-colors">
                        <td class="px-5 py-3.5 text-xs text-slate-400 font-bold">{{ $log->id }}</td>
                        <td class="px-5 py-3.5">
                            <div class="text-sm font-bold text-slate-700">{{ $log->recipient?->name ?? 'Unknown' }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $log->chat_id }}</div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase
                                {{ $log->recipient_type === 'student' ? 'bg-sky-50 text-sky-600' : ($log->recipient_type === 'parent' ? 'bg-violet-50 text-violet-600' : 'bg-slate-100 text-slate-500') }}">
                                {{ $log->recipient_type }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-[11px] font-bold text-slate-600">
                            {{ ucwords(str_replace('_', ' ', $log->event_type)) }}
                        </td>
                        <td class="px-5 py-3.5">
                            @if($log->status === 'sent')
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-emerald-50 text-emerald-700 text-[10px] font-black">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sent
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-lg bg-red-50 text-red-700 text-[10px] font-black cursor-help"
                                      title="{{ $log->error_message }}">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 max-w-xs">
                            <p class="text-xs text-slate-600 truncate font-medium" title="{{ $log->message }}">
                                {{ Str::limit(strip_tags($log->message), 65) }}
                            </p>
                        </td>
                        <td class="px-5 py-3.5 text-[11px] text-slate-400 whitespace-nowrap font-medium">
                            {{ $log->created_at?->format('d M Y, h:i A') ?? '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center">
                                    <i class="fa-solid fa-inbox text-2xl text-slate-300"></i>
                                </div>
                                <p class="text-slate-500 font-bold text-sm">No logs found.</p>
                                <p class="text-xs text-slate-400">Try adjusting the filters above.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-5 py-4 border-t border-slate-50">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
