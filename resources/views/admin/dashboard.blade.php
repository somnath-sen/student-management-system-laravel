@extends('layouts.admin')
@section('title', 'System Overview')

@section('content')
<style>
/* ─── iOS 18 Admin Dashboard Styles ───────────────────────── */
.ios-card {
    background: var(--bg-2);
    border-radius: 20px;
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s ease;
}
.ios-card:hover { transform: translateY(-3px) scale(1.005); box-shadow: var(--shadow-lg); }
.ios-badge { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.04em; padding: 3px 9px; border-radius: 100px; background: var(--accent-soft); color: var(--accent); text-transform: uppercase; }
.ios-progress-track { height: 5px; background: var(--border); border-radius: 100px; overflow: hidden; }
.ios-progress-fill { height: 100%; border-radius: 100px; transition: width 1.2s cubic-bezier(0.34,1.56,0.64,1); }
.ios-stat-num { font-size: 2.4rem; font-weight: 800; letter-spacing: -0.04em; line-height: 1; color: var(--text-primary); }
.sec-head { font-size: 1.05rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.025em; }
.sec-sub  { font-size: 0.72rem; font-weight: 500; color: var(--text-muted); margin-top: 2px; }

.qa-btn {
    display: flex; justify-content: space-between; align-items: center;
    padding: 11px 14px; border-radius: 12px;
    font-size: 0.82rem; font-weight: 600; text-decoration: none;
    transition: all 0.2s; color: #fff;
    background: rgba(255,255,255,0.14);
    border: 1px solid rgba(255,255,255,0.22);
    backdrop-filter: blur(6px);
}
.qa-btn:hover { background: rgba(255,255,255,0.24); transform: translateX(3px); }

.dir-row {
    display: flex; align-items: center; padding: 13px 14px; border-radius: 14px;
    text-decoration: none; transition: all 0.2s; gap: 12px;
    color: var(--text-secondary); border: 1px solid var(--border);
}
.dir-row:hover { background: var(--border-2); color: var(--text-primary); border-color: var(--accent); }

.pay-row { display: flex; align-items: center; gap: 12px; padding: 12px 18px; border-bottom: 1px solid var(--divider); transition: background 0.15s; }
.pay-row:last-child { border-bottom: none; }
.pay-row:hover { background: var(--border-2); }

@media(max-width:640px){ #admin-stat-grid{ grid-template-columns:1fr 1fr !important; } }
</style>

<div style="max-width:1400px;margin:0 auto;">

    {{-- ── HERO GREETING ─────────────────────────────────── --}}
    <div style="border-radius:24px;overflow:hidden;position:relative;background:linear-gradient(135deg,var(--accent),var(--accent-2));padding:26px 28px;margin-bottom:22px;box-shadow:0 8px 32px var(--accent-glow);">
        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.10);pointer-events:none;"></div>
        <div style="position:absolute;bottom:-30px;left:40%;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,0.07);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:16px;">
            <div>
                <div style="font-size:0.68rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:6px;display:flex;align-items:center;gap:7px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#fff;display:inline-block;" class="animate-pulse"></span>System Live
                </div>
                <h1 style="font-size:1.65rem;font-weight:800;color:#fff;letter-spacing:-0.03em;line-height:1.15;">
                    System Overview
                </h1>
                <p style="font-size:0.82rem;color:rgba(255,255,255,0.8);margin-top:5px;">Welcome back, {{ auth()->user()->name ?? 'Admin' }}. Here is the current status of your institution.</p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                <button onclick="window.location.reload()" style="display:flex;align-items:center;gap:7px;padding:9px 16px;border-radius:100px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);font-weight:600;font-size:0.78rem;color:#fff;cursor:pointer;transition:all 0.2s;backdrop-filter:blur(6px);">
                    <i class="fa-solid fa-rotate-right"></i>Refresh
                </button>
                <a href="{{ route('admin.analytics.export') }}" style="display:inline-flex;align-items:center;gap:8px;padding:9px 18px;border-radius:100px;font-weight:600;font-size:0.78rem;color:var(--accent);background:#fff;text-decoration:none;transition:all 0.2s;box-shadow:0 2px 8px rgba(0,0,0,0.2);">
                    <i class="fa-solid fa-download"></i>Export Report
                </a>
            </div>
        </div>
    </div>

    {{-- ── STAT CARDS ────────────────────────────────────── --}}
    <div id="admin-stat-grid" style="display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:20px;">

        <a href="{{ route('admin.fees.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(52,199,89,0.12);display:flex;align-items:center;justify-content:center;color:#34C759;"><i class="fa-solid fa-indian-rupee-sign" style="font-size:0.95rem;"></i></div>
                <span class="ios-badge" style="background:rgba(52,199,89,0.10);color:#34C759;">Revenue</span>
            </div>
            <div class="ios-stat-num" style="font-size:1.8rem;">₹{{ number_format($totalRevenue ?? 0, 0) }}</div>
            <p style="font-size:0.65rem;font-weight:600;color:#34C759;margin-top:5px;display:flex;align-items:center;gap:4px;text-transform:uppercase;letter-spacing:0.06em;"><i class="fa-solid fa-arrow-trend-up"></i>Vault Active</p>
        </a>

        <a href="{{ route('admin.students.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(0,122,255,0.10);display:flex;align-items:center;justify-content:center;color:#007AFF;"><i class="fa-solid fa-user-graduate" style="font-size:0.95rem;"></i></div>
                <span class="ios-badge">Students</span>
            </div>
            <div class="ios-stat-num">{{ $totalStudents ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:600;color:var(--accent);margin-top:5px;display:flex;align-items:center;gap:4px;text-transform:uppercase;letter-spacing:0.06em;"><span style="width:5px;height:5px;border-radius:50%;background:var(--accent);display:inline-block;"></span>Enrolled</p>
        </a>

        <a href="{{ route('admin.teachers.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(88,86,214,0.10);display:flex;align-items:center;justify-content:center;color:#5856D6;"><i class="fa-solid fa-chalkboard-user" style="font-size:0.95rem;"></i></div>
                <span class="ios-badge" style="background:rgba(88,86,214,0.10);color:#5856D6;">Teachers</span>
            </div>
            <div class="ios-stat-num">{{ $totalTeachers ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:600;color:#5856D6;margin-top:5px;display:flex;align-items:center;gap:4px;text-transform:uppercase;letter-spacing:0.06em;"><span style="width:5px;height:5px;border-radius:50%;background:#5856D6;display:inline-block;"></span>Active Staff</p>
        </a>

        <a href="{{ route('admin.courses.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(175,82,222,0.10);display:flex;align-items:center;justify-content:center;color:#AF52DE;"><i class="fa-solid fa-book-open" style="font-size:0.95rem;"></i></div>
                <span class="ios-badge" style="background:rgba(175,82,222,0.10);color:#AF52DE;">Courses</span>
            </div>
            <div class="ios-stat-num">{{ $totalCourses ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:600;color:#AF52DE;margin-top:5px;text-transform:uppercase;letter-spacing:0.06em;">Academic</p>
        </a>

        <a href="{{ route('admin.subjects.index') }}" class="ios-card" style="padding:20px;text-decoration:none;display:block;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;">
                <div style="width:38px;height:38px;border-radius:12px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;"><i class="fa-solid fa-layer-group" style="font-size:0.95rem;"></i></div>
                <span class="ios-badge">Subjects</span>
            </div>
            <div class="ios-stat-num">{{ $totalSubjects ?? 0 }}</div>
            <p style="font-size:0.65rem;font-weight:600;color:var(--accent);margin-top:5px;text-transform:uppercase;letter-spacing:0.06em;">Curriculum</p>
        </a>

    </div>

    {{-- ── MID: Quick Actions + System Directory ─────────── --}}
    <div id="admin-mid-grid" style="display:grid;grid-template-columns:1fr 2fr;gap:18px;margin-bottom:18px;">

        {{-- Quick Actions --}}
        <div style="border-radius:20px;overflow:hidden;background:linear-gradient(135deg,#1C1C1E,#2C2C2E,var(--accent));padding:24px;box-shadow:0 6px 24px var(--accent-glow);position:relative;">
            <div style="position:absolute;right:-20px;bottom:-20px;opacity:0.07;pointer-events:none;font-size:8rem;">⚡</div>
            <div style="position:relative;z-index:1;">
                <div style="width:42px;height:42px;border-radius:13px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;margin-bottom:14px;">
                    <i class="fa-solid fa-bolt" style="color:#fff;font-size:1rem;"></i>
                </div>
                <div style="font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:5px;">Quick Actions</div>
                <p style="font-size:0.75rem;color:rgba(255,255,255,0.7);line-height:1.5;margin-bottom:16px;">Direct access to core campus operations.</p>
                <div style="display:flex;flex-direction:column;gap:9px;">
                    <a href="{{ route('admin.students.create') }}" class="qa-btn"><span><i class="fa-solid fa-user-plus" style="margin-right:8px;"></i>Add New Student</span><i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
                    <a href="{{ route('admin.teachers.create') }}" class="qa-btn"><span><i class="fa-solid fa-chalkboard-user" style="margin-right:8px;"></i>Add New Teacher</span><i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
                    <a href="{{ route('admin.courses.create') }}" class="qa-btn"><span><i class="fa-solid fa-book-medical" style="margin-right:8px;"></i>Create Course</span><i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
                    <a href="{{ route('admin.notices.index') }}" class="qa-btn"><span><i class="fa-solid fa-bullhorn" style="margin-right:8px;"></i>Post Notice</span><i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
                </div>
            </div>
        </div>

        {{-- System Directory --}}
        <div class="ios-card" style="overflow:hidden;">
            <div style="padding:20px 22px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--divider);">
                <div>
                    <div class="sec-head">System Directory</div>
                    <div class="sec-sub">Institution management links</div>
                </div>
                <span style="font-size:0.62rem;font-weight:600;color:#34C759;background:rgba(52,199,89,0.10);padding:3px 10px;border-radius:100px;display:flex;align-items:center;gap:5px;">
                    <span style="width:5px;height:5px;border-radius:50%;background:#34C759;" class="animate-pulse"></span>System Active
                </span>
            </div>
            <div style="padding:18px;display:grid;grid-template-columns:repeat(2,1fr);gap:10px;">
                <a href="{{ route('admin.students.index') }}" class="dir-row"><div style="width:36px;height:36px;border-radius:10px;background:rgba(0,122,255,0.10);display:flex;align-items:center;justify-content:center;color:#007AFF;flex-shrink:0;"><i class="fa-solid fa-user-graduate" style="font-size:0.85rem;"></i></div><div><div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Manage Students</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">View & edit records</div></div></a>
                <a href="{{ route('admin.teachers.index') }}" class="dir-row"><div style="width:36px;height:36px;border-radius:10px;background:rgba(88,86,214,0.10);display:flex;align-items:center;justify-content:center;color:#5856D6;flex-shrink:0;"><i class="fa-solid fa-chalkboard-user" style="font-size:0.85rem;"></i></div><div><div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Manage Teachers</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Faculty profiles</div></div></a>
                <a href="{{ route('admin.courses.index') }}" class="dir-row"><div style="width:36px;height:36px;border-radius:10px;background:rgba(175,82,222,0.10);display:flex;align-items:center;justify-content:center;color:#AF52DE;flex-shrink:0;"><i class="fa-solid fa-book-open" style="font-size:0.85rem;"></i></div><div><div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Manage Courses</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Academic programs</div></div></a>
                <a href="{{ route('admin.subjects.index') }}" class="dir-row"><div style="width:36px;height:36px;border-radius:10px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;flex-shrink:0;"><i class="fa-solid fa-layer-group" style="font-size:0.85rem;"></i></div><div><div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Manage Subjects</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Course curriculum</div></div></a>
                <a href="{{ route('admin.fees.index') }}" class="dir-row"><div style="width:36px;height:36px;border-radius:10px;background:rgba(52,199,89,0.10);display:flex;align-items:center;justify-content:center;color:#34C759;flex-shrink:0;"><i class="fa-solid fa-file-invoice-dollar" style="font-size:0.85rem;"></i></div><div><div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Fee Management</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Collections & dues</div></div></a>
                <a href="{{ route('admin.notices.index') }}" class="dir-row"><div style="width:36px;height:36px;border-radius:10px;background:rgba(255,59,48,0.10);display:flex;align-items:center;justify-content:center;color:#FF3B30;flex-shrink:0;"><i class="fa-solid fa-bullhorn" style="font-size:0.85rem;"></i></div><div><div style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">Notice Board</div><div style="font-size:0.68rem;color:var(--text-muted);margin-top:1px;">Campus announcements</div></div></a>
            </div>
        </div>
    </div>

    {{-- ── BOTTOM: Chart + Payments ─────────────────────── --}}
    <div id="admin-bottom-grid" style="display:grid;grid-template-columns:2fr 1fr;gap:18px;">

        {{-- Revenue Chart --}}
        <div class="ios-card" style="overflow:hidden;">
            <div style="padding:20px 22px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--divider);">
                <div>
                    <div class="sec-head">Revenue Overview</div>
                    <div class="sec-sub">{{ date('Y') }} Monthly Collections</div>
                </div>
                <div style="width:36px;height:36px;border-radius:11px;background:rgba(52,199,89,0.10);display:flex;align-items:center;justify-content:center;color:#34C759;"><i class="fa-solid fa-chart-area" style="font-size:0.9rem;"></i></div>
            </div>
            <div style="padding:20px;height:300px;position:relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        {{-- Recent Payments --}}
        <div class="ios-card" style="overflow:hidden;">
            <div style="padding:20px 22px 16px;display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--divider);">
                <div>
                    <div class="sec-head">Recent Payments</div>
                    <div class="sec-sub">Latest fee transactions</div>
                </div>
                <div style="width:36px;height:36px;border-radius:11px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;"><i class="fa-solid fa-bolt" style="font-size:0.9rem;"></i></div>
            </div>
            <div>
                @forelse($recentPayments as $payment)
                    <div class="pay-row">
                        <div style="width:34px;height:34px;border-radius:10px;background:rgba(52,199,89,0.10);display:flex;align-items:center;justify-content:center;font-size:0.72rem;font-weight:700;color:#34C759;flex-shrink:0;">
                            {{ strtoupper(substr($payment->student->name ?? 'S', 0, 1)) }}
                        </div>
                        <div style="flex:1;min-width:0;">
                            <p style="font-size:0.82rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $payment->student->name ?? 'Unknown' }}</p>
                            <p style="font-size:0.65rem;color:var(--text-muted);margin-top:1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $payment->fee->title ?? 'General Fee' }}</p>
                        </div>
                        <div style="text-align:right;flex-shrink:0;">
                            <p style="font-size:0.82rem;font-weight:700;color:#34C759;">+₹{{ number_format($payment->amount_paid) }}</p>
                            <p style="font-size:0.6rem;color:var(--text-muted);margin-top:1px;">{{ $payment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <div style="padding:40px 24px;text-align:center;">
                        <div style="font-size:2rem;margin-bottom:8px;opacity:0.4;">🔎</div>
                        <p style="font-size:0.82rem;font-weight:600;color:var(--text-muted);">No recent activity.</p>
                    </div>
                @endforelse
            </div>
            @if(isset($recentPayments) && $recentPayments->count() > 0)
                <div style="padding:12px 20px;border-top:1px solid var(--divider);text-align:center;">
                    <a href="{{ route('admin.fees.index') }}" style="font-size:0.78rem;font-weight:600;color:var(--accent);text-decoration:none;">View All Transactions <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i></a>
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
            'admin-stat-grid':   { sm:'1fr 1fr', md:'repeat(3,1fr)', lg:'repeat(5,1fr)' },
            'admin-mid-grid':    { sm:'1fr',      md:'1fr',           lg:'1fr 2fr' },
            'admin-bottom-grid': { sm:'1fr',      md:'1fr',           lg:'2fr 1fr' }
        };
        const c = configs[id];
        function resize(){
            const w = window.innerWidth;
            g.style.gridTemplateColumns = w < 640 ? c.sm : (w < 1024 ? c.md : c.lg);
        }
        resize(); window.addEventListener('resize', resize);
    });

    // Revenue Chart
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('revenueChart');
        if(!canvas) return;
        const ctx = canvas.getContext('2d');
        const revenueData = @json($revenueChartData ?? array_fill(0, 12, 0));
        let grad = ctx.createLinearGradient(0, 0, 0, 280);
        grad.addColorStop(0, 'rgba(255,159,10,0.3)');
        grad.addColorStop(1, 'rgba(255,159,10,0.01)');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                datasets: [{
                    label: 'Revenue (₹)', data: revenueData,
                    borderColor: '#FF9F0A', backgroundColor: grad,
                    borderWidth: 2.5,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: '#FF9F0A',
                    pointBorderWidth: 2, pointRadius: 4, pointHoverRadius: 6,
                    fill: true, tension: 0.4
                }]
            },
            options: {
                responsive: true, maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1C1C1E',
                        padding: 12, titleFont: { size: 12, family: "'Inter',sans-serif" },
                        bodyFont: { size: 13, weight: '600', family: "'Inter',sans-serif" },
                        displayColors: false,
                        callbacks: { label: function(c) { return '₹ ' + c.parsed.y.toLocaleString(); } }
                    }
                },
                scales: {
                    x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: "'Inter',sans-serif", size: 11 }, color: 'rgba(60,60,67,0.45)' } },
                    y: {
                        grid: { color: 'rgba(0,0,0,0.04)', borderDash: [4,4], drawBorder: false },
                        ticks: { font: { family: "'Inter',sans-serif", size: 11 }, color: 'rgba(60,60,67,0.45)', callback: function(v) { return v >= 1000 ? '₹' + (v/1000) + 'k' : '₹' + v; } },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

@endsection