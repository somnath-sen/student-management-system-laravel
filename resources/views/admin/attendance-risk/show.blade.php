@extends('layouts.admin')

@section('title', 'Attendance Prediction – ' . $student->user->name)

@section('content')
@php
    $riskColors = [
        'safe'     => ['ring' => 'ring-emerald-200', 'text' => '#10B981', 'badge' => 'bg-emerald-100 text-emerald-700 border-emerald-200', 'label' => '🟢 Safe — Exam Eligible'],
        'at_risk'  => ['ring' => 'ring-amber-200',   'text' => '#F59E0B', 'badge' => 'bg-amber-100 text-amber-700 border-amber-200',   'label' => '🟡 At Risk — Needs Improvement'],
        'critical' => ['ring' => 'ring-rose-200',    'text' => '#EF4444', 'badge' => 'bg-rose-100 text-rose-700 border-rose-200',    'label' => '🔴 Critical — Immediate Action Required'],
    ];
    $rc = $riskColors[$risk];
@endphp

<div class="max-w-5xl mx-auto space-y-8">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.attendance-risk.index') }}" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-500 hover:text-indigo-600 transition-colors shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div class="flex-1">
            <h1 class="text-2xl font-extrabold text-slate-900">Attendance Prediction: {{ $student->user->name }}</h1>
            <p class="text-sm text-slate-500 mt-0.5">Threshold: 75% | Current: {{ $pct }}%</p>
        </div>
        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-black border {{ $rc['badge'] }}">
            {{ $rc['label'] }}
        </span>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        @foreach([
            ['label' => 'Total Classes', 'value' => $total,   'icon' => 'fa-calendar', 'color' => 'indigo'],
            ['label' => 'Present',       'value' => $present, 'icon' => 'fa-circle-check', 'color' => 'emerald'],
            ['label' => 'Absent',        'value' => $absent,  'icon' => 'fa-circle-xmark', 'color' => 'rose'],
            ['label' => 'Current %',     'value' => $pct.'%', 'icon' => 'fa-percent',      'color' => 'amber'],
        ] as $stat)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 text-center">
            <div class="w-10 h-10 rounded-xl bg-{{ $stat['color'] }}-50 text-{{ $stat['color'] }}-500 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid {{ $stat['icon'] }}"></i>
            </div>
            <p class="text-2xl font-black text-slate-800">{{ $stat['value'] }}</p>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide mt-1">{{ $stat['label'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Attendance Progress Bar --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <h3 class="font-bold text-slate-800">Attendance Progress</h3>
            <span class="text-sm font-black" style="color:{{ $rc['text'] }}">{{ $pct }}% / 75% Required</span>
        </div>
        <div class="relative w-full h-5 bg-slate-100 rounded-full overflow-hidden">
            <div class="h-full rounded-full transition-all duration-1000"
                 style="width:{{ min(100, $pct) }}%; background-color:{{ $rc['text'] }}"></div>
            {{-- Threshold marker at 75% --}}
            <div class="absolute top-0 h-full w-0.5 bg-indigo-500 opacity-70" style="left:75%"></div>
        </div>
        <div class="flex justify-between mt-2 text-xs font-bold text-slate-400">
            <span>0%</span>
            <span class="text-indigo-500">75% Required ↑</span>
            <span>100%</span>
        </div>
    </div>

    {{-- Prediction + Simulation --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Prediction --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-indigo-50 to-purple-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                    <i class="fa-solid fa-arrow-trend-up text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">10-Class Prediction</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">Current attendance</span>
                    <span class="text-sm font-black text-slate-700">{{ $prediction['current_pct'] }}%</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-slate-500">If same pattern continues</span>
                    @php $predColor = $prediction['predicted_pct'] >= 75 ? 'text-emerald-600' : 'text-rose-600'; @endphp
                    <span class="text-sm font-black {{ $predColor }}">{{ $prediction['predicted_pct'] }}%</span>
                </div>
                <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                    <div class="h-full rounded-full {{ $prediction['predicted_pct'] >= 75 ? 'bg-emerald-500' : 'bg-rose-500' }}" style="width:{{ min(100, $prediction['predicted_pct']) }}%"></div>
                </div>
                @if($prediction['predicted_pct'] >= 75 && $pct < 75)
                    <p class="text-sm text-emerald-700 bg-emerald-50 p-3 rounded-xl font-medium">
                        📈 With continued attendance, you'll reach the threshold after 10 more classes!
                    </p>
                @elseif($prediction['predicted_pct'] < 75)
                    <p class="text-sm text-rose-700 bg-rose-50 p-3 rounded-xl font-medium">
                        📉 At your current rate, you will still be below 75% after 10 more classes.
                    </p>
                @endif
            </div>
        </div>

        {{-- Simulation --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-gradient-to-r from-amber-50 to-orange-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                    <i class="fa-solid fa-calculator text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Recovery Simulation</h3>
            </div>
            <div class="p-6 space-y-4">
                @if($simulation['already_safe'])
                    <div class="text-center py-4">
                        <div class="w-14 h-14 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto mb-3 text-2xl">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <p class="font-bold text-emerald-700">Already above 75%!</p>
                        <p class="text-sm text-slate-500 mt-1">Keep maintaining your attendance streak.</p>
                    </div>
                @elseif($simulation['classes_needed'] < 999)
                    <div class="text-center py-2">
                        <div class="text-5xl font-black mb-1" style="color:{{ $rc['text'] }}">
                            {{ $simulation['classes_needed'] }}
                        </div>
                        <p class="text-sm font-bold text-slate-600">consecutive classes needed</p>
                        <p class="text-sm text-slate-500 mt-2">to reach the 75% required threshold</p>
                    </div>
                    <div class="mt-4 p-3 bg-indigo-50 rounded-xl text-sm text-indigo-700 font-medium text-center">
                        🎯 Attend every class for the next <strong>{{ $simulation['classes_needed'] }}</strong> session(s) without absence.
                    </div>
                @else
                    <div class="text-center py-4">
                        <div class="text-4xl mb-2">🚨</div>
                        <p class="font-bold text-rose-700 text-sm">Recovery requires special consideration.</p>
                        <p class="text-sm text-slate-500 mt-1">Contact the academic office for a condonation review.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Insights & Suggestions --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-violet-50 text-violet-600 flex items-center justify-center">
                    <i class="fa-solid fa-lightbulb text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Insights</h3>
            </div>
            <ul class="divide-y divide-slate-50">
                @forelse($insights as $insight)
                <li class="px-6 py-4 text-sm text-slate-600 leading-relaxed">{{ $insight }}</li>
                @empty
                <li class="px-6 py-4 text-sm text-slate-400 italic">No insights available.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 bg-slate-50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i class="fa-solid fa-list-check text-sm"></i>
                </div>
                <h3 class="font-bold text-slate-800">Recommendations</h3>
            </div>
            <ul class="divide-y divide-slate-50">
                @forelse($suggestions as $s)
                <li class="px-6 py-4 flex items-start gap-3">
                    <span class="mt-0.5 w-5 h-5 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-[10px]"></i>
                    </span>
                    <span class="text-sm text-slate-600 leading-relaxed">{{ $s }}</span>
                </li>
                @empty
                <li class="px-6 py-4 text-sm text-slate-400 italic">No suggestions available.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Subject Breakdown --}}
    @if(count($breakdown) > 0)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
            <h3 class="font-bold text-slate-800">Subject-wise Breakdown</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-widest font-black">
                        <th class="px-6 py-3 border-b border-slate-100">Subject</th>
                        <th class="px-6 py-3 border-b border-slate-100 text-center">Present</th>
                        <th class="px-6 py-3 border-b border-slate-100 text-center">Total</th>
                        <th class="px-6 py-3 border-b border-slate-100">Attendance</th>
                        <th class="px-6 py-3 border-b border-slate-100 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($breakdown as $sub)
                    @php
                        $sr = $sub['risk'];
                        $sColor = match($sr) { 'critical' => 'bg-rose-500', 'at_risk' => 'bg-amber-400', default => 'bg-emerald-500' };
                        $sBadge = match($sr) { 'critical' => 'bg-rose-100 text-rose-700 border-rose-200', 'at_risk' => 'bg-amber-100 text-amber-700 border-amber-200', default => 'bg-emerald-100 text-emerald-700 border-emerald-200' };
                        $sLabel = match($sr) { 'critical' => '🔴 Critical', 'at_risk' => '🟡 At Risk', default => '🟢 Safe' };
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-3 font-bold text-slate-700 text-sm">{{ $sub['subject'] }}</td>
                        <td class="px-6 py-3 text-center text-emerald-600 font-bold">{{ $sub['present'] }}</td>
                        <td class="px-6 py-3 text-center text-slate-500">{{ $sub['total'] }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $sColor }}" style="width:{{ min(100, $sub['pct']) }}%"></div>
                                </div>
                                <span class="text-sm font-bold text-slate-600">{{ $sub['pct'] }}%</span>
                            </div>
                        </td>
                        <td class="px-6 py-3 text-center">
                            <span class="text-xs font-black px-2.5 py-1 rounded-lg border {{ $sBadge }}">{{ $sLabel }}</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

</div>
@endsection
