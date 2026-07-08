<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>EdFlow | Parent Dashboard</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ═══════════════════════════════════════════════
           PREMIUM NEUMORPHISM — PARENT PORTAL
           Accent: Emerald/Teal — Family & Trust
        ═══════════════════════════════════════════════ */
        :root {
            --bg:       #dde3ee;
            --bg-light: #eef1f7;
            --bg-dark:  #cdd3e0;
            --sh-dark:  #b8bece;
            --sh-light: #ffffff;
            --accent:        #0d9488;
            --accent-2:      #059669;
            --accent-glow:   rgba(13,148,136,0.28);
            --accent-soft:   rgba(13,148,136,0.09);
            --text-primary:   #1e2340;
            --text-secondary: #5a6284;
            --text-muted:     #8c94b0;
            --r-sm:12px;--r-md:18px;--r-lg:24px;--r-xl:28px;
        }
        *,*::before,*::after{box-sizing:border-box;margin:0;}
        html{height:100%;}
        body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text-primary);-webkit-font-smoothing:antialiased;min-height:100vh;}
        ::-webkit-scrollbar{width:4px;height:4px;}
        ::-webkit-scrollbar-track{background:transparent;}
        ::-webkit-scrollbar-thumb{background:var(--sh-dark);border-radius:6px;}

        /* ── Core utilities ── */
        .nm { background:var(--bg);border-radius:22px;box-shadow:8px 8px 20px var(--sh-dark),-8px -8px 20px var(--sh-light); }
        .nm-sm { background:var(--bg);border-radius:16px;box-shadow:5px 5px 13px var(--sh-dark),-5px -5px 13px var(--sh-light); }
        .nm-inset { background:var(--bg-dark);border-radius:14px;box-shadow:inset 4px 4px 10px var(--sh-dark),inset -4px -4px 10px var(--sh-light); }
        .nm-hover { transition:box-shadow 0.28s ease,transform 0.28s ease; }
        .nm-hover:hover { box-shadow:12px 12px 28px var(--sh-dark),-12px -12px 28px var(--sh-light);transform:translateY(-3px); }
        .icon-box { background:var(--bg);border-radius:14px;box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);display:flex;align-items:center;justify-content:center;flex-shrink:0; }
        .pill-nm { font-size:0.6rem;font-weight:900;letter-spacing:0.1em;text-transform:uppercase;padding:4px 11px;border-radius:9px;background:var(--bg);box-shadow:2px 2px 6px var(--sh-dark),-2px -2px 6px var(--sh-light); }
        .grad-text { background:linear-gradient(135deg,var(--accent),var(--accent-2));-webkit-background-clip:text;-webkit-text-fill-color:transparent; }
        .track { background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -2px -2px 6px var(--sh-light);border-radius:100px;overflow:hidden; }

        /* ── Header ── */
        .top-header { height:72px;background:var(--bg);box-shadow:0 4px 18px rgba(0,0,0,0.08);border-bottom:1px solid rgba(255,255,255,0.55);display:flex;align-items:center;justify-content:space-between;padding:0 28px;position:sticky;top:0;z-index:50; }
        .hdr-btn { display:flex;align-items:center;gap:8px;padding:9px 18px;border-radius:13px;background:var(--bg);box-shadow:4px 4px 9px var(--sh-dark),-4px -4px 9px var(--sh-light);font-size:0.82rem;font-weight:700;border:none;cursor:pointer;transition:all 0.2s;color:var(--text-secondary);text-decoration:none; }
        .hdr-btn:hover { box-shadow:6px 6px 14px var(--sh-dark),-6px -6px 14px var(--sh-light); }
        .hdr-btn.danger { color:#ef4444; }

        /* ── SOS Banner ── */
        @keyframes sosFlash{0%,100%{opacity:1}50%{opacity:.88}}
        .sos-banner{animation:sosFlash 1.5s ease-in-out infinite;}
        @keyframes fadeUp{to{opacity:1;transform:translateY(0);}}
        .fade-up{animation:fadeUp 0.6s cubic-bezier(0.16,1,0.3,1) forwards;opacity:0;transform:translateY(20px);}

        /* ── Analytic card ── */
        .ana-card { background:var(--bg);border-radius:22px;box-shadow:7px 7px 18px var(--sh-dark),-7px -7px 18px var(--sh-light);padding:26px;position:relative;overflow:hidden; transition:all 0.28s ease; }
        .ana-card:hover { box-shadow:11px 11px 26px var(--sh-dark),-11px -11px 26px var(--sh-light);transform:translateY(-3px); }

        /* ── Subject score row ── */
        .score-row { display:flex;justify-content:space-between;align-items:center;padding:7px 10px;border-radius:11px;transition:background 0.15s; }
        .score-row:hover { background:rgba(255,255,255,0.55); }

        /* ── Telegram section ── */
        .tg-alert-row { display:flex;align-items:flex-start;gap:12px;padding:10px 12px;border-radius:13px;background:var(--bg);box-shadow:3px 3px 8px var(--sh-dark),-3px -3px 8px var(--sh-light);margin-bottom:8px; }

        /* ── Mobile bottom nav ── */
        .bottom-nav { background:var(--bg);box-shadow:0 -6px 24px rgba(0,0,0,0.09);border-top:1px solid rgba(255,255,255,0.55); }
        .bottom-tab { display:flex;flex-direction:column;align-items:center;gap:3px;padding:9px 8px;border-radius:14px;color:var(--text-muted);font-size:0.58rem;font-weight:700;cursor:pointer;transition:all 0.2s;border:none;background:none;text-decoration:none; }
        .bottom-tab.is-active { color:var(--accent); }
        .bottom-tab i { font-size:1.15rem; }
        .side-drawer { background:var(--bg);border-radius:28px 28px 0 0;box-shadow:0 -12px 36px rgba(0,0,0,0.12); }
        .drawer-row { display:flex;align-items:center;gap:13px;padding:12px 14px;border-radius:14px;color:var(--text-secondary);font-weight:700;font-size:0.85rem;text-decoration:none;transition:all 0.2s;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);margin-bottom:8px; }
        .drawer-row:hover { color:var(--accent);box-shadow:6px 6px 14px var(--sh-dark),-6px -6px 14px var(--sh-light); }
        .drawer-icon { width:36px;height:36px;border-radius:11px;display:flex;align-items:center;justify-content:center;background:var(--bg);box-shadow:inset 2px 2px 6px var(--sh-dark),inset -2px -2px 6px var(--sh-light);font-size:0.88rem;flex-shrink:0; }
    </style>
</head>
<body x-data="{ moreOpen: false }">

<!-- ═══ HEADER ═══════════════════════════════════════════ -->
<header class="top-header">
    <div style="display:flex;align-items:center;gap:13px;">
        <div style="width:40px;height:40px;border-radius:13px;background:linear-gradient(135deg,var(--accent),var(--accent-2));box-shadow:4px 4px 12px rgba(13,148,136,0.45),-3px -3px 8px rgba(255,255,255,0.8);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
            <i class="fa-solid fa-graduation-cap" style="color:#fff;font-size:1rem;"></i>
        </div>
        <div>
            <div style="font-size:1rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.025em;line-height:1.1;">EdFlow</div>
            <div style="font-size:0.6rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.14em;">Parent Portal</div>
        </div>
    </div>

    <div style="display:flex;align-items:center;gap:12px;">
        <!-- Role chip -->
        <div class="hidden sm:block" style="padding:7px 15px;border-radius:12px;background:var(--bg);box-shadow:4px 4px 9px var(--sh-dark),-4px -4px 9px var(--sh-light);font-size:0.72rem;font-weight:800;color:var(--text-muted);">
            Role: <span style="color:var(--accent);">Parent</span>
        </div>
        <!-- Date -->
        <div class="hidden md:flex" style="align-items:center;gap:7px;padding:7px 15px;border-radius:12px;background:var(--bg);box-shadow:4px 4px 9px var(--sh-dark),-4px -4px 9px var(--sh-light);font-size:0.72rem;font-weight:700;color:var(--text-secondary);">
            <i class="fa-regular fa-calendar" style="color:var(--accent);"></i>{{ date('d M Y') }}
        </div>
        <!-- Sign Out -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="hdr-btn danger">
                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                <span class="hidden sm:inline">Sign Out</span>
            </button>
        </form>
    </div>
</header>

<!-- ═══ CONTENT ══════════════════════════════════════════ -->
<main style="padding-bottom:120px;">

    {{-- ── SOS Emergency Banner ── --}}
    @php $anyPanicking = $childrenData->contains('is_panicking', true); @endphp
    @if($anyPanicking)
    <div class="sos-banner" style="background:linear-gradient(135deg,#dc2626,#991b1b);border-bottom:4px solid #7f1d1d;padding:20px 28px;box-shadow:0 8px 36px rgba(220,38,38,0.55);">
        <div style="max-width:1200px;margin:0 auto;display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:18px;">
            <div style="display:flex;align-items:flex-start;gap:16px;">
                <div style="width:58px;height:58px;border-radius:16px;background:rgba(255,255,255,0.15);border:2px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i class="fa-solid fa-triangle-exclamation" style="font-size:1.7rem;color:#fff;" class="animate-bounce"></i>
                </div>
                <div>
                    <p style="font-size:0.6rem;font-weight:900;letter-spacing:0.3em;text-transform:uppercase;color:rgba(255,255,255,0.75);margin-bottom:4px;">⚠ EMERGENCY S.O.S SIGNAL RECEIVED</p>
                    @foreach($childrenData as $d)
                        @if($d['is_panicking'] && $d['panic_data'])
                            <h2 style="font-size:1.4rem;font-weight:900;color:#fff;line-height:1.2;">{{ $d['student']->user->name ?? 'Your child' }} has triggered a Panic Alert!</h2>
                            <p style="font-size:0.82rem;color:rgba(255,255,255,0.75);font-weight:700;margin-top:4px;"><i class="fa-regular fa-clock"></i> Triggered {{ $d['panic_data']['time_ago'] }} — {{ $d['panic_data']['triggered_at'] }}</p>
                        @endif
                    @endforeach
                </div>
            </div>
            <div style="display:flex;flex-direction:column;gap:10px;">
                @foreach($childrenData as $d)
                    @if($d['is_panicking'] && $d['panic_data'] && $d['panic_data']['map_link'])
                        <a href="{{ $d['panic_data']['map_link'] }}" target="_blank" style="display:flex;align-items:center;justify-content:center;gap:10px;padding:14px 26px;background:#fff;color:#dc2626;font-weight:900;font-size:0.95rem;border-radius:16px;text-decoration:none;box-shadow:0 8px 24px rgba(0,0,0,0.2);transition:all 0.2s;border:2px solid #fff;">
                            <i class="fa-solid fa-map-location-dot" style="font-size:1.15rem;"></i>
                            Open Emergency Location in Maps
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                    @endif
                @endforeach
                <p style="font-size:0.62rem;color:rgba(255,255,255,0.65);font-weight:700;text-align:center;">Live GPS coordinates are embedded in this link.</p>
            </div>
        </div>
    </div>
    @endif

    <div style="max-width:1200px;margin:0 auto;padding:36px 24px;">

        {{-- Flash messages --}}
        @if(session('error'))
            <div style="display:flex;align-items:center;gap:12px;padding:14px 18px;border-radius:14px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);border-left:4px solid #f43f5e;margin-bottom:20px;" class="fade-up">
                <i class="fa-solid fa-circle-exclamation" style="color:#f43f5e;font-size:1rem;"></i>
                <p style="font-size:0.85rem;font-weight:700;color:var(--text-primary);">{{ session('error') }}</p>
            </div>
        @endif
        @if(session('success'))
            <div style="display:flex;align-items:center;gap:12px;padding:14px 18px;border-radius:14px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);border-left:4px solid var(--accent);margin-bottom:20px;" class="fade-up">
                <i class="fa-solid fa-circle-check" style="color:var(--accent);font-size:1rem;"></i>
                <p style="font-size:0.85rem;font-weight:700;color:var(--text-primary);">{{ session('success') }}</p>
            </div>
        @endif

        {{-- Welcome Header --}}
        <header style="margin-bottom:36px;" class="fade-up">
            <div style="display:flex;align-items:center;gap:8px;margin-bottom:8px;">
                <i class="fa-solid fa-users" style="color:var(--accent);font-size:0.85rem;"></i>
                <span style="font-size:0.65rem;font-weight:800;letter-spacing:0.18em;text-transform:uppercase;color:var(--text-muted);">Family Overview</span>
            </div>
            <h1 style="font-size:2.2rem;font-weight:900;color:var(--text-primary);letter-spacing:-0.03em;line-height:1.1;">
                Welcome back,<br><span class="grad-text">{{ Auth::user()->name }}</span> 👨‍👩‍👦
            </h1>
            <p style="color:var(--text-muted);font-size:0.9rem;font-weight:500;margin-top:8px;max-width:560px;line-height:1.6;">Monitor attendance, results, and real-time alerts across your connected student profiles.</p>
        </header>

        {{-- Children Cards --}}
        @forelse($childrenData as $index => $data)
            @php
                $child = $data['student'];
                $delay = $index * 0.15;
                $attColor = match($data['attendance_status'] ?? '') {
                    'green'  => ['color'=>'#22c55e','label'=>'Good'],
                    'yellow' => ['color'=>'#f59e0b','label'=>'Warning'],
                    'red'    => ['color'=>'#ef4444','label'=>'Critical'],
                    default  => ['color'=>'#8c94b0','label'=>'N/A'],
                };
            @endphp

            <div class="nm" style="overflow:hidden;margin-bottom:28px;animation:fadeUp 0.6s ease-out forwards;animation-delay:{{ $delay }}s;opacity:0;transform:translateY(20px);">

                {{-- Student Header --}}
                <div style="background:linear-gradient(135deg,#1e1b4b,#312e81,#4338ca);padding:26px 28px;display:flex;flex-wrap:wrap;justify-content:space-between;align-items:center;gap:18px;position:relative;overflow:hidden;">
                    <div style="position:absolute;right:-20px;bottom:-20px;opacity:0.08;pointer-events:none;"><i class="fa-solid fa-graduation-cap" style="font-size:9rem;color:#fff;display:block;"></i></div>
                    <div style="display:flex;align-items:center;gap:16px;position:relative;z-index:1;">
                        <div style="width:66px;height:66px;border-radius:20px;background:rgba(255,255,255,0.12);border:1.5px solid rgba(255,255,255,0.25);display:flex;align-items:center;justify-content:center;font-size:1.8rem;font-weight:900;color:#fff;position:relative;flex-shrink:0;">
                            {{ strtoupper(substr($child->user->name ?? '?', 0, 1)) }}
                            <div style="position:absolute;bottom:-6px;right:-6px;width:20px;height:20px;background:#22c55e;border-radius:50%;border:2.5px solid #312e81;display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-check" style="color:#fff;font-size:0.5rem;"></i>
                            </div>
                        </div>
                        <div>
                            <h2 style="font-size:1.5rem;font-weight:900;color:#fff;letter-spacing:-0.02em;">{{ $child->user->name ?? 'Student' }}</h2>
                            <div style="display:flex;flex-wrap:wrap;align-items:center;gap:10px;margin-top:6px;">
                                <span style="font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.8);background:rgba(255,255,255,0.12);padding:4px 12px;border-radius:9px;border:1px solid rgba(255,255,255,0.2);">{{ $child->course->name ?? 'No Course' }}</span>
                                <span style="font-size:0.65rem;font-weight:900;color:#a5f3fc;text-transform:uppercase;letter-spacing:0.14em;">Roll #{{ $child->roll_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div style="display:flex;flex-direction:column;gap:10px;align-items:flex-end;position:relative;z-index:1;">
                        @if($data['unread_broadcasts'] > 0)
                            <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 16px;background:rgba(239,68,68,0.18);border:1.5px solid rgba(239,68,68,0.6);border-radius:12px;font-size:0.8rem;font-weight:900;color:#fca5a5;">
                                <span style="width:8px;height:8px;border-radius:50%;background:#ef4444;display:inline-block;box-shadow:0 0 8px #ef4444;" class="animate-pulse"></span>
                                {{ $data['unread_broadcasts'] }} Unread Alerts
                            </div>
                        @else
                            <div style="display:inline-flex;align-items:center;gap:8px;padding:8px 14px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.18);border-radius:12px;font-size:0.72rem;font-weight:700;color:rgba(255,255,255,0.55);">
                                <i class="fa-solid fa-bell-slash"></i> No New Alerts
                            </div>
                        @endif

                        @if($data['is_results_published'])
                            <a href="{{ route('parent.report-card.download', $child->id) }}" style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:13px;font-size:0.82rem;font-weight:900;color:#fff;text-decoration:none;box-shadow:0 6px 20px rgba(245,158,11,0.4);transition:all 0.22s;">
                                <i class="fa-solid fa-file-pdf"></i> Download Report Card
                            </a>
                        @else
                            <div style="display:inline-flex;align-items:center;gap:8px;padding:10px 20px;background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.14);border-radius:13px;font-size:0.78rem;font-weight:700;color:rgba(255,255,255,0.38);cursor:not-allowed;">
                                <i class="fa-solid fa-clock"></i> Report Card Not Published
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Analytics Grid --}}
                <div id="child-grid-{{ $index }}" style="display:grid;grid-template-columns:repeat(4,1fr);gap:18px;padding:22px;">

                    {{-- 1. Attendance --}}
                    <div class="ana-card">
                        <div style="position:absolute;right:-6px;top:-6px;opacity:0.06;"><i class="fa-solid fa-calendar-check" style="font-size:4.5rem;color:var(--text-primary);display:block;"></i></div>
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;position:relative;z-index:1;">
                            <div class="icon-box" style="width:46px;height:46px;color:{{ $attColor['color'] }};"><i class="fa-solid fa-calendar-check" style="font-size:1.1rem;"></i></div>
                            <span class="pill-nm" style="color:{{ $attColor['color'] }};">{{ $attColor['label'] }}</span>
                        </div>
                        <div style="font-size:3rem;font-weight:900;color:var(--text-primary);line-height:1;position:relative;z-index:1;">{{ $data['attendance_percentage'] }}<span style="font-size:1.6rem;color:var(--text-muted);font-weight:700;">%</span></div>
                        <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:5px;text-transform:uppercase;letter-spacing:0.08em;position:relative;z-index:1;">Cumulative Presence</p>
                        <div class="track" style="height:8px;margin-top:14px;position:relative;z-index:1;">
                            <div style="height:100%;background:{{ $attColor['color'] }};border-radius:100px;width:{{ $data['attendance_percentage'] }}%;box-shadow:0 2px 8px {{ $attColor['color'] }}55;transition:width 0.6s ease;"></div>
                        </div>
                    </div>

                    {{-- 2. Academics --}}
                    <div class="ana-card">
                        <div style="position:absolute;right:-6px;top:-6px;opacity:0.06;"><i class="fa-solid fa-chart-pie" style="font-size:4.5rem;color:var(--text-primary);display:block;"></i></div>
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;position:relative;z-index:1;">
                            <div class="icon-box" style="width:46px;height:46px;color:var(--accent);"><i class="fa-solid fa-chart-pie" style="font-size:1.1rem;"></i></div>
                            <span class="pill-nm" style="color:var(--accent);">Results</span>
                        </div>
                        <div style="font-size:3rem;font-weight:900;color:var(--text-primary);line-height:1;position:relative;z-index:1;">{{ $data['overall_performance'] }}<span style="font-size:1.6rem;color:var(--text-muted);font-weight:700;">%</span></div>
                        <p style="font-size:0.7rem;font-weight:700;color:var(--text-muted);margin-top:5px;text-transform:uppercase;letter-spacing:0.08em;position:relative;z-index:1;">Aggregate Score</p>
                        <div style="margin-top:12px;max-height:110px;overflow-y:auto;position:relative;z-index:1;">
                            @forelse($data['subject_scores'] as $score)
                                <div class="score-row">
                                    <span style="font-size:0.75rem;font-weight:700;color:var(--text-primary);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:65%;">{{ $score['name'] }}</span>
                                    <span style="font-size:0.75rem;font-weight:900;color:{{ $score['percentage'] < 50 ? '#ef4444' : 'var(--accent)' }};padding:3px 9px;border-radius:8px;background:var(--bg);box-shadow:2px 2px 5px var(--sh-dark),-2px -2px 5px var(--sh-light);">{{ $score['percentage'] }}%</span>
                                </div>
                            @empty
                                <p style="font-size:0.72rem;color:var(--text-muted);font-style:italic;text-align:center;padding:8px;">No marks mapped yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- 3. Emergency / Live Tracker --}}
                    @if($data['is_panicking'])
                        <div class="sos-banner" style="border-radius:22px;background:linear-gradient(135deg,#dc2626,#991b1b);padding:26px;box-shadow:8px 8px 24px rgba(220,38,38,0.55),-4px -4px 12px rgba(255,255,255,0.5);position:relative;overflow:hidden;">
                            <div style="position:absolute;right:-8px;bottom:-8px;opacity:0.15;pointer-events:none;"><i class="fa-solid fa-triangle-exclamation" style="font-size:5rem;color:#fff;display:block;"></i></div>
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:14px;position:relative;z-index:1;">
                                <div style="width:46px;height:46px;border-radius:14px;background:rgba(255,255,255,0.15);border:1.5px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;"><i class="fa-solid fa-triangle-exclamation" style="font-size:1.1rem;color:#fff;" class="animate-bounce"></i></div>
                                <span style="font-size:0.6rem;font-weight:900;letter-spacing:0.1em;text-transform:uppercase;padding:4px 10px;border-radius:9px;background:rgba(255,255,255,0.2);color:#fff;">🚨 SOS ACTIVE</span>
                            </div>
                            <div style="position:relative;z-index:1;">
                                <div style="font-size:1.1rem;font-weight:900;color:#fff;margin-bottom:4px;">PANIC ALERT</div>
                                <p style="font-size:0.72rem;color:rgba(255,255,255,0.8);font-weight:700;">{{ $data['panic_data']['time_ago'] }}</p>
                                <p style="font-size:0.65rem;color:rgba(255,255,255,0.6);margin-bottom:12px;">{{ $data['panic_data']['triggered_at'] }}</p>
                                @if($data['panic_data']['map_link'])
                                    <a href="{{ $data['panic_data']['map_link'] }}" target="_blank" style="display:block;width:100%;padding:11px;text-align:center;background:#fff;color:#dc2626;font-weight:900;font-size:0.82rem;border-radius:13px;text-decoration:none;box-shadow:0 4px 14px rgba(0,0,0,0.2);">
                                        <i class="fa-solid fa-map-location-dot"></i> Open Emergency Location
                                    </a>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="ana-card">
                            <div style="position:absolute;right:-6px;top:-6px;opacity:0.05;"><i class="fa-solid fa-satellite-dish" style="font-size:4.5rem;color:#ef4444;display:block;"></i></div>
                            <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;position:relative;z-index:1;">
                                <div class="icon-box" style="width:46px;height:46px;color:#f43f5e;"><i class="fa-solid fa-satellite-dish" style="font-size:1.1rem;"></i></div>
                                <span class="pill-nm" style="color:#f43f5e;">Live Tracker</span>
                            </div>
                            <div style="position:relative;z-index:1;">
                                @if($data['emergency_data'])
                                    <div style="padding:12px;border-radius:14px;background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -3px -3px 8px var(--sh-light);margin-bottom:12px;">
                                        <h3 style="font-size:0.88rem;font-weight:900;color:var(--text-primary);display:flex;align-items:center;gap:7px;">
                                            <span style="width:8px;height:8px;border-radius:50%;background:#22c55e;box-shadow:0 0 6px #22c55e;display:inline-block;" class="animate-pulse"></span> GPS Linked
                                        </h3>
                                        <p style="font-size:0.65rem;font-weight:700;color:var(--text-muted);margin-top:3px;">{{ $data['emergency_data']['updated_at'] }}</p>
                                    </div>
                                    <a href="{{ $data['emergency_data']['map_link'] }}" target="_blank" style="display:block;width:100%;padding:11px;text-align:center;border-radius:13px;font-weight:900;font-size:0.8rem;color:#fff;text-decoration:none;background:linear-gradient(135deg,#1e2340,#2a3050);box-shadow:4px 4px 12px rgba(0,0,0,0.25),-2px -2px 8px rgba(255,255,255,0.7);">
                                        Track Live on Maps <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.7rem;"></i>
                                    </a>
                                @else
                                    <div style="padding:16px;border-radius:14px;background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -3px -3px 8px var(--sh-light);text-align:center;margin-bottom:12px;">
                                        <i class="fa-solid fa-location-crosshairs" style="font-size:1.5rem;color:var(--sh-dark);margin-bottom:6px;display:block;"></i>
                                        <p style="font-size:0.82rem;font-weight:800;color:var(--text-secondary);">Signal Offline</p>
                                        <p style="font-size:0.7rem;color:var(--text-muted);margin-top:3px;">Device has not pinged location.</p>
                                    </div>
                                    <div style="width:100%;padding:11px;text-align:center;border-radius:13px;font-weight:800;font-size:0.78rem;color:var(--text-muted);background:var(--bg);box-shadow:inset 2px 2px 6px var(--sh-dark),inset -2px -2px 6px var(--sh-light);cursor:not-allowed;">Location Unavailable</div>
                                @endif
                            </div>
                        </div>
                    @endif

                    {{-- 4. Fees --}}
                    @php
                        $feePercentage = $data['total_fees'] > 0 ? min(100, round(($data['total_paid'] / $data['total_fees']) * 100)) : 100;
                        $feeColor = $feePercentage === 100 ? '#22c55e' : '#f59e0b';
                        if($data['total_fees'] == 0 && $data['total_paid'] == 0) { $feePercentage = 0; $feeColor = '#8c94b0'; }
                    @endphp
                    <div class="ana-card">
                        <div style="position:absolute;right:-6px;top:-6px;opacity:0.06;"><i class="fa-solid fa-indian-rupee-sign" style="font-size:4.5rem;color:var(--text-primary);display:block;"></i></div>
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:16px;position:relative;z-index:1;">
                            <div class="icon-box" style="width:46px;height:46px;color:#f59e0b;"><i class="fa-solid fa-indian-rupee-sign" style="font-size:1.1rem;"></i></div>
                            <span class="pill-nm" style="color:#f59e0b;">Fees Track</span>
                        </div>
                        <div style="font-size:1.6rem;font-weight:900;color:var(--text-primary);line-height:1.15;position:relative;z-index:1;">₹{{ number_format($data['total_paid']) }}<span style="font-size:0.95rem;color:var(--text-muted);font-weight:700;"> / ₹{{ number_format($data['total_fees']) }}</span></div>
                        @if($data['total_due'] > 0)
                            <p style="font-size:0.72rem;font-weight:800;color:#ef4444;margin-top:6px;position:relative;z-index:1;"><i class="fa-solid fa-circle-exclamation"></i> Due: ₹{{ number_format($data['total_due']) }}</p>
                        @else
                            <p style="font-size:0.72rem;font-weight:800;color:#22c55e;margin-top:6px;position:relative;z-index:1;"><i class="fa-solid fa-circle-check"></i> Fully Paid</p>
                        @endif
                        <div class="track" style="height:8px;margin-top:14px;position:relative;z-index:1;">
                            <div style="height:100%;background:{{ $feeColor }};border-radius:100px;width:{{ $feePercentage }}%;box-shadow:0 2px 8px {{ $feeColor }}55;transition:width 0.8s ease;"></div>
                        </div>
                    </div>

                </div>{{-- /child analytics grid --}}
            </div>{{-- /child card --}}

        @empty
            <div class="nm" style="padding:60px 40px;text-align:center;margin-bottom:28px;" class="fade-up">
                <div class="nm-inset" style="display:inline-flex;flex-direction:column;align-items:center;padding:36px 48px;">
                    <i class="fa-solid fa-children" style="font-size:3rem;color:var(--sh-dark);margin-bottom:16px;display:block;"></i>
                    <h2 style="font-size:1.3rem;font-weight:900;color:var(--text-primary);margin-bottom:8px;">No Enrolled Children Found</h2>
                    <p style="font-size:0.85rem;color:var(--text-muted);max-width:400px;line-height:1.6;">Your portal account does not currently have any student profiles linked. Contact school administration if this is an error.</p>
                    <button onclick="location.reload()" style="margin-top:20px;padding:11px 24px;border-radius:14px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);font-weight:800;font-size:0.85rem;color:var(--text-secondary);border:none;cursor:pointer;transition:all 0.2s;">Refresh Portal</button>
                </div>
            </div>
        @endforelse

        {{-- ── Telegram Widget ── --}}
        @php
            $parentUser             = auth()->user();
            $isParentTelegramLinked = $parentUser->hasTelegramConnected();
            $lastParentAlert        = $isParentTelegramLinked
                ? \App\Models\NotificationLog::where('recipient_id', $parentUser->id)->where('status', 'sent')->latest('sent_at')->first()
                : null;
        @endphp

        <div class="nm" style="overflow:hidden;margin-top:24px;" class="fade-up" style="animation-delay:0.3s;">
            {{-- Telegram header --}}
            <div style="padding:26px 28px;background:{{ $isParentTelegramLinked ? 'linear-gradient(135deg,#2AABEE,#229ED9)' : 'linear-gradient(135deg,#374151,#1f2937)' }};position:relative;overflow:hidden;">
                <div style="position:absolute;right:-12px;top:-12px;opacity:0.1;pointer-events:none;"><i class="fa-brands fa-telegram" style="font-size:9rem;color:#fff;display:block;"></i></div>
                <div style="display:flex;flex-wrap:wrap;align-items:center;gap:18px;position:relative;z-index:1;">
                    <div style="width:58px;height:58px;border-radius:18px;background:rgba(255,255,255,0.15);border:1.5px solid rgba(255,255,255,0.3);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="fa-brands fa-telegram" style="color:#fff;font-size:1.7rem;"></i>
                    </div>
                    <div style="flex:1;min-width:200px;">
                        <p style="font-size:0.6rem;font-weight:900;letter-spacing:0.18em;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-bottom:4px;">Instant Alerts</p>
                        <h2 style="font-size:1.3rem;font-weight:900;color:#fff;">Telegram Notifications</h2>
                        <p style="font-size:0.82rem;color:rgba(255,255,255,0.72);margin-top:4px;line-height:1.5;">
                            {{ $isParentTelegramLinked ? "Your account is connected. You'll receive instant alerts for attendance, results, fees, and emergency SOS." : 'Connect your Telegram to receive real-time alerts about attendance, results, fees, and emergency SOS.' }}
                        </p>
                    </div>
                    @if($isParentTelegramLinked)
                        <span style="display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:rgba(255,255,255,0.15);border:1.5px solid rgba(255,255,255,0.3);border-radius:13px;font-size:0.82rem;font-weight:900;color:#fff;flex-shrink:0;">
                            <span style="width:9px;height:9px;border-radius:50%;background:#22c55e;display:inline-block;" class="animate-pulse"></span> Connected ✅
                        </span>
                    @else
                        <span style="display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:rgba(255,255,255,0.12);border:1px solid rgba(255,255,255,0.2);border-radius:13px;font-size:0.82rem;font-weight:900;color:rgba(255,255,255,0.7);flex-shrink:0;">
                            <span style="width:9px;height:9px;border-radius:50%;background:rgba(255,255,255,0.4);display:inline-block;"></span> Not Connected
                        </span>
                    @endif
                </div>
            </div>

            {{-- Telegram body --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;padding:26px 28px;background:var(--bg);">
                {{-- Alert types --}}
                <div>
                    <p style="font-size:0.8rem;font-weight:800;color:var(--text-primary);margin-bottom:14px;display:flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-bell" style="color:{{ $isParentTelegramLinked ? '#2AABEE' : '#f59e0b' }};"></i>
                        {{ $isParentTelegramLinked ? 'Active Alert Types' : 'You will receive alerts for:' }}
                    </p>
                    <div>
                        @foreach([['📊','Attendance Marked','Every time attendance is recorded'],['⚠️','Low Attendance Warning','When attendance drops below 75%'],['🎉','Results Published','When exam results are released'],['💰','Fee Reminders','When fees are due or added'],['📢','Admin Notices','When admin posts a notice'],['🚨','Emergency SOS','Instant alert when panic button is triggered']] as [$icon,$title,$desc])
                            <div class="tg-alert-row">
                                <span style="font-size:1.05rem;flex-shrink:0;">{{ $icon }}</span>
                                <div>
                                    <p style="font-size:0.78rem;font-weight:800;color:var(--text-primary);">{{ $title }}</p>
                                    @if($isParentTelegramLinked)<p style="font-size:0.65rem;color:var(--text-muted);margin-top:1px;">{{ $desc }}</p>@endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Status / Action panel --}}
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @if($isParentTelegramLinked)
                        @if($lastParentAlert)
                            <div style="padding:16px;border-radius:16px;background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -3px -3px 8px var(--sh-light);">
                                <p style="font-size:0.6rem;font-weight:900;letter-spacing:0.14em;text-transform:uppercase;color:#2AABEE;margin-bottom:4px;">Last Alert</p>
                                <p style="font-size:0.85rem;font-weight:700;color:var(--text-primary);">{{ $lastParentAlert->sent_at?->diffForHumans() }}</p>
                                <p style="font-size:0.65rem;color:var(--text-muted);margin-top:3px;">{{ \Illuminate\Support\Str::limit($lastParentAlert->message, 80) }}</p>
                            </div>
                        @endif
                        <div style="display:flex;align-items:flex-start;gap:12px;padding:16px;border-radius:16px;background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -3px -3px 8px var(--sh-light);">
                            <i class="fa-solid fa-circle-check" style="color:#22c55e;font-size:1.1rem;margin-top:2px;flex-shrink:0;"></i>
                            <div>
                                <p style="font-size:0.85rem;font-weight:800;color:var(--text-primary);">Telegram is Active</p>
                                <p style="font-size:0.7rem;color:var(--text-muted);margin-top:3px;">All notifications are being sent to your Telegram account.</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('parent.telegram.disconnect') }}">
                            @csrf
                            <button type="submit" onclick="return confirm('Disconnect Telegram? You will stop receiving notifications.')" style="width:100%;padding:13px;border-radius:15px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);font-weight:800;font-size:0.82rem;color:#ef4444;border:2px solid rgba(239,68,68,0.2);cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;">
                                <i class="fa-solid fa-link-slash"></i> Disconnect Telegram
                            </button>
                        </form>
                    @else
                        <div style="padding:16px;border-radius:16px;background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -3px -3px 8px var(--sh-light);">
                            <p style="font-size:0.82rem;font-weight:800;color:#f59e0b;display:flex;align-items:center;gap:7px;margin-bottom:6px;"><i class="fa-solid fa-triangle-exclamation"></i> Not Connected</p>
                            <p style="font-size:0.75rem;color:var(--text-muted);line-height:1.55;">Connect your Telegram to receive real-time notifications on your phone, even when offline from EdFlow.</p>
                        </div>
                        <div style="padding:14px 16px;border-radius:14px;background:var(--bg);box-shadow:inset 3px 3px 8px var(--sh-dark),inset -3px -3px 8px var(--sh-light);">
                            <p style="font-size:0.8rem;font-weight:800;color:var(--text-primary);margin-bottom:10px;">How it works:</p>
                            @foreach(['Click "Connect Telegram" below','Telegram opens with our bot','Click "Start" in the bot','You\'re connected! ✅'] as $i => $step)
                                <p style="font-size:0.72rem;color:var(--text-muted);font-weight:700;margin-bottom:4px;">{{ $i+1 }}. {{ $step }}</p>
                            @endforeach
                        </div>
                        <a href="{{ route('parent.telegram.connect') }}" id="btn-parent-connect-telegram" style="display:flex;align-items:center;justify-content:center;gap:12px;padding:15px;border-radius:16px;font-weight:900;font-size:0.95rem;color:#fff;text-decoration:none;background:linear-gradient(135deg,#2AABEE,#229ED9);box-shadow:6px 6px 16px rgba(42,171,238,0.4),-3px -3px 10px rgba(255,255,255,0.8);transition:all 0.25s;">
                            <i class="fa-brands fa-telegram" style="font-size:1.3rem;"></i>
                            Connect Parent Telegram
                        </a>
                        <p style="font-size:0.62rem;text-align:center;color:var(--text-muted);font-weight:600;">No phone number required. Works with Telegram account only.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- /max-width --}}

    {{-- Auto-refresh if panic active --}}
    @if($anyPanicking ?? false)
        <script>setTimeout(() => window.location.reload(), 10000);</script>
    @endif
</main>

<!-- ═══ MOBILE BOTTOM NAV ════════════════════════════════ -->
<div class="lg:hidden">
    <div class="bottom-nav fixed bottom-0 inset-x-0 z-[60]">
        <div style="display:flex;justify-content:space-around;align-items:center;padding:8px 12px;max-width:480px;margin:0 auto;">
            <a href="#" class="bottom-tab is-active"><i class="fa-solid fa-chart-pie"></i><span>Dashboard</span></a>
            <a href="#" class="bottom-tab"><i class="fa-solid fa-calendar-check"></i><span>Attendance</span></a>
            <a href="#" class="bottom-tab"><i class="fa-solid fa-chart-line"></i><span>Marks</span></a>
            <a href="#" class="bottom-tab" style="position:relative;">
                <i class="fa-solid fa-bell"></i>
                @if($childrenData->contains('unread_broadcasts', '>', 0))<span style="position:absolute;top:8px;right:14px;width:8px;height:8px;border-radius:50%;background:#ef4444;border:2px solid var(--bg);display:block;" class="animate-pulse"></span>@endif
                <span>Alerts</span>
            </a>
            <button type="button" @click="moreOpen = true" class="bottom-tab"><i class="fa-solid fa-grid-2"></i><span>More</span></button>
        </div>
    </div>

    <div x-show="moreOpen" style="display:none;"
         x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="moreOpen = false"
         class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm z-[70]"></div>

    <div x-show="moreOpen" style="display:none;"
         x-transition:enter="transition transform ease-out duration-400" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition transform ease-in duration-300" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="side-drawer fixed bottom-0 inset-x-0 z-[80] flex flex-col" style="max-height:88vh;">
        <div style="padding:16px 20px 12px;border-bottom:1px solid rgba(255,255,255,0.4);display:flex;justify-content:space-between;align-items:center;">
            <div style="position:absolute;left:50%;top:10px;transform:translateX(-50%);width:36px;height:4px;border-radius:4px;background:var(--sh-dark);"></div>
            <span style="font-size:1rem;font-weight:800;color:var(--text-primary);margin-top:8px;">More Options</span>
            <button @click="moreOpen = false" style="width:32px;height:32px;border-radius:10px;background:var(--bg);box-shadow:3px 3px 8px var(--sh-dark),-3px -3px 8px var(--sh-light);border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--text-muted);margin-top:8px;">
                <i class="fa-solid fa-xmark" style="font-size:0.85rem;"></i>
            </button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:14px 14px 24px;">
            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:4px 4px 10px;">Academics</p>
            <a href="#" class="drawer-row"><span class="drawer-icon" style="color:#8b5cf6;"><i class="fa-solid fa-arrow-trend-up"></i></span>Performance Analytics</a>
            <a href="#" class="drawer-row"><span class="drawer-icon" style="color:#3b82f6;"><i class="fa-solid fa-calendar-days"></i></span>Exam Schedule</a>
            @php $publishedChild = $childrenData->first(fn($d) => $d['is_results_published'] ?? false); @endphp
            @if($publishedChild)
                <a href="{{ route('parent.report-card.download', $publishedChild['student']->id) }}" class="drawer-row" style="color:#f59e0b;"><span class="drawer-icon" style="color:#f59e0b;"><i class="fa-solid fa-file-pdf"></i></span><span style="flex:1;">Download Report Card</span><span style="font-size:0.55rem;font-weight:900;color:#f59e0b;padding:2px 6px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">PDF</span></a>
            @else
                <div class="drawer-row" style="opacity:0.45;cursor:not-allowed;"><span class="drawer-icon"><i class="fa-solid fa-file-pdf"></i></span><span style="flex:1;">Report Card</span><span style="font-size:0.55rem;font-weight:700;color:var(--text-muted);padding:2px 6px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">Not Yet</span></div>
            @endif
            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:16px 4px 10px;">Security</p>
            <a href="#" class="drawer-row"><span class="drawer-icon" style="color:#ef4444;"><i class="fa-solid fa-triangle-exclamation"></i></span>Emergency Alerts</a>
            <a href="#" class="drawer-row"><span class="drawer-icon" style="color:var(--text-secondary);"><i class="fa-solid fa-gear"></i></span>Settings</a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;">
                @csrf
                <button type="submit" style="width:100%;padding:14px;border-radius:16px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);font-weight:800;font-size:0.85rem;color:#ef4444;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>
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
    // Telegram body grid
    const tgBody = document.querySelector('.nm:last-of-type .nm + div > div:last-of-type');
    // responsive 2-col on desktop, 1-col mobile handled via the parent grid
</script>
</body>
</html>
