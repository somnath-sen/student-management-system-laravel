<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal — @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ═══════════════════════════════════════════════════
           PREMIUM NEUMORPHISM — ADMIN DESIGN TOKENS
           Accent: Indigo/Slate — Authority & Precision
        ═══════════════════════════════════════════════════ */
        :root {
            --bg:       #dde3ee;
            --bg-light: #eef1f7;
            --bg-dark:  #cdd3e0;
            --sh-dark:  #b8bece;
            --sh-light: #ffffff;
            --accent:        #4f46e5;
            --accent-2:      #6d28d9;
            --accent-glow:   rgba(79,70,229,0.25);
            --accent-soft:   rgba(79,70,229,0.10);
            --text-primary:   #1e2340;
            --text-secondary: #5a6284;
            --text-muted:     #8c94b0;
            --r-sm: 12px; --r-md: 18px; --r-lg: 24px; --r-xl: 28px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; }
        html { height: 100%; }
        body { font-family: 'Inter', 'Plus Jakarta Sans', sans-serif; background: var(--bg) !important; color: var(--text-primary); -webkit-font-smoothing: antialiased; height: 100%; }

        /* ── Sidebar ──────────────────────────────── */
        .sidebar {
            background: var(--bg);
            box-shadow: 8px 0 28px rgba(0,0,0,0.10);
            border-right: 1px solid rgba(255,255,255,0.55);
            display: flex; flex-direction: column;
        }
        .sidebar-logo {
            padding: 0 20px; height: 72px;
            display: flex; align-items: center; gap: 13px;
            border-bottom: 1px solid rgba(255,255,255,0.4);
            flex-shrink: 0;
        }
        .logo-gem {
            width: 42px; height: 42px; border-radius: 14px;
            background: linear-gradient(135deg, var(--accent), var(--accent-2));
            box-shadow: 4px 4px 12px rgba(79,70,229,0.45), -3px -3px 8px rgba(255,255,255,0.8);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .logo-gem i { color: #fff; font-size: 17px; }
        .logo-text { font-weight: 800; font-size: 1rem; color: var(--text-primary); letter-spacing: -0.02em; }
        .logo-sub  { font-weight: 600; font-size: 0.6rem; color: var(--text-muted); letter-spacing: 0.12em; text-transform: uppercase; }

        .sidebar-nav { flex: 1; overflow-y: auto; padding: 14px 12px; }
        .sidebar-nav::-webkit-scrollbar { width: 3px; }
        .sidebar-nav::-webkit-scrollbar-thumb { background: var(--sh-dark); border-radius: 4px; }

        .nav-label { font-size: 0.58rem; font-weight: 800; letter-spacing: 0.18em; text-transform: uppercase; color: var(--text-muted); padding: 20px 14px 6px; display: block; }

        .nav-item {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 13px; border-radius: var(--r-sm);
            color: var(--text-secondary); font-weight: 600; font-size: 0.8rem;
            text-decoration: none; position: relative;
            transition: all 0.22s ease; user-select: none;
        }
        .nav-item:hover { color: var(--text-primary); box-shadow: 4px 4px 10px var(--sh-dark), -4px -4px 10px var(--sh-light); background: var(--bg); }
        .nav-item.active { color: var(--accent); font-weight: 700; box-shadow: inset 4px 4px 10px var(--sh-dark), inset -4px -4px 10px var(--sh-light); background: var(--bg-dark); }
        .nav-item.active::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 52%; background: linear-gradient(180deg, var(--accent), var(--accent-2)); border-radius: 0 4px 4px 0; box-shadow: 0 0 10px var(--accent-glow); }

        .nav-icon { width: 32px; height: 32px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.78rem; flex-shrink: 0; background: var(--bg); box-shadow: 3px 3px 7px var(--sh-dark), -3px -3px 7px var(--sh-light); transition: all 0.22s ease; color: inherit; }
        .nav-item.active .nav-icon { background: linear-gradient(135deg, var(--accent), var(--accent-2)); box-shadow: 3px 3px 10px rgba(79,70,229,0.45), -2px -2px 6px rgba(255,255,255,0.8); color: #fff; }
        .nav-item:hover .nav-icon { box-shadow: 5px 5px 12px var(--sh-dark), -5px -5px 12px var(--sh-light); }

        .nav-pill { font-size: 0.55rem; font-weight: 900; letter-spacing: 0.1em; text-transform: uppercase; padding: 3px 7px; border-radius: 7px; background: var(--bg); box-shadow: inset 2px 2px 5px var(--sh-dark), inset -2px -2px 5px var(--sh-light); }

        .sidebar-footer { padding: 16px 14px; border-top: 1px solid rgba(255,255,255,0.45); background: var(--bg); flex-shrink: 0; }
        .sidebar-footer .avatar { width: 38px; height: 38px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); box-shadow: 3px 3px 9px rgba(79,70,229,0.4), -2px -2px 6px rgba(255,255,255,0.8); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 800; font-size: 0.9rem; flex-shrink: 0; }

        /* ── Header ──────────────────────────────── */
        .top-header { height: 72px; background: var(--bg); box-shadow: 0 4px 18px rgba(0,0,0,0.07); border-bottom: 1px solid rgba(255,255,255,0.55); display: flex; align-items: center; justify-content: space-between; padding: 0 28px; position: sticky; top: 0; z-index: 30; flex-shrink: 0; }
        .header-icon-btn { width: 42px; height: 42px; border-radius: 13px; background: var(--bg); box-shadow: 4px 4px 9px var(--sh-dark), -4px -4px 9px var(--sh-light); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); cursor: pointer; transition: all 0.2s; border: none; position: relative; }
        .header-icon-btn:hover { color: var(--accent); box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light); }
        .header-icon-btn:active { box-shadow: inset 3px 3px 8px var(--sh-dark), inset -3px -3px 8px var(--sh-light); }
        .header-logout { display: flex; align-items: center; gap: 8px; padding: 9px 20px; border-radius: 13px; background: var(--bg); box-shadow: 4px 4px 9px var(--sh-dark), -4px -4px 9px var(--sh-light); color: #ef4444; font-size: 0.8rem; font-weight: 700; cursor: pointer; border: none; transition: all 0.2s; }
        .header-logout:hover { box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light); }
        .header-logout:active { box-shadow: inset 3px 3px 8px var(--sh-dark), inset -3px -3px 8px var(--sh-light); }

        .notif-dropdown { background: var(--bg); box-shadow: 10px 10px 28px var(--sh-dark), -6px -6px 16px var(--sh-light); border-radius: var(--r-lg); border: 1px solid rgba(255,255,255,0.65); }
        .notif-item:hover { background: rgba(255,255,255,0.5); }

        /* ── Mobile Bottom Nav ─────────────────── */
        .bottom-nav { background: var(--bg); box-shadow: 0 -6px 24px rgba(0,0,0,0.09); border-top: 1px solid rgba(255,255,255,0.55); }
        .bottom-tab { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 9px 8px; border-radius: 14px; color: var(--text-muted); font-size: 0.58rem; font-weight: 700; cursor: pointer; transition: all 0.2s; border: none; background: none; text-decoration: none; }
        .bottom-tab.is-active { color: var(--accent); }
        .bottom-tab.is-active i { filter: drop-shadow(0 0 5px var(--accent-glow)); }
        .bottom-tab i { font-size: 1.15rem; transition: all 0.2s; }

        .side-drawer { background: var(--bg); border-radius: 28px 28px 0 0; box-shadow: 0 -12px 36px rgba(0,0,0,0.12); }
        .drawer-row { display: flex; align-items: center; gap: 14px; padding: 12px 14px; border-radius: 14px; color: var(--text-secondary); font-weight: 700; font-size: 0.85rem; text-decoration: none; transition: all 0.2s; background: var(--bg); box-shadow: 4px 4px 10px var(--sh-dark), -4px -4px 10px var(--sh-light); margin-bottom: 8px; }
        .drawer-row:hover { color: var(--accent); box-shadow: 6px 6px 14px var(--sh-dark), -6px -6px 14px var(--sh-light); }
        .drawer-icon { width: 36px; height: 36px; border-radius: 11px; display: flex; align-items: center; justify-content: center; background: var(--bg); box-shadow: inset 2px 2px 6px var(--sh-dark), inset -2px -2px 6px var(--sh-light); font-size: 0.88rem; }

        /* ── Animations ─────────────────────────── */
        @keyframes pageIn { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
        .shimmer { background: var(--bg); background-image: linear-gradient(90deg, rgba(255,255,255,0) 0, rgba(255,255,255,0.55) 35%, rgba(255,255,255,0) 65%); background-repeat: no-repeat; background-size: 900px 100%; animation: shim 1.6s infinite linear; }
        @keyframes shim { 0%{background-position:-500px 0} 100%{background-position:500px 0} }

        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--sh-dark); border-radius: 6px; }
    </style>
</head>

<body x-data="{ sidebarOpen: false }">
<div class="flex h-screen overflow-hidden">

    <!-- Mobile overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display:none;" class="fixed inset-0 z-40 bg-slate-900/30 backdrop-blur-sm lg:hidden"></div>

    <!-- ═══ SIDEBAR ════════════════════════════ -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="sidebar fixed inset-y-0 left-0 z-50 w-[260px] transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">

        <!-- Logo -->
        <div class="sidebar-logo">
            <div class="logo-gem"><i class="fa-solid fa-shield-halved"></i></div>
            <div>
                <div class="logo-text">EduAdmin</div>
                <div class="logo-sub">Control Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-label">Overview</span>

            <a href="{{ url('admin/dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-pie"></i></span>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.analytics.index') }}" class="nav-item {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span>
                <span>Analytics</span>
            </a>
            <a href="{{ route('admin.student-analysis.index') }}" class="nav-item {{ request()->routeIs('admin.student-analysis.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-simple"></i></span>
                <span>Student Analysis</span>
            </a>
            <a href="{{ route('admin.notices.index') }}" class="nav-item {{ request()->is('admin/notices*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span style="flex:1">Notice Board</span>
                <span class="nav-pill" style="color:#f43f5e;">Live</span>
            </a>
            <a href="{{ route('admin.timetable.index') }}" class="nav-item {{ request()->routeIs('admin.timetable.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-plus"></i></span>
                <span>Routine Builder</span>
            </a>
            <a href="{{ route('admin.exams.index') }}" class="nav-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span>
                <span>Exam Calendar</span>
            </a>
            <a href="{{ route('admin.admit-card.index') }}" class="nav-item {{ request()->routeIs('admin.admit-card.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-export"></i></span>
                <span>Admit Cards</span>
            </a>

            <span class="nav-label">Applications</span>

            <a href="{{ route('admin.registrations.index') }}" class="nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-signature"></i></span>
                <span style="flex:1">Student Regs.</span>
                @if(($pendingStudentRegistrations ?? 0) > 0)
                    <span class="nav-pill" style="color:#f59e0b;">{{ $pendingStudentRegistrations }}</span>
                @endif
            </a>
            <a href="{{ route('admin.faculty-registrations.index') }}" class="nav-item {{ request()->routeIs('admin.faculty-registrations.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chalkboard-teacher"></i></span>
                <span style="flex:1">Faculty Regs.</span>
                @if(($pendingFacultyRegistrations ?? 0) > 0)
                    <span class="nav-pill" style="color:var(--accent);">{{ $pendingFacultyRegistrations }}</span>
                @endif
            </a>

            <span class="nav-label">Management</span>

            <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-users"></i></span>
                <span>Students</span>
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="nav-item {{ request()->is('admin/teachers*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chalkboard-user"></i></span>
                <span>Teachers</span>
            </a>
            <a href="{{ route('admin.fees.index') }}" class="nav-item {{ request()->is('admin/fees*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
                <span>Fees Management</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-gear"></i></span>
                <span>System Settings</span>
            </a>
            <a href="{{ route('admin.telegram.index') }}" class="nav-item {{ request()->is('admin/telegram*') ? 'active' : '' }}">
                <span class="nav-icon" style="{{ request()->is('admin/telegram*') ? '' : 'color:#2AABEE' }}"><i class="fa-brands fa-telegram"></i></span>
                <span style="flex:1">Telegram Alerts</span>
                <span class="nav-pill" style="color:#2AABEE;">Bot</span>
            </a>

            <span class="nav-label">Academics</span>

            <a href="{{ route('admin.courses.index') }}" class="nav-item {{ request()->is('admin/courses*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-book-open"></i></span>
                <span>Courses</span>
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="nav-item {{ request()->is('admin/subjects*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-layer-group"></i></span>
                <span>Subjects</span>
            </a>
            <a href="{{ route('admin.results.index') }}" class="nav-item {{ request()->is('admin/results*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-square-poll-vertical"></i></span>
                <span>Publish Results</span>
            </a>
            <a href="{{ route('admin.report-cards.index') }}" class="nav-item {{ request()->is('admin/report-cards*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-pdf"></i></span>
                <span>Report Cards</span>
            </a>
            <a href="{{ route('admin.dropout-risk.index') }}" class="nav-item {{ request()->is('admin/dropout-risk*') ? 'active' : '' }}">
                <span class="nav-icon" style="{{ request()->is('admin/dropout-risk*') ? '' : 'color:#f43f5e' }}"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <span style="flex:1">Dropout Risk</span>
                <span class="nav-pill" style="color:#f43f5e;">AI</span>
            </a>
            <a href="{{ route('admin.attendance-risk.index') }}" class="nav-item {{ request()->is('admin/attendance-risk*') ? 'active' : '' }}">
                <span class="nav-icon" style="{{ request()->is('admin/attendance-risk*') ? '' : 'color:#f59e0b' }}"><i class="fa-solid fa-chart-line"></i></span>
                <span style="flex:1">Attendance Risk</span>
                <span class="nav-pill" style="color:#f59e0b;">AI</span>
            </a>

        </nav>

        <div class="sidebar-footer">
            <div style="display:flex;align-items:center;gap:12px;">
                <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div style="overflow:hidden;flex:1;">
                    <div style="font-size:0.82rem;font-weight:700;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div style="font-size:0.6rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.12em;">Super Admin</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ═══ MAIN ════════════════════════════════ -->
    <div style="flex:1;display:flex;flex-direction:column;height:100%;overflow:hidden;background:var(--bg);">

        <header class="top-header">
            <div style="display:flex;align-items:center;gap:14px;">
                <button @click="sidebarOpen = true" class="header-icon-btn lg:hidden">
                    <i class="fa-solid fa-bars" style="font-size:1rem;"></i>
                </button>
                <div class="hidden sm:block">
                    <x-breadcrumb />
                    <h1 style="font-size:1.15rem;font-weight:800;color:var(--text-primary);letter-spacing:-0.025em;line-height:1.2;">@yield('title', 'Control Panel')</h1>
                </div>
            </div>

            <div style="display:flex;align-items:center;gap:12px;">
                <!-- Date chip -->
                <div class="hidden md:flex" style="align-items:center;gap:8px;padding:8px 16px;border-radius:13px;background:var(--bg);box-shadow:4px 4px 9px var(--sh-dark),-4px -4px 9px var(--sh-light);font-size:0.78rem;font-weight:700;color:var(--text-secondary);">
                    <i class="fa-regular fa-calendar" style="color:var(--accent);"></i>
                    {{ date('d M, Y') }}
                </div>

                <!-- Bell -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="header-icon-btn">
                        <i class="fa-solid fa-bell" style="font-size:1rem;"></i>
                        <span style="position:absolute;top:9px;right:9px;width:8px;height:8px;background:#f43f5e;border-radius:50%;border:2px solid var(--bg);" class="animate-pulse"></span>
                    </button>
                    <div x-show="open" style="display:none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="notif-dropdown absolute right-0 mt-3 w-80 z-[9999] overflow-hidden">
                        <div style="padding:18px 20px 14px;border-bottom:1px solid rgba(255,255,255,0.4);display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.9rem;font-weight:800;color:var(--text-primary);">System Alerts</span>
                            <span style="font-size:0.65rem;font-weight:800;color:var(--accent);padding:3px 9px;border-radius:8px;background:var(--bg);box-shadow:2px 2px 6px var(--sh-dark),-2px -2px 6px var(--sh-light);">1 New</span>
                        </div>
                        <div style="max-height:320px;overflow-y:auto;">
                            <a href="{{ route('admin.registrations.index') }}" class="notif-item" style="display:block;padding:14px 20px;text-decoration:none;transition:background 0.15s;">
                                <div style="display:flex;gap:12px;align-items:flex-start;">
                                    <div style="width:36px;height:36px;border-radius:11px;background:var(--bg);box-shadow:3px 3px 7px var(--sh-dark),-3px -3px 7px var(--sh-light);display:flex;align-items:center;justify-content:center;color:#f43f5e;flex-shrink:0;">
                                        <i class="fa-solid fa-user-plus" style="font-size:0.75rem;"></i>
                                    </div>
                                    <div>
                                        <p style="font-size:0.82rem;font-weight:700;color:var(--text-primary);">New student registrations pending</p>
                                        <p style="font-size:0.62rem;color:var(--text-muted);margin-top:3px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Just now</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div style="width:1px;height:22px;background:rgba(0,0,0,0.1);" class="hidden sm:block"></div>

                <!-- Profile dropdown -->
                <div class="relative" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen" style="display:flex;align-items:center;gap:10px;padding:6px 10px;border-radius:14px;background:var(--bg);box-shadow:4px 4px 9px var(--sh-dark),-4px -4px 9px var(--sh-light);border:none;cursor:pointer;transition:all 0.2s;">
                        <div class="hidden sm:block" style="text-align:right;">
                            <p style="font-size:0.82rem;font-weight:800;color:var(--text-primary);line-height:1.2;">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p style="font-size:0.6rem;font-weight:700;color:var(--accent);text-transform:uppercase;letter-spacing:0.1em;">Super Admin</p>
                        </div>
                        <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-2));box-shadow:3px 3px 8px rgba(79,70,229,0.4);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:0.9rem;">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                        <i class="fa-solid fa-chevron-down hidden sm:block" style="font-size:0.7rem;color:var(--text-muted);"></i>
                    </button>

                    <div x-show="profileOpen" style="display:none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="notif-dropdown absolute right-0 mt-3 w-56 z-[9999] overflow-hidden py-2">
                        <div style="padding:14px 18px;border-bottom:1px solid rgba(255,255,255,0.4);margin-bottom:4px;">
                            <p style="font-size:0.6rem;font-weight:900;letter-spacing:0.14em;text-transform:uppercase;color:var(--text-muted);">Signed in as</p>
                            <p style="font-size:0.8rem;font-weight:700;color:var(--text-primary);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->email ?? 'admin@edu.com' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:10px;padding:10px 18px;font-size:0.8rem;font-weight:700;color:var(--text-secondary);text-decoration:none;transition:background 0.15s;" class="notif-item">
                            <i class="fa-solid fa-gear" style="font-size:0.82rem;"></i> Account Settings
                        </a>
                        <div style="margin:4px 0;border-top:1px solid rgba(255,255,255,0.4);"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display:flex;align-items:center;gap:10px;padding:10px 18px;font-size:0.8rem;font-weight:700;color:#ef4444;border:none;background:none;cursor:pointer;width:100%;text-align:left;transition:background 0.15s;" class="notif-item">
                                <i class="fa-solid fa-arrow-right-from-bracket" style="font-size:0.82rem;"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main style="flex:1;overflow-y:auto;overflow-x:hidden;position:relative;" class="pb-24 lg:pb-0">
            <x-skeleton-ui />
            <div id="main-page-content" style="padding:28px;">@yield('content')</div>
        </main>

    </div>
</div>

<!-- ═══ MOBILE BOTTOM NAV ════════════════════ -->
<div x-data="{ moreOpen: false }" class="lg:hidden">
    <div class="bottom-nav fixed bottom-0 inset-x-0 z-[60]">
        <div style="display:flex;justify-content:space-around;align-items:center;padding:8px 12px;max-width:480px;margin:0 auto;">
            <a href="{{ route('admin.dashboard') }}" class="bottom-tab {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.students.index') }}" class="bottom-tab {{ request()->is('admin/students*') ? 'is-active' : '' }}">
                <i class="fa-solid fa-users"></i><span>Students</span>
            </a>
            <a href="{{ route('admin.courses.index') }}" class="bottom-tab {{ request()->is('admin/courses*') ? 'is-active' : '' }}">
                <i class="fa-solid fa-book"></i><span>Courses</span>
            </a>
            <a href="{{ route('admin.analytics.index') }}" class="bottom-tab {{ request()->is('admin/analytics*') ? 'is-active' : '' }}">
                <i class="fa-solid fa-chart-line"></i><span>Analytics</span>
            </a>
            <button type="button" @click="moreOpen = true" class="bottom-tab">
                <i class="fa-solid fa-grid-2"></i><span>More</span>
            </button>
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
            <button @click="moreOpen = false" class="header-icon-btn" style="width:32px;height:32px;border-radius:10px;margin-top:8px;">
                <i class="fa-solid fa-xmark" style="font-size:0.85rem;"></i>
            </button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:14px 14px 24px;">
            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:4px 4px 10px;">Management</p>
            <a href="{{ route('admin.teachers.index') }}"      class="drawer-row"><span class="drawer-icon" style="color:var(--accent);"><i class="fa-solid fa-chalkboard-user"></i></span>Teachers</a>
            <a href="{{ route('admin.exams.index') }}"         class="drawer-row"><span class="drawer-icon" style="color:#0ea5e9;"><i class="fa-solid fa-calendar-days"></i></span>Exam Calendar</a>
            <a href="{{ route('admin.fees.index') }}"          class="drawer-row"><span class="drawer-icon" style="color:#f59e0b;"><i class="fa-solid fa-indian-rupee-sign"></i></span>Fee Collections</a>
            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:16px 4px 10px;">AI & Insights</p>
            <a href="{{ route('admin.dropout-risk.index') }}"  class="drawer-row"><span class="drawer-icon" style="color:#f43f5e;"><i class="fa-solid fa-triangle-exclamation"></i></span><span style="flex:1">Dropout Risk AI</span><span style="font-size:0.55rem;font-weight:900;color:#f43f5e;padding:2px 7px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">AI</span></a>
            <a href="{{ route('admin.attendance-risk.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#f97316;"><i class="fa-solid fa-chart-line"></i></span><span style="flex:1">Attendance Risk AI</span><span style="font-size:0.55rem;font-weight:900;color:#f97316;padding:2px 7px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">AI</span></a>
            <p style="font-size:0.6rem;font-weight:800;letter-spacing:0.16em;text-transform:uppercase;color:var(--text-muted);padding:16px 4px 10px;">System</p>
            <a href="{{ route('admin.notices.index') }}"       class="drawer-row"><span class="drawer-icon" style="color:#8b5cf6;"><i class="fa-solid fa-bullhorn"></i></span>Notice Board</a>
            <a href="{{ route('admin.telegram.index') }}"      class="drawer-row"><span class="drawer-icon" style="color:#2AABEE;"><i class="fa-brands fa-telegram"></i></span><span style="flex:1">Telegram Alerts</span><span style="font-size:0.55rem;font-weight:900;color:#2AABEE;padding:2px 7px;border-radius:6px;background:var(--bg);box-shadow:inset 2px 2px 5px var(--sh-dark),inset -2px -2px 5px var(--sh-light);">Bot</span></a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:14px;">
                @csrf
                <button type="submit" style="width:100%;padding:14px;border-radius:16px;background:var(--bg);box-shadow:4px 4px 10px var(--sh-dark),-4px -4px 10px var(--sh-light);font-weight:800;font-size:0.85rem;color:#ef4444;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.2s;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Secure Logout
                </button>
            </form>
        </div>
    </div>
</div>

<x-sweetalert />
</body>
</html>