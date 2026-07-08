@extends('layouts.admin')
@section('title', 'System Overview')

@section('content')
<style>
.ac { background:var(--bg); border-radius:22px; box-shadow:8px 8px 20px var(--sh-dark),-8px -8px 20px var(--sh-light); transition:box-shadow 0.3s ease,transform 0.28s ease; }
.ac:hover { box-shadow:12px 12px 28px var(--sh-dark),-12px -12px 28px var(--sh-light); transform:translateY(-3px); }
.ac-sm { background:var(--bg); border-radius:16px; box-shadow:5px 5px 12px var(--sh-dark),-5px -5px 12px var(--sh-light); }
.ac-inset { background:var(--bg-dark); border-radius:14px; box-shadow:inset 4px 4px 10px var(--sh-dark),inset -4px -4px 10px var(--sh-light); }
.icon-box { border-radius:14px; background:var(--bg); box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light); display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.icon-box-sm { border-radius:11px; background:var(--bg); box-shadow:3px 3px 8px var(--sh-dark),-3px -3px 8px var(--sh-light); display:flex;align-items:center;justify-content:center;flex-shrink:0; }
.pill-nm { font-size:0.6rem;font-weight:900;letter-spacing:0.1em;text-transform:uppercase;padding:4px 10px;border-radius:9px;background:var(--bg);box-shadow:2px 2px 6px var(--sh-dark),-2px -2px 6px var(--sh-light); }
.grad-text { background:linear-gradient(135deg,var(--accent),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent; }
.sec-title { font-size:1.05rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.02em; }
.sec-sub   { font-size:0.62rem;font-weight:700;color:var(--text-muted);text-transform:uppercase;letter-spacing:0.1em;margin-top:1px; }
.track { background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -2px -2px 6px var(--sh-light);border-radius:100px;overflow:hidden; }
.qa-btn { display:flex;justify-content:space-between;align-items:center;padding:12px 16px;border-radius:13px;font-size:0.82rem;font-weight:700;text-decoration:none;transition:all 0.22s;background:rgba(255,255,255,0.15);border:1.5px solid rgba(255,255,255,0.25);color:#fff;backdrop-filter:blur(4px); }
.qa-btn:hover { background:rgba(255,255,255,0.25);transform:translateX(3px); }
.dir-row { display:flex;align-items:center;padding:14px 16px;border-radius:14px;text-decoration:none;transition:all 0.2s;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);gap:12px;color:var(--text-secondary); }
.dir-row:hover { box-shadow:6px 6px 14px var(--sh-dark),-6px -6px 14px var(--sh-light);transform:translateY(-2px);color:var(--accent); }
.pay-row { display:flex;align-items:center;gap:12px;padding:12px 16px;border-bottom:1px solid rgba(255,255,255,0.4);transition:background 0.15s; }
.pay-row:last-child { border-bottom:none; }
.pay-row:hover { background:rgba(255,255,255,0.42); }
</style>

<div style="min-height:100vh;background:var(--bg);max-width:1400px;margin:0 auto;">

    {{-- Header --}}
    <div style="display:flex;flex-wrap:wrap;justify-content:space-between;align-items:flex-start;gap:18px;margin-bottom:28px;">
        <div>
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:6px;">
                <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;display:inline-block;box-shadow:0 0 8px 2px #22c55e;" class="animate-pulse"></span>
                <span style="font-size:0.65rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">System Live</span>
            </div>
            <h1 style="font-size:2rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.03em;line-height:1.1;">
                System <span class="grad-text">Overview</span>
            </h1>
            <p style="color:var(--text-muted);font-size:0.88rem;font-weight:500;margin-top:6px;">Welcome back, {{ auth()->user()->name ?? 'Admin' }}. Here is the current status of your institution.</p>
        </div>
        <div style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
            <button onclick="window.location.reload()" style="display:flex;align-items:center;gap:7px;padding:10px 18px;border-radius:13px;background:var(--bg);box-shadow:4px 4px 9px var(--sh-dark),-4px -4px 9px var(--sh-light);font-weight:700;font-size:0.8rem;color:var(--text-secondary);border:none;cursor:pointer;transition:all 0.2s;">
                <i class="fa-solid fa-rotate-right"></i> Refresh
            </button>
            <a href="{{ route('admin.analytics.export') }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;border-radius:13px;font-weight:800;font-size:0.8rem;color:#fff;background:linear-gradient(135deg,var(--accent),var(--accent-2));box-shadow:5px 5px 14px rgba(79,70,229,0.4),-3px -3px 9px rgba(255,255,255,0.8);text-decoration:none;transition:all 0.25s;">
                <i class="fa-solid fa-download"></i> Export Report
            </a>
        </div>
    </div>

    {{-- Stat Cards --}}
    <div id="admin-stat-grid" style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-bottom:24px;">

        <a href="{{ route('admin.fees.index') }}" class="ac" style="padding:22px 20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                <div class="icon-box" style="width:46px;height:46px;color:#10b981;"><i class="fa-solid fa-indian-rupee-sign" style="font-size:1.1rem;"></i></div>
                <span class="pill-nm" style="color:#10b981;">Revenue</span>
            </div>
            <div style="font-size:1.9rem;font-weight:900;color:var(--text-primary);line-height:1;letter-spacing:-0.02em;">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
            <p style="font-size:0.65rem;font-weight:700;color:#10b981;margin-top:6px;display:flex;align-items:center;gap:4px;text-transform:uppercase;letter-spacing:0.08em;">
                <i class="fa-solid fa-arrow-trend-up"></i> Vault Active
            </p>
        </a>

        <a href="{{ route('admin.students.index') }}" class="ac" style="padding:22px 20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                <div class="icon-box" style="width:46px;height:46px;color:#3b82f6;"><i class="fa-solid fa-user-graduate" style="font-size:1.1rem;"></i></div>
                <span class="pill-nm" style="color:#3b82f6;">Students</span>
            </div>
            <div style="font-size:2.2rem;font-weight:900;color:var(--text-primary);line-height:1;">{{ $totalStudents ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:700;color:#3b82f6;margin-top:6px;text-transform:uppercase;letter-spacing:0.08em;display:flex;align-items:center;gap:4px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#3b82f6;display:inline-block;"></span> Enrolled
            </p>
        </a>

        <a href="{{ route('admin.teachers.index') }}" class="ac" style="padding:22px 20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                <div class="icon-box" style="width:46px;height:46px;color:#8b5cf6;"><i class="fa-solid fa-chalkboard-user" style="font-size:1.1rem;"></i></div>
                <span class="pill-nm" style="color:#8b5cf6;">Teachers</span>
            </div>
            <div style="font-size:2.2rem;font-weight:900;color:var(--text-primary);line-height:1;">{{ $totalTeachers ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:700;color:#8b5cf6;margin-top:6px;text-transform:uppercase;letter-spacing:0.08em;display:flex;align-items:center;gap:4px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#8b5cf6;display:inline-block;"></span> Active Staff
            </p>
        </a>

        <a href="{{ route('admin.courses.index') }}" class="ac" style="padding:22px 20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                <div class="icon-box" style="width:46px;height:46px;color:#6d28d9;"><i class="fa-solid fa-book-open" style="font-size:1.1rem;"></i></div>
                <span class="pill-nm" style="color:#6d28d9;">Courses</span>
            </div>
            <div style="font-size:2.2rem;font-weight:900;color:var(--text-primary);line-height:1;">{{ $totalCourses ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:700;color:#6d28d9;margin-top:6px;text-transform:uppercase;letter-spacing:0.08em;display:flex;align-items:center;gap:4px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#6d28d9;display:inline-block;"></span> Academic
            </p>
        </a>

        <a href="{{ route('admin.subjects.index') }}" class="ac" style="padding:22px 20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;">
                <div class="icon-box" style="width:46px;height:46px;color:#f59e0b;"><i class="fa-solid fa-layer-group" style="font-size:1.1rem;"></i></div>
                <span class="pill-nm" style="color:#f59e0b;">Subjects</span>
            </div>
            <div style="font-size:2.2rem;font-weight:900;color:var(--text-primary);line-height:1;">{{ $totalSubjects ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:700;color:#f59e0b;margin-top:6px;text-transform:uppercase;letter-spacing:0.08em;display:flex;align-items:center;gap:4px;">
                <span style="width:6px;height:6px;border-radius:50%;background:#f59e0b;display:inline-block;"></span> Curriculum
            </p>
        </a>

    </div>

    {{-- Mid Section: Quick Actions + System Directory --}}
    <div id="admin-mid-grid" style="display:grid;grid-template-columns:1fr 2fr;gap:20px;margin-bottom:22px;">

        {{-- Quick Actions --}}
        <div style="border-radius:22px;overflow:hidden;box-shadow:8px 8px 20px var(--sh-dark),-5px -5px 14px var(--sh-light);background:linear-gradient(135deg,#312e81,#4338ca,#6366f1);">
            <div style="padding:26px;position:relative;overflow:hidden;">
                <div style="position:absolute;right:-20px;bottom:-20px;opacity:0.08;pointer-events:none;">
                    <i class="fa-solid fa-bolt-lightning" style="font-size:9rem;color:#fff;display:block;"></i>
                </div>
                <div style="position:relative;z-index:1;">
                    <div style="width:46px;height:46px;border-radius:14px;background:rgba(255,255,255,0.15);border:1.5px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                        <i class="fa-solid fa-bolt" style="color:#fff;font-size:1.1rem;"></i>
                    </div>
                    <div style="font-size:1.2rem;font-weight:900;color:#fff;margin-bottom:5px;">Quick Actions</div>
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.72);line-height:1.5;margin-bottom:18px;">Direct access to core campus operations.</p>
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <a href="{{ route('admin.students.create') }}" class="qa-btn">
                            <span><i class="fa-solid fa-user-plus" style="margin-right:8px;"></i>Add New Student</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                        <a href="{{ route('admin.teachers.create') }}" class="qa-btn">
                            <span><i class="fa-solid fa-chalkboard-user" style="margin-right:8px;"></i>Add New Teacher</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                        <a href="{{ route('admin.courses.create') }}" class="qa-btn">
                            <span><i class="fa-solid fa-book-medical" style="margin-right:8px;"></i>Create Course</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                        <a href="{{ route('admin.notices.index') }}" class="qa-btn">
                            <span><i class="fa-solid fa-bullhorn" style="margin-right:8px;"></i>Post Notice</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.75rem;"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- System Directory --}}
        <div class="ac" style="overflow:hidden;">
            <div style="padding:22px 24px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.5);">
                <div>
                    <div class="sec-title">System Directory</div>
                    <div class="sec-sub">Institution management links</div>
                </div>
                <div style="display:flex;align-items:center;gap:7px;padding:6px 13px;border-radius:10px;background:var(--bg);box-shadow:inset 2px 2px 6px var(--sh-dark),inset -2px -2px 6px var(--sh-light);">
                    <span style="width:7px;height:7px;border-radius:50%;background:#22c55e;display:inline-block;" class="animate-pulse"></span>
                    <span style="font-size:0.62rem;font-weight:800;color:#22c55e;text-transform:uppercase;letter-spacing:0.1em;">System Active</span>
                </div>
            </div>
            <div style="padding:20px;display:grid;grid-template-columns:repeat(2,1fr);gap:12px;">
                <a href="{{ route('admin.students.index') }}" class="dir-row">
                    <div class="icon-box-sm" style="width:38px;height:38px;color:#3b82f6;"><i class="fa-solid fa-user-graduate" style="font-size:0.88rem;"></i></div>
                    <div><div style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Manage Students</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">View & edit records</div></div>
                </a>
                <a href="{{ route('admin.teachers.index') }}" class="dir-row">
                    <div class="icon-box-sm" style="width:38px;height:38px;color:#8b5cf6;"><i class="fa-solid fa-chalkboard-user" style="font-size:0.88rem;"></i></div>
                    <div><div style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Manage Teachers</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Faculty profiles</div></div>
                </a>
                <a href="{{ route('admin.courses.index') }}" class="dir-row">
                    <div class="icon-box-sm" style="width:38px;height:38px;color:#6d28d9;"><i class="fa-solid fa-book-open" style="font-size:0.88rem;"></i></div>
                    <div><div style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Manage Courses</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Academic programs</div></div>
                </a>
                <a href="{{ route('admin.subjects.index') }}" class="dir-row">
                    <div class="icon-box-sm" style="width:38px;height:38px;color:#f59e0b;"><i class="fa-solid fa-layer-group" style="font-size:0.88rem;"></i></div>
                    <div><div style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Manage Subjects</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Course curriculum</div></div>
                </a>
                <a href="{{ route('admin.fees.index') }}" class="dir-row">
                    <div class="icon-box-sm" style="width:38px;height:38px;color:#10b981;"><i class="fa-solid fa-file-invoice-dollar" style="font-size:0.88rem;"></i></div>
                    <div><div style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Fee Management</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Collections & dues</div></div>
                </a>
                <a href="{{ route('admin.notices.index') }}" class="dir-row">
                    <div class="icon-box-sm" style="width:38px;height:38px;color:#f43f5e;"><i class="fa-solid fa-bullhorn" style="font-size:0.88rem;"></i></div>
                    <div><div style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Notice Board</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Campus announcements</div></div>
                </a>
            </div>
        </div>
    </div>

    {{-- Bottom: Chart + Payments --}}
    <div id="admin-bottom-grid" style="display:grid;grid-template-columns:2fr 1fr;gap:20px;">

        {{-- Revenue Chart --}}
        <div class="ac" style="overflow:hidden;">
            <div style="padding:22px 24px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.5);">
                <div>
                    <div class="sec-title">Revenue Overview</div>
                    <div class="sec-sub">{{ date('Y') }} Monthly Collections</div>
                </div>
                <div class="icon-box" style="width:42px;height:42px;color:#10b981;">
                    <i class="fa-solid fa-chart-area" style="font-size:1rem;"></i>
                </div>
            </div>
            <div style="padding:22px;height:320px;position:relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="ac" style="overflow:hidden;">
            <div style="padding:22px 24px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid rgba(255,255,255,0.5);">
                <div>
                    <div class="sec-title">Recent Payments</div>
                    <div class="sec-sub">Latest fee transactions</div>
                </div>
                <div class="icon-box" style="width:42px;height:42px;color:#f59e0b;">
                    <i class="fa-solid fa-bolt" style="font-size:1rem;"></i>
                </div>
            </div>
            <div>
                @forelse($recentPayments as $payment)
                    <div class="pay-row">
                        <div class="icon-box-sm" style="width:36px;height:36px;font-size:0.7rem;font-weight:900;color:#10b981;flex-shrink:0;">
                            {{ strtoupper(substr($payment->student->name ?? 'S', 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.82rem;font-weight:800;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $payment->student->name ?? 'Unknown' }}</p>
                            <p style="font-size:0.65rem;color:var(--text-muted);margin-top:1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $payment->fee->title ?? 'General Fee' }}</p>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <p style="font-size:0.82rem;font-weight:900;color:#10b981;">+₹{{ number_format($payment->amount_paid) }}</p>
                            <p style="font-size:0.6rem;color:var(--text-muted);margin-top:1px;">{{ $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div style="padding:40px 24px;text-align:center;">
                        <div class="ac-inset" style="display:inline-flex;flex-direction:column;align-items:center;padding:20px 28px;">
                            <i class="fa-solid fa-ghost" style="font-size:2rem;color:var(--sh-dark);margin-bottom:8px;"></i>
                            <p style="font-size:0.8rem;font-weight:700;color:var(--text-muted);">No recent activity.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            @if(isset($recentPayments) && $recentPayments->count() > 0)
                <div style="padding:14px 24px;border-top:1px solid rgba(255,255,255,0.4);text-align:center;">
                    <a href="{{ route('admin.fees.index') }}" style="font-size:0.78rem;font-weight:800;color:var(--accent);text-decoration:none;">View All Transactions <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;margin-left:3px;"></i></a>
                </div>
            @endif
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Responsive grids
    ['admin-stat-grid','admin-mid-grid','admin-bottom-grid'].forEach(id => {
        const g = document.getElementById(id); if(!g) return;
        const configs = {
            'admin-stat-grid': { sm:'1fr 1fr', md:'repeat(3,1fr)', lg:'repeat(5,1fr)' },
            'admin-mid-grid':  { sm:'1fr',      md:'1fr',           lg:'1fr 2fr' },
            'admin-bottom-grid':{ sm:'1fr',     md:'1fr',           lg:'2fr 1fr' }
        };
        const c = configs[id];
        function resize(){
            const w = window.innerWidth;
            g.style.gridTemplateColumns = w < 640 ? c.sm : (w < 1024 ? c.md : c.lg);
        }
        resize(); window.addEventListener('resize', resize);
    });

    // Chart
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('revenueChart');
        if(!canvas) return;
        const ctx = canvas.getContext('2d');
        const revenueData = @json($revenueChartData ?? array_fill(0, 12, 0));
        let grad = ctx.createLinearGradient(0, 0, 0, 300);
        grad.addColorStop(0, 'rgba(79,70,229,0.45)');
        grad.addColorStop(1, 'rgba(79,70,229,0.01)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Revenue Collected (₹)', data: revenueData,
                    borderColor: '#4f46e5', backgroundColor: grad,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#ffffff', pointBorderColor: '#4f46e5',
                    pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6,
                    fill: true, tension: 0.4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1e2340', padding: 12,
                        titleFont: { size: 12, family: "'Inter', sans-serif" },
                        bodyFont: { size: 13, weight: 'bold', family: "'Inter', sans-serif" },
                        displayColors: false,
                        callbacks: { label: function(c) { return '₹ ' + c.parsed.y.toLocaleString(); } }
                    }
                },
                scales: {
                    x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: "'Inter', sans-serif", size: 11 }, color: '#8c94b0' } },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.04)', borderDash: [4,4], drawBorder: false },
                        ticks: {
                            font: { family: "'Inter', sans-serif", size: 11 }, color: '#8c94b0',
                            callback: function(v) { return v >= 1000 ? '₹' + (v/1000) + 'k' : '₹' + v; }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@endsection