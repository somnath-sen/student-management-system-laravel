<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ═══════════════════════════════════════════════════
           PREMIUM NEUMORPHISM — DESIGN TOKENS
        ═══════════════════════════════════════════════════ */
        :root {
            /* Base surface — cool blue-gray with a touch of warmth */
            --bg:       #dde3ee;
            --bg-light: #eef1f7;
            --bg-dark:  #cdd3e0;

            /* Shadow pair */
            --sh-dark:  #b8bece;
            --sh-light: #ffffff;

            /* Accent — vivid indigo / violet */
            --accent:        #5b5ef4;
            --accent-2:      #7c3aed;
            --accent-glow:   rgba(91, 94, 244, 0.25);
            --accent-soft:   rgba(91, 94, 244, 0.10);

            /* Text hierarchy */
            --text-primary:   #1e2340;
            --text-secondary: #5a6284;
            --text-muted:     #8c94b0;

            /* Shared radii */
            --r-sm: 12px;
            --r-md: 18px;
            --r-lg: 24px;
            --r-xl: 28px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; }

        html { height: 100%; }

        body {
            font-family: 'Inter', 'Plus Jakarta Sans', sans-serif;
            background: var(--bg) !important;
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            height: 100%;
        }

        /* ── Utility shadows ──────────────────────────────── */
        .sh-raised     { box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light); }
        .sh-raised-sm  { box-shadow: 4px 4px 9px  var(--sh-dark), -4px -4px 9px  var(--sh-light); }
        .sh-raised-lg  { box-shadow: 10px 10px 24px var(--sh-dark), -10px -10px 24px var(--sh-light); }
        .sh-inset      { box-shadow: inset 4px 4px 10px var(--sh-dark), inset -4px -4px 10px var(--sh-light); }
        .sh-inset-sm   { box-shadow: inset 2px 2px 6px  var(--sh-dark), inset -2px -2px 6px  var(--sh-light); }

        /* ── SIDEBAR ──────────────────────────────────────── */
        .sidebar {
            background: var(--bg);
            box-shadow: 8px 0 28px rgba(0,0,0,0.10);
            border-right: 1px solid rgba(255,255,255,0.55);
            display: flex;
            flex-direction: column;
        }

        /* Logo bar */
        .sidebar-logo {
            padding: 0 20px;
            height: 72px;
            display: flex;
            align-items: center;
            gap: 13px;
            border-bottom: 1px solid rgba(255,255,255,0.4);
            background: var(--bg);
            flex-shrink: 0;
        }
        .logo-gem {
            width: 42px; height: 42px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 4px 4px 12px rgba(91,94,244,0.45), -3px -3px 8px rgba(255,255,255,0.8);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .logo-gem i { color: #fff; font-size: 17px; }
        .logo-text  { font-weight: 800; font-size: 1rem; color: var(--text-primary); letter-spacing: -0.02em; }
        .logo-sub   { font-weight: 600; font-size: 0.6rem; color: var(--text-muted); letter-spacing: 0.12em; text-transform: uppercase; }

        /* Nav scroll area */
        .sidebar-nav { flex: 1; overflow-y: auto; padding: 14px 12px; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--sh-dark); border-radius: 4px; }

        /* Section label */
        .nav-label {
            font-size: 0.58rem; font-weight: 800;
            letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--text-muted);
            padding: 20px 14px 6px;
            display: block;
        }

        /* Nav item */
        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 13px; border-radius: var(--r-sm);
            color: var(--text-secondary);
            font-weight: 600; font-size: 0.8rem;
            text-decoration: none; cursor: pointer;
            position: relative;
            transition: all 0.22s ease;
            user-select: none;
        }
        .nav-item:hover {
            color: var(--text-primary);
            box-shadow: 4px 4px 10px var(--sh-dark), -4px -4px 10px var(--sh-light);
            background: var(--bg);
        }
        .nav-item.active {
            color: var(--accent);
            font-weight: 700;
            box-shadow: inset 4px 4px 10px var(--sh-dark), inset -4px -4px 10px var(--sh-light);
            background: var(--bg-dark);
        }
        .nav-item.active::before {
            content: '';
            position: absolute; left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 52%;
            background: linear-gradient(180deg, var(--accent), var(--accent-2));
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px var(--accent-glow);
        }

        /* Nav icon */
        .nav-icon {
            width: 32px; height: 32px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.78rem; flex-shrink: 0;
            background: var(--bg);
            box-shadow: 3px 3px 7px var(--sh-dark), -3px -3px 7px var(--sh-light);
            transition: all 0.22s ease;
            color: inherit;
        }
        .nav-item.active .nav-icon {
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 3px 3px 10px rgba(91,94,244,0.45), -2px -2px 6px rgba(255,255,255,0.8);
            color: #fff;
        }
        .nav-item:hover .nav-icon {
            box-shadow: 5px 5px 12px var(--sh-dark), -5px -5px 12px var(--sh-light);
        }

        /* Pill badge on nav */
        .nav-pill {
            font-size: 0.55rem; font-weight: 900;
            letter-spacing: 0.1em; text-transform: uppercase;
            padding: 3px 7px; border-radius: 7px;
            background: var(--bg);
            box-shadow: inset 2px 2px 5px var(--sh-dark), inset -2px -2px 5px var(--sh-light);
        }

        /* User footer */
        .sidebar-footer {
            padding: 16px 14px;
            border-top: 1px solid rgba(255,255,255,0.45);
            background: var(--bg);
            flex-shrink: 0;
        }
        .sidebar-footer .avatar {
            width: 38px; height: 38px; border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 3px 3px 9px rgba(91,94,244,0.4), -2px -2px 6px rgba(255,255,255,0.8);
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 800; font-size: 0.9rem;
            flex-shrink: 0;
        }

        /* ── HEADER ───────────────────────────────────────── */
        .top-header {
            height: 72px;
            background: var(--bg);
            box-shadow: 0 4px 18px rgba(0,0,0,0.07);
            border-bottom: 1px solid rgba(255,255,255,0.55);
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 28px;
            position: sticky; top: 0; z-index: 30;
            flex-shrink: 0;
        }
        .header-icon-btn {
            width: 42px; height: 42px; border-radius: 13px;
            background: var(--bg);
            box-shadow: 4px 4px 9px var(--sh-dark), -4px -4px 9px var(--sh-light);
            display: flex; align-items: center; justify-content: center;
            color: var(--text-secondary); cursor: pointer;
            transition: all 0.2s; border: none; position: relative;
        }
        .header-icon-btn:hover {
            color: var(--accent);
            box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light);
        }
        .header-icon-btn:active {
            box-shadow: inset 3px 3px 8px var(--sh-dark), inset -3px -3px 8px var(--sh-light);
        }
        .header-logout {
            display: flex; align-items: center; gap: 8px;
            padding: 9px 20px; border-radius: 13px;
            background: var(--bg);
            box-shadow: 4px 4px 9px var(--sh-dark), -4px -4px 9px var(--sh-light);
            color: #ef4444; font-size: 0.8rem; font-weight: 700;
            cursor: pointer; border: none; transition: all 0.2s;
        }
        .header-logout:hover { box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light); }
        .header-logout:active { box-shadow: inset 3px 3px 8px var(--sh-dark), inset -3px -3px 8px var(--sh-light); }

        /* Notification dropdown */
        .notif-dropdown {
            background: var(--bg);
            box-shadow: 10px 10px 28px var(--sh-dark), -6px -6px 16px var(--sh-light);
            border-radius: var(--r-lg);
            border: 1px solid rgba(255,255,255,0.65);
        }
        .notif-item:hover { background: rgba(255,255,255,0.5); }

        /* ── MOBILE BOTTOM NAV ────────────────────────────── */
        .bottom-nav {
            background: var(--bg);
            box-shadow: 0 -6px 24px rgba(0,0,0,0.09);
            border-top: 1px solid rgba(255,255,255,0.55);
        }
        .bottom-tab {
            display: flex; flex-direction: column; align-items: center;
            gap: 3px; padding: 9px 8px; border-radius: 14px;
            color: var(--text-muted); font-size: 0.58rem; font-weight: 700;
            cursor: pointer; transition: all 0.2s; border: none; background: none;
            text-decoration: none;
        }
        .bottom-tab.is-active { color: var(--accent); }
        .bottom-tab.is-active i {
            filter: drop-shadow(0 0 5px var(--accent-glow));
        }
        .bottom-tab i { font-size: 1.15rem; transition: all 0.2s; }

        /* Drawer */
        .side-drawer {
            background: var(--bg);
            border-radius: 28px 28px 0 0;
            box-shadow: 0 -12px 36px rgba(0,0,0,0.12);
        }
        .drawer-row {
            display: flex; align-items: center; gap: 14px;
            padding: 12px 14px; border-radius: 14px;
            color: var(--text-secondary); font-weight: 700; font-size: 0.85rem;
            text-decoration: none; transition: all 0.2s;
            background: var(--bg);
            box-shadow: 4px 4px 10px var(--sh-dark), -4px -4px 10px var(--sh-light);
            margin-bottom: 8px;
        }
        .drawer-row:hover {
            color: var(--accent);
            box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light);
        }
        .drawer-icon {
            width: 36px; height: 36px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            background: var(--bg);
            box-shadow: inset 2px 2px 6px var(--sh-dark), inset -2px -2px 6px var(--sh-light);
            font-size: 0.88rem;
        }

        /* ── ANIMATIONS ───────────────────────────────────── */
        .page-in {
            animation: pageIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }
        @keyframes pageIn {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .shimmer {
            background: var(--bg);
            background-image: linear-gradient(90deg, rgba(255,255,255,0) 0, rgba(255,255,255,0.55) 35%, rgba(255,255,255,0) 65%);
            background-repeat: no-repeat;
            background-size: 900px 100%;
            animation: shim 1.6s infinite linear;
        }
        @keyframes shim { 0%{background-position:-500px 0} 100%{background-position:500px 0} }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--sh-dark); border-radius: 6px; }
        ::-webkit-scrollbar-thumb:hover { background: #aab0c2; }
    </style>
</head>

<body x-data="{ sidebarOpen: false }">
<div class="flex h-screen overflow-hidden">

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition:enter="transition-opacity duration-300"
         x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display:none;"
         class="fixed inset-0 z-40 bg-slate-900/30 backdrop-blur-sm lg:hidden"></div>

    <!-- ═══════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════ -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="sidebar fixed inset-y-0 left-0 z-50 w-[260px] transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">

        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="logo-gem"><i class="fa-solid fa-graduation-cap"></i></div>
            <div>
                <div class="logo-text">StudentPanel</div>
                <div class="logo-sub">Academic Portal</div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="sidebar-nav">

            <a href="{{ route('student.dashboard') }}" class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('student.timetable') }}" class="nav-item {{ request()->routeIs('student.timetable.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span>
                <span>Class Routine</span>
            </a>

            <a href="{{ route('student.attendance.index') }}" class="nav-item {{ request()->routeIs('student.attendance.index') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
                <span>Attendance</span>
            </a>

            <a href="{{ route('student.attendance.insights') }}" class="nav-item {{ request()->routeIs('student.attendance.insights') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-brain"></i></span>
                <span style="flex:1">Attendance Insights</span>
                <span class="nav-pill" style="color:var(--accent);">AI</span>
            </a>

            <a href="{{ route('student.exams.index') }}" class="nav-item {{ request()->routeIs('student.exams.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-pen"></i></span>
                <span>Exam Schedule</span>
            </a>

            <a href="{{ route('student.admit-card.show') }}" class="nav-item {{ request()->routeIs('student.admit-card.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-id-card"></i></span>
                <span>Admit Card</span>
            </a>

            <a href="{{ route('student.results.index') }}" class="nav-item {{ request()->routeIs('student.results.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-trophy"></i></span>
                <span>Results</span>
            </a>

            <a href="{{ route('student.marksheet.show') }}" class="nav-item {{ request()->routeIs('student.marksheet.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-invoice"></i></span>
                <span>Marksheet</span>
            </a>

            @php
                $reportCardStudent = auth()->user()->student ?? null;
                $reportCardPublished = $reportCardStudent
                    ? \App\Models\Mark::where('student_id', $reportCardStudent->id)
                        ->where('is_locked', true)
                        ->whereHas('subject', fn($q) => $q->where('course_id', $reportCardStudent->course_id))
                        ->exists()
                    : false;
            @endphp

            @if($reportCardPublished)
            <a href="{{ route('student.report-card.download') }}" id="sidebar-report-card-link" class="nav-item" style="color:#d97706;">
                <span class="nav-icon" style="color:#d97706;"><i class="fa-solid fa-file-pdf"></i></span>
                <span style="flex:1">Report Card</span>
                <span class="nav-pill" style="color:#d97706;">PDF</span>
            </a>
            @else
            <div class="nav-item" style="opacity:0.38;cursor:not-allowed;">
                <span class="nav-icon"><i class="fa-solid fa-file-pdf"></i></span>
                <span style="flex:1">Report Card</span>
                <span class="nav-pill">Soon</span>
            </div>
            @endif

            <a href="{{ route('student.performance.index') }}" class="nav-item {{ request()->routeIs('student.performance.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-arrow-trend-up"></i></span>
                <span>Performance</span>
            </a>

            <span class="nav-label">Financials</span>

            <a href="{{ route('student.fees.index') }}" class="nav-item {{ request()->routeIs('student.fees.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-credit-card"></i></span>
                <span>My Fees</span>
            </a>

            <span class="nav-label">Tools</span>

            <a href="{{ route('studyai.index') }}" class="nav-item {{ request()->routeIs('studyai.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-robot"></i></span>
                <span style="flex:1">StudyAI</span>
                <span class="nav-pill" style="color:var(--accent);">AI</span>
            </a>

            <a href="{{ route('student.suggestions') }}" class="nav-item {{ request()->routeIs('student.suggestions*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-brain"></i></span>
                <span style="flex:1">AI Suggestions</span>
                <span class="nav-pill" style="color:#a855f7;">New</span>
            </a>

            <a href="{{ route('student.dashboard') }}#announcements" class="nav-item {{ request()->routeIs('student.broadcast.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span style="flex:1">Broadcasts</span>
                <span id="unread-broadcast-badge" class="hidden items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black text-white bg-violet-500 rounded-full">0</span>
            </a>

            <span class="nav-label">Settings</span>

            <a href="{{ route('student.location') }}" class="nav-item {{ request()->routeIs('student.location.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-location-crosshairs"></i></span>
                <span style="flex:1">Family Tracker</span>
                <span class="nav-pill" style="color:#f43f5e;display:flex;align-items:center;gap:4px;">
                    <span style="width:6px;height:6px;border-radius:50%;background:#f43f5e;display:inline-block;" class="animate-pulse"></span>Live
                </span>
            </a>

            <a href="{{ route('student.smart-id') }}" class="nav-item {{ request()->routeIs('student.smart-id.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-id-badge"></i></span>
                <span style="flex:1">Smart ID Card</span>
                <span class="nav-pill" style="color:#10b981;">QR</span>
            </a>

            <a href="{{ route('student.emergency') }}" class="nav-item {{ request()->routeIs('student.emergency.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-shield-halved"></i></span>
                <span>Emergency Info</span>
            </a>

            <a href="{{ route('student.details') }}" class="nav-item {{ request()->routeIs('student.details.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-user"></i></span>
                <span>My Profile</span>
            </a>

        </nav>

        <!-- Footer -->
        <div class="sidebar-footer">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</div>
                <div style="overflow:hidden;flex:1;">
                    <div style="font-size:0.82rem;font-weight:700;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                        {{ auth()->user()->name ?? 'Student' }}
                    </div>
                    <div style="font-size:0.6rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.12em;">Student Account</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ═══════════════════════════════════════════
         MAIN CONTENT AREA
    ═══════════════════════════════════════════ -->
    <div style="flex:1;display:flex;flex-direction:column;height:100%;overflow:hidden;background:var(--bg);">

        <!-- Header -->
        <header class="top-header">
            <div style="display:flex;align-items:center;gap:14px;">
                <button @click="sidebarOpen = true" class="header-icon-btn lg:hidden">
                    <i class="fa-solid fa-bars" style="font-size:1rem;"></i>
                </button>
                <div class="hidden sm:block">
                    <x-breadcrumb />
                    <h1 style="font-size:1.15rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.025em;line-height:1.2;">@yield('title')</h1>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:12px;">

                <!-- Notifications -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="header-icon-btn">
                        <i class="fa-solid fa-bell" style="font-size:1rem;"></i>
                        @if(isset($latestNotices) && $latestNotices->count() > 0)
                            <span style="position:absolute;top:9px;right:9px;width:8px;height:8px;background:#f43f5e;border-radius:50%;border:2px solid var(--bg);" class="animate-pulse"></span>
                        @endif
                    </button>

                    <div x-show="open" style="display:none;"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="notif-dropdown absolute right-0 mt-3 w-80 sm:w-[360px] z-[9999] overflow-hidden">

                        <div style="padding:18px 20px 14px;border-bottom:1px solid rgba(255,255,255,0.4);display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.9rem;font-weight:800;color:var(--text-primary);">Notifications</span>
                            @if(isset($latestNotices) && $latestNotices->count() > 0)
                                <span style="font-size:0.65rem;font-weight:800;color:var(--accent);padding:3px 9px;border-radius:8px;background:var(--bg);box-shadow:2px 2px 6px var(--sh-dark),-2px -2px 6px var(--sh-light);">
                                    {{ $latestNotices->count() }} New
                                </span>
                            @endif
                        </div>

                        <div style="max-height:340px;overflow-y:auto;">
                            @if(isset($latestNotices) && $latestNotices->count() > 0)
                                @foreach($latestNotices as $notice)
                                @php $nc=['Urgent'=>'#f43f5e','Exam'=>'var(--accent)','Holiday'=>'#10b981','General'=>'#3b82f6'];$cl=$nc[$notice->category]??$nc['General']; @endphp
                                <a href="{{ route('student.notices.show', $notice) }}" class="notif-item" style="display:block;padding:14px 20px;border-bottom:1px solid rgba(255,255,255,0.3);text-decoration:none;transition:background 0.15s;">
                                    <div style="display:flex;gap:12px;align-items:flex-start;">
                                        <div style="width:36px;height:36px;border-radius:11px;background:var(--bg);box-shadow:3px 3px 7px var(--sh-dark),-3px -3px 7px var(--sh-light);display:flex;align-items:center;justify-content:center;color:{{ $cl }};flex-shrink:0;">
                                            <i class="fa-solid fa-bullhorn" style="font-size:0.75rem;"></i>
                                        </div>
                                        <div style="flex:1;min-width:0;">
                                            <p style="font-size:0.82rem;font-weight:700;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $notice->title }}</p>
                                            <p style="font-size:0.7rem;color:var(--text-muted);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ Str::limit($notice->content, 42) }}</p>
                                            <p style="font-size:0.6rem;color:var(--text-muted);margin-top:4px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">{{ $notice->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                                <a href="{{ route('student.dashboard') }}" style="display:block;text-align:center;padding:13px;font-size:0.75rem;font-weight:800;color:var(--accent);text-decoration:none;transition:background 0.15s;" class="notif-item">
                                    View All Notices →
                                </a>
                            @else
                                <div style="padding:32px 20px;text-align:center;">
                                    <div style="width:42px;height:42px;border-radius:14px;background:var(--bg);box-shadow:3px 3px 8px var(--sh-dark),-3px -3px 8px var(--sh-light);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;color:var(--text-muted);">
                                        <i class="fa-solid fa-check"></i>
                                    </div>
                                    <p style="font-size:0.82rem;font-weight:700;color:var(--text-secondary);">All caught up!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div style="width:1px;height:22px;background:rgba(0,0,0,0.1);" class="hidden sm:block"></div>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="header-logout">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span class="hidden sm:inline">Sign Out</span>
                    </button>
                </form>
            </div>
        </header>

        <!-- Page content -->
        <main style="flex:1;overflow-y:auto;overflow-x:hidden;position:relative;" class="pb-24 lg:pb-0">
            <x-skeleton-ui />
            <div id="main-page-content">@yield('content')</div>
        </main>

    </div>
</div>

<!-- ═══════════════════════════════════════════
     MOBILE BOTTOM NAV
═══════════════════════════════════════════ -->
<div x-data="{ moreOpen: false }" class="lg:hidden">

    <div class="bottom-nav fixed bottom-0 inset-x-0 z-[60]">
        <div style="display:flex;justify-content:space-around;align-items:center;padding:8px 12px;max-width:480px;margin:0 auto;">

            <a href="{{ route('student.dashboard') }}" class="bottom-tab {{ request()->routeIs('student.dashboard') ? 'is-active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('student.attendance.index') }}" class="bottom-tab {{ request()->routeIs('student.attendance.index') ? 'is-active' : '' }}">
                <i class="fa-solid fa-calendar-check"></i><span>Attendance</span>
            </a>
            <a href="{{ route('student.performance.index') }}" class="bottom-tab {{ request()->routeIs('student.performance.*') ? 'is-active' : '' }}">
                <i class="fa-solid fa-arrow-trend-up"></i><span>Performance</span>
            </a>
            <a href="{{ route('studyai.index') }}" class="bottom-tab {{ request()->routeIs('studyai.*') ? 'is-active' : '' }}">
                <div style="position:relative;">
                    <i class="fa-solid fa-robot"></i>
                    <span style="position:absolute;top:-3px;right:-6px;width:7px;height:7px;background:#a855f7;border-radius:50%;border:1.5px solid var(--bg);" class="animate-pulse"></span>
                </div>
                <span>StudyAI</span>
            </a>
            <button type="button" @click="moreOpen = true" class="bottom-tab">
                <i class="fa-solid fa-grid-2"></i><span>More</span>
            </button>

        </div>
    </div>

    <!-- Overlay -->
    <div x-show="moreOpen" style="display:none;"
         x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         @click="moreOpen = false"
         class="fixed inset-0 bg-slate-900/30 backdrop-blur-sm z-[70]"></div>

    <!-- Drawer -->
    <div x-show="moreOpen" style="display:none;"
         x-transition:enter="transition transform ease-out duration-400"
         x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition transform ease-in duration-300"
         x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="side-drawer fixed bottom-0 inset-x-0 z-[80] flex flex-col" style="max-height:88vh;">

        <div style="padding:16px 20px 12px;border-bottom:1px solid rgba(255,255,255,0.4);display:flex;justify-content:space-between;align-items:center;">
            <div style="position:absolute;left:50%;top:10px;transform:translateX(-50%);width:36px;height:4px;border-radius:4px;background:var(--sh-dark);"></div>
            <span style="font-size:1rem;font-weight:800;color:var(--text-primary);margin-top:8px;">More Options</span>
            <button @click="moreOpen = false" class="header-icon-btn" style="width:32px;height:32px;border-radius:10px;margin-top:8px;">
                <i class="fa-solid fa-xmark" style="font-size:0.85rem;"></i>
            </button>
        </div>

        <div style="overflow-y:auto;flex:1;padding:14px 14px 24px;">
            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:4px 4px 10px;">Academic</p>
            <a href="{{ route('student.timetable') }}"     class="drawer-row"><span class="drawer-icon" style="color:#3b82f6;"><i class="fa-solid fa-clock"></i></span>Class Routine</a>
            <a href="{{ route('student.exams.index') }}"   class="drawer-row"><span class="drawer-icon" style="color:var(--accent);"><i class="fa-solid fa-file-pen"></i></span>Exam Schedule</a>
            <a href="{{ route('student.admit-card.show') }}" class="drawer-row"><span class="drawer-icon" style="color:#0ea5e9;"><i class="fa-solid fa-id-card-clip"></i></span>Admit Card</a>
            <a href="{{ route('student.results.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#eab308;"><i class="fa-solid fa-trophy"></i></span>Results</a>
            <a href="{{ route('student.marksheet.show') }}" class="drawer-row"><span class="drawer-icon" style="color:#f97316;"><i class="fa-solid fa-file-lines"></i></span>Marksheet</a>
            @if($reportCardPublished)
            <a href="{{ route('student.report-card.download') }}" class="drawer-row"><span class="drawer-icon" style="color:#d97706;"><i class="fa-solid fa-file-pdf"></i></span><span style="flex:1">Report Card</span><span style="font-size:0.6rem;font-weight:900;color:#d97706;padding:2px 7px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">PDF</span></a>
            @endif

            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:16px 4px 10px;">AI & Analytics</p>
            <a href="{{ route('student.attendance.insights') }}" class="drawer-row"><span class="drawer-icon" style="color:#d946ef;"><i class="fa-solid fa-lightbulb"></i></span><span style="flex:1">Attendance Insights</span><span style="font-size:0.55rem;font-weight:900;color:#d946ef;padding:2px 7px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">AI</span></a>
            <a href="{{ route('student.suggestions') }}"  class="drawer-row"><span class="drawer-icon" style="color:#a855f7;"><i class="fa-solid fa-wand-magic-sparkles"></i></span>AI Suggestions</a>

            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:16px 4px 10px;">Campus Life</p>
            <a href="{{ route('student.dashboard') }}#announcements" class="drawer-row"><span class="drawer-icon" style="color:#8b5cf6;"><i class="fa-solid fa-bullhorn"></i></span>Broadcasts</a>
            <a href="{{ route('student.smart-id') }}"     class="drawer-row"><span class="drawer-icon" style="color:#10b981;"><i class="fa-solid fa-id-badge"></i></span>Smart ID Card</a>
            <a href="{{ route('student.location') }}"     class="drawer-row"><span class="drawer-icon" style="color:#f43f5e;"><i class="fa-solid fa-location-crosshairs"></i></span><span style="flex:1">Family Tracker</span><span style="width:7px;height:7px;border-radius:50%;background:#f43f5e;" class="animate-pulse"></span></a>
            <a href="{{ route('student.emergency') }}"    class="drawer-row"><span class="drawer-icon" style="color:#ef4444;"><i class="fa-solid fa-shield-halved"></i></span>Emergency Info</a>

            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:16px 4px 10px;">Account</p>
            <a href="{{ route('student.fees.index') }}"   class="drawer-row"><span class="drawer-icon" style="color:#14b8a6;"><i class="fa-solid fa-credit-card"></i></span>My Fees</a>
            <a href="{{ route('student.details') }}"      class="drawer-row"><span class="drawer-icon" style="color:var(--text-secondary);"><i class="fa-solid fa-user"></i></span>My Profile</a>

            <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;">
                @csrf
                <button type="submit" style="width:100%;padding:14px;border-radius:16px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);font-weight:800;font-size:0.85rem;color:#ef4444;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>
    </div>
</div>

<x-sweetalert />
</body>
</html>