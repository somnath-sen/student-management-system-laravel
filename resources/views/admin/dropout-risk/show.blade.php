@extends('layouts.admin')

@section('title', 'Risk Analysis – ' . $student->user->name)

@section('content')
@php
    $level = $log->risk_level;
    $scoreColor = $log->risk_score >= 75 ? '#10B981' : ($log->risk_score >= 50 ? '#F59E0B' : '#EF4444');
    $ringClass  = $level === 'high_risk' ? 'ring-rose-200' : ($level === 'at_risk' ? 'ring-amber-200' : 'ring-emerald-200');
    $badgeClass = $level === 'high_risk' ? 'bg-rose-100 text-rose-700 border-rose-200' : ($level === 'at_risk' ? 'bg-amber-100 text-amber-700 border-amber-200' : 'bg-emerald-100 text-emerald-700 border-emerald-200');
    $badgeLabel = $level === 'high_risk' ? '🔴 High Risk — Immediate Action Required' : ($level === 'at_risk' ? '🟡 At Risk — Needs Attention' : '🟢 Safe — Student is Stable');
@endphp

<div class="max-w-5xl mx-auto space-y-8">

    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dropout-risk.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition-colors shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl font-extrabold text-slate-900">Risk Profile: {{ $student->user->name }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">Last evaluated: {{ $log->last_evaluated_at?->diffForHumans() ?? 'Never' }}</p>
        </div>
        <span class="ml-auto inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-black border {{ $badgeClass }}">
            {{ $badgeLabel }}
        </span>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            <p class="text-emerald-700 font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Top Row: Score Ring + Student Info --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Score Gauge --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8 flex flex-col items-center justify-center">
            <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Overall Risk Score</p>
            <div class="relative w-36 h-36 mb-4">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="#f1f5f9" stroke-width="12"/>
                    <circle cx="60" cy="60" r="50" fill="none"
                            stroke="{{ $scoreColor }}"
                            stroke-width="12"
                            stroke-linecap="round"
                            stroke-dasharray="{{ round($log->risk_score * 3.14159, 1) }} 314.159"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black" style="color:{{ $scoreColor }}">{{ $log->risk_score }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">/100</span>
                </div>
            </div>
            <form action="{{ route('admin.dropout-risk.reevaluate', $student->id) }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-colors">
                    <i class="fa-solid fa-rotate text-xs"></i> Re-evaluate
                </button>
            </form>
        </div>

        {{-- Student Details --}}
        <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
            <div class="flex items-center gap-4 pb-4 border-b border-slate-100">
                <div class="w-14 h-14 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center text-2xl font-black shadow-md">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-lg font-bold text-slate-800">{{ $student->user->name }}</h2>
                    <p class="text-sm text-slate-500">{{ $student->user->email }}</p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Roll Number</p>
                    <p class="font-bold text-slate-700 mt-0.5">{{ $student->roll_number }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Course</p>
                    <p class="font-bold text-slate-700 mt-0.5">{{ $student->course->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Parents Linked</p>
                    <p class="font-bold text-slate-700 mt-0.5">{{ $student->parents->count() }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status</p>
                    <p class="font-bold text-slate-700 mt-0.5 capitalize">{{ $student->status ?? 'active' }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Score Breakdown --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-bold text-slate-800">Score Breakdown</h3>
            <p class="text-xs text-slate-400 mt-0.5">Weighted: Attendance 40% · Marks 40% · Engagement 20%</p>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $metrics = [
                    ['label' => 'Attendance', 'icon' => 'fa-calendar-check', 'score' => $log->attendance_score, 'weight' => '40%', 'color' => 'indigo'],
                    ['label' => 'Academic Marks', 'icon' => 'fa-graduation-cap', 'score' => $log->marks_score, 'weight' => '40%', 'color' => 'violet'],
                    ['label' => 'Platform Engagement', 'icon' => 'fa-arrow-trend-up', 'score' => $log->engagement_score, 'weight' => '20%', 'color' => 'cyan'],
                ];
            @endphp
            @foreach($metrics as $m)
            @php
                $mColor = $m['score'] >= 75 ? '#10B981' : ($m['score'] >= 50 ? '#F59E0B' : '#EF4444');
                $mBg    = $m['score'] >= 75 ? 'bg-emerald-100 text-emerald-600' : ($m['score'] >= 50 ? 'bg-amber-100 text-amber-600' : 'bg-rose-100 text-rose-600');
            @endphp
            <div class="bg-slate-50 rounded-xl p-5 border border-slate-100">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl {{ $mBg }} flex items-center justify-center">
                        <i class="fa-solid {{ $m['icon'] }}"></i>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-700">{{ $m['label'] }}</p>
                        <p class="text-xs text-slate-400">Weight: {{ $m['weight'] }}</p>
                    </div>
                </div>
                <div class="flex items-end justify-between mb-2">
                    <span class="text-3xl font-black" style="color:{{ $mColor }}">{{ $m['score'] }}</span>
                    <span class="text-xs font-bold text-slate-400">/100</span>
                </div>
                <div class="w-full h-2.5 bg-white rounded-full overflow-hidden border border-slate-200">
                    <div class="h-full rounded-full transition-all" style="width:{{ min(100, $m['score']) }}%; background-color:{{ $mColor }}"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Insights & Suggestions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Insights --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-lightbulb text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Insights</h3>
            </div>
            <ul class="divide-y divide-slate-50">
                @forelse($log->insights ?? [] as $insight)
                <li class="px-6 py-4 text-sm text-slate-600 leading-relaxed">{{ $insight }}</li>
                @empty
                <li class="px-6 py-4 text-sm text-slate-400 italic">No insights available.</li>
                @endforelse
            </ul>
        </div>

        {{-- Suggestions --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-list-check text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Recommended Actions</h3>
            </div>
            <ul class="divide-y divide-slate-50">
                @forelse($log->suggestions ?? [] as $suggestion)
                <li class="px-6 py-4 flex items-start gap-3">
                    <span class="mt-0.5 w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </span>
                    <span class="text-sm text-slate-600 leading-relaxed">{{ $suggestion }}</span>
                </li>
                @empty
                <li class="px-6 py-4 text-sm text-slate-400 italic">No suggestions available.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
