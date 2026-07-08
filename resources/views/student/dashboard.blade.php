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
    style="min-height:100vh;background:var(--bg);padding:28px 28px 40px;position:relative;"
>

{{-- ═══════════════════════════════════════════════════════
     DASHBOARD STYLES
════════════════════════════════════════════════════════ --}}
<style>
/* ─ Card system ─────────────────────────────────────────── */
.c {
    background: var(--bg);
    border-radius: 22px;
    box-shadow: 8px 8px 20px var(--sh-dark), -8px -8px 20px var(--sh-light);
    transition: box-shadow 0.3s ease, transform 0.28s ease;
}
.c:hover {
    box-shadow: 12px 12px 28px var(--sh-dark), -12px -12px 28px var(--sh-light);
    transform: translateY(-3px);
}
.c-sm {
    background: var(--bg);
    border-radius: 16px;
    box-shadow: 5px 5px 13px var(--sh-dark), -5px -5px 13px var(--sh-light);
}
.c-inset {
    background: var(--bg);
    border-radius: 14px;
    box-shadow: inset 4px 4px 10px var(--sh-dark), inset -4px -4px 10px var(--sh-light);
}
.c-pressed {
    background: var(--bg-dark);
    border-radius: 14px;
    box-shadow: inset 3px 3px 9px var(--sh-dark), inset -3px -3px 9px var(--sh-light);
}

/* ─ Icon circles / boxes ────────────────────────────────── */
.icon-box {
    border-radius: 14px;
    background: var(--bg);
    box-shadow: 4px 4px 10px var(--sh-dark), -4px -4px 10px var(--sh-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.icon-box-sm {
    border-radius: 11px;
    background: var(--bg);
    box-shadow: 3px 3px 8px var(--sh-dark), -3px -3px 8px var(--sh-light);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}

/* ─ Progress bar track ──────────────────────────────────── */
.track {
    background: var(--bg);
    box-shadow: inset 3px 3px 8px var(--sh-dark), inset -2px -2px 6px var(--sh-light);
    border-radius: 100px; overflow: hidden;
}

/* ─ Pill / tag ──────────────────────────────────────────── */
.pill {
    font-size: 0.6rem; font-weight: 900; letter-spacing: 0.1em;
    text-transform: uppercase; padding: 4px 10px; border-radius: 9px;
    background: var(--bg);
    box-shadow: 2px 2px 6px var(--sh-dark), -2px -2px 6px var(--sh-light);
}
.tag {
    font-size: 0.73rem; font-weight: 700; padding: 6px 13px; border-radius: 11px;
    background: var(--bg);
    box-shadow: 3px 3px 8px var(--sh-dark), -3px -3px 8px var(--sh-light);
    color: var(--text-secondary); cursor: default; transition: all 0.2s;
}
.tag:hover { color: var(--accent); box-shadow: 4px 4px 11px var(--sh-dark), -4px -4px 11px var(--sh-light); }

/* ─ CTA button inside banners ───────────────────────────── */
.cta-glass {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; border-radius: 14px;
    font-weight: 800; font-size: 0.82rem; color: #fff;
    background: rgba(255,255,255,0.18);
    border: 1.5px solid rgba(255,255,255,0.35);
    backdrop-filter: blur(6px);
    cursor: pointer; text-decoration: none;
    transition: all 0.25s ease;
    box-shadow: inset 2px 2px 8px rgba(255,255,255,0.15), inset -2px -2px 6px rgba(0,0,0,0.1);
    white-space: nowrap;
}
.cta-glass:hover { background: rgba(255,255,255,0.28); transform: translateY(-2px); }

/* ─ stat value gradient text ────────────────────────────── */
.grad-text {
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ─ Section heading ─────────────────────────────────────── */
.sec-title { font-size: 1.05rem; font-weight: 800; color: var(--text-primary); letter-spacing: -0.02em; }
.sec-sub   { font-size: 0.65rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em; margin-top:1px; }

/* ─ Table row ───────────────────────────────────────────── */
.trow { transition: background 0.2s; }
.trow:hover { background: rgba(255,255,255,0.42); }

/* ─ Notice card ─────────────────────────────────────────── */
.nc {
    background: var(--bg);
    box-shadow: 6px 6px 16px var(--sh-dark), -6px -6px 16px var(--sh-light);
    border-radius: 18px;
    transition: all 0.25s ease;
}
.nc:hover {
    box-shadow: 9px 9px 22px var(--sh-dark), -9px -9px 22px var(--sh-light);
    transform: translateY(-4px);
}

/* ─ Badge circle ────────────────────────────────────────── */
.badge-wrap {
    width: 64px; height: 64px; border-radius: 18px;
    background: var(--bg);
    box-shadow: 5px 5px 13px var(--sh-dark), -5px -5px 13px var(--sh-light);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.8rem; transition: all 0.3s ease;
}
.badge-wrap:hover {
    box-shadow: 7px 7px 18px var(--sh-dark), -7px -7px 18px var(--sh-light);
    transform: rotate(8deg) scale(1.1);
}

/* ─ Broadcast row ───────────────────────────────────────── */
.bc-row {
    padding: 13px 20px;
    display: flex; align-items: center; gap: 12px;
    text-decoration: none; color: var(--text-secondary);
    transition: background 0.2s;
    border-bottom: 1px solid rgba(255,255,255,0.4);
}
.bc-row:last-child { border-bottom: none; }
.bc-row:hover { background: rgba(255,255,255,0.42); }

/* ─ Clock digits ────────────────────────────────────────── */
.digit { display: inline-block; transition: opacity 0.15s, transform 0.15s; }
.digit.flip { opacity: 0; transform: translateY(-5px); }
.colon { animation: blink 1s step-end infinite; }
@keyframes blink { 0%,100%{opacity:1} 50%{opacity:0.2} }

/* ─ Telegram boxes ──────────────────────────────────────── */
.tg-info {
    background: var(--bg);
    box-shadow: inset 3px 3px 9px var(--sh-dark), inset -3px -3px 9px var(--sh-light);
    border-radius: 14px; padding: 14px 16px;
}

/* ─ Divider ─────────────────────────────────────────────── */
.div-line { border: none; border-top: 1px solid rgba(255,255,255,0.5); margin: 0; }

/* ─ Animation helpers ───────────────────────────────────── */
@keyframes floatUp {
    0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)}
}
.float-anim { animation: floatUp 6s ease-in-out infinite; }

/* ─ Accent btn (solid) ──────────────────────────────────── */
.btn-accent {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 11px 22px; border-radius: 14px;
    font-weight: 800; font-size: 0.82rem; color: #fff;
    background: linear-gradient(135deg, var(--accent), var(--accent-2));
    box-shadow: 5px 5px 14px rgba(91,94,244,0.4), -3px -3px 9px rgba(255,255,255,0.8);
    cursor: pointer; text-decoration: none; border: none;
    transition: all 0.25s ease;
}
.btn-accent:hover { transform: translateY(-2px); box-shadow: 7px 7px 18px rgba(91,94,244,0.45), -4px -4px 12px rgba(255,255,255,0.9); }
.btn-accent:active { transform: scale(0.97); }

/* ─ Glow dot ────────────────────────────────────────────── */
.glow-dot {
    width: 9px; height: 9px; border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 8px 2px currentColor;
}

/* Responsive tweak */
@media(max-width:640px){ .grid-stats{ grid-template-columns:1fr 1fr; } }
</style>

{{-- ════════ CONTENT WRAPPER ════════ --}}
<div style="max-width:1280px;margin:0 auto;">

    {{-- ── WELCOME HEADER ──────────────────────────────── --}}
    <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:32px;">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;" class="glow-dot animate-pulse"></span>
                <span style="font-size:0.65rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">Active Session</span>
            </div>
            <h1 style="font-size:2rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.03em;line-height:1.1;">
                Welcome back,&nbsp;<span class="grad-text">{{ $student->user->name }}</span>&nbsp;👋
            </h1>
            <p style="color:var(--text-muted);font-size:0.88rem;font-weight:500;margin-top:6px;">Here's your academic overview for today.</p>
        </div>

        {{-- Clock widget --}}
        <div class="c" style="padding:16px 22px;display:flex;align-items:center;gap:16px;min-width:210px;">
            <div style="position:relative;">
                <div class="icon-box" style="width:44px;height:44px;">
                    <span style="width:10px;height:10px;border-radius:50%;background:#22c55e;box-shadow:0 0 10px #22c55e;display:block;"></span>
                </div>
                <span style="position:absolute;inset:0;border-radius:50%;background:#22c55e;opacity:0.12;" class="animate-ping"></span>
            </div>
            <div>
                <p style="font-size:0.58rem;font-weight:900;letter-spacing:0.2em;text-transform:uppercase;color:#22c55e;margin-bottom:2px;">Active Now</p>
                <div id="db-clock" style="display:flex;align-items:baseline;gap:1px;">
                    <span id="ch" class="digit" style="font-size:1.3rem;font-weight:900;color:var(--text-primary);font-variant-numeric:tabular-nums;">00</span>
                    <span class="colon" style="font-size:1.2rem;font-weight:900;color:var(--text-muted);">:</span>
                    <span id="cm" class="digit" style="font-size:1.3rem;font-weight:900;color:var(--text-primary);font-variant-numeric:tabular-nums;">00</span>
                    <span class="colon" style="font-size:1.2rem;font-weight:900;color:var(--text-muted);">:</span>
                    <span id="cs" class="digit" style="font-size:0.95rem;font-weight:800;color:var(--text-muted);font-variant-numeric:tabular-nums;">00</span>
                    <span id="ca" style="font-size:0.58rem;font-weight:900;color:var(--text-muted);text-transform:uppercase;margin-left:4px;margin-top:2px;align-self:flex-start;">AM</span>
                </div>
                <p id="cd" style="font-size:0.62rem;font-weight:700;color:var(--text-muted);letter-spacing:0.08em;text-transform:uppercase;margin-top:1px;"></p>
            </div>
        </div>
    </div>

    <script>
    (function(){
        const D=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
              M=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        function sd(el,v){if(el.textContent!==v){el.classList.add('flip');setTimeout(()=>{el.textContent=v;el.classList.remove('flip');},140);}}
        function p2(n){return String(n).padStart(2,'0');}
        function tick(){
            const n=new Date();let h=n.getHours();const mi=n.getMinutes(),se=n.getSeconds(),ap=h>=12?'PM':'AM';
            h=h%12||12;
            sd(document.getElementById('ch'),p2(h));
            sd(document.getElementById('cm'),p2(mi));
            sd(document.getElementById('cs'),p2(se));
            const ae=document.getElementById('ca');if(ae.textContent!==ap)ae.textContent=ap;
            const de=document.getElementById('cd'),ds=D[n.getDay()]+', '+M[n.getMonth()]+' '+n.getDate();
            if(de.textContent!==ds)de.textContent=ds;
        }
        tick();setInterval(tick,1000);
    })();
    </script>

    {{-- ── STAT CARDS ───────────────────────────────────── --}}
    <div class="grid-stats" style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:28px;">

        {{-- XP --}}
        <div class="c" style="padding:24px 22px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:var(--accent);">
                    <i class="fa-solid fa-bolt-lightning" style="font-size:1.2rem;"></i>
                </div>
                <span class="pill" style="color:var(--accent);">Total XP</span>
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--text-primary);font-variant-numeric:tabular-nums;line-height:1;" x-text="count">0</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:5px;text-transform:uppercase;letter-spacing:0.08em;">Experience Points</p>
        </div>

        {{-- Level --}}
        @php
            $nextLevelXP = ($stats->level ?? 1) * 1000;
            $currentLevelXP = (($stats->level ?? 1) - 1) * 1000;
            $progressXP = ($stats->total_points ?? 0) - $currentLevelXP;
            $percentage = min(100, max(0, ($progressXP / 1000) * 100));
        @endphp
        <div class="c" style="padding:24px 22px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:#06b6d4;">
                    <i class="fa-solid fa-award" style="font-size:1.2rem;"></i>
                </div>
                <span class="pill" style="color:#06b6d4;">Level</span>
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--text-primary);line-height:1;">Lvl. {{ $stats->level ?? 1 }}</div>
            <div style="margin-top:14px;">
                <div class="track" style="height:8px;width:100%;">
                    <div style="height:100%;width:{{ $percentage }}%;background:linear-gradient(90deg,var(--accent),#a855f7);border-radius:100px;transition:width 1.2s ease;"></div>
                </div>
                <div style="display:flex;justify-content:space-between;margin-top:5px;">
                    <span style="font-size:0.62rem;font-weight:700;color:var(--text-muted);">{{ $progressXP }} / 1000 XP</span>
                    <span style="font-size:0.62rem;font-weight:800;color:var(--accent);">{{ round($percentage) }}%</span>
                </div>
            </div>
        </div>

        {{-- Attendance --}}
        <div class="c" style="padding:24px 22px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:#22c55e;">
                    <i class="fa-solid fa-calendar-check" style="font-size:1.2rem;"></i>
                </div>
                <span class="pill" style="color:#22c55e;">Attendance</span>
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--text-primary);line-height:1;">{{ $attendancePercentage ?? 0 }}%</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:5px;text-transform:uppercase;letter-spacing:0.08em;">Average Presence</p>
        </div>

        {{-- Streak --}}
        <div class="c" style="padding:24px 22px;position:relative;overflow:hidden;">
            <div style="position:absolute;right:-8px;bottom:-10px;opacity:0.07;pointer-events:none;" class="float-anim">
                <i class="fa-solid fa-fire" style="font-size:6rem;color:#f97316;"></i>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;position:relative;z-index:1;">
                <div class="icon-box" style="width:48px;height:48px;color:#f97316;">
                    <i class="fa-solid fa-fire-flame-simple" style="font-size:1.2rem;"></i>
                </div>
                <span class="pill" style="color:#f97316;">Streak</span>
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--text-primary);line-height:1;position:relative;z-index:1;">{{ $stats->current_streak ?? 0 }}</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:5px;text-transform:uppercase;letter-spacing:0.08em;position:relative;z-index:1;">Day Streak 🔥</p>
        </div>

    </div>

    {{-- ── TWO-COLUMN GRID ──────────────────────────────── --}}
    <div style="display:grid;grid-template-columns:1fr;gap:22px;" class="xl:grid-cols-3-custom">
    <div style="display:grid;grid-template-columns:minmax(0,2fr) minmax(0,1fr);gap:22px;" class="xl-grid">

        {{-- LEFT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:22px;min-width:0;">

            {{-- Report Card Banner --}}
            <div style="border-radius:22px;overflow:hidden;position:relative;box-shadow:8px 8px 20px var(--sh-dark),-5px -5px 14px var(--sh-light);background:linear-gradient(135deg,#f59e0b,#b45309);">
                <div style="position:absolute;top:-30px;right:-30px;width:160px;height:160px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.2),transparent);filter:blur(20px);pointer-events:none;"></div>
                <div style="position:absolute;bottom:-20px;left:-20px;width:100px;height:100px;border-radius:50%;background:radial-gradient(circle,rgba(255,200,50,0.3),transparent);filter:blur(18px);pointer-events:none;"></div>
                <div style="position:relative;z-index:1;padding:24px 26px;display:flex;flex-wrap:wrap;align-items:center;gap:18px;">
                    <div style="width:56px;height:56px;border-radius:18px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);border:1.5px solid rgba(255,255,255,0.35);flex-shrink:0;">
                        <i class="fa-solid fa-file-pdf" style="color:#fff;font-size:1.5rem;"></i>
                    </div>
                    <div style="flex:1;min-width:180px;">
                        <div style="display:flex;gap:7px;margin-bottom:8px;">
                            <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.18);padding:3px 9px;border-radius:7px;">Official</span>
                            <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.18);padding:3px 9px;border-radius:7px;">Auto-Generated</span>
                        </div>
                        <h2 style="font-size:1.2rem;font-weight:900;color:#fff;letter-spacing:-0.02em;line-height:1.2;">Your Report Card is Ready</h2>
                        <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin-top:5px;line-height:1.5;">Download your official PDF with subject marks, grades, rank & teacher remarks.</p>
                    </div>
                    <a href="{{ route('student.report-card.download') }}" id="btn-download-report-card" class="cta-glass" style="flex-shrink:0;">
                        <i class="fa-solid fa-download"></i>Download PDF<i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                    </a>
                </div>
            </div>

            {{-- AI Suggestions Banner --}}
            <div style="border-radius:22px;overflow:hidden;position:relative;box-shadow:8px 8px 20px var(--sh-dark),-5px -5px 14px var(--sh-light);background:linear-gradient(135deg,#4f46e5,#7c3aed,#be185d);">
                <div style="position:absolute;top:-30px;right:-30px;width:140px;height:140px;border-radius:50%;background:radial-gradient(circle,rgba(255,255,255,0.18),transparent);filter:blur(22px);pointer-events:none;"></div>
                <div style="position:absolute;bottom:-18px;left:-18px;width:90px;height:90px;border-radius:50%;background:radial-gradient(circle,rgba(236,72,153,0.4),transparent);filter:blur(16px);pointer-events:none;"></div>
                <div style="position:relative;z-index:1;padding:24px 26px;display:flex;flex-wrap:wrap;align-items:center;gap:18px;">
                    <div style="width:56px;height:56px;border-radius:18px;display:flex;align-items:center;justify-content:center;background:rgba(255,255,255,0.18);border:1.5px solid rgba(255,255,255,0.35);flex-shrink:0;font-size:1.7rem;">🧠</div>
                    <div style="flex:1;min-width:180px;">
                        <div style="display:flex;gap:7px;margin-bottom:8px;">
                            <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.9);background:rgba(255,255,255,0.18);padding:3px 9px;border-radius:7px;">AI‑Powered</span>
                            <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.9);background:rgba(255,255,255,0.18);padding:3px 9px;border-radius:7px;">Personalized</span>
                        </div>
                        <h2 style="font-size:1.2rem;font-weight:900;color:#fff;letter-spacing:-0.02em;line-height:1.2;">Your AI Study Coach is Ready</h2>
                        <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin-top:5px;line-height:1.5;">Recommendations based on your marks, attendance & performance trends.</p>
                        @php
                            $weakCount = \App\Models\Mark::with('subject')
                                ->whereHas('student', fn($q) => $q->where('user_id', Auth::id()))
                                ->get()
                                ->filter(fn($m) => $m->total_marks > 0 && ($m->marks_obtained / $m->total_marks) * 100 < 50)
                                ->count();
                        @endphp
                        @if($weakCount > 0)
                        <div style="margin-top:10px;display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,0.18);padding:5px 12px;border-radius:8px;">
                            <i class="fa-solid fa-triangle-exclamation" style="font-size:0.7rem;color:#fbbf24;" class="animate-pulse"></i>
                            <span style="font-size:0.7rem;font-weight:800;color:rgba(255,255,255,0.95);">{{ $weakCount }} subject{{ $weakCount > 1 ? 's' : '' }} need{{ $weakCount === 1 ? 's' : '' }} attention</span>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('student.suggestions') }}" class="cta-glass" style="flex-shrink:0;">
                        <i class="fa-solid fa-brain"></i>View AI Plan<i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                    </a>
                </div>
            </div>

            {{-- Subject Analytics --}}
            <div class="c" style="overflow:hidden;">
                <div style="padding:22px 24px 18px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.5);">
                    <div>
                        <div class="sec-title">Subject Analytics</div>
                        <div class="sec-sub">Attendance tracked per subject</div>
                    </div>
                    <div class="icon-box" style="width:44px;height:44px;color:var(--accent);">
                        <i class="fa-solid fa-chart-pie" style="font-size:1rem;"></i>
                    </div>
                </div>
                <div style="overflow-x:auto;">
                    <table style="width:100%;border-collapse:collapse;">
                        <thead>
                            <tr style="border-bottom:1px solid rgba(255,255,255,0.45);">
                                <th style="padding:12px 24px;text-align:left;font-size:0.6rem;font-weight:900;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">Subject</th>
                                <th style="padding:12px 16px;text-align:center;font-size:0.6rem;font-weight:900;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">Classes</th>
                                <th style="padding:12px 24px;font-size:0.6rem;font-weight:900;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">Progress</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($subjectAttendance as $row)
                                @php
                                    $sp = $row->total_classes > 0 ? round(($row->present_count / $row->total_classes) * 100) : 0;
                                    $bg = $sp >= 75 ? 'linear-gradient(90deg,#34d399,#10b981)' : ($sp >= 60 ? 'linear-gradient(90deg,#fcd34d,#f59e0b)' : 'linear-gradient(90deg,#fb7185,#f43f5e)');
                                    $tc = $sp >= 75 ? '#10b981' : ($sp >= 60 ? '#f59e0b' : '#f43f5e');
                                @endphp
                                <tr class="trow" style="border-bottom:1px solid rgba(255,255,255,0.38);">
                                    <td style="padding:14px 24px;">
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="icon-box-sm" style="width:34px;height:34px;font-size:0.78rem;font-weight:800;color:var(--text-secondary);">
                                                {{ strtoupper(substr($row->subject->name ?? 'U', 0, 1)) }}
                                            </div>
                                            <span style="font-size:0.85rem;font-weight:700;color:var(--text-primary);">{{ $row->subject->name ?? 'Unknown' }}</span>
                                        </div>
                                    </td>
                                    <td style="padding:14px 16px;text-align:center;">
                                        <span style="font-size:0.75rem;font-weight:800;color:var(--text-primary);">{{ $row->present_count }}</span>
                                        <span style="font-size:0.72rem;font-weight:600;color:var(--text-muted);">/ {{ $row->total_classes }}</span>
                                    </td>
                                    <td style="padding:14px 24px;min-width:180px;">
                                        <div style="display:flex;align-items:center;gap:10px;">
                                            <div class="track" style="flex:1;height:8px;">
                                                <div style="height:100%;width:{{ $sp }}%;background:{{ $bg }};border-radius:100px;transition:width 1.1s ease;"></div>
                                            </div>
                                            <span style="font-size:0.72rem;font-weight:900;color:{{ $tc }};min-width:32px;text-align:right;font-variant-numeric:tabular-nums;">{{ $sp }}%</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" style="padding:40px 24px;text-align:center;">
                                        <div class="c-inset" style="display:inline-flex;flex-direction:column;align-items:center;padding:24px 32px;">
                                            <i class="fa-solid fa-chart-bar" style="font-size:2rem;color:var(--sh-dark);margin-bottom:10px;"></i>
                                            <p style="font-size:0.82rem;font-weight:700;color:var(--text-muted);">No analytics data yet.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Campus Feed --}}
            <div class="c" style="padding:24px;position:relative;overflow:hidden;" id="announcements-section">
                <div style="position:absolute;right:20px;top:20px;opacity:0.03;pointer-events:none;">
                    <i class="fa-solid fa-satellite-dish" style="font-size:10rem;color:var(--text-primary);transform:rotate(-12deg);display:block;"></i>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:22px;padding-bottom:18px;border-bottom:1px solid rgba(255,255,255,0.5);position:relative;z-index:1;">
                    <div style="display:flex;align-items:center;gap:14px;">
                        <div class="icon-box" style="width:46px;height:46px;color:#f43f5e;">
                            <i class="fa-solid fa-bullhorn" style="font-size:1rem;"></i>
                        </div>
                        <div>
                            <div class="sec-title">Campus Feed</div>
                            <div class="sec-sub">Latest announcements</div>
                        </div>
                    </div>
                    <div style="position:relative;display:inline-flex;">
                        <span style="position:absolute;top:-4px;right:-4px;width:10px;height:10px;background:#f43f5e;border-radius:50%;border:2px solid var(--bg);" class="animate-ping"></span>
                        <span style="position:absolute;top:-4px;right:-4px;width:10px;height:10px;background:#f43f5e;border-radius:50%;border:2px solid var(--bg);"></span>
                        <span class="pill" style="color:#f43f5e;">Live Updates</span>
                    </div>
                </div>

                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;position:relative;z-index:1;">
                    @forelse($notices as $notice)
                        @php
                            $nc=['Urgent'=>['#f43f5e','#e11d48'],'Exam'=>['#5b5ef4','#4338ca'],'Holiday'=>['#10b981','#059669'],'General'=>['#3b82f6','#2563eb']];
                            $c=$nc[$notice->category]??$nc['General'];
                        @endphp
                        <div class="nc" style="padding:20px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                                <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.1em;text-transform:uppercase;color:#fff;padding:4px 10px;border-radius:8px;background:linear-gradient(135deg,{{ $c[0] }},{{ $c[1] }});">{{ $notice->category }}</span>
                                <span style="font-size:0.65rem;font-weight:700;color:var(--text-muted);">{{ $notice->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 style="font-size:0.92rem;font-weight:800;color:var(--text-primary);line-height:1.35;margin-bottom:8px;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">{{ $notice->title }}</h3>
                            <p style="font-size:0.78rem;color:var(--text-muted);line-height:1.55;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:16px;">{{ $notice->content }}</p>
                            <div style="padding-top:14px;border-top:1px solid rgba(255,255,255,0.5);display:flex;align-items:center;gap:9px;">
                                <div class="icon-box-sm" style="width:28px;height:28px;font-size:0.68rem;color:var(--text-muted);">
                                    <i class="fa-solid fa-pen-nib"></i>
                                </div>
                                <span style="font-size:0.62rem;font-weight:800;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.1em;">{{ $notice->author->name ?? 'Administration' }}</span>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column:1/-1;padding:48px 24px;text-align:center;" class="c-inset">
                            <i class="fa-solid fa-envelope-open-text" style="font-size:2.2rem;color:var(--sh-dark);display:block;margin-bottom:12px;"></i>
                            <p style="font-size:0.85rem;font-weight:700;color:var(--text-muted);">No campus updates at the moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>{{-- /left --}}

        {{-- RIGHT COLUMN --}}
        <div style="display:flex;flex-direction:column;gap:22px;min-width:0;">

            {{-- My Program --}}
            <div class="c" style="overflow:hidden;">
                <div style="padding:22px;position:relative;overflow:hidden;background:linear-gradient(135deg,var(--accent),var(--accent-2));">
                    <div style="position:absolute;right:-10px;top:-10px;opacity:0.12;pointer-events:none;">
                        <i class="fa-solid fa-graduation-cap" style="font-size:7rem;color:#fff;"></i>
                    </div>
                    <div style="position:relative;z-index:1;">
                        <div style="width:44px;height:44px;border-radius:14px;background:rgba(255,255,255,0.2);border:1.5px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                            <i class="fa-solid fa-book-open-reader" style="color:#fff;font-size:1.1rem;"></i>
                        </div>
                        <div style="font-size:0.6rem;font-weight:900;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-bottom:4px;">My Program</div>
                        <div style="font-size:1.05rem;font-weight:900;color:#fff;line-height:1.2;">{{ $course->name ?? 'Not Assigned' }}</div>
                    </div>
                </div>
                <div style="padding:20px;margin-top:0;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;">
                        <span style="font-size:0.62rem;font-weight:800;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-muted);">Enrolled Subjects</span>
                        <span class="pill" style="color:var(--accent);">{{ count($subjects) }} Total</span>
                    </div>
                    <div style="display:flex;flex-wrap:wrap;gap:8px;">
                        @forelse($subjects as $subject)
                            <span class="tag">{{ $subject->name }}</span>
                        @empty
                            <span style="font-size:0.8rem;color:var(--text-muted);font-style:italic;width:100%;text-align:center;padding:12px 0;">No subjects enrolled.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Messages / Broadcasts --}}
            @php $studentRecord = auth()->user()->student; @endphp
            <div class="c" style="overflow:hidden;" id="announcements">
                <div style="padding:18px 20px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.5);">
                    <div style="display:flex;align-items:center;gap:12px;">
                        <div class="icon-box" style="width:42px;height:42px;color:#7c3aed;">
                            <i class="fa-solid fa-bell" style="font-size:0.95rem;"></i>
                        </div>
                        <div>
                            <div class="sec-title" style="font-size:0.95rem;">Messages</div>
                            <div class="sec-sub">Teacher Broadcasts</div>
                        </div>
                    </div>
                    <span id="total-unread-badge" style="display:none;width:28px;height:28px;border-radius:50%;background:#ef4444;font-size:0.7rem;font-weight:900;color:#fff;align-items:center;justify-content:center;box-shadow:3px 3px 8px rgba(239,68,68,0.35);" class="animate-bounce">0</span>
                </div>
                <div>
                    @forelse($subjects as $subject)
                        @php
                            $smc = \App\Models\BroadcastMessage::where('subject_id', $subject->id)->count();
                            $rc = $studentRecord ? \App\Models\MessageRead::where('student_id', $studentRecord->id)->whereHas('message', fn($q) => $q->where('subject_id', $subject->id))->where('seen', true)->count() : 0;
                            $un = max(0, $smc - $rc);
                        @endphp
                        <a href="{{ route('student.broadcast.index', $subject->id) }}" class="bc-row" style="text-decoration:none;">
                            <div class="icon-box-sm" style="width:38px;height:38px;font-size:0.72rem;font-weight:900;color:var(--accent);flex-shrink:0;">
                                {{ strtoupper(substr($subject->name, 0, 2)) }}
                            </div>
                            <div style="flex:1;min-width:0;">
                                <p style="font-size:0.82rem;font-weight:800;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $subject->name }}</p>
                                <p style="font-size:0.65rem;font-weight:600;color:var(--text-muted);margin-top:1px;">{{ $smc }} announcement{{ $smc != 1 ? 's' : '' }}</p>
                            </div>
                            <div style="display:flex;align-items:center;gap:8px;flex-shrink:0;">
                                @if($un > 0)
                                    <span class="subject-unread-badge" data-subject-id="{{ $subject->id }}" style="min-width:22px;height:22px;padding:0 6px;border-radius:11px;background:var(--accent);box-shadow:2px 2px 6px rgba(91,94,244,0.4);font-size:0.65rem;font-weight:900;color:#fff;display:flex;align-items:center;justify-content:center;">{{ $un }}</span>
                                @else
                                    <span class="subject-unread-badge" data-subject-id="{{ $subject->id }}" style="width:22px;height:22px;border-radius:50%;background:var(--bg);box-shadow:2px 2px 5px var(--sh-dark),-2px -2px 5px var(--sh-light);font-size:0.75rem;color:#22c55e;display:flex;align-items:center;justify-content:center;">✓</span>
                                @endif
                                <i class="fa-solid fa-chevron-right" style="font-size:0.7rem;color:var(--text-muted);"></i>
                            </div>
                        </a>
                    @empty
                        <div style="padding:28px;text-align:center;color:var(--text-muted);font-size:0.82rem;font-style:italic;">No subjects enrolled.</div>
                    @endforelse
                </div>
            </div>

            {{-- Recent Badges --}}
            <div class="c" style="padding:22px;">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:18px;padding-bottom:14px;border-bottom:1px solid rgba(255,255,255,0.5);">
                    <div>
                        <div class="sec-title" style="font-size:0.95rem;">Recent Badges</div>
                        <div class="sec-sub">Your achievements</div>
                    </div>
                    <div class="icon-box" style="width:38px;height:38px;color:#eab308;">
                        <i class="fa-solid fa-medal" style="font-size:0.9rem;"></i>
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;">
                    @php $bc = 0; @endphp
                    @foreach($badges as $badge)
                        @if($bc < 3)
                        <div style="display:flex;flex-direction:column;align-items:center;gap:8px;cursor:help;" title="{{ $badge->description }}">
                            <div class="badge-wrap">{!! $badge->icon !!}</div>
                            <span style="font-size:0.62rem;font-weight:800;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-secondary);text-align:center;line-height:1.2;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;width:100%;text-align:center;">{{ $badge->name }}</span>
                        </div>
                        @php $bc++; @endphp
                        @endif
                    @endforeach
                    @for($i = $bc; $i < 3; $i++)
                    <div style="display:flex;flex-direction:column;align-items:center;gap:8px;opacity:0.35;">
                        <div class="c-inset" style="width:64px;height:64px;border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:var(--text-muted);">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <span style="font-size:0.62rem;font-weight:800;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);">Locked</span>
                    </div>
                    @endfor
                </div>
                @if(count($badges) > 0)
                <div style="margin-top:16px;padding-top:14px;border-top:1px solid rgba(255,255,255,0.5);text-align:center;">
                    <a href="#" class="btn-accent" style="padding:9px 18px;font-size:0.75rem;display:inline-flex;">View All Badges <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
                </div>
                @endif
            </div>

            {{-- Telegram Connect --}}
            @php
                $isTg = auth()->user()->hasTelegramConnected();
                $lastTg = $isTg ? \App\Models\NotificationLog::where('recipient_id', auth()->id())->where('status','sent')->latest('sent_at')->first() : null;
            @endphp
            <div class="c" style="overflow:hidden;">
                <div style="padding:20px;position:relative;overflow:hidden;background:{{ $isTg ? 'linear-gradient(135deg,#2AABEE,#229ED9)' : 'linear-gradient(135deg,#64748b,#475569)' }};">
                    <div style="position:absolute;right:-10px;top:-10px;opacity:0.1;pointer-events:none;">
                        <i class="fa-brands fa-telegram" style="font-size:7rem;color:#fff;"></i>
                    </div>
                    <div style="position:relative;z-index:1;display:flex;align-items:center;gap:14px;">
                        <div style="width:44px;height:44px;border-radius:14px;background:rgba(255,255,255,0.2);border:1.5px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i class="fa-brands fa-telegram" style="color:#fff;font-size:1.3rem;"></i>
                        </div>
                        <div style="flex:1;">
                            <div style="font-size:0.58rem;font-weight:900;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-bottom:2px;">Notifications</div>
                            <div style="font-size:1rem;font-weight:900;color:#fff;">Telegram</div>
                        </div>
                        <span style="font-size:0.6rem;font-weight:900;text-transform:uppercase;letter-spacing:0.1em;padding:4px 10px;border-radius:8px;background:rgba(255,255,255,0.2);color:#fff;display:flex;align-items:center;gap:5px;">
                            <span style="width:6px;height:6px;border-radius:50%;background:{{ $isTg ? '#34d399' : 'rgba(255,255,255,0.5)' }};display:inline-block;" {{ $isTg ? 'class=animate-pulse' : '' }}></span>
                            {{ $isTg ? 'Connected' : 'Not Connected' }}
                        </span>
                    </div>
                </div>

                <div style="padding:18px;">
                    @if($isTg)
                        <div class="tg-info" style="display:flex;align-items:flex-start;gap:10px;margin-bottom:12px;">
                            <i class="fa-solid fa-circle-check" style="color:#22c55e;font-size:1.1rem;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <p style="font-size:0.82rem;font-weight:800;color:#166534;">Telegram Connected ✅</p>
                                <p style="font-size:0.7rem;color:#15803d;margin-top:2px;line-height:1.45;">Receiving real-time alerts for attendance, results, fees & more.</p>
                            </div>
                        </div>
                        @if($lastTg)
                        <div class="tg-info" style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <i class="fa-solid fa-clock" style="color:var(--text-muted);font-size:0.85rem;flex-shrink:0;"></i>
                            <div>
                                <p style="font-size:0.62rem;font-weight:900;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Last Alert Sent</p>
                                <p style="font-size:0.78rem;font-weight:700;color:var(--text-primary);">{{ $lastTg->sent_at?->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endif
                        <form method="POST" action="{{ route('student.telegram.disconnect') }}">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Disconnect Telegram? You will stop receiving notifications.')"
                                    style="width:100%;padding:11px;border-radius:13px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);font-size:0.8rem;font-weight:800;color:#ef4444;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;">
                                <i class="fa-solid fa-link-slash"></i> Disconnect Telegram
                            </button>
                        </form>
                    @else
                        <div class="tg-info" style="display:flex;align-items:flex-start;gap:10px;margin-bottom:14px;">
                            <i class="fa-solid fa-triangle-exclamation" style="color:#d97706;font-size:1.1rem;margin-top:1px;flex-shrink:0;"></i>
                            <div>
                                <p style="font-size:0.82rem;font-weight:800;color:#92400e;">Not Connected</p>
                                <p style="font-size:0.7rem;color:#b45309;margin-top:2px;line-height:1.45;">Connect to receive instant alerts for attendance, results, fees & emergencies.</p>
                            </div>
                        </div>
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px;margin-bottom:14px;">
                            <div style="font-size:0.68rem;font-weight:700;color:var(--text-muted);display:flex;align-items:center;gap:5px;">📊 Attendance alerts</div>
                            <div style="font-size:0.68rem;font-weight:700;color:var(--text-muted);display:flex;align-items:center;gap:5px;">⚠️ Low warnings</div>
                            <div style="font-size:0.68rem;font-weight:700;color:var(--text-muted);display:flex;align-items:center;gap:5px;">🎉 Result alerts</div>
                            <div style="font-size:0.68rem;font-weight:700;color:var(--text-muted);display:flex;align-items:center;gap:5px;">💰 Fee reminders</div>
                        </div>
                        <a href="{{ route('student.telegram.connect') }}" id="btn-connect-telegram" class="btn-accent" style="width:100%;justify-content:center;background:linear-gradient(135deg,#2AABEE,#229ED9);box-shadow:5px 5px 14px rgba(42,171,238,0.4),-3px -3px 9px rgba(255,255,255,0.8);">
                            <i class="fa-brands fa-telegram" style="font-size:1rem;"></i> Connect Telegram
                        </a>
                        <p style="font-size:0.62rem;text-align:center;color:var(--text-muted);margin-top:9px;">Redirected to Telegram → click "Start" in the bot.</p>
                    @endif
                </div>
            </div>

        </div>{{-- /right --}}
    </div>{{-- /two-col --}}
    </div>

</div>{{-- /max-w --}}

<script>
    // Responsive two-col grid
    (function(){
        const g = document.querySelector('.xl-grid');
        if(!g) return;
        function resize(){
            g.style.gridTemplateColumns = window.innerWidth >= 1280 ? 'minmax(0,2fr) minmax(0,1fr)' : 'minmax(0,1fr)';
        }
        resize();
        window.addEventListener('resize', resize);
    })();

    // Responsive stat grid
    (function(){
        const g = document.querySelector('.grid-stats');
        if(!g) return;
        function resize(){
            if(window.innerWidth < 640) g.style.gridTemplateColumns = '1fr 1fr';
            else if(window.innerWidth < 1024) g.style.gridTemplateColumns = 'repeat(2,1fr)';
            else g.style.gridTemplateColumns = 'repeat(4,1fr)';
        }
        resize();
        window.addEventListener('resize', resize);
    })();

    // Unread badge polling
    function refreshUnreadBadge() {
        fetch('{{ route("student.broadcast.unread") }}', {
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
        })
        .then(r => r.json())
        .then(data => {
            const b = document.getElementById('total-unread-badge');
            const nb = document.getElementById('unread-broadcast-badge');
            if(b){ b.textContent = data.count; b.style.display = data.count > 0 ? 'flex' : 'none'; }
            if(nb){ nb.textContent = data.count; nb.style.display = data.count > 0 ? 'flex' : 'none'; }
        })
        .catch(() => {});
    }
    refreshUnreadBadge();
    setInterval(refreshUnreadBadge, 5000);
</script>

</div>
@endsection