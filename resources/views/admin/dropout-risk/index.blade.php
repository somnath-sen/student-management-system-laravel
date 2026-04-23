@extends('layouts.admin')

@section('title', 'Dropout Risk Monitoring')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">

    {{-- Page Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shadow-sm">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                </span>
                Dropout Risk Monitoring
            </h1>
            <p class="text-sm text-slate-500 mt-1">AI-powered early warning system identifying students at risk of dropout.</p>
        </div>
        <form action="{{ route('admin.dropout-risk.reevaluate-all') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-all shadow-md shadow-indigo-500/20">
                <i class="fa-solid fa-rotate"></i>
                Re-evaluate All Students
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-emerald-500"></i>
            <p class="text-emerald-700 font-medium text-sm">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        {{-- High Risk --}}
        <div class="bg-white rounded-2xl border border-rose-100 p-6 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500">
                    <i class="fa-solid fa-skull-crossbones text-xl"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-rose-500 bg-rose-50 px-2 py-1 rounded-lg border border-rose-100">High Risk</span>
            </div>
            <p class="text-4xl font-black text-slate-900">{{ $highRiskCount }}</p>
            <p class="text-sm text-slate-500 font-medium mt-1">Student(s) need immediate action</p>
        </div>

        {{-- At Risk --}}
        <div class="bg-white rounded-2xl border border-amber-100 p-6 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 px-2 py-1 rounded-lg border border-amber-100">At Risk</span>
            </div>
            <p class="text-4xl font-black text-slate-900">{{ $atRiskCount }}</p>
            <p class="text-sm text-slate-500 font-medium mt-1">Student(s) need attention</p>
        </div>

        {{-- Safe --}}
        <div class="bg-white rounded-2xl border border-emerald-100 p-6 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500">
                    <i class="fa-solid fa-shield-check text-xl"></i>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-2 py-1 rounded-lg border border-emerald-100">Safe</span>
            </div>
            <p class="text-4xl font-black text-slate-900">{{ $safeCount }}</p>
            <p class="text-sm text-slate-500 font-medium mt-1">Student(s) stable</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <form method="GET" action="{{ route('admin.dropout-risk.index') }}" class="flex flex-wrap gap-4 items-end">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Risk Level</label>
                <select name="risk_level" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 outline-none bg-white min-w-[160px]">
                    <option value="">All Levels</option>
                    <option value="high_risk" {{ request('risk_level') === 'high_risk' ? 'selected' : '' }}>🔴 High Risk</option>
                    <option value="at_risk"   {{ request('risk_level') === 'at_risk'   ? 'selected' : '' }}>🟡 At Risk</option>
                    <option value="safe"      {{ request('risk_level') === 'safe'      ? 'selected' : '' }}>🟢 Safe</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Course</label>
                <select name="course_id" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 outline-none bg-white min-w-[180px]">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Sort By Score</label>
                <select name="sort" class="px-4 py-2.5 rounded-xl border border-slate-200 text-sm font-medium focus:ring-2 focus:ring-indigo-500 outline-none bg-white min-w-[160px]">
                    <option value="asc"  {{ request('sort', 'asc') === 'asc'  ? 'selected' : '' }}>Worst First (↑ Risk)</option>
                    <option value="desc" {{ request('sort') === 'desc' ? 'selected' : '' }}>Best First (↓ Risk)</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold rounded-xl transition-all">
                <i class="fa-solid fa-filter mr-2"></i>Apply Filters
            </button>
            @if(request()->hasAny(['risk_level','course_id','sort']))
                <a href="{{ route('admin.dropout-risk.index') }}" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-sm font-bold rounded-xl transition-all">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Main Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-800">Student Risk Overview</h3>
            <span class="text-xs text-slate-400 font-medium">{{ $riskLogs->total() }} student(s) found</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-400 text-[11px] uppercase tracking-widest font-black">
                        <th class="px-6 py-4 border-b border-slate-100">Student</th>
                        <th class="px-6 py-4 border-b border-slate-100">Course</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Attendance</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Avg Marks</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Engagement</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Risk Score</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-center">Status</th>
                        <th class="px-6 py-4 border-b border-slate-100 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riskLogs as $log)
                    @php
                        $level = $log->risk_level;
                        $badgeClass = match($level) {
                            'high_risk' => 'bg-rose-100 text-rose-700 border-rose-200',
                            'at_risk'   => 'bg-amber-100 text-amber-700 border-amber-200',
                            default     => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        };
                        $badgeIcon = match($level) {
                            'high_risk' => '🔴',
                            'at_risk'   => '🟡',
                            default     => '🟢',
                        };
                        $badgeLabel = match($level) {
                            'high_risk' => 'High Risk',
                            'at_risk'   => 'At Risk',
                            default     => 'Safe',
                        };
                        $scoreColor = $log->risk_score >= 75 ? 'text-emerald-600' : ($log->risk_score >= 50 ? 'text-amber-600' : 'text-rose-600');
                        $barColor = $log->risk_score >= 75 ? 'bg-emerald-500' : ($log->risk_score >= 50 ? 'bg-amber-400' : 'bg-rose-500');
                    @endphp
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl {{ $level === 'high_risk' ? 'bg-rose-100 text-rose-600' : ($level === 'at_risk' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600') }} flex items-center justify-center font-black text-sm">
                                    {{ substr($log->student->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm">{{ $log->student->user->name }}</p>
                                    <p class="text-xs text-slate-400 font-medium">{{ $log->student->roll_number }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-sm font-medium text-slate-600">{{ $log->student->course->name ?? '—' }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-slate-700">{{ $log->attendance_score }}%</span>
                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $log->attendance_score >= 75 ? 'bg-emerald-500' : ($log->attendance_score >= 50 ? 'bg-amber-400' : 'bg-rose-500') }}" style="width:{{ min(100, $log->attendance_score) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-slate-700">{{ $log->marks_score }}%</span>
                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $log->marks_score >= 75 ? 'bg-emerald-500' : ($log->marks_score >= 50 ? 'bg-amber-400' : 'bg-rose-500') }}" style="width:{{ min(100, $log->marks_score) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1">
                                <span class="text-sm font-bold text-slate-700">{{ $log->engagement_score }}%</span>
                                <div class="w-16 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $log->engagement_score >= 75 ? 'bg-emerald-500' : ($log->engagement_score >= 50 ? 'bg-amber-400' : 'bg-rose-500') }}" style="width:{{ min(100, $log->engagement_score) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col items-center gap-1.5">
                                <span class="text-xl font-black {{ $scoreColor }}">{{ $log->risk_score }}</span>
                                <div class="w-20 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full rounded-full {{ $barColor }} transition-all" style="width:{{ min(100, $log->risk_score) }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-black border {{ $badgeClass }}">
                                {{ $badgeIcon }} {{ $badgeLabel }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.dropout-risk.show', $log->student_id) }}" class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-50 hover:bg-indigo-600 hover:text-white text-slate-600 text-xs font-bold rounded-xl transition-all border border-slate-200 hover:border-indigo-600">
                                <i class="fa-solid fa-eye"></i> Analyse
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mb-4 text-slate-300">
                                    <i class="fa-solid fa-user-check text-3xl"></i>
                                </div>
                                <p class="font-bold text-slate-600">No students found for these filters.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riskLogs->hasPages())
        <div class="p-5 border-t border-slate-100">
            {{ $riskLogs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
