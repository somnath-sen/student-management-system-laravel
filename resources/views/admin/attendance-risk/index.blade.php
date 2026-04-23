@extends('layouts.admin')

@section('title', 'Attendance Risk Monitor')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
                Attendance Risk Monitor
            </h1>
            <p class="text-sm text-slate-500 mt-1">AI-powered attendance prediction — identify students at risk of losing exam eligibility.</p>
        </div>
        <a href="{{ route('admin.attendance-risk.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold rounded-xl transition-all">
            <i class="fa-solid fa-rotate"></i> Refresh
        </a>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-rose-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <i class="fa-solid fa-circle-radiation text-xl"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-rose-500 bg-rose-50 px-2 py-1 rounded-lg border border-rose-100">Critical</span>
            </div>
            <p class="text-4xl font-black text-slate-900">{{ $highCount }}</p>
            <p class="text-sm text-slate-500 font-medium mt-1">Below 60% attendance</p>
        </div>

        <div class="bg-white rounded-2xl border border-amber-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 px-2 py-1 rounded-lg border border-amber-100">At Risk</span>
            </div>
            <p class="text-4xl font-black text-slate-900">{{ $atRiskCount }}</p>
            <p class="text-sm text-slate-500 font-medium mt-1">60–74% attendance</p>
        </div>

        <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <i class="fa-solid fa-shield-check text-xl"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">Safe</span>
            </div>
            <p class="text-4xl font-black text-slate-900">{{ $safeCount }}</p>
            <p class="text-sm text-slate-500 font-medium mt-1">≥75% attendance</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.attendance-risk.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Risk Level</label>
                <select name="risk" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 outline-none bg-white min-w-[160px]">
                    <option value="">All Levels</option>
                    <option value="critical" {{ request('risk') === 'critical' ? 'selected' : '' }}>🔴 Critical (&lt;60%)</option>
                    <option value="at_risk"  {{ request('risk') === 'at_risk'  ? 'selected' : '' }}>🟡 At Risk (60–74%)</option>
                    <option value="safe"     {{ request('risk') === 'safe'     ? 'selected' : '' }}>🟢 Safe (≥75%)</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all">
                <i class="fa-solid fa-filter mr-2"></i>Filter
            </button>
            @if(request()->has('risk'))
                <a href="{{ route('admin.attendance-risk.index') }}" class="px-5 py-2.5 bg-slate-100 text-slate-600 text-sm font-bold rounded-xl">Clear</a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50">
            <h3 class="font-bold text-slate-800">Student Attendance Overview</h3>
            <span class="text-xs text-slate-400 font-medium">{{ $evaluated->count() }} student(s)</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-widest font-black">
                        <th class="px-6 py-4 border-b border-slate-100">Student</th>
                        <th class="px-6 py-4 border-b border-slate-100">Course</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Present</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Absent</th>
                        <th class="px-6 py-4 border-b border-slate-100">Attendance %</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Status</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($evaluated as $row)
                    @php
                        $r = $row['risk'];
                        $badgeClass = match($r) { 'critical' => 'bg-rose-100 text-rose-700 border-rose-200', 'at_risk' => 'bg-amber-100 text-amber-700 border-amber-200', default => 'bg-emerald-100 text-emerald-700 border-emerald-200' };
                        $barColor   = match($r) { 'critical' => 'bg-rose-500', 'at_risk' => 'bg-amber-400', default => 'bg-emerald-500' };
                        $emoji      = match($r) { 'critical' => '🔴', 'at_risk' => '🟡', default => '🟢' };
                        $label      = match($r) { 'critical' => 'Critical', 'at_risk' => 'At Risk', default => 'Safe' };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl {{ $r === 'critical' ? 'bg-rose-100 text-rose-600' : ($r === 'at_risk' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600') }} flex items-center justify-center font-black text-sm">
                                    {{ substr($row['student']->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $row['student']->user->name }}</p>
                                    <p class="text-xs text-slate-400">{{ $row['student']->roll_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">{{ $row['student']->course->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-center font-bold text-emerald-600">{{ $row['present'] }}</td>
                        <td class="px-6 py-4 text-center font-bold text-rose-500">{{ $row['absent'] }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex-1 max-w-[100px] h-2.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $barColor }}" style="width:{{ min(100, $row['pct']) }}%"></div>
                                </div>
                                <span class="text-sm font-black text-slate-700 tabular-nums">{{ $row['pct'] }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black border {{ $badgeClass }}">
                                {{ $emoji }} {{ $label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.attendance-risk.show', $row['student']->id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 hover:bg-indigo-600 hover:text-white text-slate-600 text-xs font-bold rounded-xl transition-all border border-slate-200 hover:border-indigo-600">
                                <i class="fa-solid fa-magnifying-glass-chart"></i> Predict
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center text-slate-400">No students found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
