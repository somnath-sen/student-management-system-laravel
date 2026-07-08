@extends('layouts.teacher')
@section('title', 'Teacher Dashboard')

@section('content')
<style>
.tc { background:var(--bg); border-radius:22px; box-shadow:8px 8px 20px var(--sh-dark),-8px -8px 20px var(--sh-light); transition:box-shadow 0.3s ease,transform 0.28s ease; }
.tc:hover { box-shadow:12px 12px 28px var(--sh-dark),-12px -12px 28px var(--sh-light); transform:translateY(-3px); }
.tc-sm { background:var(--bg); border-radius:16px; box-shadow:5px 5px 13px var(--sh-dark),-5px -5px 13px var(--sh-light); }
.tc-inset { background:var(--bg); border-radius:14px; box-shadow:inset 4px 4px 10px var(--sh-dark),inset -4px -4px 10px var(--sh-light); }
.icon-box { border-radius:14px; background:var(--bg); box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light); display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.pill-nm { font-size:0.6rem;font-weight:900;letter-spacing:0.1em;text-transform:uppercase;padding:4px 10px;border-radius:9px;background:var(--bg);box-shadow:2px 2px 6px var(--sh-dark),-2px -2px 6px var(--sh-light); }
.grad-text { background:linear-gradient(135deg,var(--accent),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent; }
.btn-accent { display:inline-flex;align-items:center;gap:8px;padding:11px 22px;border-radius:14px;font-weight:800;font-size:0.82rem;color:#fff;background:linear-gradient(135deg,var(--accent),var(--accent-2));box-shadow:5px 5px 14px rgba(13,148,136,0.4),-3px -3px 9px rgba(255,255,255,0.8);cursor:pointer;text-decoration:none;border:none;transition:all 0.25s ease; }
.btn-accent:hover { transform:translateY(-2px);box-shadow:7px 7px 18px rgba(13,148,136,0.45),-4px -4px 12px rgba(255,255,255,0.9); }
.subject-card { background:var(--bg);border-radius:20px;box-shadow:7px 7px 17px var(--sh-dark),-7px -7px 17px var(--sh-light);transition:all 0.28s ease; }
.subject-card:hover { box-shadow:10px 10px 24px var(--sh-dark),-10px -10px 24px var(--sh-light);transform:translateY(-4px); }
.sub-btn { display:flex;align-items:center;justify-content:center;gap:6px;flex:1;padding:9px 10px;border-radius:12px;font-weight:800;font-size:0.75rem;border:none;cursor:pointer;text-decoration:none;transition:all 0.2s; background:var(--bg);box-shadow:3px 3px 8px var(--sh-dark),-3px -3px 8px var(--sh-light);color:var(--text-secondary); }
.sub-btn:hover { box-shadow:5px 5px 12px var(--sh-dark),-5px -5px 12px var(--sh-light); color:var(--accent); }
.sub-btn.primary { background:linear-gradient(135deg,var(--accent),var(--accent-2));color:#fff;box-shadow:4px 4px 12px rgba(13,148,136,0.4),-2px -2px 7px rgba(255,255,255,0.8); }
.sub-btn.primary:hover { transform:translateY(-1px); }
@keyframes floatUp{0%,100%{transform:translateY(0)}50%{transform:translateY(-8px)}}
.float-icon{animation:floatUp 5s ease-in-out infinite;}
</style>

<div style="min-height:100vh;background:var(--bg);padding:28px 28px 40px;max-width:1280px;margin:0 auto;">

    {{-- Welcome --}}
    <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-start;gap:20px;margin-bottom:32px;">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                <i class="fa-solid fa-chalkboard-user" style="color:var(--accent);font-size:0.85rem;"></i>
                <span style="font-size:0.65rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">Instructor Portal</span>
            </div>
            <h1 style="font-size:2rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.03em;line-height:1.1;">
                Hello, <span class="grad-text">{{ auth()->user()->name ?? 'Professor' }}</span> 👨‍🏫
            </h1>
            <p style="color:var(--text-muted);font-size:0.88rem;font-weight:500;margin-top:6px;">Manage your classes, record attendance, and evaluate student performance.</p>
        </div>
        <div class="tc" style="padding:14px 20px;display:flex;align-items:center;gap:12px;flex-shrink:0;">
            <div class="icon-box" style="width:40px;height:40px;">
                <span style="width:10px;height:10px;border-radius:50%;background:#22c55e;box-shadow:0 0 10px #22c55e;display:block;" class="animate-pulse"></span>
            </div>
            <div>
                <p style="font-size:0.58rem;font-weight:900;letter-spacing:0.2em;text-transform:uppercase;color:#22c55e;">Active Session</p>
                <p style="font-size:0.88rem;font-weight:800;color:var(--text-primary);">{{ date('D, d M Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Stat cards --}}
    <div id="stat-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-bottom:28px;">

        <div class="tc" style="padding:24px 22px;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:var(--accent);">
                    <i class="fa-solid fa-book-open" style="font-size:1.2rem;"></i>
                </div>
                <span class="pill-nm" style="color:var(--accent);">Subjects</span>
            </div>
            <div style="font-size:2.5rem;font-weight:900;color:var(--text-primary);line-height:1;">{{ $subjects->count() ?? 0 }}</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:5px;text-transform:uppercase;letter-spacing:0.08em;">Assigned This Semester</p>
        </div>

        <a href="{{ route('teacher.attendance.create') }}" class="tc" style="padding:24px 22px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:#22c55e;">
                    <i class="fa-solid fa-clipboard-user" style="font-size:1.2rem;"></i>
                </div>
                <i class="fa-solid fa-arrow-right" style="font-size:0.9rem;color:var(--text-muted);margin-top:14px;"></i>
            </div>
            <div style="font-size:1.3rem;font-weight:900;color:var(--text-primary);line-height:1.2;">Mark<br>Attendance</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:8px;text-transform:uppercase;letter-spacing:0.08em;">Record Daily Presence</p>
        </a>

        <a href="{{ route('teacher.marks.index') }}" class="tc" style="padding:24px 22px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:#f59e0b;">
                    <i class="fa-solid fa-file-pen" style="font-size:1.2rem;"></i>
                </div>
                <i class="fa-solid fa-arrow-right" style="font-size:0.9rem;color:var(--text-muted);margin-top:14px;"></i>
            </div>
            <div style="font-size:1.3rem;font-weight:900;color:var(--text-primary);line-height:1.2;">Upload<br>Marks</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:8px;text-transform:uppercase;letter-spacing:0.08em;">Grade Assignments & Exams</p>
        </a>

        <a href="{{ route('teacher.performance.index') }}" class="tc" style="padding:24px 22px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:18px;">
                <div class="icon-box" style="width:48px;height:48px;color:#0ea5e9;">
                    <i class="fa-solid fa-chart-line" style="font-size:1.2rem;"></i>
                </div>
                <i class="fa-solid fa-arrow-right" style="font-size:0.9rem;color:var(--text-muted);margin-top:14px;"></i>
            </div>
            <div style="font-size:1.3rem;font-weight:900;color:var(--text-primary);line-height:1.2;">Class<br>Analytics</div>
            <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:8px;text-transform:uppercase;letter-spacing:0.08em;">View Trends & Insights</p>
        </a>
    </div>

    {{-- My Subjects --}}
    <div class="tc" style="overflow:hidden;margin-bottom:24px;">
        <div style="padding:22px 26px 18px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.5);">
            <div>
                <div style="font-size:1.05rem;font-weight:800;color:var(--text-primary);">My Assigned Subjects</div>
                <div style="font-size:0.62rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.1em;margin-top:1px;">This Semester's Classes</div>
            </div>
            <span class="pill-nm" style="color:var(--accent);">{{ $subjects->count() ?? 0 }} Classes</span>
        </div>

        <div style="padding:22px 22px;display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:18px;">
            @forelse($subjects as $index => $subject)
                <div class="subject-card" style="padding:22px;position:relative;overflow:hidden;">
                    <div style="position:absolute;right:-8px;top:-8px;opacity:0.05;pointer-events:none;">
                        <i class="fa-solid fa-book-open" style="font-size:5rem;color:var(--text-primary);display:block;"></i>
                    </div>
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;position:relative;z-index:1;">
                        <div class="icon-box" style="width:44px;height:44px;font-size:1.1rem;font-weight:900;color:var(--accent);">
                            {{ strtoupper(substr($subject->name, 0, 1)) }}
                        </div>
                        <span style="font-size:0.6rem;font-weight:900;text-transform:uppercase;letter-spacing:0.1em;color:var(--text-muted);">Subject-{{ $index + 1 }}</span>
                    </div>
                    <h3 style="font-size:1.05rem;font-weight:800;color:var(--text-primary);margin-bottom:6px;position:relative;z-index:1;">{{ $subject->name }}</h3>
                    <p style="font-size:0.78rem;color:var(--text-muted);line-height:1.5;margin-bottom:16px;position:relative;z-index:1;">Manage curriculum, grades & student records for this subject.</p>
                    <div style="border-top:1px solid rgba(255,255,255,0.5);padding-top:14px;display:flex;align-items:center;gap:8px;position:relative;z-index:1;">
                        <a href="{{ route('teacher.marks.edit', $subject->id) }}" class="sub-btn primary">
                            <i class="fa-solid fa-pen"></i> Edit Marks
                        </a>
                        <a href="{{ route('teacher.broadcast.index', $subject->id) }}" class="sub-btn">
                            <i class="fa-solid fa-bullhorn"></i> Broadcast
                        </a>
                        <a href="{{ route('teacher.performance.show', $subject->id) }}" class="sub-btn" style="flex:0;padding:9px 12px;" title="View Analysis">
                            <i class="fa-solid fa-chart-pie"></i>
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;padding:60px 24px;text-align:center;">
                    <div class="tc-inset" style="display:inline-flex;flex-direction:column;align-items:center;padding:32px 40px;">
                        <i class="fa-solid fa-folder-open" style="font-size:2.5rem;color:var(--sh-dark);margin-bottom:14px;" class="float-icon"></i>
                        <h3 style="font-size:1rem;font-weight:800;color:var(--text-primary);margin-bottom:6px;">No Subjects Assigned</h3>
                        <p style="font-size:0.8rem;color:var(--text-muted);max-width:300px;line-height:1.55;">You haven't been assigned any subjects for this semester. Contact the Administration.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    {{-- StudyAI Banner --}}
    <div style="border-radius:22px;overflow:hidden;position:relative;box-shadow:8px 8px 20px var(--sh-dark),-5px -5px 14px var(--sh-light);background:linear-gradient(135deg,#1e1b4b,#312e81,#4338ca);">
        <div style="position:absolute;left:-30px;top:50%;transform:translateY(-50%);width:180px;height:180px;border-radius:50%;background:radial-gradient(circle,rgba(99,102,241,0.35),transparent);filter:blur(22px);pointer-events:none;"></div>
        <div style="position:absolute;right:60px;top:-20px;opacity:0.08;pointer-events:none;" class="float-icon">
            <i class="fa-solid fa-robot" style="font-size:8rem;color:#fff;display:block;"></i>
        </div>
        <div style="position:relative;z-index:1;padding:28px 32px;display:flex;flex-wrap:wrap;align-items:center;gap:22px;">
            <div style="width:60px;height:60px;border-radius:20px;background:rgba(255,255,255,0.12);border:1.5px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;font-size:1.8rem;flex-shrink:0;">🤖</div>
            <div style="flex:1;min-width:200px;">
                <div style="display:flex;gap:7px;margin-bottom:8px;">
                    <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.12em;text-transform:uppercase;color:rgba(255,255,255,0.85);background:rgba(255,255,255,0.15);padding:3px 9px;border-radius:7px;">AI-Powered</span>
                </div>
                <h2 style="font-size:1.3rem;font-weight:900;color:#fff;letter-spacing:-0.02em;line-height:1.2;">StudyAI Assistant</h2>
                <p style="font-size:0.82rem;color:rgba(255,255,255,0.75);margin-top:5px;line-height:1.5;">Generate lesson plans, quizzes, summaries, and student feedback instantly.</p>
            </div>
            <a href="{{ route('studyai.index') }}" style="display:inline-flex;align-items:center;gap:9px;padding:13px 26px;border-radius:15px;font-weight:800;font-size:0.88rem;color:#1e1b4b;background:#fff;box-shadow:4px 4px 14px rgba(0,0,0,0.2);cursor:pointer;text-decoration:none;transition:all 0.25s ease;flex-shrink:0;">
                Launch StudyAI <i class="fa-solid fa-sparkles" style="color:#6366f1;font-size:0.85rem;"></i>
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