@extends('layouts.teacher')
@section('title', 'Teacher Dashboard')

@section('content')
<style>
/* ─── iOS 18 Teacher Dashboard ─────────────────────────────── */
.ios-card {
    background: var(--bg-2);
    border-radius: 20px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s ease;
}
.ios-card:hover { transform: translateY(-3px) scale(1.005); box-shadow: var(--shadow-lg); }
.ios-badge { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.04em; padding: 3px 9px; border-radius: 100px; background: var(--accent-soft); color: var(--accent); text-transform: uppercase; }
.ios-stat-num { font-size: 2.4rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1; color: var(--text-primary); }
.sec-head { font-size: 1.05rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.025em; }
.sec-sub  { font-size: 0.72rem; font-weight: 500; color: var(--text-muted); margin-top: 2px; }

.sub-card {
    background: var(--bg-2);
    border-radius: 18px;
    border: 1px solid var(--border);
    padding: 20px;
    position: relative;
    overflow: hidden;
    transition: all 0.28s cubic-bezier(0.34,1.56,0.64,1);
}
.sub-card:hover { transform: translateY(-4px); box-shadow: var(--shadow-lg); border-color: var(--accent); }

.sub-btn-primary {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    flex: 1; padding: 9px 10px; border-radius: 10px;
    font-weight: 600; font-size: 0.75rem; border: none; cursor: pointer; text-decoration: none;
    background: var(--accent); color: #fff;
    box-shadow: 0 3px 10px var(--accent-glow);
    transition: all 0.2s;
}
.sub-btn-primary:hover { transform: translateY(-1px); box-shadow: 0 5px 14px var(--accent-glow); }

.sub-btn-outline {
    display: flex; align-items: center; justify-content: center; gap: 6px;
    flex: 1; padding: 9px 10px; border-radius: 10px;
    font-weight: 600; font-size: 0.75rem; cursor: pointer; text-decoration: none;
    background: var(--border-2); color: var(--text-secondary);
    border: 1px solid var(--border); transition: all 0.2s;
}
.sub-btn-outline:hover { background: var(--accent-soft); color: var(--accent); border-color: var(--accent); }

@media(max-width:640px){ #stat-grid{ grid-template-columns: 1fr 1fr !important; } }
</style>

<div style="padding:20px 24px 40px;max-width:1280px;margin:0 auto;">

    {{-- ── HERO GREETING ─────────────────────────────────── --}}
    <div style="border-radius:24px;overflow:hidden;background:linear-gradient(135deg,var(--accent),var(--accent-2));padding:26px 28px;margin-bottom:20px;box-shadow:0 8px 32px var(--accent-glow);position:relative;">
        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.10);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:14px;">
            <div>
                <div style="font-size:0.68rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:6px;display:flex;align-items:center;gap:7px;">
                    <i class="fa-solid fa-chalkboard-user" style="font-size:0.85rem;"></i>Instructor Portal
                </div>
                <h1 style="font-size:1.65rem;font-weight:800;color:#fff;letter-spacing:-0.03em;line-height:1.15;">
                    Hello, {{ auth()->user()->name ?? 'Professor' }} 👨‍🏫
                </h1>
                <p style="font-size:0.82rem;color:rgba(255,255,255,0.8);margin-top:5px;">Manage your classes, record attendance, and evaluate student performance.</p>
            </div>
            <div style="background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:16px;padding:13px 18px;backdrop-filter:blur(8px);text-align:center;flex-shrink:0;">
                <div style="font-size:0.6rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:3px;">Active Session</div>
                <div style="font-size:0.95rem;font-weight:700;color:#fff;">{{ date('D, d M Y') }}</div>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ────────────────────────────────────── --}}
    <div id="stat-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px;">

        <div class="ios-card" style="padding:20px;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;color:var(--accent);"><i class="fa-solid fa-book-open" style="font-size:0.95rem;"></i></div>
                <span class="ios-badge">Subjects</span>
            </div>
            <div class="ios-stat-num">{{ $subjects->count() ?? 0 }}</div>
            <p style="font-size:0.7rem;font-weight:500;color:var(--text-muted);margin-top:4px;">Assigned This Semester</p>
        </div>

        <a href="{{ route('teacher.attendance.create') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(52,199,89,0.12);display:flex;align-items:center;justify-content:center;color:#34C759;"><i class="fa-solid fa-clipboard-user" style="font-size:0.95rem;"></i></div>
                <i class="fa-solid fa-arrow-right" style="font-size:0.8rem;color:var(--text-muted);"></i>
            </div>
            <div style="font-size:1.2rem;font-weight:700;color:var(--text-primary);line-height:1.25;">Mark<br>Attendance</div>
            <p style="font-size:0.7rem;font-weight:500;color:var(--text-muted);margin-top:6px;">Record Daily Presence</p>
        </a>

        <a href="{{ route('teacher.marks.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;"><i class="fa-solid fa-file-pen" style="font-size:0.95rem;"></i></div>
                <i class="fa-solid fa-arrow-right" style="font-size:0.8rem;color:var(--text-muted);"></i>
            </div>
            <div style="font-size:1.2rem;font-weight:700;color:var(--text-primary);line-height:1.25;">Upload<br>Marks</div>
            <p style="font-size:0.7rem;font-weight:500;color:var(--text-muted);margin-top:6px;">Grade Assignments & Exams</p>
        </a>

        <a href="{{ route('teacher.performance.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(50,174,230,0.12);display:flex;align-items:center;justify-content:center;color:#32ADE6;"><i class="fa-solid fa-chart-line" style="font-size:0.95rem;"></i></div>
                <i class="fa-solid fa-arrow-right" style="font-size:0.8rem;color:var(--text-muted);"></i>
            </div>
            <div style="font-size:1.2rem;font-weight:700;color:var(--text-primary);line-height:1.25;">Class<br>Analytics</div>
            <p style="font-size:0.7rem;font-weight:500;color:var(--text-muted);margin-top:6px;">View Trends & Insights</p>
        </a>

    </div>

    {{-- ── MY SUBJECTS ───────────────────────────────────── --}}
    <div class="ios-card" style="overflow:hidden;margin-bottom:20px;">
        <div style="padding:20px 22px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--divider);">
            <div>
                <div class="sec-head">My Assigned Subjects</div>
                <div class="sec-sub">This Semester's Classes</div>
            </div>
            <span class="ios-badge">{{ $subjects->count() ?? 0 }} Classes</span>
        </div>
        <div style="padding:20px;display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:16px;">
            @forelse($subjects as $index => $subject)
                <div class="sub-card">
                    <div style="position:absolute;right:-8px;top:-8px;opacity:0.05;pointer-events:none;font-size:5rem;">📖</div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;position:relative;z-index:1;">
                        <div style="width:40px;height:40px;border-radius:12px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;font-size:1rem;font-weight:700;color:var(--accent);">
                            {{ strtoupper(substr($subject->name, 0, 1)) }}
                        </div>
                        <span style="font-size:0.6rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);">Subject-{{ $index + 1 }}</span>
                    </div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:5px;position:relative;z-index:1;">{{ $subject->name }}</h3>
                    <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.5;margin-bottom:14px;position:relative;z-index:1;">Manage curriculum, grades & student records for this subject.</p>
                    <div style="border-top:1px solid var(--divider);padding-top:12px;display:flex;align-items:center;gap:7px;position:relative;z-index:1;">
                        <a href="{{ route('teacher.marks.edit', $subject->id) }}" class="sub-btn-primary" style="flex:1;padding:9px 10px;">
                            <i class="fa-solid fa-pen"></i> Edit Marks
                        </a>
                        <a href="{{ route('teacher.broadcast.index', $subject->id) }}" class="sub-btn-outline" style="flex:1;padding:9px 10px;">
                            <i class="fa-solid fa-bullhorn"></i> Broadcast
                        </a>
                        <a href="{{ route('teacher.performance.show', $subject->id) }}" class="sub-btn-outline" style="flex:0;padding:9px 11px;" title="View Analysis">
                            <i class="fa-solid fa-chart-pie"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;padding:60px 24px;text-align:center;">
                    <div style="font-size:3rem;margin-bottom:14px;opacity:0.4;">📂</div>
                    <h3 style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-bottom:6px;">No Subjects Assigned</h3>
                    <p style="font-size:0.8rem;color:var(--text-muted);max-width:300px;margin:0 auto;line-height:1.55;">You haven't been assigned any subjects for this semester. Contact the Administration.</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- ── StudyAI Banner ─────────────────────────────────── --}}
    <div style="border-radius:20px;overflow:hidden;background:linear-gradient(135deg,#1C1C1E,#2C2C2E,#5856D6);padding:26px;box-shadow:0 6px 24px rgba(88,86,214,0.3);position:relative;">
        <div style="position:absolute;right:60px;top:-20px;opacity:0.07;pointer-events:none;font-size:8rem;">🤖</div>
        <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;align-items:center;gap:20px;">
            <div style="width:56px;height:56px;border-radius:18px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;font-size:1.7rem;flex-shrink:0;">🤖</div>
            <div style="flex:1;min-width:200px;">
                <div style="display:flex;gap:6px;margin-bottom:7px;">
                    <span style="font-size:0.6rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.15);padding:2px 8px;border-radius:100px;">AI-Powered</span>
                </div>
                <h2 style="font-size:1.2rem;font-weight:700;color:#fff;letter-spacing:-0.02em;line-height:1.2;">StudyAI Assistant</h2>
                <p style="font-size:0.8rem;color:rgba(255,255,255,0.75);margin-top:5px;line-height:1.5;">Generate lesson plans, quizzes, summaries, and student feedback instantly.</p>
            </div>
            <a href="{{ route('studyai.index') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 24px;border-radius:100px;font-weight:700;font-size:0.85rem;color:#1C1C1E;background:#fff;box-shadow:0 4px 14px rgba(0,0,0,0.25);cursor:pointer;text-decoration:none;transition:all 0.25s;flex-shrink:0;">
                Launch StudyAI <i class="fa-solid fa-sparkles" style="color:#5856D6;font-size:0.82rem;"></i>
            </a>
        </div>
    </div>

</div>

<script>
(function(){
    const g = document.getElementById('stat-grid');
    if(!g) return;
    function resize(){
        if(window.innerWidth < 640) g.style.gridTemplateColumns = '1fr 1fr';
        else if(window.innerWidth < 1024) g.style.gridTemplateColumns = 'repeat(2,1fr)';
        else g.style.gridTemplateColumns = 'repeat(4,1fr)';
    }
    resize(); window.addEventListener('resize', resize);
})();
</script>

@endsection