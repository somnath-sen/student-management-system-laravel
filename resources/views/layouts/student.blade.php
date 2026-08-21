<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Portal — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ═══════════════════════════════════════════════════════
           iOS 18 PREMIUM — STUDENT PORTAL
           Accent: #007AFF (iOS Blue)
        ═══════════════════════════════════════════════════════ */
        :root {
            --accent: #007AFF;
            --accent-2: #5AC8FA;
            --accent-rgb: 0, 122, 255;
            --accent-glow: rgba(0, 122, 255, 0.35);
            --accent-soft: rgba(0, 122, 255, 0.12);
            --r-sm: 10px;
            --r-md: 16px;
            --r-lg: 20px;
            --r-xl: 28px;
            --bg: #F2F2F7;
            --bg-2: #FFFFFF;
            --bg-3: #E5E5EA;
            --surface: rgba(255, 255, 255, 0.72);
            --surface-2: rgba(255, 255, 255, 0.5);
            --border: rgba(60, 60, 67, 0.12);
            --border-2: rgba(60, 60, 67, 0.08);
            --text-primary: #1C1C1E;
            --text-secondary: rgba(60, 60, 67, 0.60);
            --text-muted: rgba(60, 60, 67, 0.40);
            --shadow: 0 2px 20px rgba(0, 0, 0, 0.08), 0 1px 4px rgba(0, 0, 0, 0.05);
            --shadow-lg: 0 8px 40px rgba(0, 0, 0, 0.12), 0 2px 8px rgba(0, 0, 0, 0.06);
            --divider: rgba(60, 60, 67, 0.10);
            --sidebar-bg: rgba(248, 248, 248, 0.92);
            --header-bg: rgba(248, 248, 248, 0.90);
            --nav-active-bg: rgba(0, 122, 255, 0.10);
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
        }

        html {
            height: 100%;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            -webkit-font-smoothing: antialiased;
            height: 100%;
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border);
            border-radius: 8px;
        }

        /* ── SIDEBAR ──────────────────────────────────────────── */
        .sidebar {
            background: var(--sidebar-bg);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
        }

        .sidebar-logo {
            padding: 0 18px;
            height: 64px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid var(--divider);
            flex-shrink: 0;
        }

        .logo-gem {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px var(--accent-glow);
        }

        .logo-gem i {
            color: #fff;
            font-size: 15px;
        }

        .logo-text {
            font-weight: 700;
            font-size: 0.95rem;
            color: var(--text-primary);
            letter-spacing: -0.025em;
            line-height: 1.1;
        }

        .logo-sub {
            font-size: 0.58rem;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .sidebar-nav {
            flex: 1;
            overflow-y: auto;
            padding: 10px 10px;
            scrollbar-width: none;
        }

        .sidebar-nav::-webkit-scrollbar {
            display: none;
        }

        .nav-section {
            font-size: 0.62rem;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 18px 12px 6px;
            display: block;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            border-radius: var(--r-md);
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.82rem;
            text-decoration: none;
            transition: all 0.18s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            margin-bottom: 2px;
        }

        .nav-item:hover {
            background: var(--border-2);
            color: var(--text-primary);
        }

        .nav-item.active {
            background: var(--nav-active-bg);
            color: var(--accent);
            font-weight: 600;
        }

        .nav-icon {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            flex-shrink: 0;
            background: var(--border-2);
            transition: all 0.18s ease;
            color: inherit;
        }

        .nav-item.active .nav-icon {
            background: var(--accent);
            color: #fff;
            box-shadow: 0 3px 10px var(--accent-glow);
        }

        .nav-badge {
            font-size: 0.52rem;
            font-weight: 700;
            padding: 2px 7px;
            border-radius: 100px;
            background: var(--accent-soft);
            color: var(--accent);
            margin-left: auto;
        }

        .sidebar-footer {
            padding: 14px 14px;
            border-top: 1px solid var(--divider);
            flex-shrink: 0;
        }

        .user-chip {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 11px;
            border-radius: var(--r-md);
            background: var(--border-2);
        }

        .user-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-weight: 700;
            font-size: 0.85rem;
            flex-shrink: 0;
            box-shadow: 0 2px 8px var(--accent-glow);
        }

        /* ── HEADER ───────────────────────────────────────────── */
        .top-header {
            height: 60px;
            background: var(--header-bg);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border-bottom: 1px solid var(--divider);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 22px;
            position: sticky;
            top: 0;
            z-index: 30;
            flex-shrink: 0;
        }

        .hdr-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: var(--border-2);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.18s;
            border: none;
            font-size: 0.9rem;
            position: relative;
        }

        .hdr-btn:hover {
            background: var(--border);
            color: var(--text-primary);
        }

        .hdr-logout {
            display: flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            border-radius: 100px;
            background: rgba(255, 59, 48, 0.10);
            color: #FF3B30;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: all 0.18s;
        }

        .hdr-logout:hover {
            background: rgba(255, 59, 48, 0.18);
        }

        /* Notif dropdown */
        .notif-panel {
            background: var(--surface);
            backdrop-filter: blur(40px) saturate(200%);
            -webkit-backdrop-filter: blur(40px) saturate(200%);
            border: 1px solid var(--border);
            border-radius: var(--r-xl);
            box-shadow: var(--shadow-lg);
        }

        .notif-row:hover {
            background: var(--border-2);
            border-radius: 12px;
        }

        /* ── MOBILE BOTTOM NAV ────────────────────────────────── */
        .bottom-nav {
            background: var(--header-bg);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
            border-top: 1px solid var(--divider);
        }

        .bottom-tab {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding: 8px;
            border-radius: 12px;
            color: var(--text-muted);
            font-size: 0.56rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.18s;
            border: none;
            background: none;
            text-decoration: none;
            min-width: 52px;
        }

        .bottom-tab.is-active {
            color: var(--accent);
        }

        .bottom-tab i {
            font-size: 1.2rem;
            transition: all 0.18s;
        }

        .bottom-tab.is-active i {
            filter: drop-shadow(0 0 6px var(--accent-glow));
        }

        /* More drawer */
        .more-drawer {
            background: var(--surface);
            backdrop-filter: blur(40px) saturate(200%);
            -webkit-backdrop-filter: blur(40px) saturate(200%);
            border-radius: 20px 20px 0 0;
            border-top: 1px solid var(--border);
        }

        .drawer-row {
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 11px 14px;
            border-radius: 12px;
            color: var(--text-secondary);
            font-weight: 500;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.15s;
            margin-bottom: 2px;
        }

        .drawer-row:hover {
            background: var(--border-2);
            color: var(--text-primary);
        }

        .drawer-icon {
            width: 34px;
            height: 34px;
            border-radius: 9px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.88rem;
            flex-shrink: 0;
            background: var(--border-2);
        }

        /* ── ANIMATIONS ───────────────────────────────────────── */
        @keyframes ios-in {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .ios-in {
            animation: ios-in 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        @keyframes ios-in-fast {
            from {
                opacity: 0;
                transform: translateY(6px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ios-in-fast {
            animation: ios-in-fast 0.22s ease-out forwards;
        }
    </style>
</head>

<body x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">

        <!-- Mobile overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition:enter="transition-opacity duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" style="display:none;"
            class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"></div>

        <!-- ═══════ SIDEBAR ═══════ -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="sidebar fixed inset-y-0 left-0 z-50 w-[252px] transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:inset-0">

            <!-- Logo -->
            <div class="sidebar-logo">
                <div class="logo-gem"><i class="fa-solid fa-graduation-cap"></i></div>
                <div>
                    <div class="logo-text">EdFlow</div>
                    <div class="logo-sub">Student Portal</div>
                </div>
            </div>

            <!-- Nav -->
            <nav class="sidebar-nav">

                <a href="{{ route('student.dashboard') }}"
                    class="nav-item {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-house"></i></span>
                    <span>Dashboard</span>
                </a>

                <span class="nav-section">Academics</span>

                <a href="{{ route('student.timetable') }}"
                    class="nav-item {{ request()->routeIs('student.timetable.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-calendar-days"></i></span>
                    <span>Class Routine</span>
                </a>

                <a href="{{ route('student.attendance.index') }}"
                    class="nav-item {{ request()->routeIs('student.attendance.index') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
                    <span>Attendance</span>
                </a>

                <a href="{{ route('student.attendance.insights') }}"
                    class="nav-item {{ request()->routeIs('student.attendance.insights') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-brain"></i></span>
                    <span style="flex:1">Attendance Insights</span>
                    <span class="nav-badge">AI</span>
                </a>

                <a href="{{ route('student.exams.index') }}"
                    class="nav-item {{ request()->routeIs('student.exams.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-file-pen"></i></span>
                    <span>Exam Schedule</span>
                </a>

                <a href="{{ route('student.admit-card.show') }}"
                    class="nav-item {{ request()->routeIs('student.admit-card.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-id-card"></i></span>
                    <span>Admit Card</span>
                </a>

                <a href="{{ route('student.results.index') }}"
                    class="nav-item {{ request()->routeIs('student.results.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-trophy"></i></span>
                    <span>Results</span>
                </a>

                <a href="{{ route('student.marksheet.show') }}"
                    class="nav-item {{ request()->routeIs('student.marksheet.*') ? 'active' : '' }}">
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
                    <a href="{{ route('student.report-card.download') }}" id="sidebar-report-card-link" class="nav-item"
                        style="color:#FF9F0A;">
                        <span class="nav-icon" style="background:rgba(255,159,10,0.15);color:#FF9F0A;"><i
                                class="fa-solid fa-file-pdf"></i></span>
                        <span style="flex:1">Report Card</span>
                        <span class="nav-badge" style="background:rgba(255,159,10,0.15);color:#FF9F0A;">PDF</span>
                    </a>
                @else
                    <div class="nav-item" style="opacity:0.4;cursor:not-allowed;">
                        <span class="nav-icon"><i class="fa-solid fa-file-pdf"></i></span>
                        <span style="flex:1">Report Card</span>
                        <span class="nav-badge">Soon</span>
                    </div>
                @endif

                <a href="{{ route('student.performance.index') }}"
                    class="nav-item {{ request()->routeIs('student.performance.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-arrow-trend-up"></i></span>
                    <span>Performance</span>
                </a>

                <span class="nav-section">Financials</span>

                <a href="{{ route('student.fees.index') }}"
                    class="nav-item {{ request()->routeIs('student.fees.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-credit-card"></i></span>
                    <span>My Fees</span>
                </a>

                <span class="nav-section">Tools</span>

                <a href="{{ route('studyai.index') }}"
                    class="nav-item {{ request()->routeIs('studyai.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-robot"></i></span>
                    <span style="flex:1">StudyAI</span>
                    <span class="nav-badge" style="background:rgba(175,82,222,0.12);color:#AF52DE;">AI</span>
                </a>

                <a href="{{ route('student.suggestions') }}"
                    class="nav-item {{ request()->routeIs('student.suggestions*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></span>
                    <span style="flex:1">AI Suggestions</span>
                    <span class="nav-badge" style="background:rgba(175,82,222,0.12);color:#AF52DE;">New</span>
                </a>

                <a href="{{ route('student.dashboard') }}#announcements"
                    class="nav-item {{ request()->routeIs('student.broadcast.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span>
                    <span style="flex:1">Broadcasts</span>
                    <span id="unread-broadcast-badge"
                        class="hidden items-center justify-center min-w-[20px] h-5 px-1.5 text-[9px] font-black text-white bg-violet-500 rounded-full">0</span>
                </a>

                <span class="nav-section">Campus</span>

                <a href="{{ route('student.location') }}"
                    class="nav-item {{ request()->routeIs('student.location.*') ? 'active' : '' }}">
                    <span class="nav-icon" style="color:#FF3B30;"><i class="fa-solid fa-location-crosshairs"></i></span>
                    <span style="flex:1">Family Tracker</span>
                    <span class="nav-badge"
                        style="background:rgba(255,59,48,0.10);color:#FF3B30;display:flex;align-items:center;gap:4px;">
                        <span style="width:5px;height:5px;border-radius:50%;background:#FF3B30;"
                            class="animate-pulse"></span>Live
                    </span>
                </a>

                <a href="{{ route('student.smart-id') }}"
                    class="nav-item {{ request()->routeIs('student.smart-id.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-id-badge"></i></span>
                    <span style="flex:1">Smart ID Card</span>
                    <span class="nav-badge" style="background:rgba(52,199,89,0.12);color:#34C759;">QR</span>
                </a>

                <a href="{{ route('student.emergency') }}"
                    class="nav-item {{ request()->routeIs('student.emergency.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-shield-halved"></i></span>
                    <span>Emergency Info</span>
                </a>

                <a href="{{ route('student.details') }}"
                    class="nav-item {{ request()->routeIs('student.details.*') ? 'active' : '' }}">
                    <span class="nav-icon"><i class="fa-solid fa-user"></i></span>
                    <span>My Profile</span>
                </a>

                <span class="nav-section">Help</span>

                <a href="{{ route('student.support.index') }}"
                    class="nav-item {{ request()->routeIs('student.support.*') ? 'active' : '' }}"
                    style="text-decoration:none;">
                    <span class="nav-icon" style="background:rgba(0,122,255,0.12);color:#007AFF;"><i
                            class="fa-solid fa-headset"></i></span>
                    <span style="flex:1;">Support</span>
                    <span class="nav-badge" style="background:rgba(0,122,255,0.1);color:#007AFF;">Help</span>
                </a>

            </nav>

            <!-- Footer -->
            <div class="sidebar-footer">
                <div class="user-chip">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</div>
                    <div style="overflow:hidden;flex:1;">
                        <div
                            style="font-size:0.82rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ auth()->user()->name ?? 'Student' }}</div>
                        <div style="font-size:0.6rem;color:var(--accent);font-weight:500;">Student Account</div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ═══════ MAIN ═══════ -->
        <div style="flex:1;display:flex;flex-direction:column;height:100%;overflow:hidden;background:var(--bg);">

            <!-- Header -->
            <header class="top-header">
                <div style="display:flex;align-items:center;gap:12px;">
                    <button @click="sidebarOpen = true" class="hdr-btn lg:hidden">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <div class="hidden sm:block">
                        <x-breadcrumb />
                        <h1
                            style="font-size:1.05rem;font-weight:700;color:var(--text-primary);letter-spacing:-0.02em;line-height:1.2;">
                            @yield('title')</h1>
                    </div>
                </div>

                <div style="display:flex;align-items:center;gap:10px;">

                    <!-- Notifications -->
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="hdr-btn">
                            <i class="fa-solid fa-bell"></i>
                            @if(isset($latestNotices) && $latestNotices->count() > 0)
                                <span
                                    style="position:absolute;top:8px;right:8px;width:7px;height:7px;background:#FF3B30;border-radius:50%;border:1.5px solid var(--bg);"
                                    class="animate-pulse"></span>
                            @endif
                        </button>

                        <div x-show="open" style="display:none;" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="notif-panel absolute right-0 mt-2 w-80 sm:w-[340px] z-[9999] overflow-hidden">

                            <div
                                style="padding:16px 18px 12px;border-bottom:1px solid var(--divider);display:flex;justify-content:space-between;align-items:center;">
                                <span
                                    style="font-size:0.9rem;font-weight:700;color:var(--text-primary);">Notifications</span>
                                @if(isset($latestNotices) && $latestNotices->count() > 0)
                                    <span
                                        style="font-size:0.65rem;font-weight:700;color:var(--accent);padding:3px 9px;border-radius:100px;background:var(--accent-soft);">{{ $latestNotices->count() }}
                                        New</span>
                                @endif
                            </div>

                            <div style="max-height:320px;overflow-y:auto;padding:8px;">
                                @if(isset($latestNotices) && $latestNotices->count() > 0)
                                    @foreach($latestNotices as $notice)
                                        @php $nc = ['Urgent' => '#FF3B30', 'Exam' => 'var(--accent)', 'Holiday' => '#34C759', 'General' => '#007AFF'];
                                        $cl = $nc[$notice->category] ?? $nc['General']; @endphp
                                        <a href="{{ route('student.notices.show', $notice) }}" class="notif-row"
                                            style="display:block;padding:10px 10px;text-decoration:none;border-radius:12px;margin-bottom:2px;">
                                            <div style="display:flex;gap:10px;align-items:flex-start;">
                                                <div
                                                    style="width:34px;height:34px;border-radius:10px;background:var(--border-2);display:flex;align-items:center;justify-content:center;color:{{ $cl }};flex-shrink:0;">
                                                    <i class="fa-solid fa-bullhorn" style="font-size:0.75rem;"></i>
                                                </div>
                                                <div style="flex:1;min-width:0;">
                                                    <p
                                                        style="font-size:0.8rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                                        {{ $notice->title }}</p>
                                                    <p
                                                        style="font-size:0.7rem;color:var(--text-muted);margin-top:1px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                                        {{ Str::limit($notice->content, 42) }}</p>
                                                    <p
                                                        style="font-size:0.58rem;color:var(--text-muted);margin-top:3px;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">
                                                        {{ $notice->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('student.dashboard') }}"
                                        style="display:block;text-align:center;padding:11px;font-size:0.75rem;font-weight:700;color:var(--accent);text-decoration:none;border-radius:12px;"
                                        class="notif-row">
                                        View All →
                                    </a>
                                @else
                                    <div style="padding:28px 20px;text-align:center;">
                                        <div
                                            style="width:40px;height:40px;border-radius:12px;background:var(--border-2);display:flex;align-items:center;justify-content:center;margin:0 auto 10px;color:var(--text-muted);">
                                            <i class="fa-solid fa-check"></i>
                                        </div>
                                        <p style="font-size:0.82rem;font-weight:600;color:var(--text-secondary);">All caught
                                            up!</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Divider -->
                    <div style="width:1px;height:18px;background:var(--divider);" class="hidden sm:block"></div>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="hdr-logout">
                            <i class="fa-solid fa-arrow-right-from-bracket" style="font-size:0.8rem;"></i>
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

    <!-- ═══════ MOBILE BOTTOM NAV ═══════ -->
    <div x-data="{ moreOpen: false }" class="lg:hidden">

        <div class="bottom-nav fixed bottom-0 inset-x-0 z-[60]">
            <div
                style="display:flex;justify-content:space-around;align-items:center;padding:6px 8px 10px;max-width:480px;margin:0 auto;">

                <a href="{{ route('student.dashboard') }}"
                    class="bottom-tab {{ request()->routeIs('student.dashboard') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-house"></i><span>Home</span>
                </a>
                <a href="{{ route('student.attendance.index') }}"
                    class="bottom-tab {{ request()->routeIs('student.attendance.index') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-calendar-check"></i><span>Attendance</span>
                </a>
                <a href="{{ route('student.performance.index') }}"
                    class="bottom-tab {{ request()->routeIs('student.performance.*') ? 'is-active' : '' }}">
                    <i class="fa-solid fa-chart-line"></i><span>Performance</span>
                </a>
                <a href="{{ route('studyai.index') }}"
                    class="bottom-tab {{ request()->routeIs('studyai.*') ? 'is-active' : '' }}">
                    <div style="position:relative;">
                        <i class="fa-solid fa-robot"></i>
                        <span
                            style="position:absolute;top:-3px;right:-6px;width:6px;height:6px;background:#AF52DE;border-radius:50%;border:1.5px solid var(--bg);"
                            class="animate-pulse"></span>
                    </div>
                    <span>StudyAI</span>
                </a>
                <button type="button" @click="moreOpen = true" class="bottom-tab">
                    <i class="fa-solid fa-ellipsis"></i><span>More</span>
                </button>

            </div>
        </div>

        <!-- Overlay -->
        <div x-show="moreOpen" style="display:none;" x-transition:enter="transition-opacity duration-250"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="moreOpen = false"
            class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[70]"></div>

        <!-- Drawer -->
        <div x-show="moreOpen" style="display:none;" x-transition:enter="transition transform ease-out duration-300"
            x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
            x-transition:leave="transition transform ease-in duration-250" x-transition:leave-start="translate-y-0"
            x-transition:leave-end="translate-y-full" class="more-drawer fixed bottom-0 inset-x-0 z-[80] flex flex-col"
            style="max-height:88vh;">

            <!-- Drag handle + title -->
            <div
                style="padding:14px 18px 10px;border-bottom:1px solid var(--divider);display:flex;justify-content:space-between;align-items:center;flex-shrink:0;">
                <div
                    style="position:absolute;left:50%;top:9px;transform:translateX(-50%);width:36px;height:4px;border-radius:4px;background:var(--border);">
                </div>
                <span style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-top:7px;">More</span>
                <button @click="moreOpen = false" class="hdr-btn"
                    style="width:30px;height:30px;border-radius:8px;margin-top:7px;">
                    <i class="fa-solid fa-xmark" style="font-size:0.85rem;"></i>
                </button>
            </div>

            <div style="overflow-y:auto;flex:1;padding:12px 12px 28px;">
                <p
                    style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:4px 4px 8px;">
                    Academic</p>
                <a href="{{ route('student.timetable') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#007AFF;"><i class="fa-solid fa-clock"></i></span>Class Routine</a>
                <a href="{{ route('student.exams.index') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#5856D6;"><i class="fa-solid fa-file-pen"></i></span>Exam Schedule</a>
                <a href="{{ route('student.admit-card.show') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#32ADE6;"><i class="fa-solid fa-id-card-clip"></i></span>Admit Card</a>
                <a href="{{ route('student.results.index') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#FF9F0A;"><i class="fa-solid fa-trophy"></i></span>Results</a>
                <a href="{{ route('student.marksheet.show') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#FF6B00;"><i class="fa-solid fa-file-lines"></i></span>Marksheet</a>
                @if($reportCardPublished)
                    <a href="{{ route('student.report-card.download') }}" class="drawer-row"><span class="drawer-icon"
                            style="color:#FF9F0A;"><i class="fa-solid fa-file-pdf"></i></span><span style="flex:1">Report
                            Card</span><span class="nav-badge"
                            style="background:rgba(255,159,10,0.15);color:#FF9F0A;">PDF</span></a>
                @endif

                <p
                    style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 8px;">
                    AI & Analytics</p>
                <a href="{{ route('student.attendance.insights') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#AF52DE;"><i class="fa-solid fa-lightbulb"></i></span><span
                        style="flex:1">Attendance Insights</span><span class="nav-badge"
                        style="background:rgba(175,82,222,0.12);color:#AF52DE;">AI</span></a>
                <a href="{{ route('student.suggestions') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#AF52DE;"><i class="fa-solid fa-wand-magic-sparkles"></i></span>AI Suggestions</a>

                <p
                    style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 8px;">
                    Campus</p>
                <a href="{{ route('student.dashboard') }}#announcements" class="drawer-row"><span class="drawer-icon"
                        style="color:#5856D6;"><i class="fa-solid fa-bullhorn"></i></span>Broadcasts</a>
                <a href="{{ route('student.smart-id') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#34C759;"><i class="fa-solid fa-id-badge"></i></span>Smart ID Card</a>
                <a href="{{ route('student.location') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#FF3B30;"><i class="fa-solid fa-location-crosshairs"></i></span><span
                        style="flex:1">Family Tracker</span><span
                        style="width:6px;height:6px;border-radius:50%;background:#FF3B30;"
                        class="animate-pulse"></span></a>
                <a href="{{ route('student.emergency') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#FF3B30;"><i class="fa-solid fa-shield-halved"></i></span>Emergency Info</a>

                <p
                    style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 8px;">
                    Account</p>
                <a href="{{ route('student.fees.index') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:#32ADE6;"><i class="fa-solid fa-credit-card"></i></span>My Fees</a>
                <a href="{{ route('student.details') }}" class="drawer-row"><span class="drawer-icon"
                        style="color:var(--text-secondary);"><i class="fa-solid fa-user"></i></span>My Profile</a>

                <p
                    style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 8px;">
                    Help</p>
                <a href="{{ route('student.support.index') }}" class="drawer-row" style="text-decoration:none;">
                    <span class="drawer-icon" style="color:#007AFF;"><i class="fa-solid fa-circle-question"></i></span>
                    <span style="flex:1;">Support &amp; Doubts</span>
                    <span style="font-size:0.6rem;font-weight:700;padding:2px 8px;border-radius:100px;background:rgba(0,122,255,0.1);color:#007AFF;">Help</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
                    @csrf
                    <button type="submit"
                        style="width:100%;padding:13px;border-radius:14px;background:rgba(255,59,48,0.10);font-weight:600;font-size:0.85rem;color:#FF3B30;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.18s;">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>

    <x-sweetalert />
    <x-support-modal />
</body>

</html>