@extends('layouts.student')

@section('title', 'EdFlow | 🧠 AI Study Coach')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* ══════════════════════════════════════════
       SUGGESTION ENGINE — DESIGN SYSTEM
    ══════════════════════════════════════════ */
    * { font-family: 'Outfit', sans-serif; }

    /* Creamy background with neon orbs */
    .sg-root {
        min-height: 100vh;
        background: #FAF7F2;
        position: relative;
        overflow-x: hidden;
        padding: 2rem 1rem 5rem;
    }

    /* Neon orb blurs */
    .sg-orb {
        position: fixed;
        border-radius: 50%;
        filter: blur(100px);
        pointer-events: none;
        z-index: 0;
        opacity: 0.35;
        animation: orbDrift 18s ease-in-out infinite;
    }
    .sg-orb-1 { width: 500px; height: 500px; background: #E50040; top: -150px; left: -100px; animation-delay: 0s; }
    .sg-orb-2 { width: 600px; height: 600px; background: #7C3AED; bottom: 0; right: -200px; animation-delay: 6s; }
    .sg-orb-3 { width: 350px; height: 350px; background: #DB2777; top: 40%; left: 40%; animation-delay: 12s; }

    @keyframes orbDrift {
        0%   { transform: translate(0, 0) scale(1); }
        33%  { transform: translate(40px, -60px) scale(1.08); }
        66%  { transform: translate(-30px, 40px) scale(0.95); }
        100% { transform: translate(0, 0) scale(1); }
    }

    /* Glass card base */
    .sg-glass {
        background: rgba(255, 255, 255, 0.75);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        box-shadow: 0 8px 40px rgba(0,0,0,0.06), inset 0 1px 0 rgba(255,255,255,0.9);
        border-radius: 2rem;
        transition: all 0.35s cubic-bezier(0.4,0,0.2,1);
    }

    /* Red-glow glass variant for weak subjects */
    .sg-danger-card {
        background: rgba(255, 255, 255, 0.8);
        border: 1px solid rgba(229, 0, 64, 0.25);
        box-shadow: 0 8px 40px rgba(229,0,64,0.12), 0 0 0 1px rgba(229,0,64,0.08) inset;
        border-radius: 2rem;
        transition: all 0.35s ease;
    }
    .sg-danger-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 50px rgba(229, 0, 64, 0.2), 0 0 0 1px rgba(229,0,64,0.15) inset;
    }

    /* Purple-glow suggestion cards */
    .sg-suggestion-card {
        background: rgba(255, 255, 255, 0.85);
        border: 1px solid rgba(124, 58, 237, 0.2);
        box-shadow: 0 8px 30px rgba(124,58,237,0.08);
        border-radius: 1.5rem;
        transition: all 0.3s ease;
    }
    .sg-suggestion-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(124, 58, 237, 0.15);
        border-color: rgba(124, 58, 237, 0.4);
    }

    /* Performance level badges */
    .badge-strong    { background: #ECFDF5; color: #059669; border: 1px solid #A7F3D0; }
    .badge-average   { background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }
    .badge-weak      { background: #FFF1F2; color: #E11D48; border: 1px solid #FECDD3; }
    .badge-very-weak { background: #FFF1F2; color: #9F1239; border: 1px solid #FDA4AF; box-shadow: 0 0 8px rgba(229,0,64,0.2); }

    /* Suggestion type icons */
    .sg-icon-study      { background: linear-gradient(135deg, #7C3AED, #A855F7); }
    .sg-icon-attendance { background: linear-gradient(135deg, #E50040, #F43F5E); }
    .sg-icon-warning    { background: linear-gradient(135deg, #DC2626, #E50040); }
    .sg-icon-tip        { background: linear-gradient(135deg, #0EA5E9, #6366F1); }
    .sg-icon-schedule   { background: linear-gradient(135deg, #059669, #10B981); }
    .sg-icon-motivation { background: linear-gradient(135deg, #F59E0B, #EF4444); }

    /* Progress bars */
    .sg-progress-track {
        background: rgba(0,0,0,0.06);
        border-radius: 999px;
        height: 8px;
        overflow: hidden;
    }
    .sg-progress-fill {
        height: 100%;
        border-radius: 999px;
        transition: width 1.2s cubic-bezier(0.4,0,0.2,1);
    }
    .fill-strong  { background: linear-gradient(90deg, #10B981, #34D399); }
    .fill-average { background: linear-gradient(90deg, #F59E0B, #FBBF24); }
    .fill-weak    { background: linear-gradient(90deg, #E50040, #F43F5E); }
    .fill-very-weak { background: linear-gradient(90deg, #9F1239, #E50040); }

    /* Overall status banner */
    .status-excellent { background: linear-gradient(135deg, #059669, #10B981); }
    .status-average   { background: linear-gradient(135deg, #D97706, #F59E0B); }
    .status-weak      { background: linear-gradient(135deg, #E50040, #9F1239); }

    /* Fade-in-up animation */
    .fade-up {
        opacity: 0;
        transform: translateY(24px);
        animation: fadeUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards;
    }
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }
    .delay-5 { animation-delay: 0.5s; }
    .delay-6 { animation-delay: 0.6s; }
    .delay-7 { animation-delay: 0.7s; }

    /* Refresh button */
    .sg-refresh-btn {
        background: linear-gradient(135deg, #7C3AED, #E50040);
        color: #fff;
        border: none;
        border-radius: 999px;
        padding: 0.85rem 2rem;
        font-weight: 800;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 8px 25px rgba(124,58,237,0.35);
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .sg-refresh-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(124,58,237,0.5);
    }
    .sg-refresh-btn:active { transform: translateY(0); }
    .sg-refresh-btn:disabled { opacity: 0.7; cursor: not-allowed; transform: none; }

    /* Spin animation for refresh icon */
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinning { animation: spin 0.8s linear infinite; }

    /* Section divider title */
    .section-title {
        font-size: 1.35rem;
        font-weight: 900;
        color: #1F2937;
        display: flex;
        align-items: center;
        gap: 0.6rem;
        margin-bottom: 1.25rem;
    }

    /* Pulse dot */
    @keyframes pulse { 0%,100% { opacity:1; } 50% { opacity:0.4; } }
    .dot-pulse { animation: pulse 2s ease-in-out infinite; }

    /* Content container */
    .sg-content { max-width: 1280px; margin: 0 auto; position: relative; z-index: 1; }
</style>

<div class="sg-root" id="sg-root">

    <!-- Background orbs -->
    <div class="sg-orb sg-orb-1"></div>
    <div class="sg-orb sg-orb-2"></div>
    <div class="sg-orb sg-orb-3"></div>

    <div class="sg-content space-y-8">

        {{-- ─── HEADER ─── --}}
        <div class="fade-up delay-1 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <div class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-purple-600 bg-purple-50 border border-purple-100 px-4 py-1.5 rounded-full mb-3">
                    <span class="w-2 h-2 rounded-full bg-purple-500 dot-pulse"></span>
                    AI-Powered Analysis
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                    🧠 Your AI Study Coach
                </h1>
                <p class="text-gray-500 font-medium mt-2 text-lg">
                    Personalized insights based on your marks &amp; attendance
                </p>
            </div>

            <div class="flex flex-col items-start md:items-end gap-3 shrink-0">
                <button id="sg-refresh-btn" class="sg-refresh-btn" onclick="refreshSuggestions()">
                    <i class="fa-solid fa-rotate-right" id="refresh-icon"></i>
                    Generate Fresh AI Plan
                </button>
                <p class="text-xs text-gray-400 font-medium">
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

        <div id="status-banner" class="fade-up delay-2 {{ $levelConfig['class'] }} rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-start md:items-center gap-6 text-white overflow-hidden relative">
            <div class="absolute right-0 top-0 opacity-10 pointer-events-none">
                <i class="fa-solid {{ $levelConfig['icon'] }} text-[12rem]"></i>
            </div>
            <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                <i class="fa-solid {{ $levelConfig['icon'] }} text-2xl"></i>
            </div>
            <div class="flex-1 relative z-10">
                <p class="text-xs font-black uppercase tracking-widest text-white/70 mb-1">Overall Status</p>
                <h2 class="text-2xl font-black mb-1">{{ $levelConfig['label'] }}</h2>
                <p class="text-white/80 font-medium text-sm leading-relaxed">{{ $levelConfig['msg'] }}</p>
            </div>
            <div class="shrink-0 text-right relative z-10">
                <p class="text-xs font-black text-white/60 uppercase tracking-wider">Current Level</p>
                <p class="text-5xl font-black mt-1">{{ $overallLevel }}</p>
            </div>
        </div>

        {{-- ─── SUBJECT PERFORMANCE GRID ─── --}}
        <div class="fade-up delay-3">
            <div class="section-title">
                <i class="fa-solid fa-chart-bar text-purple-500"></i>
                Subject Performance Status
            </div>
            @if(count($analysis) > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5" id="analysis-grid">
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
                    $lvlIcon = match($lvl) {
                        'Strong'    => '🟢',
                        'Average'   => '🟡',
                        'Weak'      => '🔴',
                        'Very Weak' => '⛔',
                        default     => '🟡',
                    };
                @endphp
                <div class="sg-glass p-6 hover:scale-[1.02] transition-transform duration-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1 pr-2">
                            <h3 class="font-black text-gray-800 text-lg leading-tight">
                                {{ $subject['subject_name'] }}
                            </h3>
                        </div>
                        <span class="text-xs font-black px-3 py-1 rounded-full shrink-0 {{ $badgeClass }}">
                            {{ $lvlIcon }} {{ $lvl }}
                        </span>
                    </div>

                    <div class="space-y-3">
                        <!-- Marks -->
                        <div>
                            <div class="flex justify-between items-center mb-1.5">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Marks</span>
                                <span class="text-sm font-black text-gray-700">
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
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Attendance</span>
                                <span class="text-sm font-black text-gray-700">
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
            <div class="sg-glass p-12 text-center text-gray-400 font-medium">
                No performance data available yet. Marks and attendance will appear here once recorded.
            </div>
            @endif
        </div>

        {{-- ─── WEAK SUBJECTS SPOTLIGHT ─── --}}
        @if(count($weakSubjects) > 0)
        <div class="fade-up delay-4" id="weak-section">
            <div class="section-title">
                <i class="fa-solid fa-triangle-exclamation text-red-500"></i>
                Weak Subjects — Immediate Focus Required
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5" id="weak-grid">
                @foreach($weakSubjects as $subject)
                <div class="sg-danger-card p-7">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0"
                             style="background: linear-gradient(135deg, #E50040, #9F1239);">
                            <i class="fa-solid fa-circle-exclamation text-white text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center justify-between gap-2 mb-1">
                                <h3 class="font-black text-gray-800 text-xl">{{ $subject['subject_name'] }}</h3>
                                @if($subject['level'] === 'Very Weak')
                                    <span class="text-[10px] font-black px-3 py-1 rounded-full badge-very-weak">⛔ CRITICAL</span>
                                @else
                                    <span class="text-[10px] font-black px-3 py-1 rounded-full badge-weak">🔴 WEAK</span>
                                @endif
                            </div>
                            <div class="flex gap-6 mt-3">
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Marks</p>
                                    <p class="text-2xl font-black text-red-600">{{ $subject['marks_pct'] }}%</p>
                                </div>
                                <div class="w-px bg-gray-200"></div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Attendance</p>
                                    <p class="text-2xl font-black {{ $subject['att_pct'] < 75 ? 'text-red-600' : 'text-emerald-600' }}">
                                        {{ $subject['att_pct'] }}%
                                    </p>
                                </div>
                                <div class="w-px bg-gray-200"></div>
                                <div>
                                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-wider">Classes</p>
                                    <p class="text-2xl font-black text-gray-700">
                                        {{ $subject['att_present'] ?? 0 }}/{{ $subject['att_total'] ?? 0 }}
                                    </p>
                                </div>
                            </div>
                            @if($subject['marks_pct'] < 40)
                            <div class="mt-4 inline-flex items-center gap-2 text-xs font-black text-red-600 bg-red-50 border border-red-100 px-3 py-1.5 rounded-full">
                                <i class="fa-solid fa-bomb text-xs"></i>
                                You may fail this subject. Seek teacher help immediately.
                            </div>
                            @elseif($subject['att_pct'] < 75)
                            <div class="mt-4 inline-flex items-center gap-2 text-xs font-black text-amber-700 bg-amber-50 border border-amber-100 px-3 py-1.5 rounded-full">
                                <i class="fa-solid fa-calendar-xmark text-xs"></i>
                                Attendance below 75% — exam eligibility at risk.
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
                <i class="fa-solid fa-brain text-purple-500"></i>
                AI-Generated Study Recommendations
            </div>

            @if(count($suggestions) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5" id="suggestions-grid">
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
                    $priorityBadge = match($priority) {
                        'high'   => 'bg-red-50 text-red-600 border-red-100',
                        'medium' => 'bg-amber-50 text-amber-600 border-amber-100',
                        default  => 'bg-green-50 text-green-600 border-green-100',
                    };
                @endphp
                <div class="sg-suggestion-card p-7 flex flex-col gap-4">
                    <div class="flex items-start justify-between gap-3">
                        <div class="w-12 h-12 rounded-2xl {{ $typeConfig['class'] }} flex items-center justify-center shrink-0 shadow-lg">
                            <i class="fa-solid {{ $typeConfig['icon'] }} text-white text-xl"></i>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <span class="text-[9px] font-black uppercase tracking-widest text-purple-500 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded-full">
                                {{ $typeConfig['label'] }}
                            </span>
                            <span class="text-[9px] font-black uppercase tracking-widest border px-2 py-0.5 rounded-full {{ $priorityBadge }}">
                                {{ strtoupper($priority) }} PRIORITY
                            </span>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-black text-gray-800 text-lg leading-tight mb-2">
                            {{ $suggestion['title'] ?? 'Study Tip' }}
                        </h3>
                        <p class="text-gray-500 font-medium text-sm leading-relaxed">
                            {{ $suggestion['message'] ?? '' }}
                        </p>
                    </div>

                    <div class="mt-auto pt-3 border-t border-gray-100 flex items-center gap-2">
                        <div class="w-1 h-4 rounded-full {{ $priority === 'high' ? 'bg-red-500' : ($priority === 'medium' ? 'bg-amber-400' : 'bg-emerald-400') }}"></div>
                        <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">AI Recommendation #{{ $i + 1 }}</span>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="sg-glass p-12 text-center">
                <i class="fa-solid fa-robot text-5xl text-purple-300 mb-4"></i>
                <p class="text-gray-500 font-medium text-lg mb-4">No suggestions generated yet.</p>
                <button class="sg-refresh-btn" onclick="refreshSuggestions()">
                    <i class="fa-solid fa-rotate-right"></i> Generate AI Plan Now
                </button>
            </div>
            @endif
        </div>

        {{-- ─── DAILY STUDY PLAN ─── --}}
        @if(count($analysis) > 0)
        <div class="fade-up delay-6">
            <div class="section-title">
                <i class="fa-solid fa-calendar-days text-indigo-500"></i>
                Recommended Daily Study Plan
            </div>
            <div class="sg-glass p-6 md:p-8">
                <p class="text-sm text-gray-500 font-medium mb-6">Suggested daily hours based on your performance levels:</p>
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
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
                    <div class="flex items-center gap-4 p-4 rounded-2xl bg-white/60 border border-gray-100">
                        <div class="shrink-0 text-center w-16">
                            <p class="text-2xl font-black text-gray-800">{{ $hours }}h</p>
                            <p class="text-[10px] text-gray-400 font-bold uppercase">/ day</p>
                        </div>
                        <div class="flex-1">
                            <p class="font-black text-gray-700 text-sm mb-1.5">{{ $subject['subject_name'] }}</p>
                            <div class="sg-progress-track">
                                <div class="sg-progress-fill {{ $subject['level'] === 'Strong' ? 'fill-strong' : ($subject['level'] === 'Average' ? 'fill-average' : 'fill-weak') }}"
                                     style="width: {{ $widthPct }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-6 p-5 rounded-2xl bg-purple-50 border border-purple-100 flex items-start gap-3">
                    <i class="fa-solid fa-circle-info text-purple-500 text-lg mt-0.5 shrink-0"></i>
                    <p class="text-sm font-medium text-purple-700 leading-relaxed">
                        <strong>Pro tip:</strong> Study weak subjects during your peak concentration hours (morning is ideal).
                        Use the Pomodoro method: 25 min focused study → 5 min break. Avoid studying multiple weak subjects back-to-back.
                    </p>
                </div>
            </div>
        </div>
        @endif

        {{-- ─── BACK TO DASHBOARD ─── --}}
        <div class="fade-up delay-7 flex justify-center pt-2">
            <a href="{{ route('student.dashboard') }}"
               class="inline-flex items-center gap-2 text-sm font-black text-gray-500 hover:text-purple-600 transition-colors">
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
    btn.innerHTML = '<i class="fa-solid fa-rotate-right spinning" id="refresh-icon"></i> Generating AI Plan...';

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

            showToast('✨ Fresh AI plan generated!', 'success');
        } else {
            showToast('⚠️ Something went wrong. Please try again.', 'error');
        }
    })
    .catch(() => showToast('❌ Network error. Check your connection.', 'error'))
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa-solid fa-rotate-right" id="refresh-icon"></i> Generate Fresh AI Plan';
    });
}

function renderAnalysisGrid(container, analysis) {
    const levelBadge = { 'Strong': 'badge-strong 🟢', 'Average': 'badge-average 🟡', 'Weak': 'badge-weak 🔴', 'Very Weak': 'badge-very-weak ⛔' };
    const fillClass  = { 'Strong': 'fill-strong', 'Average': 'fill-average', 'Weak': 'fill-weak', 'Very Weak': 'fill-very-weak' };

    container.innerHTML = analysis.map(s => {
        const lvl = s.level;
        const bc  = (levelBadge[lvl] || 'badge-average 🟡').split(' ');
        const fc  = fillClass[lvl] || 'fill-average';
        const attFc = s.att_pct >= 75 ? 'fill-strong' : (s.att_pct >= 60 ? 'fill-average' : 'fill-weak');
        const emoji = bc[1] ?? '🟡';
        const cls   = bc[0];

        return `
        <div class="sg-glass p-6 hover:scale-[1.02] transition-transform duration-300">
            <div class="flex items-start justify-between mb-4">
                <div class="flex-1 pr-2">
                    <h3 class="font-black text-gray-800 text-lg leading-tight">${s.subject_name}</h3>
                </div>
                <span class="text-xs font-black px-3 py-1 rounded-full shrink-0 ${cls}">${emoji} ${lvl}</span>
            </div>
            <div class="space-y-3">
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Marks</span>
                        <span class="text-sm font-black text-gray-700">${s.marks_obtained ?? '—'}/${s.total_marks ?? '—'} (${s.marks_pct}%)</span>
                    </div>
                    <div class="sg-progress-track"><div class="sg-progress-fill ${fc}" style="width:${s.marks_pct}%"></div></div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Attendance</span>
                        <span class="text-sm font-black text-gray-700">${s.att_present ?? '—'}/${s.att_total ?? '—'} (${s.att_pct}%)</span>
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
    const priorityBadge = {
        'high':   'bg-red-50 text-red-600 border-red-100',
        'medium': 'bg-amber-50 text-amber-600 border-amber-100',
        'low':    'bg-green-50 text-green-600 border-green-100',
    };
    const priorityBar = { 'high': 'bg-red-500', 'medium': 'bg-amber-400', 'low': 'bg-emerald-400' };

    container.innerHTML = suggestions.map((s, i) => {
        const t   = typeMap[s.type] || typeMap['tip'];
        const pb  = priorityBadge[s.priority] || priorityBadge['medium'];
        const pp  = priorityBar[s.priority] || priorityBar['medium'];

        return `
        <div class="sg-suggestion-card p-7 flex flex-col gap-4">
            <div class="flex items-start justify-between gap-3">
                <div class="w-12 h-12 rounded-2xl ${t.cls} flex items-center justify-center shrink-0 shadow-lg">
                    <i class="fa-solid ${t.icon} text-white text-xl"></i>
                </div>
                <div class="flex flex-col items-end gap-1">
                    <span class="text-[9px] font-black uppercase tracking-widest text-purple-500 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded-full">${t.label}</span>
                    <span class="text-[9px] font-black uppercase tracking-widest border px-2 py-0.5 rounded-full ${pb}">${(s.priority || 'medium').toUpperCase()} PRIORITY</span>
                </div>
            </div>
            <div>
                <h3 class="font-black text-gray-800 text-lg leading-tight mb-2">${s.title || 'Study Tip'}</h3>
                <p class="text-gray-500 font-medium text-sm leading-relaxed">${s.message || ''}</p>
            </div>
            <div class="mt-auto pt-3 border-t border-gray-100 flex items-center gap-2">
                <div class="w-1 h-4 rounded-full ${pp}"></div>
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-wider">AI Recommendation #${i + 1}</span>
            </div>
        </div>`;
    }).join('');
}

function updateStatusBanner(level) {
    const banner = document.getElementById('status-banner');
    if (!banner) return;
    banner.classList.remove('status-excellent','status-average','status-weak');
    const cls = (level === 'Strong') ? 'status-excellent' : (level === 'Average' ? 'status-average' : 'status-weak');
    banner.classList.add(cls);
}

function showToast(msg, type) {
    const t = document.createElement('div');
    t.className = `fixed bottom-6 right-6 z-50 px-6 py-4 rounded-2xl font-black text-sm shadow-2xl text-white transition-all duration-500 ${type === 'success' ? 'bg-gradient-to-r from-purple-600 to-violet-500' : 'bg-gradient-to-r from-red-600 to-rose-500'}`;
    t.textContent = msg;
    document.body.appendChild(t);
    setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(20px)'; }, 3000);
    setTimeout(() => t.remove(), 3500);
}
</script>

@endsection
