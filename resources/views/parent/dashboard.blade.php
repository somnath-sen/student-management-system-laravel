<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EdFlow | Parent Portal</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
    /* ══════════════════════════════════════════════════════
       iOS 18-INSPIRED PARENT PORTAL — EdFlow
       Accent: Emerald/Teal
    ══════════════════════════════════════════════════════ */
    :root {
        --bg:           #F2F2F7;
        --bg-2:         #FFFFFF;
        --bg-3:         #E5E5EA;
        --accent:       #0D9488;
        --accent-2:     #059669;
        --accent-glow:  rgba(13,148,136,0.25);
        --accent-soft:  rgba(13,148,136,0.10);
        --text-primary:   #1C1C1E;
        --text-secondary: #3A3A3C;
        --text-muted:     #8E8E93;
        --border:       rgba(60,60,67,0.12);
        --border-2:     rgba(60,60,67,0.06);
        --divider:      rgba(60,60,67,0.08);
        --shadow:       0 2px 16px rgba(0,0,0,0.07), 0 0 0 1px rgba(60,60,67,0.06);
        --shadow-lg:    0 8px 32px rgba(0,0,0,0.12), 0 0 0 1px rgba(60,60,67,0.07);
    }
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    html { height: 100%; }
    body { font-family: 'Inter', -apple-system, sans-serif; background: var(--bg); color: var(--text-primary); -webkit-font-smoothing: antialiased; min-height: 100vh; }
    ::-webkit-scrollbar { width: 4px; height: 4px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 6px; }

    /* ── iOS Card ── */
    .ios-card {
        background: var(--bg-2);
        border-radius: 20px;
        border: 1px solid var(--border);
        box-shadow: var(--shadow);
        transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), box-shadow 0.25s ease;
    }
    .ios-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }

    .ios-badge { font-size: 0.6rem; font-weight: 700; letter-spacing: 0.04em; padding: 3px 9px; border-radius: 100px; background: var(--accent-soft); color: var(--accent); text-transform: uppercase; }

    /* ── Header ── */
    .top-header {
        height: 64px; background: var(--bg-2); border-bottom: 1px solid var(--divider);
        display: flex; align-items: center; justify-content: space-between; padding: 0 24px;
        position: sticky; top: 0; z-index: 50;
        backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px);
    }
    .hdr-btn { display: flex; align-items: center; gap: 8px; padding: 8px 16px; border-radius: 100px; background: var(--bg-3); font-size: 0.82rem; font-weight: 600; border: none; cursor: pointer; transition: all 0.2s; color: var(--text-secondary); text-decoration: none; border: 1px solid var(--border); }
    .hdr-btn:hover { background: var(--border); }
    .hdr-btn.danger { color: #FF3B30; }

    /* ── Score row ── */
    .score-row { display: flex; justify-content: space-between; align-items: center; padding: 6px 10px; border-radius: 9px; transition: background 0.15s; }
    .score-row:hover { background: var(--border-2); }

    /* ── Bottom nav ── */
    .bottom-nav { background: var(--bg-2); border-top: 1px solid var(--divider); backdrop-filter: blur(20px); }
    .bottom-tab { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 8px 10px; border-radius: 12px; color: var(--text-muted); font-size: 0.58rem; font-weight: 600; cursor: pointer; transition: all 0.2s; border: none; background: none; text-decoration: none; }
    .bottom-tab.is-active { color: var(--accent); }
    .bottom-tab i { font-size: 1.15rem; }
    .drawer-panel { background: var(--bg-2); border-radius: 24px 24px 0 0; box-shadow: 0 -8px 32px rgba(0,0,0,0.15); }
    .drawer-row { display: flex; align-items: center; gap: 13px; padding: 12px 14px; border-radius: 14px; color: var(--text-secondary); font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: all 0.2s; background: var(--bg-3); margin-bottom: 8px; border: 1px solid var(--border); }
    .drawer-row:hover { color: var(--accent); border-color: var(--accent); background: var(--accent-soft); }
    .drawer-icon { width: 34px; height: 34px; border-radius: 10px; display: flex; align-items: center; justify-content: center; background: var(--accent-soft); font-size: 0.88rem; flex-shrink: 0; }

    /* ── SOS ── */
    @keyframes sosFlash { 0%,100%{opacity:1} 50%{opacity:.88} }
    .sos-banner { animation: sosFlash 1.5s ease-in-out infinite; }
    @keyframes fadeUp { to { opacity:1; transform:translateY(0); } }
    .fade-up { animation: fadeUp 0.55s cubic-bezier(0.16,1,0.3,1) forwards; opacity: 0; transform: translateY(16px); }
    </style>
</head>
<body x-data="{ moreOpen: false }">

<!-- ═══ HEADER ══════════════════════════════════════════════ -->
<header class="top-header">
    <div style="display:flex;align-items:center;gap:12px;">
        <div style="width:38px;height:38px;border-radius:12px;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 3px 10px var(--accent-glow);">
            <i class="fa-solid fa-graduation-cap" style="color:#fff;font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:0.95rem;font-weight:700;color:var(--text-primary);letter-spacing:-0.02em;line-height:1.1;">EdFlow</div>
            <div style="font-size:0.6rem;font-weight:600;color:var(--accent);text-transform:uppercase;letter-spacing:0.1em;">Parent Portal</div>
        </div>
    </div>

    <div style="display:flex;align-items:center;gap:10px;">
        <div style="padding:6px 13px;border-radius:100px;background:var(--bg-3);font-size:0.72rem;font-weight:600;color:var(--text-muted);border:1px solid var(--border);" class="hidden-mobile">
            <i class="fa-regular fa-calendar" style="margin-right:5px;color:var(--accent);"></i>{{ date('d M Y') }}
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="hdr-btn danger">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="hidden-mobile">Sign Out</span>
            </button>
        </form>
    </div>
</header>

<!-- ═══ SOS EMERGENCY BANNER ════════════════════════════════ -->
@php $anyPanicking = $childrenData->contains('is_panicking', true); @endphp
@if($anyPanicking)
<div class="sos-banner" style="background:linear-gradient(135deg,#FF3B30,#C0392B);padding:18px 24px;box-shadow:0 6px 28px rgba(255,59,48,0.5);">
    <div style="max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:16px;">
        <div style="display:flex;align-items:center;gap:14px;">
            <div style="width:52px;height:52px;border-radius:16px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <i class="fa-solid fa-triangle-exclamation" style="font-size:1.5rem;color:#fff;" class="animate-bounce"></i>
            </div>
            <div>
                <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.2em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:3px;">⚠ EMERGENCY S.O.S RECEIVED</p>
                @foreach($childrenData as $d)
                    @if($d['is_panicking'] && $d['panic_data'])
                        <h2 style="font-size:1.2rem;font-weight:800;color:#fff;">{{ $d['student']->user->name ?? 'Your child' }} has triggered a Panic Alert!</h2>
                        <p style="font-size:0.78rem;color:rgba(255,255,255,0.75);font-weight:600;margin-top:3px;"><i class="fa-regular fa-clock"></i> Triggered {{ $d['panic_data']['time_ago'] }} — {{ $d['panic_data']['triggered_at'] }}</p>
                    @endif
                @endforeach
            </div>
        </div>
        <div>
            @foreach($childrenData as $d)
                @if($d['is_panicking'] && $d['panic_data'] && $d['panic_data']['map_link'])
                    <a href="{{ $d['panic_data']['map_link'] }}" target="_blank" style="display:flex;align-items:center;gap:9px;padding:12px 22px;background:#fff;color:#FF3B30;font-weight:800;font-size:0.9rem;border-radius:100px;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.2);">
                        <i class="fa-solid fa-map-location-dot" style="font-size:1rem;"></i>Open Emergency Location
                    </a>
                @endif
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- ═══ MAIN CONTENT ════════════════════════════════════════ -->
<main style="padding-bottom:100px;">
<div style="max-width:1200px;margin:0 auto;padding:28px 20px;">

    {{-- Flash Messages --}}
    @if(session('error'))
        <div style="display:flex;align-items:center;gap:12px;padding:13px 16px;border-radius:14px;background:rgba(255,59,48,0.08);border:1px solid rgba(255,59,48,0.15);margin-bottom:18px;" class="fade-up">
            <i class="fa-solid fa-circle-exclamation" style="color:#FF3B30;font-size:1rem;"></i>
            <p style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">{{ session('error') }}</p>
        </div>
    @endif
    @if(session('success'))
        <div style="display:flex;align-items:center;gap:12px;padding:13px 16px;border-radius:14px;background:var(--accent-soft);border:1px solid rgba(13,148,136,0.2);margin-bottom:18px;" class="fade-up">
            <i class="fa-solid fa-circle-check" style="color:var(--accent);font-size:1rem;"></i>
            <p style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">{{ session('success') }}</p>
        </div>
    @endif

    {{-- ── HERO GREETING ─────────────────────────────────── --}}
    <div style="border-radius:24px;overflow:hidden;background:linear-gradient(135deg,var(--accent),var(--accent-2));padding:24px 26px;margin-bottom:22px;box-shadow:0 8px 32px var(--accent-glow);position:relative;" class="fade-up">
        <div style="position:absolute;top:-40px;right:-40px;width:180px;height:180px;border-radius:50%;background:rgba(255,255,255,0.10);pointer-events:none;"></div>
        <div style="position:relative;z-index:1;">
            <div style="font-size:0.68rem;font-weight:600;letter-spacing:0.08em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:6px;display:flex;align-items:center;gap:7px;">
                <i class="fa-solid fa-users" style="font-size:0.85rem;"></i>Family Overview
            </div>
            <h1 style="font-size:1.6rem;font-weight:800;color:#fff;letter-spacing:-0.03em;line-height:1.15;">
                Welcome back, {{ Auth::user()->name }} 👨‍👩‍👦
            </h1>
            <p style="font-size:0.82rem;color:rgba(255,255,255,0.8);margin-top:5px;line-height:1.5;">Monitor attendance, results, and real-time alerts across your connected student profiles.</p>
        </div>
    </div>

    {{-- ── CHILDREN CARDS ─────────────────────────────────── --}}
    @forelse($childrenData as $index => $data)
        @php
            $child = $data['student'];
            $delay = $index * 0.12;
            $attColor = match($data['attendance_status'] ?? '') {
                'green'  => ['color'=>'#34C759','label'=>'Good'],
                'yellow' => ['color'=>'#FF9F0A','label'=>'Warning'],
                'red'    => ['color'=>'#FF3B30','label'=>'Critical'],
                default  => ['color'=>'#8E8E93','label'=>'N/A'],
            };
            $feePercentage = $data['total_fees'] > 0 ? min(100, round(($data['total_paid'] / $data['total_fees']) * 100)) : 100;
            $feeColor = $feePercentage === 100 ? '#34C759' : '#FF9F0A';
            if($data['total_fees'] == 0 && $data['total_paid'] == 0) { $feePercentage = 0; $feeColor = '#8E8E93'; }
        @endphp

        <div class="ios-card" style="overflow:hidden;margin-bottom:20px;animation:fadeUp 0.55s ease-out forwards;animation-delay:{{ $delay }}s;opacity:0;transform:translateY(16px);">

            {{-- Child header --}}
            <div style="background:linear-gradient(135deg,#1C1C1E,#2C2C2E,#5856D6);padding:22px 24px;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:16px;position:relative;overflow:hidden;">
                <div style="position:absolute;right:-18px;bottom:-18px;opacity:0.06;pointer-events:none;font-size:8rem;">🎓</div>
                <div style="display:flex;align-items:center;gap:14px;position:relative;z-index:1;">
                    <div style="width:60px;height:60px;border-radius:18px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.22);display:flex;align-items:center;justify-content:center;font-size:1.65rem;font-weight:800;color:#fff;position:relative;flex-shrink:0;">
                        {{ strtoupper(substr($child->user->name ?? '?', 0, 1)) }}
                        <div style="position:absolute;bottom:-5px;right:-5px;width:18px;height:18px;background:#34C759;border-radius:50%;border:2px solid #2C2C2E;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-check" style="color:#fff;font-size:0.45rem;"></i>
                        </div>
                    </div>
                    <div>
                        <h2 style="font-size:1.3rem;font-weight:800;color:#fff;letter-spacing:-0.02em;">{{ $child->user->name ?? 'Student' }}</h2>
                        <div style="display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:5px;">
                            <span style="font-size:0.7rem;font-weight:600;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.12);padding:3px 10px;border-radius:100px;border:1px solid rgba(255,255,255,0.18);">{{ $child->course->name ?? 'No Course' }}</span>
                            <span style="font-size:0.62rem;font-weight:700;color:#A5B4FC;text-transform:uppercase;letter-spacing:0.1em;">Roll #{{ $child->roll_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:9px;align-items:flex-end;position:relative;z-index:1;">
                    @if($data['unread_broadcasts'] > 0)
                        <div style="display:inline-flex;align-items:center;gap:7px;padding:7px 13px;background:rgba(255,59,48,0.18);border:1px solid rgba(255,59,48,0.5);border-radius:100px;font-size:0.78rem;font-weight:700;color:#FCA5A5;">
                            <span style="width:7px;height:7px;border-radius:50%;background:#FF3B30;display:inline-block;" class="animate-pulse"></span>{{ $data['unread_broadcasts'] }} Unread Alerts
                        </div>
                    @else
                        <div style="display:inline-flex;align-items:center;gap:7px;padding:7px 12px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:100px;font-size:0.72rem;font-weight:600;color:rgba(255,255,255,0.55);">
                            <i class="fa-solid fa-bell-slash"></i>No New Alerts
                        </div>
                    @endif
                    @if($data['is_results_published'])
                        <a href="{{ route('parent.report-card.download', $child->id) }}" style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:linear-gradient(135deg,#FF9F0A,#FF6B00);border-radius:100px;font-size:0.8rem;font-weight:700;color:#fff;text-decoration:none;box-shadow:0 4px 14px rgba(255,159,10,0.4);">
                            <i class="fa-solid fa-file-pdf"></i>Download Report Card
                        </a>
                    @else
                        <div style="display:inline-flex;align-items:center;gap:7px;padding:9px 18px;background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:100px;font-size:0.78rem;font-weight:600;color:rgba(255,255,255,0.35);cursor:not-allowed;">
                            <i class="fa-solid fa-clock"></i>Report Card Not Published
                        </div>
                    @endif
                </div>
            </div>

            {{-- Analytics 4-grid --}}
            <div id="child-grid-{{ $index }}" style="display:grid;grid-template-columns:repeat(4,1fr);gap:14px;padding:18px;">

                {{-- 1. Attendance --}}
                <div class="ios-card" style="padding:20px;position:relative;overflow:hidden;">
                    <div style="position:absolute;right:-6px;top:-6px;opacity:0.05;font-size:4rem;pointer-events:none;">📅</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;position:relative;z-index:1;">
                        <div style="width:36px;height:36px;border-radius:11px;background:{{ $attColor['color'] }}18;display:flex;align-items:center;justify-content:center;color:{{ $attColor['color'] }};"><i class="fa-solid fa-calendar-check" style="font-size:0.85rem;"></i></div>
                        <span class="ios-badge" style="background:{{ $attColor['color'] }}18;color:{{ $attColor['color'] }};">{{ $attColor['label'] }}</span>
                    </div>
                    <div style="font-size:2.4rem;font-weight:800;letter-spacing:-0.04em;line-height:1;color:var(--text-primary);position:relative;z-index:1;">{{ $data['attendance_percentage'] }}<span style="font-size:1.2rem;color:var(--text-muted);font-weight:600;">%</span></div>
                    <p style="font-size:0.68rem;font-weight:500;color:var(--text-muted);margin-top:4px;position:relative;z-index:1;">Cumulative Presence</p>
                    <div style="height:4px;background:var(--border);border-radius:100px;overflow:hidden;margin-top:12px;position:relative;z-index:1;">
                        <div style="height:100%;background:{{ $attColor['color'] }};border-radius:100px;width:{{ $data['attendance_percentage'] }}%;transition:width 0.8s ease;"></div>
                    </div>
                </div>

                {{-- 2. Academics --}}
                <div class="ios-card" style="padding:20px;position:relative;overflow:hidden;">
                    <div style="position:absolute;right:-6px;top:-6px;opacity:0.05;font-size:4rem;pointer-events:none;">📊</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;position:relative;z-index:1;">
                        <div style="width:36px;height:36px;border-radius:11px;background:var(--accent-soft);display:flex;align-items:center;justify-content:center;color:var(--accent);"><i class="fa-solid fa-chart-pie" style="font-size:0.85rem;"></i></div>
                        <span class="ios-badge">Results</span>
                    </div>
                    <div style="font-size:2.4rem;font-weight:800;letter-spacing:-0.04em;line-height:1;color:var(--text-primary);position:relative;z-index:1;">{{ $data['overall_performance'] }}<span style="font-size:1.2rem;color:var(--text-muted);font-weight:600;">%</span></div>
                    <p style="font-size:0.68rem;font-weight:500;color:var(--text-muted);margin-top:4px;position:relative;z-index:1;">Aggregate Score</p>
                    <div style="margin-top:10px;max-height:100px;overflow-y:auto;position:relative;z-index:1;">
                        @forelse($data['subject_scores'] as $score)
                            <div class="score-row">
                                <span style="font-size:0.72rem;font-weight:600;color:var(--text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:60%;">{{ $score['name'] }}</span>
                                <span style="font-size:0.72rem;font-weight:700;color:{{ $score['percentage'] < 50 ? '#FF3B30' : 'var(--accent)' }};padding:2px 8px;border-radius:100px;background:{{ $score['percentage'] < 50 ? 'rgba(255,59,48,0.10)' : 'var(--accent-soft)' }};">{{ $score['percentage'] }}%</span>
                            </div>
                        @empty
                            <p style="font-size:0.72rem;color:var(--text-muted);font-style:italic;text-align:center;padding:8px;">No marks mapped yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- 3. Emergency / Live Tracker --}}
                @if($data['is_panicking'])
                    <div class="sos-banner" style="border-radius:18px;background:linear-gradient(135deg,#FF3B30,#C0392B);padding:20px;box-shadow:0 6px 24px rgba(255,59,48,0.5);position:relative;overflow:hidden;">
                        <div style="position:absolute;right:-8px;bottom:-8px;opacity:0.12;font-size:4.5rem;pointer-events:none;">🚨</div>
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;position:relative;z-index:1;">
                            <div style="width:36px;height:36px;border-radius:11px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-triangle-exclamation" style="color:#fff;font-size:0.9rem;" class="animate-bounce"></i></div>
                            <span style="font-size:0.6rem;font-weight:700;letter-spacing:0.04em;text-transform:uppercase;padding:3px 9px;border-radius:100px;background:rgba(255,255,255,0.2);color:#fff;">🚨 SOS ACTIVE</span>
                        </div>
                        <div style="position:relative;z-index:1;">
                            <div style="font-size:1rem;font-weight:800;color:#fff;margin-bottom:3px;">PANIC ALERT</div>
                            <p style="font-size:0.72rem;color:rgba(255,255,255,0.8);font-weight:600;">{{ $data['panic_data']['time_ago'] }}</p>
                            <p style="font-size:0.65rem;color:rgba(255,255,255,0.6);margin-bottom:11px;">{{ $data['panic_data']['triggered_at'] }}</p>
                            @if($data['panic_data']['map_link'])
                                <a href="{{ $data['panic_data']['map_link'] }}" target="_blank" style="display:block;width:100%;padding:10px;text-align:center;background:#fff;color:#FF3B30;font-weight:800;font-size:0.8rem;border-radius:12px;text-decoration:none;">
                                    <i class="fa-solid fa-map-location-dot"></i> Open Emergency Location
                                </a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="ios-card" style="padding:20px;position:relative;overflow:hidden;">
                        <div style="position:absolute;right:-6px;top:-6px;opacity:0.05;font-size:4rem;pointer-events:none;">📡</div>
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;position:relative;z-index:1;">
                            <div style="width:36px;height:36px;border-radius:11px;background:rgba(255,59,48,0.10);display:flex;align-items:center;justify-content:center;color:#FF3B30;"><i class="fa-solid fa-satellite-dish" style="font-size:0.85rem;"></i></div>
                            <span class="ios-badge" style="background:rgba(255,59,48,0.10);color:#FF3B30;">Live Tracker</span>
                        </div>
                        <div style="position:relative;z-index:1;">
                            @if($data['emergency_data'])
                                <div style="background:rgba(52,199,89,0.10);border:1px solid rgba(52,199,89,0.2);border-radius:12px;padding:10px;margin-bottom:11px;">
                                    <h3 style="font-size:0.82rem;font-weight:700;color:var(--text-primary);display:flex;align-items:center;gap:7px;">
                                        <span style="width:7px;height:7px;border-radius:50%;background:#34C759;" class="animate-pulse"></span>GPS Linked
                                    </h3>
                                    <p style="font-size:0.65rem;font-weight:600;color:var(--text-muted);margin-top:2px;">{{ $data['emergency_data']['updated_at'] }}</p>
                                </div>
                                <a href="{{ $data['emergency_data']['map_link'] }}" target="_blank" style="display:block;width:100%;padding:10px;text-align:center;border-radius:12px;font-weight:700;font-size:0.78rem;color:#fff;text-decoration:none;background:linear-gradient(135deg,#1C1C1E,#2C2C2E);">
                                    Track Live on Maps <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.7rem;"></i>
                                </a>
                            @else
                                <div style="background:var(--border-2);border:1px solid var(--border);border-radius:12px;padding:14px;text-align:center;margin-bottom:11px;">
                                    <div style="font-size:1.5rem;margin-bottom:5px;opacity:0.4;">📍</div>
                                    <p style="font-size:0.8rem;font-weight:700;color:var(--text-secondary);">Signal Offline</p>
                                    <p style="font-size:0.68rem;color:var(--text-muted);margin-top:2px;">Device has not pinged location.</p>
                                </div>
                                <div style="width:100%;padding:10px;text-align:center;border-radius:12px;font-weight:600;font-size:0.78rem;color:var(--text-muted);background:var(--border-2);border:1px solid var(--border);cursor:not-allowed;">Location Unavailable</div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- 4. Fees --}}
                <div class="ios-card" style="padding:20px;position:relative;overflow:hidden;">
                    <div style="position:absolute;right:-6px;top:-6px;opacity:0.05;font-size:4rem;pointer-events:none;">💰</div>
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;position:relative;z-index:1;">
                        <div style="width:36px;height:36px;border-radius:11px;background:rgba(255,159,10,0.12);display:flex;align-items:center;justify-content:center;color:#FF9F0A;"><i class="fa-solid fa-indian-rupee-sign" style="font-size:0.85rem;"></i></div>
                        <span class="ios-badge" style="background:rgba(255,159,10,0.12);color:#FF9F0A;">Fees</span>
                    </div>
                    <div style="font-size:1.5rem;font-weight:800;letter-spacing:-0.03em;line-height:1.15;color:var(--text-primary);position:relative;z-index:1;">₹{{ number_format($data['total_paid']) }}<span style="font-size:0.85rem;color:var(--text-muted);font-weight:500;"> / ₹{{ number_format($data['total_fees']) }}</span></div>
                    @if($data['total_due'] > 0)
                        <p style="font-size:0.72rem;font-weight:700;color:#FF3B30;margin-top:5px;position:relative;z-index:1;"><i class="fa-solid fa-circle-exclamation" style="margin-right:3px;"></i>Due: ₹{{ number_format($data['total_due']) }}</p>
                    @else
                        <p style="font-size:0.72rem;font-weight:700;color:#34C759;margin-top:5px;position:relative;z-index:1;"><i class="fa-solid fa-circle-check" style="margin-right:3px;"></i>Fully Paid</p>
                    @endif
                    <div style="height:4px;background:var(--border);border-radius:100px;overflow:hidden;margin-top:12px;position:relative;z-index:1;">
                        <div style="height:100%;background:{{ $feeColor }};border-radius:100px;width:{{ $feePercentage }}%;transition:width 0.8s ease;"></div>
                    </div>
                </div>

            </div>{{-- /child analytics grid --}}
        </div>{{-- /child card --}}

    @empty
        <div class="ios-card" style="padding:60px 40px;text-align:center;margin-bottom:20px;" class="fade-up">
            <div style="font-size:3rem;margin-bottom:14px;opacity:0.4;">👶</div>
            <h2 style="font-size:1.1rem;font-weight:700;color:var(--text-primary);margin-bottom:7px;">No Enrolled Children Found</h2>
            <p style="font-size:0.85rem;color:var(--text-muted);max-width:380px;margin:0 auto;line-height:1.6;">Your portal account does not currently have any student profiles linked. Contact school administration.</p>
            <button onclick="location.reload()" style="margin-top:18px;padding:10px 22px;border-radius:100px;background:var(--bg-3);font-weight:600;font-size:0.85rem;color:var(--text-secondary);border:1px solid var(--border);cursor:pointer;">Refresh Portal</button>
        </div>
    @endforelse

    {{-- ── TELEGRAM WIDGET ───────────────────────────────── --}}
    @php
        $parentUser             = auth()->user();
        $isParentTelegramLinked = $parentUser->hasTelegramConnected();
        $lastParentAlert        = $isParentTelegramLinked
            ? \App\Models\NotificationLog::where('recipient_id', $parentUser->id)->where('status', 'sent')->latest('sent_at')->first()
            : null;
    @endphp

    <div class="ios-card" style="overflow:hidden;margin-top:4px;" class="fade-up" style="animation-delay:0.3s;">
        {{-- Telegram header --}}
        <div style="padding:22px 24px;background:{{ $isParentTelegramLinked ? 'linear-gradient(135deg,#2AABEE,#229ED9)' : 'linear-gradient(135deg,#3A3A3C,#2C2C2E)' }};position:relative;overflow:hidden;">
            <div style="position:absolute;right:-12px;top:-12px;opacity:0.08;font-size:8rem;pointer-events:none;">✈️</div>
            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:16px;position:relative;z-index:1;">
                <div style="width:54px;height:54px;border-radius:16px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-brands fa-telegram" style="color:#fff;font-size:1.7rem;"></i>
                </div>
                <div style="flex:1;min-width:200px;">
                    <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-bottom:4px;">Instant Alerts</p>
                    <h2 style="font-size:1.2rem;font-weight:800;color:#fff;">Telegram Notifications</h2>
                    <p style="font-size:0.8rem;color:rgba(255,255,255,0.72);margin-top:4px;line-height:1.5;">
                        {{ $isParentTelegramLinked ? "Your account is connected. You'll receive instant alerts for attendance, results, fees, and emergency SOS." : 'Connect to receive real-time alerts about attendance, results, fees, and emergency SOS.' }}
                    </p>
                </div>
                @if($isParentTelegramLinked)
                    <span style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;background:rgba(255,255,255,0.15);border:1px solid rgba(255,255,255,0.25);border-radius:100px;font-size:0.8rem;font-weight:700;color:#fff;flex-shrink:0;">
                        <span style="width:8px;height:8px;border-radius:50%;background:#34C759;" class="animate-pulse"></span>Connected ✅
                    </span>
                @else
                    <span style="display:inline-flex;align-items:center;gap:7px;padding:9px 16px;background:rgba(255,255,255,0.10);border:1px solid rgba(255,255,255,0.18);border-radius:100px;font-size:0.8rem;font-weight:700;color:rgba(255,255,255,0.65);flex-shrink:0;">
                        <span style="width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,0.4);"></span>Not Connected
                    </span>
                @endif
            </div>
        </div>

        {{-- Telegram body --}}
        <div id="tg-body" style="display:grid;grid-template-columns:1fr 1fr;gap:22px;padding:22px 24px;">
            {{-- Alert types --}}
            <div>
                <p style="font-size:0.8rem;font-weight:700;color:var(--text-primary);margin-bottom:13px;display:flex;align-items:center;gap:8px;">
                    <i class="fa-solid fa-bell" style="color:{{ $isParentTelegramLinked ? '#2AABEE' : '#FF9F0A' }};"></i>
                    {{ $isParentTelegramLinked ? 'Active Alert Types' : 'You will receive alerts for:' }}
                </p>
                <div style="display:flex;flex-direction:column;gap:8px;">
                    @foreach([['📊','Attendance Marked','Every time attendance is recorded'],['⚠️','Low Attendance Warning','When attendance drops below 75%'],['🎉','Results Published','When exam results are released'],['💰','Fee Reminders','When fees are due or added'],['📢','Admin Notices','When admin posts a notice'],['🚨','Emergency SOS','Instant alert when panic button is triggered']] as [$icon,$title,$desc])
                        <div style="display:flex;align-items:center;gap:11px;padding:10px 12px;border-radius:13px;background:var(--border-2);border:1px solid var(--border);">
                            <span style="font-size:1rem;flex-shrink:0;">{{ $icon }}</span>
                            <div>
                                <p style="font-size:0.78rem;font-weight:600;color:var(--text-primary);">{{ $title }}</p>
                                @if($isParentTelegramLinked)<p style="font-size:0.65rem;color:var(--text-muted);margin-top:1px;">{{ $desc }}</p>@endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Status / Action panel --}}
            <div style="display:flex;flex-direction:column;gap:12px;">
                @if($isParentTelegramLinked)
                    @if($lastParentAlert)
                        <div style="padding:14px;border-radius:14px;background:var(--border-2);border:1px solid var(--border);">
                            <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.1em;text-transform:uppercase;color:#2AABEE;margin-bottom:4px;">Last Alert</p>
                            <p style="font-size:0.85rem;font-weight:600;color:var(--text-primary);">{{ $lastParentAlert->sent_at?->diffForHumans() }}</p>
                            <p style="font-size:0.65rem;color:var(--text-muted);margin-top:3px;">{{ \Illuminate\Support\Str::limit($lastParentAlert->message, 80) }}</p>
                        </div>
                    @endif
                    <div style="display:flex;align-items:flex-start;gap:11px;padding:14px;border-radius:14px;background:rgba(52,199,89,0.08);border:1px solid rgba(52,199,89,0.15);">
                        <i class="fa-solid fa-circle-check" style="color:#34C759;font-size:1rem;margin-top:2px;flex-shrink:0;"></i>
                        <div>
                            <p style="font-size:0.85rem;font-weight:700;color:var(--text-primary);">Telegram is Active</p>
                            <p style="font-size:0.7rem;color:var(--text-muted);margin-top:3px;">All notifications are being sent to your Telegram account.</p>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('parent.telegram.disconnect') }}">
                        @csrf
                        <button type="submit" onclick="return confirm('Disconnect Telegram? You will stop receiving notifications.')" style="width:100%;padding:12px;border-radius:14px;background:rgba(255,59,48,0.08);font-weight:700;font-size:0.82rem;color:#FF3B30;border:1px solid rgba(255,59,48,0.15);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;">
                            <i class="fa-solid fa-link-slash"></i>Disconnect Telegram
                        </button>
                    </form>
                @else
                    <div style="padding:14px;border-radius:14px;background:rgba(255,159,10,0.08);border:1px solid rgba(255,159,10,0.15);">
                        <p style="font-size:0.82rem;font-weight:700;color:#FF9F0A;display:flex;align-items:center;gap:7px;margin-bottom:5px;"><i class="fa-solid fa-triangle-exclamation"></i>Not Connected</p>
                        <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.55;">Connect your Telegram to receive real-time notifications on your phone, even when offline from EdFlow.</p>
                    </div>
                    <div style="padding:14px;border-radius:14px;background:var(--border-2);border:1px solid var(--border);">
                        <p style="font-size:0.8rem;font-weight:700;color:var(--text-primary);margin-bottom:9px;">How it works:</p>
                        @foreach(['Click "Connect Telegram" below','Telegram opens with our bot','Click "Start" in the bot','You\'re connected! ✅'] as $i => $step)
                            <p style="font-size:0.72rem;color:var(--text-muted);font-weight:600;margin-bottom:4px;">{{ $i+1 }}. {{ $step }}</p>
                        @endforeach
                    </div>
                    <a href="{{ route('parent.telegram.connect') }}" id="btn-parent-connect-telegram" style="display:flex;align-items:center;justify-content:center;gap:11px;padding:14px;border-radius:14px;font-weight:800;font-size:0.92rem;color:#fff;text-decoration:none;background:linear-gradient(135deg,#2AABEE,#229ED9);box-shadow:0 5px 18px rgba(42,171,238,0.4);">
                        <i class="fa-brands fa-telegram" style="font-size:1.2rem;"></i>Connect Parent Telegram
                    </a>
                    <p style="font-size:0.62rem;text-align:center;color:var(--text-muted);font-weight:500;">No phone number required. Works with Telegram account only.</p>
                @endif
            </div>
        </div>
    </div>

</div>{{-- /max-width --}}

{{-- Auto-refresh if panic --}}
@if($anyPanicking ?? false)
    <script>setTimeout(() => window.location.reload(), 10000);</script>
@endif

{{-- ── SUPPORT SECTION ──────────────────────────────────────────── --}}
<div style="max-width:1200px;margin:0 auto;padding:0 20px 28px;" class="fade-up">
    <div class="ios-card" style="overflow:hidden;">
        <div style="background:linear-gradient(135deg,#5856D6,#007AFF);padding:22px 26px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;">
            <div style="display:flex;align-items:center;gap:14px;">
                <div style="width:48px;height:48px;border-radius:16px;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.3rem;flex-shrink:0;">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h3 style="font-size:1.05rem;font-weight:800;color:#fff;letter-spacing:-0.025em;">Support Center</h3>
                    <p style="font-size:0.78rem;color:rgba(255,255,255,0.8);margin-top:2px;">Have a question? Our team is here to help</p>
                </div>
            </div>
            <button onclick="openSupportModal()" style="display:flex;align-items:center;gap:9px;padding:11px 22px;border-radius:14px;background:rgba(255,255,255,0.22);color:#fff;font-size:0.85rem;font-weight:700;border:1.5px solid rgba(255,255,255,0.3);cursor:pointer;transition:all 0.2s;backdrop-filter:blur(10px);" onmouseover="this.style.background='rgba(255,255,255,0.35)'" onmouseout="this.style.background='rgba(255,255,255,0.22)'">
                <i class="fa-solid fa-circle-question"></i>
                Ask a Doubt
            </button>
        </div>
        <div style="padding:20px 26px;">
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:12px;">
                <div style="background:#F2F2F7;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(0,122,255,0.1);display:flex;align-items:center;justify-content:center;color:#007AFF;font-size:0.9rem;flex-shrink:0;"><i class="fa-solid fa-bolt"></i></div>
                    <div><p style="font-size:0.72rem;font-weight:700;color:#1C1C1E;">Fast Response</p><p style="font-size:0.65rem;color:#8E8E93;">Usually within 24h</p></div>
                </div>
                <div style="background:#F2F2F7;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(52,199,89,0.1);display:flex;align-items:center;justify-content:center;color:#34C759;font-size:0.9rem;flex-shrink:0;"><i class="fa-solid fa-envelope"></i></div>
                    <div><p style="font-size:0.72rem;font-weight:700;color:#1C1C1E;">Email Reply</p><p style="font-size:0.65rem;color:#8E8E93;">Get notified by email</p></div>
                </div>
                <div style="background:#F2F2F7;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;">
                    <div style="width:36px;height:36px;border-radius:10px;background:rgba(88,86,214,0.1);display:flex;align-items:center;justify-content:center;color:#5856D6;font-size:0.9rem;flex-shrink:0;"><i class="fa-solid fa-chart-gantt"></i></div>
                    <div><p style="font-size:0.72rem;font-weight:700;color:#1C1C1E;">Track Progress</p><p style="font-size:0.65rem;color:#8E8E93;">Live status updates</p></div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>

<!-- ═══ MOBILE BOTTOM NAV ════════════════════════════════════ -->
<div style="display:none;" id="mobile-nav" class="lg:hidden">
    <div class="bottom-nav" style="position:fixed;bottom:0;left:0;right:0;z-index:60;">
        <div style="display:flex;justify-content:space-around;align-items:center;padding:8px 12px;max-width:480px;margin:0 auto;">
            <a href="#" class="bottom-tab is-active"><i class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
            <a href="#" class="bottom-tab"><i class="fa-solid fa-calendar-check"></i><span>Attendance</span></a>
            <a href="#" class="bottom-tab"><i class="fa-solid fa-chart-line"></i><span>Marks</span></a>
            <a href="#" class="bottom-tab" style="position:relative;">
                <i class="fa-solid fa-bell"></i>
                @if($childrenData->contains('unread_broadcasts', '>', 0))<span style="position:absolute;top:8px;right:14px;width:7px;height:7px;border-radius:50%;background:#FF3B30;" class="animate-pulse"></span>@endif
                <span>Alerts</span>
            </a>
            <button type="button" @click="moreOpen = true" class="bottom-tab"><i class="fa-solid fa-grid-2"></i><span>More</span></button>
        </div>
    </div>
</div>

{{-- More Drawer --}}
<div x-show="moreOpen" style="display:none;"
     x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     @click="moreOpen = false"
     style="position:fixed;inset:0;background:rgba(0,0,0,0.4);backdrop-filter:blur(4px);z-index:70;"></div>

<div x-show="moreOpen" style="display:none;"
     x-transition:enter="transition transform ease-out duration-350" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
     x-transition:leave="transition transform ease-in duration-250" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
     class="drawer-panel" style="position:fixed;bottom:0;left:0;right:0;z-index:80;max-height:88vh;display:flex;flex-direction:column;">
    <div style="padding:14px 20px 10px;border-bottom:1px solid var(--divider);display:flex;justify-content:space-between;align-items:center;">
        <div style="position:absolute;left:50%;top:10px;transform:translateX(-50%);width:32px;height:4px;border-radius:4px;background:var(--border);"></div>
        <span style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-top:8px;">More Options</span>
        <button @click="moreOpen = false" style="width:30px;height:30px;border-radius:9px;background:var(--bg-3);border:1px solid var(--border);cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);margin-top:8px;"><i class="fa-solid fa-xmark" style="font-size:0.85rem;"></i></button>
    </div>
    <div style="overflow-y:auto;flex:1;padding:14px 14px 24px;">
        <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-muted);padding:4px 4px 9px;">Academics</p>
        <a href="#" class="drawer-row"><span class="drawer-icon" style="color:#5856D6;"><i class="fa-solid fa-arrow-trend-up"></i></span>Performance Analytics</a>
        <a href="#" class="drawer-row"><span class="drawer-icon" style="color:#007AFF;"><i class="fa-solid fa-calendar-days"></i></span>Exam Schedule</a>
        @php $publishedChild = $childrenData->first(fn($d) => $d['is_results_published'] ?? false); @endphp
        @if($publishedChild)
            <a href="{{ route('parent.report-card.download', $publishedChild['student']->id) }}" class="drawer-row" style="color:#FF9F0A;"><span class="drawer-icon" style="color:#FF9F0A;"><i class="fa-solid fa-file-pdf"></i></span><span style="flex:1;">Download Report Card</span><span style="font-size:0.55rem;font-weight:700;color:#FF9F0A;padding:2px 6px;border-radius:100px;background:rgba(255,159,10,0.12);">PDF</span></a>
        @else
            <div class="drawer-row" style="opacity:0.45;cursor:not-allowed;"><span class="drawer-icon"><i class="fa-solid fa-file-pdf"></i></span><span style="flex:1;">Report Card</span><span style="font-size:0.55rem;font-weight:600;color:var(--text-muted);padding:2px 6px;border-radius:100px;background:var(--border-2);">Not Yet</span></div>
        @endif
        <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 9px;">Security</p>
        <a href="#" class="drawer-row"><span class="drawer-icon" style="color:#FF3B30;"><i class="fa-solid fa-triangle-exclamation"></i></span>Emergency Alerts</a>
        <a href="#" class="drawer-row"><span class="drawer-icon" style="color:var(--text-secondary);"><i class="fa-solid fa-gear"></i></span>Settings</a>
        <p style="font-size:0.6rem;font-weight:700;letter-spacing:0.12em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 9px;">Help</p>
        <a href="{{ route('parent.support.index') }}" class="drawer-row" style="text-decoration:none;">
            <span class="drawer-icon" style="color:#5856D6;"><i class="fa-solid fa-circle-question"></i></span>
            <span style="flex:1;">Support &amp; Doubts</span>
            <span style="font-size:0.55rem;font-weight:700;padding:2px 7px;border-radius:100px;background:rgba(88,86,214,0.1);color:#5856D6;">Help</span>
        </a>
        <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
            @csrf
            <button type="submit" style="width:100%;padding:13px;border-radius:14px;background:rgba(255,59,48,0.08);font-weight:700;font-size:0.85rem;color:#FF3B30;border:1px solid rgba(255,59,48,0.15);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>Sign Out
            </button>
        </form>
    </div>
</div>

<script>
// Responsive child analytics grids
document.querySelectorAll('[id^="child-grid-"]').forEach(g => {
    function resize(){
        const w = window.innerWidth;
        g.style.gridTemplateColumns = w < 640 ? '1fr 1fr' : (w < 1024 ? '1fr 1fr' : 'repeat(4,1fr)');
    }
    resize(); window.addEventListener('resize', resize);
});

// Responsive tg body
const tgBody = document.getElementById('tg-body');
if(tgBody){
    function resizeTg(){
        tgBody.style.gridTemplateColumns = window.innerWidth < 768 ? '1fr' : '1fr 1fr';
    }
    resizeTg(); window.addEventListener('resize', resizeTg);
}

// Show mobile nav
const mn = document.getElementById('mobile-nav');
if(mn){ if(window.innerWidth < 1024) mn.style.display='block'; window.addEventListener('resize',()=>{ mn.style.display = window.innerWidth<1024?'block':'none'; }); }
</script>
<x-support-modal />
</body>
</html>
