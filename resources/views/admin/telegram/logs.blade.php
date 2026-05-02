@extends('layouts.admin')

@section('title', 'Telegram Notification Logs')

@section('content')
<div class="max-w-7xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Notification Logs</h1>
            <p class="text-slate-500 font-medium mt-1">Full delivery history of all Telegram messages.</p>
        </div>
        <a href="{{ route('admin.telegram.index') }}"
           class="inline-flex items-center gap-2 bg-slate-100 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
            <i class="fa-solid fa-arrow-left"></i> Back to Panel
        </a>
    </div>

    {{-- Filters --}}
    <form method="GET" class="flex flex-wrap gap-3 bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
        <select name="status" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-blue-400 outline-none">
            <option value="">All Statuses</option>
            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
        </select>
        <select name="event_type" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-medium text-slate-600 focus:ring-2 focus:ring-blue-400 outline-none">
            <option value="">All Events</option>
            @foreach(['attendance','low_attendance','result_published','fee_created','fee_reminder','notice','sos','broadcast','test','connect'] as $evt)
            <option value="{{ $evt }}" {{ request('event_type') === $evt ? 'selected' : '' }}>{{ ucwords(str_replace('_',' ',$evt)) }}</option>
            @endforeach
        </select>
        <button type="submit" class="bg-blue-500 text-white px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-blue-600 transition-colors">
            <i class="fa-solid fa-filter mr-1"></i> Filter
        </button>
        <a href="{{ route('admin.telegram.logs') }}" class="bg-slate-100 text-slate-600 px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-200 transition-colors">
            Reset
        </a>
    </form>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Recipient</th>
                        <th class="px-6 py-4">Type</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Message</th>
                        <th class="px-6 py-4">Time</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($logs as $log)
                    <tr class="hover:bg-blue-50/30 transition-colors">
                        <td class="px-6 py-4 text-xs text-slate-400 font-bold">{{ $log->id }}</td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-slate-700">{{ $log->recipient?->name ?? 'Unknown' }}</div>
                            <div class="text-[10px] text-slate-400 font-mono">{{ $log->chat_id }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-lg text-[10px] font-black uppercase
                                {{ $log->recipient_type === 'student' ? 'bg-blue-50 text-blue-600' : 'bg-violet-50 text-violet-600' }}">
                                {{ $log->recipient_type }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-[11px] font-bold text-slate-600">
                            {{ ucwords(str_replace('_', ' ', $log->event_type)) }}
                        </td>
                        <td class="px-6 py-4">
                            @if($log->status === 'sent')
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-emerald-50 text-emerald-600 text-[10px] font-black">
                                    ✅ Sent
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-1 rounded-lg bg-red-50 text-red-600 text-[10px] font-black cursor-help"
                                      title="{{ $log->error_message }}">
                                    ❌ Failed
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-xs text-slate-600 truncate" title="{{ $log->message }}">
                                {{ Str::limit($log->message, 70) }}
                            </p>
                        </td>
                        <td class="px-6 py-4 text-[11px] text-slate-400 whitespace-nowrap">
                            {{ $log->created_at?->format('d M Y, h:i A') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <i class="fa-solid fa-inbox text-4xl text-slate-200 mb-3 block"></i>
                            <p class="text-slate-400 font-bold">No logs found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="p-5 border-t border-slate-50">
            {{ $logs->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
