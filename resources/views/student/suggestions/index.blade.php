@extends('layouts.student')

@section('title', 'EdFlow | 🧠 AI Study Coach')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ══════════════════════════════════════════
       SUGGESTION ENGINE — CLEAN SAAS DESIGN
    ══════════════════════════════════════════ */
    * { font-family: 'Outfit', sans-serif; }

    .sg-root {
        min-height: 100vh;
        background: #F8FAFC;
        padding: 2rem 1rem 5rem;
        color: #0F172A;
    }

    /* Clean Card Base */
    .sg-glass {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
        border-radius: 0.75rem;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .sg-glass:hover {
        border-color: #CBD5E1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
    }

    /* Danger Card (Weak Subjects) */
    .sg-danger-card {
        background: #FFFFFF;
        border: 1px solid #FECACA;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }
    .sg-danger-card:hover {
        border-color: #F87171;
        box-shadow: 0 4px 6px -1px rgba(239, 68, 68, 0.05), 0 2px 4px -2px rgba(239, 68, 68, 0.05);
    }

    /* Suggestion Cards */
    .sg-suggestion-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
        border-radius: 0.75rem;
        transition: all 0.2s ease;
    }
    .sg-suggestion-card:hover {
        border-color: #CBD5E1;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
    }

    /* Performance level badges */
    .badge-strong    { background: #F0FDF4; color: #166534; border: 1px solid #DCFCE7; }
    .badge-average   { background: #FEFCE8; color: #854D0E; border: 1px solid #FEF08A; }
    .badge-weak      { background: #FEF2F2; color: #991B1B; border: 1px solid #FEE2E2; }
    .badge-very-weak { background: #FEF2F2; color: #7F1D1D; border: 1px solid #FECACA; }

    /* Suggestion type icons */
    .sg-icon-study      { background: #F3E8FF; color: #7E22CE; }
    .sg-icon-attendance { background: #FFE4E6; color: #BE123C; }
    .sg-icon-warning    { background: #FEF2F2; color: #B91C1C; }
    .sg-icon-tip        { background: #E0F2FE; color: #0369A1; }
    .sg-icon-schedule   { background: #D1FAE5; color: #047857; }
    .sg-icon-motivation { background: #FEF3C7; color: #B45309; }

    /* Progress bars */
    .sg-progress-track {
        background: #F1F5F9;
        border-radius: 999px;
        height: 6px;
        overflow: hidden;
    }
    .sg-progress-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 1s ease-in-out;
    }
    .fill-strong  { background: #10B981; }
    .fill-average { background: #F59E0B; }
    .fill-weak    { background: #EF4444; }
    .fill-very-weak { background: #B91C1C; }

    /* Overall status banner */
    .status-excellent { background: #0F172A; color: #F8FAFC; border: 1px solid #1E293B; }
    .status-average   { background: #FFFFFF; color: #0F172A; border: 1px solid #E2E8F0; }
    .status-weak      { background: #FEF2F2; color: #7F1D1D; border: 1px solid #FECACA; }

    /* Clean Fade-in-up animation */
    .fade-up {
        opacity: 0;
        transform: translateY(10px);
        animation: fadeUp 0.4s ease-out forwards;
    }
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.05s; }
    .delay-2 { animation-delay: 0.1s; }
    .delay-3 { animation-delay: 0.15s; }
    .delay-4 { animation-delay: 0.2s; }
    .delay-5 { animation-delay: 0.25s; }
    .delay-6 { animation-delay: 0.3s; }
    .delay-7 { animation-delay: 0.35s; }

    /* Refresh button */
    .sg-refresh-btn {
        background: #FFFFFF;
        color: #334155;
        border: 1px solid #CBD5E1;
        border-radius: 0.5rem;
        padding: 0.5rem 1rem;
        font-weight: 500;
        font-size: 0.875rem;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sg-refresh-btn:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: #0F172A;
    }
    .sg-refresh-btn:active { background: #F1F5F9; }
    .sg-refresh-btn:disabled { opacity: 0.6; cursor: not-allowed; }

    /* Spin animation for refresh icon */
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinning { animation: spin 1s linear infinite; }

    /* Section divider title */
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    /* Content container */
    .sg-content { max-width: 1100px; margin: 0 auto; position: relative; z-index: 1; }
</style>

<div class="sg-root" id="sg-root">

    <div class="sg-content space-y-8">

        {{-- ─── HEADER ─── --}}
        <div class="fade-up delay-1 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 leading-tight">
                    AI Suggestion Engine
                </h1>
                <p class="text-slate-500 font-medium mt-1 text-sm">
                    Personalized insights based on your marks &amp; attendance
                </p>
            </div>

            <div class="flex flex-col items-start md:items-end gap-2 shrink-0">
                <button id="sg-refresh-btn" class="sg-refresh-btn" onclick="refreshSuggestions()">
                    <i class="fa-solid fa-rotate-right text-slate-400" id="refresh-icon"></i>
                    Generate AI Plan
                </button>
                <p class="text-xs text-slate-400 font-medium">
                    Last updated: <span id="gen-time">{{ $generatedAt ? $generatedAt->format('M d, Y H:i') : 'Never' }}</span>
                </p>
            </div>
        </div>

        {{-- ─── OVERALL STATUS BANNER ─── --}}
        @php
            $levelConfig = match($overallLevel) {
                'Strong'    => ['class' => 'status-excellent', 'icon' => 'fa-trophy',      'label' => 'Excellent Performance', 'msg' => 'Keep up the outstanding work! You are performing above average in most subjects.'],
                'Average'   => ['class' => 'status-average',   'icon' => 'fa-chart-line',  'label' => 'Average Performance',   'msg' => 'You are doing okay, but there is clear room for improvement in several areas.'],
                'Weak'      => ['class' => 'status-weak',      'icon' => 'fa-triangle-exclamation', 'label' => 'Needs Improvement', 'msg' => 'Your performance is below expectations. Focus on the weak subjects highlighted below.'],
                'Very Weak' => ['class' => 'status-weak',      'icon' => 'fa-circle-exclamation',  'label' => 'Critical — Action Required', 'msg' => 'Immediate action is required. You are at serious risk in multiple subjects.'],
                default     => ['class' => 'status-average',   'icon' => 'fa-chart-line',  'label' => 'Average Performance',   'msg' => 'Analysis in progress — please check back shortly.'],
            };
        @endphp

        <div id="status-banner" class="fade-up delay-2 {{ $levelConfig['class'] }} rounded-xl p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center gap-6 shadow-sm">
            <div class="w-12 h-12 rounded-full flex items-center justify-center shrink-0 {{ $levelConfig['class'] === 'status-excellent' ? 'bg-slate-800' : ($levelConfig['class'] === 'status-weak' ? 'bg-red-100' : 'bg-slate-100') }}">
                <i class="fa-solid {{ $levelConfig['icon'] }} text-xl {{ $levelConfig['class'] === 'status-excellent' ? 'text-slate-300' : ($levelConfig['class'] === 'status-weak' ? 'text-red-600' : 'text-slate-600') }}"></i>
            </div>
            <div class="flex-1">
                <p class="text-xs font-semibold uppercase tracking-wider mb-1 {{ $levelConfig['class'] === 'status-excellent' ? 'text-slate-400' : ($levelConfig['class'] === 'status-weak' ? 'text-red-400' : 'text-slate-500') }}">Overall Status</p>
                <h2 class="text-xl font-bold mb-1 {{ $levelConfig['class'] === 'status-excellent' ? 'text-white' : ($levelConfig['class'] === 'status-weak' ? 'text-red-900' : 'text-slate-900') }}">{{ $levelConfig['label'] }}</h2>
                <p class="font-medium text-sm leading-relaxed {{ $levelConfig['class'] === 'status-excellent' ? 'text-slate-300' : ($levelConfig['class'] === 'status-weak' ? 'text-red-700' : 'text-slate-600') }}">{{ $levelConfig['msg'] }}</p>
            </div>
            <div class="shrink-0 text-left md:text-right">
                <p class="text-xs font-semibold uppercase tracking-wider {{ $levelConfig['class'] === 'status-excellent' ? 'text-slate-400' : ($levelConfig['class'] === 'status-weak' ? 'text-red-400' : 'text-slate-500') }}">Current Level</p>
                <p class="text-3xl font-bold mt-1 {{ $levelConfig['class'] === 'status-excellent' ? 'text-white' : ($levelConfig['class'] === 'status-weak' ? 'text-red-900' : 'text-slate-800') }}">{{ $overallLevel }}</p>
            </div>
        </div>

        {{-- ─── SUBJECT PERFORMANCE GRID ─── --}}
        <div class="fade-up delay-3">
            <div class="section-title">
                <i class="fa-solid fa-chart-bar text-slate-400 text-sm"></i>
                Subject Performance Status
            </div>
            @if(count($analysis) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4" id="analysis-grid">
                @foreach($analysis as $i => $subject)
                @php
                    $lvl = $subject['level'];
                    $badgeClass = match($lvl) {
                        'Strong'    => 'badge-strong',
                        'Average'   => 'badge-average',
                        'Weak'      => 'badge-weak',
                        'Very Weak' => 'badge-very-weak',
                        default     => 'badge-average',
                    };
                    $fillClass = match($lvl) {
                        'Strong'    => 'fill-strong',
                        'Average'   => 'fill-average',
                        'Weak'      => 'fill-weak',
                        'Very Weak' => 'fill-very-weak',
                        default     => 'fill-average',
                    };
                @endphp
                <div class="sg-glass p-5">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 pr-2">
                            <h3 class="font-semibold text-slate-800 text-base leading-tight">
                                {{ $subject['subject_name'] }}
                            </h3>
                        </div>
                        <span class="text-[11px] font-semibold px-2.5 py-1 rounded-md shrink-0 {{ $badgeClass }}">
                            {{ $lvl }}
                        </span>
                    </div>

                    <div class="space-y-4">
                        <!-- Marks -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Marks</span>
                                <span class="text-xs font-bold text-slate-700">
                                    {{ $subject['marks_obtained'] ?? '—' }}/{{ $subject['total_marks'] ?? '—' }}
                                    ({{ $subject['marks_pct'] }}%)
                                </span>
                            </div>
                            <div class="sg-progress-track">
                                <div class="sg-progress-fill {{ $fillClass }}" style="width: {{ $subject['marks_pct'] }}%"></div>
                            </div>
                        </div>

                        <!-- Attendance -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Attendance</span>
                                <span class="text-xs font-bold text-slate-700">
                                    {{ $subject['att_present'] ?? '—' }}/{{ $subject['att_total'] ?? '—' }}
                                    ({{ $subject['att_pct'] }}%)
                                </span>
                            </div>
                            <div class="sg-progress-track">
                                <div class="sg-progress-fill {{ $subject['att_pct'] >= 75 ? 'fill-strong' : ($subject['att_pct'] >= 60 ? 'fill-average' : 'fill-weak') }}"
                                     style="width: {{ $subject['att_pct'] }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="sg-glass p-10 text-center text-slate-500 font-medium text-sm">
                No performance data available yet. Marks and attendance will appear here once recorded.
            </div>
            @endif
        </div>

        {{-- ─── WEAK SUBJECTS SPOTLIGHT ─── --}}
        @if(count($weakSubjects) > 0)
        <div class="fade-up delay-4" id="weak-section">
            <div class="section-title">
                <i class="fa-solid fa-triangle-exclamation text-red-500 text-sm"></i>
                Focus Required
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="weak-grid">
                @foreach($weakSubjects as $subject)
                <div class="sg-danger-card p-5">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 bg-red-100">
                            <i class="fa-solid fa-exclamation text-red-600 text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <h3 class="font-bold text-slate-800 text-base">{{ $subject['subject_name'] }}</h3>
                                @if($subject['level'] === 'Very Weak')
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md badge-very-weak">CRITICAL</span>
                                @else
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md badge-weak">WEAK</span>
                                @endif
                            </div>
                            <div class="flex gap-5 mt-2">
                                <div>
                                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Marks</p>
                                    <p class="text-lg font-bold text-red-600">{{ $subject['marks_pct'] }}%</p>
                                </div>
                                <div class="w-px bg-slate-200"></div>
                                <div>
                                    <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Attendance</p>
                                    <p class="text-lg font-bold {{ $subject['att_pct'] < 75 ? 'text-red-600' : 'text-emerald-600' }}">
                                        {{ $subject['att_pct'] }}%
                                    </p>
                                </div>
                            </div>
                            @if($subject['marks_pct'] < 40)
                            <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-red-700 bg-red-50 px-2 py-1 rounded-md">
                                You may fail this subject. Seek help immediately.
                            </div>
                            @elseif($subject['att_pct'] < 75)
                            <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-semibold text-amber-800 bg-amber-50 px-2 py-1 rounded-md">
                                Attendance below 75% — eligibility at risk.
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ─── AI SUGGESTION CARDS ─── --}}
        <div class="fade-up delay-5">
            <div class="section-title">
                <i class="fa-solid fa-lightbulb text-amber-500 text-sm"></i>
                Recommendations
            </div>

            @if(count($suggestions) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4" id="suggestions-grid">
                @foreach($suggestions as $i => $suggestion)
                @php
                    $typeConfig = match($suggestion['type'] ?? 'tip') {
                        'study'      => ['icon' => 'fa-book-open',           'class' => 'sg-icon-study',      'label' => 'Study'],
                        'attendance' => ['icon' => 'fa-calendar-check',      'class' => 'sg-icon-attendance', 'label' => 'Attendance'],
                        'warning'    => ['icon' => 'fa-triangle-exclamation','class' => 'sg-icon-warning',    'label' => 'Warning'],
                        'schedule'   => ['icon' => 'fa-clock',               'class' => 'sg-icon-schedule',   'label' => 'Schedule'],
                        'motivation' => ['icon' => 'fa-fire-flame-curved',   'class' => 'sg-icon-motivation', 'label' => 'Motivation'],
                        default      => ['icon' => 'fa-lightbulb',           'class' => 'sg-icon-tip',        'label' => 'Tip'],
                    };
                    $priority = $suggestion['priority'] ?? 'medium';
                    $priorityText = match($priority) {
                        'high'   => 'text-red-600',
                        'medium' => 'text-amber-600',
                        default  => 'text-emerald-600',
                    };
                @endphp
                <div class="sg-suggestion-card p-5 flex flex-col gap-3">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-full {{ $typeConfig['class'] }} flex items-center justify-center shrink-0">
                            <i class="fa-solid {{ $typeConfig['icon'] }} text-sm"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between mb-1">
                                <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">
                                    {{ $typeConfig['label'] }}
                                </span>
                                <span class="text-[10px] font-bold uppercase tracking-wider {{ $priorityText }}">
                                    {{ $priority }}
                                </span>
                            </div>
                            <h3 class="font-semibold text-slate-800 text-sm leading-tight mb-2">
                                {{ $suggestion['title'] ?? 'Study Tip' }}
                            </h3>
                            <p class="text-slate-600 text-xs leading-relaxed">
                                {{ $suggestion['message'] ?? '' }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="sg-glass p-8 text-center">
                <p class="text-slate-500 font-medium text-sm mb-4">No suggestions generated yet.</p>
                <button class="sg-refresh-btn" onclick="refreshSuggestions()">
                    Generate Plan Now
                </button>
            </div>
            @endif
        </div>

        {{-- ─── DAILY STUDY PLAN ─── --}}
        @if(count($analysis) > 0)
        <div class="fade-up delay-6">
            <div class="section-title">
                <i class="fa-solid fa-calendar-days text-indigo-500 text-sm"></i>
                Daily Study Plan
            </div>
            <div class="sg-glass p-5">
                <p class="text-xs text-slate-500 font-medium mb-4">Suggested daily hours based on your performance:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($analysis as $subject)
                    @php
                        $hours = match($subject['level']) {
                            'Very Weak' => 3.0,
                            'Weak'      => 2.0,
                            'Average'   => 1.5,
                            'Strong'    => 0.5,
                            default     => 1.0,
                        };
                        $maxHours = 3;
                        $widthPct = ($hours / $maxHours) * 100;
                    @endphp
                    <div class="flex items-center gap-3 p-3 rounded-lg bg-slate-50 border border-slate-100">
                        <div class="shrink-0 text-center w-12">
                            <p class="text-xl font-bold text-slate-800">{{ $hours }}h</p>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-slate-700 text-xs mb-1">{{ $subject['subject_name'] }}</p>
                            <div class="sg-progress-track" style="height: 4px;">
                                <div class="sg-progress-fill {{ $subject['level'] === 'Strong' ? 'fill-strong' : ($subject['level'] === 'Average' ? 'fill-average' : 'fill-weak') }}"
                                     style="width: {{ $widthPct }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        {{-- ─── BACK TO DASHBOARD ─── --}}
        <div class="fade-up delay-7 flex justify-center pt-2">
            <a href="{{ route('student.dashboard') }}"
               class="inline-flex items-center gap-1.5 text-xs font-medium text-slate-500 hover:text-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

    </div><!-- /.sg-content -->
</div><!-- /.sg-root -->

{{-- ─── AJAX REFRESH SCRIPT ─── --}}
<script>
function refreshSuggestions() {
    const btn  = document.getElementById('sg-refresh-btn');
    const icon = document.getElementById('refresh-icon');

    btn.disabled = true;
    icon.classList.add('spinning');
    btn.innerHTML = '<i class="fa-solid fa-rotate-right spinning text-slate-400" id="refresh-icon"></i> Generating...';

    fetch('{{ route("student.suggestions.refresh") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('gen-time').textContent = data.generated_at;

            // Update subject analysis grid
            const analysisGrid = document.getElementById('analysis-grid');
            if (analysisGrid && data.analysis) {
                renderAnalysisGrid(analysisGrid, data.analysis);
            }

            // Update suggestion cards
            const sgGrid = document.getElementById('suggestions-grid');
            if (sgGrid && data.suggestions) {
                renderSuggestions(sgGrid, data.suggestions);
            }

            // Update status banner color
            updateStatusBanner(data.overall_level);

            showToast('AI plan generated', 'success');
        } else {
            showToast('Something went wrong', 'error');
        }
    })
    .catch(() => showToast('Network error', 'error'))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-rotate-right text-slate-400" id="refresh-icon"></i> Generate AI Plan';
    });
}

function renderAnalysisGrid(container, analysis) {
    const levelBadge = { 'Strong': 'badge-strong', 'Average': 'badge-average', 'Weak': 'badge-weak', 'Very Weak': 'badge-very-weak' };
    const fillClass  = { 'Strong': 'fill-strong', 'Average': 'fill-average', 'Weak': 'fill-weak', 'Very Weak': 'fill-very-weak' };

    container.innerHTML = analysis.map(s => {
        const lvl = s.level;
        const cls = levelBadge[lvl] || 'badge-average';
        const fc  = fillClass[lvl] || 'fill-average';
        const attFc = s.att_pct >= 75 ? 'fill-strong' : (s.att_pct >= 60 ? 'fill-average' : 'fill-weak');

        return `
        <div class="sg-glass p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1 pr-2">
                    <h3 class="font-semibold text-slate-800 text-base leading-tight">${s.subject_name}</h3>
                </div>
                <span class="text-[11px] font-semibold px-2.5 py-1 rounded-md shrink-0 ${cls}">${lvl}</span>
            </div>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Marks</span>
                        <span class="text-xs font-bold text-slate-700">${s.marks_obtained ?? '—'}/${s.total_marks ?? '—'} (${s.marks_pct}%)</span>
                    </div>
                    <div class="sg-progress-track"><div class="sg-progress-fill ${fc}" style="width:${s.marks_pct}%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wide">Attendance</span>
                        <span class="text-xs font-bold text-slate-700">${s.att_present ?? '—'}/${s.att_total ?? '—'} (${s.att_pct}%)</span>
                    </div>
                    <div class="sg-progress-track"><div class="sg-progress-fill ${attFc}" style="width:${s.att_pct}%"></div></div>
                </div>
            </div>
        </div>`;
    }).join('');
}

function renderSuggestions(container, suggestions) {
    const typeMap = {
        'study':      { icon: 'fa-book-open',            cls: 'sg-icon-study',      label: 'Study' },
        'attendance': { icon: 'fa-calendar-check',       cls: 'sg-icon-attendance', label: 'Attendance' },
        'warning':    { icon: 'fa-triangle-exclamation', cls: 'sg-icon-warning',    label: 'Warning' },
        'schedule':   { icon: 'fa-clock',                cls: 'sg-icon-schedule',   label: 'Schedule' },
        'motivation': { icon: 'fa-fire-flame-curved',    cls: 'sg-icon-motivation', label: 'Motivation' },
        'tip':        { icon: 'fa-lightbulb',            cls: 'sg-icon-tip',        label: 'Tip' },
    };
    const priorityTextMap = {
        'high':   'text-red-600',
        'medium': 'text-amber-600',
        'low':    'text-emerald-600',
    };

    container.innerHTML = suggestions.map((s, i) => {
        const t   = typeMap[s.type] || typeMap['tip'];
        const p   = s.priority || 'medium';
        const pt  = priorityTextMap[p] || priorityTextMap['medium'];

        return `
        <div class="sg-suggestion-card p-5 flex flex-col gap-3">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-full ${t.cls} flex items-center justify-center shrink-0">
                    <i class="fa-solid ${t.icon} text-sm"></i>
                </div>
                <div class="flex-1">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-[10px] font-semibold uppercase tracking-wider text-slate-500">${t.label}</span>
                        <span class="text-[10px] font-bold uppercase tracking-wider ${pt}">${p}</span>
                    </div>
                    <h3 class="font-semibold text-slate-800 text-sm leading-tight mb-2">${s.title || 'Study Tip'}</h3>
                    <p class="text-slate-600 text-xs leading-relaxed">${s.message || ''}</p>
                </div>
            </div>
        </div>`;
    }).join('');
}

function updateStatusBanner(level) {
    const banner = document.getElementById('status-banner');
    if (!banner) return;
    
    // reset banner classes
    banner.className = 'fade-up delay-2 rounded-xl p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center gap-6 shadow-sm';
    
    // add proper status class
    const cls = (level === 'Strong') ? 'status-excellent' : (level === 'Average' ? 'status-average' : 'status-weak');
    banner.classList.add(cls);
}

function showToast(msg, type) {
    const t = document.createElement('div');
    t.className = `fixed bottom-6 right-6 z-50 px-4 py-3 rounded-lg font-medium text-sm shadow-lg text-white transition-all duration-300 ${type === 'success' ? 'bg-slate-800' : 'bg-red-600'}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(10px)'; }, 3000);
    setTimeout(() => t.remove(), 3300);
}
</script>

@endsection

