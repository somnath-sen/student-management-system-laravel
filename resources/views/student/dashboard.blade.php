@extends('layouts.student')
@section('title', 'Dashboard')

@section('content')
<div
    x-data="{
        count: 0,
        target: {{ $stats->total_points ?? 0 }},
        init() {
            if (this.target <= 0) return;
            let start = 0;
            const step = Math.ceil(this.target / 80);
            const t = setInterval(() => {
                start = Math.min(start + step, this.target);
                this.count = start;
                if (start >= this.target) clearInterval(t);
            }, 20);
        }
    }"
    style="padding:20px 24px 40px;"
>

<style>
/* ─── iOS 18 Student Dashboard Styles ───────────────────── */
.ios-card {
    background: var(--bg-2);
    border-radius: 20px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s ease;
}
.ios-card:hover { transform: translateY(-3px) scale(1.005); box-shadow: var(--shadow-lg); }

@media (prefers-color-scheme: dark) {
    .ios-card { background: var(--bg-2); }
}

.ios-badge {
    font-size: 0.6rem; font-weight: 700; letter-spacing: 0.04em;
    padding: 3px 9px; border-radius: 100px;
    background: var(--accent-soft); color: var(--accent);
    text-transform: uppercase;
}
.ios-pill {
    font-size: 0.7rem; font-weight: 600; padding: 5px 12px; border-radius: 100px;
    background: var(--border-2); color: var(--text-secondary); transition: all 0.18s;
}
.ios-pill:hover { background: var(--accent-soft); color: var(--accent); }

.ios-progress-track {
    height: 5px; background: var(--border); border-radius: 100px; overflow: hidden;
}
.ios-progress-fill {
    height: 100%; border-radius: 100px;
    transition: width 1.2s cubic-bezier(0.34,1.56,0.64,1);
}

.ios-stat-num {
    font-size: 2.6rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1;
    color: var(--text-primary);
}
.ios-label { font-size: 0.72rem; font-weight: 500; color: var(--text-muted); margin-top: 4px; letter-spacing: 0.01em; }
.sec-head { font-size: 1.1rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.025em; }
.sec-sub  { font-size: 0.72rem; font-weight: 500; color: var(--text-muted); margin-top: 2px; }

.cta-glass {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 10px 18px; border-radius: 100px;
    font-weight: 600; font-size: 0.8rem; color: #fff;
    background: rgba(255,255,255,0.20); border: 1px solid rgba(255,255,255,0.3);
    text-decoration: none; transition: all 0.2s ease; white-space: nowrap;
    backdrop-filter: blur(6px);
}
.cta-glass:hover { background: rgba(255,255,255,0.30); transform: scale(1.03); }

.bc-row {
    display: flex; align-items: center; gap: 12px; padding: 12px 0;
    border-bottom: 1px solid var(--divider); text-decoration: none; transition: all 0.15s;
}
.bc-row:last-child { border-bottom: none; }
.bc-row:hover { opacity: 0.75; }

.trow { border-bottom: 1px solid var(--divider); transition: background 0.15s; }
.trow:last-child { border-bottom: none; }
.trow:hover { background: var(--border-2); }

.badge-chip {
    width: 60px; height: 60px; border-radius: 16px;
    background: var(--border-2); display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem; transition: all 0.3s cubic-bezier(0.34,1.56,0.64,1);
}
.badge-chip:hover { transform: rotate(8deg) scale(1.15); }

@media(max-width:640px){ .grid-stats{ grid-template-columns: 1fr 1fr !important; } }
</style>

<div style="max-width:1300px;margin:0 auto;">

    {{-- ── HERO GREETING ────────────────────────────── --}}
    <div style="margin-bottom:28px;">

        {{-- iOS Gradient hero card --}}
        <div style="border-radius:24px;overflow:hidden;position:relative;background:linear-gradient(135deg,var(--accent),var(--accent-2));padding:28px 28px;margin-bottom:18px;box-shadow:0 8px 32px var(--accent-glow);">
            {{-- Orb decorations --}}
            <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.12);pointer-events:none;"></div>
            <div style="position:absolute;bottom:-30px;left:30%;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,0.08);pointer-events:none;"></div>
            <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:16px;">
                <div>
                    <div style="font-size:0.68rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:6px;display:flex;align-items:center;gap:7px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#fff;display:inline-block;" class="animate-pulse"></span>Active Session
                    </div>
                    <h1 style="font-size:1.75rem;font-weight:800;color:#fff;letter-spacing:-0.03em;line-height:1.15;">
                        Welcome back, {{ $student->user->name }} 👋
                    </h1>
                    <p style="font-size:0.85rem;color:rgba(255,255,255,0.8);margin-top:6px;font-weight:400;">Here's your academic snapshot for today.</p>
                </div>
                {{-- Live clock --}}
                <div style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:18px;padding:14px 20px;backdrop-filter:blur(8px);text-align:center;min-width:130px;">
                    <div id="db-clock" style="font-size:1.6rem;font-weight:800;color:#fff;font-variant-numeric:tabular-nums;letter-spacing:-0.02em;">
                        <span id="ch">00</span><span style="opacity:0.6;" class="colon">:</span><span id="cm">00</span><span id="ca" style="font-size:0.8rem;font-weight:500;margin-left:3px;opacity:0.7;">AM</span>
                    </div>
                    <div id="cd" style="font-size:0.62rem;font-weight:500;color:rgba(255,255,255,0.7);margin-top:3px;letter-spacing:0.04em;text-transform:uppercase;"></div>
                </div>
            </div>
        </div>

        {{-- Quick 4 stat chips --}}
        <div class="grid-stats" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;">

            {{-- XP Points --}}
            <div class="ios-card" style="padding:20px;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="width:38px;height:38px;border-radius:12px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;color:var(--accent);">
                        <i class="fa-solid fa-bolt-lightning" style="font-size:0.95rem;"></i>
                    </div>
                    <span class="ios-badge">XP</span>
                </div>
                <div class="ios-stat-num" x-text="count">0</div>
                <div class="ios-label">Experience Points</div>
            </div>

            {{-- Level --}}
            @php
                $nextLevelXP = ($stats->level ?? 1) * 1000;
                $currentLevelXP = (($stats->level ?? 1) - 1) * 1000;
                $progressXP = ($stats->total_points ?? 0) - $currentLevelXP;
                $percentage = min(100, max(0, ($progressXP / 1000) * 100));
            @endphp
            <div class="ios-card" style="padding:20px;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="width:38px;height:38px;border-radius:12px;background:rgba(90,200,250,0.12);display:flex;align-items:center;justify-content:center;color:#5AC8FA;">
                        <i class="fa-solid fa-award" style="font-size:0.95rem;"></i>
                    </div>
                    <span class="ios-badge" style="background:rgba(90,200,250,0.12);color:#5AC8FA;">Level</span>
                </div>
                <div class="ios-stat-num">{{ $stats->level ?? 1 }}</div>
                <div class="ios-progress-track" style="margin-top:4px;">
                    <div class="ios-progress-fill" style="width:{{ $percentage }}%;background:linear-gradient(90deg,var(--accent),#5AC8FA);"></div>
                </div>
                <div class="ios-label">{{ $progressXP }} / 1000 XP to next level</div>
            </div>

            {{-- Attendance --}}
            <div class="ios-card" style="padding:20px;display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;justify-content:space-between;align-items:center;">
                    <div style="width:38px;height:38px;border-radius:12px;background:rgba(52,199,89,0.12);display:flex;align-items:center;justify-content:center;color:#34C759;">
                        <i class="fa-solid fa-calendar-check" style="font-size:0.95rem;"></i>
                    </div>
                    <span class="ios-badge" style="background:rgba(52,199,89,0.12);color:#34C759;">Present</span>
                </div>
                <div class="ios-stat-num">{{ $attendancePercentage ?? 0 }}%</div>
                <div class="ios-label">Overall Attendance</div>
            </div>

            {{-- Streak --}}
            <div class="ios-card" style="padding:20px;display:flex;flex-direction:column;gap:8px;position:relative;overflow:hidden;">
                <div style="position:absolute;right:-8px;bottom:-8px;font-size:5rem;opacity:0.06;pointer-events:none;">🔥</div>
                <div style="display:flex;justify-content:space-between;align-items:center;position:relative;z-index:1;">
                    <div style="width:38px;height:38px;border-radius:12px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;">
                        <i class="fa-solid fa-fire-flame-simple" style="font-size:0.95rem;"></i>
                    </div>
                    <span class="ios-badge" style="background:rgba(255,159,10,0.12);color:#FF9F0A;position:relative;z-index:1;">Streak</span>
                </div>
                <div class="ios-stat-num" style="position:relative;z-index:1;">{{ $stats->current_streak ?? 0 }}</div>
                <div class="ios-label" style="position:relative;z-index:1;">Day Streak 🔥</div>
            </div>

        </div>
    </div>

    {{-- ── MAIN GRID ─────────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:minmax(0,2fr) minmax(0,1fr);gap:18px;">

        {{-- LEFT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:18px;min-width:0;">

            {{-- Report Card Banner (conditional) --}}
            @if(isset($reportCardPublished) && $reportCardPublished)
            <div style="border-radius:20px;overflow:hidden;background:linear-gradient(135deg,#F59E0B,#B45309);padding:22px;box-shadow:0 6px 24px rgba(245,158,11,0.35);position:relative;">
                <div style="position:absolute;top:-20px;right:-20px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,0.12);pointer-events:none;"></div>
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;position:relative;z-index:1;">
                    <div style="width:50px;height:50px;border-radius:15px;background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-solid fa-file-pdf" style="color:#fff;font-size:1.4rem;"></i>
                    </div>
                    <div style="flex:1;min-width:160px;">
                        <div style="display:flex;gap:6px;margin-bottom:7px;">
                            <span style="font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.18);padding:2px 8px;border-radius:100px;">Official</span>
                            <span style="font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.18);padding:2px 8px;border-radius:100px;">Auto-Generated</span>
                        </div>
                        <h2 style="font-size:1.1rem;font-weight:700;color:#fff;letter-spacing:-0.02em;">Your Report Card is Ready</h2>
                        <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin-top:4px;line-height:1.5;">Download PDF with marks, grades, rank & remarks.</p>
                    </div>
                    <a href="{{ route('student.report-card.download') }}" class="cta-glass" style="flex-shrink:0;">
                        <i class="fa-solid fa-download"></i>Download PDF
                    </a>
                </div>
            </div>
            @endif

            {{-- AI Suggestions Banner --}}
            <div style="border-radius:20px;overflow:hidden;background:linear-gradient(135deg,#5856D6,#AF52DE,#FF375F);padding:22px;box-shadow:0 6px 24px rgba(88,86,214,0.3);position:relative;">
                <div style="position:absolute;top:-20px;right:-20px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,0.10);pointer-events:none;"></div>
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;position:relative;z-index:1;">
                    <div style="width:50px;height:50px;border-radius:15px;background:rgba(255,255,255,0.18);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:1.5rem;">🧠</div>
                    <div style="flex:1;min-width:160px;">
                        <div style="display:flex;gap:6px;margin-bottom:7px;">
                            <span style="font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.9);background:rgba(255,255,255,0.18);padding:2px 8px;border-radius:100px;">AI‑Powered</span>
                            <span style="font-size:0.6rem;font-weight:600;color:rgba(255,255,255,0.9);background:rgba(255,255,255,0.18);padding:2px 8px;border-radius:100px;">Personalized</span>
                        </div>
                        <h2 style="font-size:1.1rem;font-weight:700;color:#fff;letter-spacing:-0.02em;">Your AI Study Coach is Ready</h2>
                        <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin-top:4px;line-height:1.5;">Recommendations based on your marks, attendance & performance.</p>
                    </div>
                    <a href="{{ route('student.suggestions') }}" class="cta-glass" style="flex-shrink:0;">
                        <i class="fa-solid fa-brain"></i>View AI Plan
                    </a>
                </div>
            </div>

            {{-- Subject Analytics --}}
            <div class="ios-card" style="overflow:hidden;">
                <div style="padding:20px 22px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--divider);">
                    <div>
                        <div class="sec-head">Subject Analytics</div>
                        <div class="sec-sub">Attendance tracked per subject</div>
                    </div>
                    <div style="width:38px;height:38px;border-radius:12px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;color:var(--accent);">
                        <i class="fa-solid fa-chart-pie" style="font-size:0.9rem;"></i>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th style="padding:11px 22px;text-align:left;font-size:0.6rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Subject</th>
                                <th style="padding:11px 14px;text-align:center;font-size:0.6rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Classes</th>
                                <th style="padding:11px 22px;font-size:0.6rem;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:var(--text-muted);">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjectAttendance as $row)
                                @php
                                    $sp = $row->total_classes > 0 ? round(($row->present_count / $row->total_classes) * 100) : 0;
                                    $bar = $sp >= 75 ? 'linear-gradient(90deg,#34C759,#30D158)' : ($sp >= 60 ? 'linear-gradient(90deg,#FF9F0A,#FF6B00)' : 'linear-gradient(90deg,#FF3B30,#FF2D20)');
                                    $tc  = $sp >= 75 ? '#34C759' : ($sp >= 60 ? '#FF9F0A' : '#FF3B30');
                                @endphp
                                <tr class="trow">
                                    <td style="padding:13px 22px;">
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div style="width:32px;height:32px;border-radius:9px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:700;color:var(--accent);">
                                                {{ strtoupper(substr($row->subject->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">{{ $row->subject->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td style="padding:13px 14px;text-align:center;">
                                        <span style="font-size:0.8rem;font-weight:700;color:var(--text-primary);">{{ $row->present_count }}</span>
                                        <span style="font-size:0.75rem;color:var(--text-muted);">/ {{ $row->total_classes }}</span>
                                    </td>
                                    <td style="padding:13px 22px;min-width:180px;">
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="ios-progress-track" style="flex:1;height:6px;">
                                                <div class="ios-progress-fill" style="width:{{ $sp }}%;background:{{ $bar }};"></div>
                                            </div>
                                            <span style="font-size:0.75rem;font-weight:700;color:{{ $tc }};min-width:32px;text-align:right;">{{ $sp }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="padding:40px 24px;text-align:center;">
                                        <i class="fa-solid fa-chart-bar" style="font-size:2rem;color:var(--text-muted);margin-bottom:10px;display:block;"></i>
                                        <p style="font-size:0.82rem;font-weight:600;color:var(--text-muted);">No analytics data yet.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Campus Feed --}}
            <div class="ios-card" style="padding:22px;" id="announcements-section">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;padding-bottom:16px;border-bottom:1px solid var(--divider);">
                    <div style="display:flex;align-items:center;gap:13px;">
                        <div style="width:38px;height:38px;border-radius:12px;background:rgba(255,59,48,0.10);display:flex;align-items:center;justify-content:center;color:#FF3B30;">
                            <i class="fa-solid fa-bullhorn" style="font-size:0.9rem;"></i>
                        </div>
                        <div>
                            <div class="sec-head">Campus Feed</div>
                            <div class="sec-sub">Latest announcements</div>
                        </div>
                    </div>
                    <span style="font-size:0.62rem;font-weight:600;color:#FF3B30;background:rgba(255,59,48,0.10);padding:3px 10px;border-radius:100px;display:flex;align-items:center;gap:5px;">
                        <span style="width:5px;height:5px;border-radius:50%;background:#FF3B30;" class="animate-pulse"></span>Live
                    </span>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:14px;">
                    @forelse($notices as $notice)
                        @php $nc=['Urgent'=>['#FF3B30','#FF2D20'],'Exam'=>['#5856D6','#4F46E5'],'Holiday'=>['#34C759','#30D158'],'General'=>['#007AFF','#0071E3']]; $c=$nc[$notice->category]??$nc['General']; @endphp
                        <div style="background:var(--border-2);border-radius:16px;padding:18px;border:1px solid var(--border);transition:all 0.2s;" onmouseover="this.style.transform='translateY(-3px)'" onmouseout="this.style.transform='none'">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                                <span style="font-size:0.6rem;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;color:#fff;padding:3px 9px;border-radius:100px;background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }});">{{ $notice->category }}</span>
                                <span style="font-size:0.65rem;font-weight:500;color:var(--text-muted);">{{ $notice->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 style="font-size:0.88rem;font-weight:700;color:var(--text-primary);line-height:1.35;margin-bottom:7px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $notice->title }}</h3>
                            <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.55;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;">{{ $notice->content }}</p>
                            <div style="padding-top:12px;border-top:1px solid var(--divider);margin-top:12px;font-size:0.62rem;font-weight:600;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.06em;">{{ $notice->author->name ?? 'Administration' }}</div>
                        </div>
                    @empty
                        <div style="grid-column:1/-1;padding:40px;text-align:center;color:var(--text-muted);">
                            <i class="fa-solid fa-envelope-open-text" style="font-size:2rem;margin-bottom:10px;display:block;"></i>
                            <p style="font-size:0.85rem;font-weight:600;">No campus updates at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>{{-- /left --}}

        {{-- RIGHT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:18px;min-width:0;">

            {{-- My Program --}}
            <div class="ios-card" style="overflow:hidden;">
                <div style="padding:20px;background:linear-gradient(135deg,var(--accent),var(--accent-2));position:relative;">
                    <div style="position:absolute;right:-10px;top:-10px;opacity:0.12;font-size:6rem;pointer-events:none;">🎓</div>
                    <div style="position:relative;z-index:1;">
                        <div style="font-size:0.6rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:4px;">My Program</div>
                        <div style="font-size:1.05rem;font-weight:700;color:#fff;line-height:1.2;">{{ $course->name ?? 'Not Assigned' }}</div>
                    </div>
                </div>
                <div style="padding:18px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <span style="font-size:0.65rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);">Enrolled Subjects</span>
                        <span class="ios-badge">{{ count($subjects) }} Total</span>
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:7px;">
                        @forelse($subjects as $subject)
                            <span class="ios-pill">{{ $subject->name }}</span>
                        @empty
                            <span style="font-size:0.8rem;color:var(--text-muted);font-style:italic;">No subjects enrolled.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Messages / Broadcasts --}}
            @php $studentRecord = auth()->user()->student; @endphp
            <div class="ios-card" style="overflow:hidden;" id="announcements">
                <div style="padding:16px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--divider);">
                    <div style="display:flex;align-items:center;gap:11px;">
                        <div style="width:36px;height:36px;border-radius:11px;background:rgba(88,86,214,0.12);display:flex;align-items:center;justify-content:center;color:#5856D6;">
                            <i class="fa-solid fa-bell" style="font-size:0.88rem;"></i>
                        </div>
                        <div>
                            <div class="sec-head" style="font-size:0.92rem;">Messages</div>
                            <div class="sec-sub">Teacher Broadcasts</div>
                        </div>
                    </div>
                    <span id="total-unread-badge" style="display:none;width:26px;height:26px;border-radius:50%;background:#FF3B30;font-size:0.68rem;font-weight:700;color:#fff;align-items:center;justify-content:center;" class="animate-bounce">0</span>
                </div>
                <div style="padding:0 0 4px;">
                    @forelse($subjects as $subject)
                        @php
                            $smc = \App\Models\BroadcastMessage::where('subject_id', $subject->id)->count();
                            $rc = $studentRecord ? \App\Models\MessageRead::where('student_id', $studentRecord->id)->whereHas('message', fn($q) => $q->where('subject_id', $subject->id))->where('seen', true)->count() : 0;
                            $un = max(0, $smc - $rc);
                        @endphp
                        <a href="{{ route('student.broadcast.index', $subject->id) }}" class="bc-row" style="padding:12px 20px;text-decoration:none;">
                            <div style="width:36px;height:36px;border-radius:10px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;font-size:0.68rem;font-weight:700;color:var(--accent);flex-shrink:0;">
                                {{ strtoupper(substr($subject->name, 0, 2)) }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p style="font-size:0.82rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $subject->name }}</p>
                                <p style="font-size:0.65rem;color:var(--text-muted);margin-top:1px;">{{ $smc }} announcement{{ $smc != 1 ? 's' : '' }}</p>
                            </div>
                            @if($un > 0)
                                <span class="subject-unread-badge" data-subject-id="{{ $subject->id }}" style="min-width:20px;height:20px;padding:0 5px;border-radius:10px;background:var(--accent);font-size:0.62rem;font-weight:700;color:#fff;display:flex;align-items:center;justify-content:center;">{{ $un }}</span>
                            @else
                                <span class="subject-unread-badge" data-subject-id="{{ $subject->id }}" style="width:20px;height:20px;border-radius:50%;background:rgba(52,199,89,0.12);font-size:0.7rem;color:#34C759;display:flex;align-items:center;justify-content:center;">✓</span>
                            @endif
                            <i class="fa-solid fa-chevron-right" style="font-size:0.65rem;color:var(--text-muted);"></i>
                        </a>
                    @empty
                        <div style="padding:28px;text-align:center;color:var(--text-muted);font-size:0.82rem;">No subjects enrolled.</div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Badges --}}
            <div class="ios-card" style="padding:20px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid var(--divider);">
                    <div>
                        <div class="sec-head" style="font-size:0.92rem;">Recent Badges</div>
                        <div class="sec-sub">Your achievements</div>
                    </div>
                    <div style="width:36px;height:36px;border-radius:11px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;font-size:0.9rem;">🏅</div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;">
                    @php $bc = 0; @endphp
                    @foreach($badges as $badge)
                        @if($bc < 3)
                        <div style="display:flex;flex-direction:column;align-items:center;gap:7px;" title="{{ $badge->description }}">
                            <div class="badge-chip">{!! $badge->icon !!}</div>
                            <span style="font-size:0.6rem;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;color:var(--text-secondary);text-align:center;line-height:1.2;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;width:100%;">{{ $badge->name }}</span>
                        </div>
                        @php $bc++; @endphp
                        @endif
                    @endforeach
                    @for($i = $bc; $i < 3; $i++)
                    <div style="display:flex;flex-direction:column;align-items:center;gap:7px;opacity:0.35;">
                        <div style="width:60px;height:60px;border-radius:16px;background:var(--border-2);display:flex;align-items:center;justify-content:center;font-size:1.2rem;color:var(--text-muted);">🔒</div>
                        <span style="font-size:0.6rem;font-weight:700;text-transform:uppercase;color:var(--text-muted);">Locked</span>
                    </div>
                    @endfor
                </div>
            </div>

            {{-- Telegram Connect --}}
            @php
                $isTg = auth()->user()->hasTelegramConnected();
                $lastTg = $isTg ? \App\Models\NotificationLog::where('recipient_id', auth()->id())->where('status','sent')->latest('sent_at')->first() : null;
            @endphp
            <div class="ios-card" style="overflow:hidden;">
                <div style="padding:18px;background:{{ $isTg ? 'linear-gradient(135deg,#2AABEE,#229ED9)' : 'linear-gradient(135deg,#636366,#48484A)' }};position:relative;">
                    <div style="position:absolute;right:-8px;top:-8px;opacity:0.10;font-size:6rem;pointer-events:none;">✈️</div>
                    <div style="display:flex;align-items:center;gap:13px;position:relative;z-index:1;">
                        <div style="width:42px;height:42px;border-radius:13px;background:rgba(255,255,255,0.2);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-brands fa-telegram" style="color:#fff;font-size:1.3rem;"></i>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:0.6rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-bottom:2px;">Notifications</div>
                            <div style="font-size:1rem;font-weight:700;color:#fff;">Telegram</div>
                        </div>
                        <span style="font-size:0.6rem;font-weight:600;text-transform:uppercase;padding:4px 10px;border-radius:100px;background:rgba(255,255,255,0.2);color:#fff;display:flex;align-items:center;gap:5px;">
                            <span style="width:5px;height:5px;border-radius:50%;background:{{ $isTg ? '#34C759' : 'rgba(255,255,255,0.5)' }};" {{ $isTg ? 'class=animate-pulse' : '' }}></span>
                            {{ $isTg ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                </div>
                <div style="padding:16px;">
                    @if($isTg)
                        <div style="background:rgba(52,199,89,0.08);border:1px solid rgba(52,199,89,0.15);border-radius:12px;padding:12px;display:flex;gap:9px;align-items:flex-start;margin-bottom:12px;">
                            <i class="fa-solid fa-circle-check" style="color:#34C759;font-size:1rem;margin-top:1px;"></i>
                            <div>
                                <p style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">Telegram Connected ✅</p>
                                <p style="font-size:0.7rem;color:var(--text-secondary);margin-top:2px;line-height:1.45;">Receiving real-time alerts for attendance, results, fees & more.</p>
                            </div>
                        </div>
                        @if($lastTg)
                        <div style="font-size:0.72rem;color:var(--text-muted);margin-bottom:12px;display:flex;align-items:center;gap:6px;">
                            <i class="fa-solid fa-clock" style="font-size:0.8rem;"></i>Last alert: {{ $lastTg->sent_at?->diffForHumans() }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('student.telegram.disconnect') }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Disconnect Telegram?')" style="width:100%;padding:11px;border-radius:12px;background:rgba(255,59,48,0.08);font-size:0.8rem;font-weight:600;color:#FF3B30;border:1px solid rgba(255,59,48,0.15);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;">
                                <i class="fa-solid fa-link-slash"></i>Disconnect Telegram
                            </button>
                        </form>
                    @else
                        <div style="background:rgba(255,159,10,0.08);border:1px solid rgba(255,159,10,0.15);border-radius:12px;padding:12px;margin-bottom:12px;display:flex;gap:9px;align-items:flex-start;">
                            <i class="fa-solid fa-triangle-exclamation" style="color:#FF9F0A;font-size:0.9rem;margin-top:2px;"></i>
                            <div>
                                <p style="font-size:0.82rem;font-weight:600;color:var(--text-primary);">Not Connected</p>
                                <p style="font-size:0.7rem;color:var(--text-secondary);margin-top:2px;line-height:1.45;">Connect to receive instant notifications.</p>
                            </div>
                        </div>
                        @php $tgToken = auth()->user()->telegram_connect_token; @endphp
                        @if($tgToken)
                        <div style="background:var(--border-2);border-radius:12px;padding:12px;margin-bottom:12px;font-family:monospace;font-size:0.82rem;color:var(--accent);font-weight:600;text-align:center;letter-spacing:0.04em;border:1px solid var(--border);">/connect_{{ $tgToken }}</div>
                        @endif
                        <a href="https://t.me/{{ config('services.telegram.bot_username') }}" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:7px;padding:11px;border-radius:12px;background:#2AABEE;color:#fff;font-size:0.82rem;font-weight:600;text-decoration:none;">
                            <i class="fa-brands fa-telegram"></i>Connect on Telegram
                        </a>
                    @endif
                </div>
            </div>

        </div>{{-- /right --}}

    </div>{{-- /main grid --}}

</div>{{-- /max-w --}}

<script>
(function(){
    const D=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    const M=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
    function p2(n){return String(n).padStart(2,'0');}
    function tick(){
        const n=new Date();let h=n.getHours();const mi=n.getMinutes(),ap=h>=12?'PM':'AM';
        h=h%12||12;
        document.getElementById('ch').textContent=p2(h);
        document.getElementById('cm').textContent=p2(mi);
        const ae=document.getElementById('ca');if(ae)ae.textContent=' '+ap;
        const de=document.getElementById('cd');
        if(de)de.textContent=D[n.getDay()]+', '+M[n.getMonth()]+' '+n.getDate();
    }
    tick();setInterval(tick,30000);
})();

// Broadcast badge polling
(function(){
    function updateBroadcastBadges(){
        fetch('/student/broadcast/unread-counts')
            .then(r=>r.json()).then(data=>{
                let total=0;
                document.querySelectorAll('.subject-unread-badge').forEach(el=>{
                    const id=el.dataset.subjectId;
                    const c=data[id]||0;
                    total+=c;
                    if(c>0){el.textContent=c;el.style.display='flex';el.style.background='var(--accent)';el.style.color='#fff';el.style.borderRadius='10px';}
                    else{el.textContent='✓';el.style.background='rgba(52,199,89,0.12)';el.style.color='#34C759';el.style.borderRadius='50%';}
                });
                const tb=document.getElementById('total-unread-badge');
                const nb=document.getElementById('unread-broadcast-badge');
                if(tb){if(total>0){tb.textContent=total;tb.style.display='flex';}else tb.style.display='none';}
                if(nb){if(total>0){nb.textContent=total;nb.classList.remove('hidden');}else nb.classList.add('hidden');}
            }).catch(()=>{});
    }
    updateBroadcastBadges();setInterval(updateBroadcastBadges,30000);
})();
</script>

</div>
@endsection