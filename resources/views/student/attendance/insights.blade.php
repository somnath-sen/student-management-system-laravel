@extends('layouts.student')

@section('title', 'Attendance Insights')

@section('content')
@php
    $threshold = 75;
    $riskMeta = [
        'safe'     => ['color' => '#10B981', 'bg' => 'from-emerald-500 to-teal-500', 'soft' => 'bg-emerald-50 border-emerald-200', 'text' => 'text-emerald-700', 'label' => '🟢 Safe',     'desc' => 'You are exam-eligible! Keep it up.'],
        'at_risk'  => ['color' => '#F59E0B', 'bg' => 'from-amber-500 to-orange-400', 'soft' => 'bg-amber-50 border-amber-200',   'text' => 'text-amber-700',   'label' => '🟡 At Risk',   'desc' => 'You are below the required threshold. Act now.'],
        'critical' => ['color' => '#EF4444', 'bg' => 'from-rose-500 to-red-600',     'soft' => 'bg-rose-50 border-rose-200',     'text' => 'text-rose-700',    'label' => '🔴 Critical',  'desc' => 'Immediate action required to avoid exam disqualification.'],
    ];
    $rm = $riskMeta[$risk];
@endphp

<style>
    @keyframes fadeUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { animation: fadeUp 0.7s cubic-bezier(0.2,0.8,0.2,1) forwards; }
    @keyframes countUp { from { opacity:0; transform:scale(0.8); } to { opacity:1; transform:scale(1); } }
    .count-up { animation: countUp 0.8s cubic-bezier(0.2,0.8,0.2,1) 0.3s both; }
    @keyframes dashDraw { from { stroke-dashoffset: 314; } to { stroke-dashoffset: 0; } }
    .ring-track { transition: stroke-dasharray 1.2s cubic-bezier(0.2,0.8,0.2,1); }
</style>

<div class="max-w-4xl mx-auto space-y-8 fade-up">

    {{-- ── Hero Card ─────────────────────────────────────────────────── --}}
    <div class="relative overflow-hidden rounded-[2.5rem] text-white shadow-2xl"
         style="background: linear-gradient(135deg, {{ $rm['color'] }}dd, {{ $rm['color'] }}aa)">
        <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full opacity-10 pointer-events-none"
             style="background: radial-gradient(circle, white, transparent); filter:blur(30px);"></div>
        <div class="absolute -left-8 -bottom-8 w-48 h-48 rounded-full opacity-10 pointer-events-none"
             style="background: radial-gradient(circle, white, transparent); filter:blur(20px);"></div>

        <div class="relative z-10 p-8 flex flex-col md:flex-row items-center gap-8">
            {{-- SVG Ring --}}
            <div class="relative w-40 h-40 flex-shrink-0 count-up">
                <svg class="w-full h-full -rotate-90" viewBox="0 0 120 120">
                    <circle cx="60" cy="60" r="50" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="10"/>
                    <circle cx="60" cy="60" r="50" fill="none"
                            stroke="white"
                            stroke-width="10"
                            stroke-linecap="round"
                            stroke-dasharray="{{ round($pct * 3.14159, 1) }} 314.159"
                            class="ring-track"/>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-4xl font-black leading-none">{{ $pct }}%</span>
                    <span class="text-white/70 text-xs font-bold uppercase tracking-widest mt-1">Attendance</span>
                </div>
            </div>

            {{-- Info --}}
            <div class="flex-1 text-center md:text-left">
                <div class="inline-flex items-center gap-2 bg-white/20 backdrop-blur px-3 py-1.5 rounded-xl text-xs font-black uppercase tracking-widest mb-3">
                    <span class="w-2 h-2 rounded-full bg-white animate-pulse"></span>
                    {{ $rm['label'] }}
                </div>
                <h1 class="text-3xl font-black tracking-tight mb-2">Attendance Insights</h1>
                <p class="text-white/80 font-medium mb-4">{{ $rm['desc'] }}</p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start text-sm font-bold">
                    <span class="bg-white/20 px-4 py-2 rounded-xl">{{ $present }} Present</span>
                    <span class="bg-white/20 px-4 py-2 rounded-xl">{{ $absent }} Absent</span>
                    <span class="bg-white/20 px-4 py-2 rounded-xl">{{ $total }} Total Classes</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Progress Bar + Threshold ─────────────────────────────── --}}
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-2">
            <h3 class="font-bold text-slate-800">Attendance vs Required Threshold</h3>
            <span class="text-xs font-black text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100">75% Required</span>
        </div>
        <div class="relative h-6 bg-slate-100 rounded-full overflow-hidden mt-4">
            <div class="h-full rounded-full transition-all duration-1000 ease-out"
                 style="width:{{ min(100, $pct) }}%; background-color:{{ $rm['color'] }}"></div>
            <div class="absolute top-0 h-full w-0.5 bg-indigo-500 opacity-80" style="left:75%"></div>
        </div>
        <div class="flex justify-between mt-2 text-xs font-bold text-slate-400">
            <span>0%</span>
            <span class="text-indigo-600">← 75% Threshold</span>
            <span>100%</span>
        </div>
    </div>

    {{-- ── Prediction + Simulation ──────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Prediction Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-violet-50 to-indigo-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-violet-100 text-violet-600 flex items-center justify-center">
                        <i class="fa-solid fa-arrow-trend-up"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">10-Class Forecast</h3>
                        <p class="text-xs text-slate-400">If current pattern continues</p>
                    </div>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-medium">Now</span>
                    <span class="font-black text-slate-700">{{ $prediction['current_pct'] }}%</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-slate-500 font-medium">After 10 more classes</span>
                    @php $predOk = $prediction['predicted_pct'] >= 75; @endphp
                    <span class="font-black {{ $predOk ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ $prediction['predicted_pct'] }}%
                    </span>
                </div>
                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $predOk ? 'bg-emerald-500' : 'bg-rose-500' }}"
                         style="width:{{ min(100, $prediction['predicted_pct']) }}%"></div>
                </div>
                <p class="text-sm p-3 rounded-xl font-medium {{ $predOk ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                    @if($predOk && $risk !== 'safe')
                        📈 Consistent attendance will bring you above 75% in 10 classes!
                    @elseif(!$predOk)
                        📉 You'll still be below 75% after 10 more classes at this rate.
                    @else
                        ✅ You're on track! Forecast confirms safe attendance.
                    @endif
                </p>
            </div>
        </div>

        {{-- Simulation Card --}}
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center">
                        <i class="fa-solid fa-calculator"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-800">Recovery Plan</h3>
                        <p class="text-xs text-slate-400">Classes needed to reach 75%</p>
                    </div>
                </div>
            </div>
            <div class="p-6 text-center space-y-3">
                @if($simulation['already_safe'])
                    <div class="text-5xl mb-2">🏆</div>
                    <p class="text-lg font-black text-emerald-600">You're safe!</p>
                    <p class="text-sm text-slate-500">Maintain your streak and aim for 85%+ for a safety buffer.</p>
                @elseif($simulation['classes_needed'] < 999)
                    <div class="text-6xl font-black count-up" style="color:{{ $rm['color'] }}">
                        {{ $simulation['classes_needed'] }}
                    </div>
                    <p class="text-sm font-bold text-slate-600">consecutive classes to reach 75%</p>
                    <div class="mt-2 p-3 rounded-xl text-sm font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">
                        🎯 Don't miss a single class for the next <strong>{{ $simulation['classes_needed'] }}</strong> session(s)!
                    </div>
                @else
                    <div class="text-4xl mb-2">🚨</div>
                    <p class="text-sm font-bold text-rose-600">Critical — contact your academic advisor immediately.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- ── AI Message ────────────────────────────────────────────── --}}
    @if($ai_message)
    <div class="relative overflow-hidden rounded-[2rem] p-7 shadow-lg"
         style="background: linear-gradient(135deg, rgba(99,102,241,0.08), rgba(168,85,247,0.06)); border: 1px solid rgba(99,102,241,0.15);">
        <div class="absolute -top-6 -right-6 w-32 h-32 rounded-full opacity-10 pointer-events-none"
             style="background: radial-gradient(circle, #6366f1, transparent); filter:blur(20px);"></div>
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl flex-shrink-0 flex items-center justify-center text-2xl shadow-lg ring-4 ring-white"
                 style="background: linear-gradient(135deg, #6366f1, #a855f7);">🤖</div>
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <span class="text-xs font-black uppercase tracking-widest text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full border border-indigo-100">AI Mentor</span>
                    <span class="text-xs font-black uppercase tracking-widest text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-100">Personalised</span>
                </div>
                <p class="text-slate-700 font-medium leading-relaxed text-sm">{{ $ai_message }}</p>
            </div>
        </div>
    </div>
    @endif

    {{-- ── Insights & Suggestions ────────────────────────────────── --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                    <i class="fa-solid fa-lightbulb text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Insights</h3>
            </div>
            <ul class="divide-y divide-slate-50">
                @foreach($insights as $i)
                <li class="px-6 py-4 text-sm text-slate-600 leading-relaxed">{{ $i }}</li>
                @endforeach
            </ul>
        </div>

        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-list-check text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Your Action Plan</h3>
            </div>
            <ul class="divide-y divide-slate-50">
                @foreach($suggestions as $s)
                <li class="px-6 py-4 flex items-start gap-3">
                    <span class="mt-0.5 w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </span>
                    <span class="text-sm text-slate-600 leading-relaxed">{{ $s }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- ── Subject Breakdown ─────────────────────────────────────── --}}
    @if(count($breakdown) > 0)
    <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 flex items-center justify-center">
                <i class="fa-solid fa-book-open text-sm"></i>
            </div>
            <h3 class="font-bold text-slate-800">Subject-wise Attendance</h3>
        </div>
        <div class="divide-y divide-slate-50">
            @foreach($breakdown as $sub)
            @php
                $sr = $sub['risk'];
                $sc = match($sr) { 'critical' => '#EF4444', 'at_risk' => '#F59E0B', default => '#10B981' };
                $sb = match($sr) { 'critical' => 'bg-rose-100 text-rose-700', 'at_risk' => 'bg-amber-100 text-amber-700', default => 'bg-emerald-100 text-emerald-700' };
                $sl = match($sr) { 'critical' => '🔴', 'at_risk' => '🟡', default => '🟢' };
            @endphp
            <div class="px-6 py-4 flex items-center gap-4">
                <div class="w-9 h-9 rounded-xl bg-slate-50 border border-slate-100 flex items-center justify-center font-black text-slate-600 text-sm flex-shrink-0">
                    {{ strtoupper(substr($sub['subject'], 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-bold text-slate-700 truncate">{{ $sub['subject'] }}</span>
                        <span class="text-xs font-black ml-2" style="color:{{ $sc }}">{{ $sub['pct'] }}%</span>
                    </div>
                    <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full rounded-full" style="width:{{ min(100, $sub['pct']) }}%; background-color:{{ $sc }}"></div>
                    </div>
                    <div class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $sub['present'] }}/{{ $sub['total'] }} classes</div>
                </div>
                <span class="text-xs font-black px-2.5 py-1 rounded-lg {{ $sb }} flex-shrink-0">{{ $sl }}</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection
