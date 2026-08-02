<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal — @yield('title', 'Control Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,400;0,14..32,500;0,14..32,600;0,14..32,700;0,14..32,800;0,14..32,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* ═══════════════════════════════════════════════════
           iOS 18 PREMIUM — ADMIN PORTAL
           Accent: #FF9F0A (iOS Orange/Amber) — Authority
        ═══════════════════════════════════════════════════ */
        :root {
            --accent:      #FF9F0A;
            --accent-2:    #FF6B00;
            --accent-rgb:  255,159,10;
            --accent-glow: rgba(255,159,10,0.35);
            --accent-soft: rgba(255,159,10,0.12);
            --r-sm: 10px; --r-md: 16px; --r-lg: 20px; --r-xl: 28px;
        }
        :root {
            --bg:          #F2F2F7;
            --bg-2:        #FFFFFF;
            --bg-3:        #E5E5EA;
            --surface:     rgba(255,255,255,0.72);
            --surface-2:   rgba(255,255,255,0.5);
            --border:      rgba(60,60,67,0.12);
            --border-2:    rgba(60,60,67,0.08);
            --text-primary:   #1C1C1E;
            --text-secondary: rgba(60,60,67,0.60);
            --text-muted:     rgba(60,60,67,0.40);
            --shadow:      0 2px 20px rgba(0,0,0,0.08), 0 1px 4px rgba(0,0,0,0.05);
            --shadow-lg:   0 8px 40px rgba(0,0,0,0.12), 0 2px 8px rgba(0,0,0,0.06);
            --divider:     rgba(60,60,67,0.10);
            --sidebar-bg:  rgba(248,248,248,0.92);
            --header-bg:   rgba(248,248,248,0.90);
            --nav-active-bg: rgba(255,159,10,0.10);
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; }
        html { height: 100%; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'SF Pro Display', sans-serif; background: var(--bg); color: var(--text-primary); -webkit-font-smoothing: antialiased; height: 100%; }
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 8px; }

        .sidebar { background: var(--sidebar-bg); backdrop-filter: blur(30px) saturate(180%); -webkit-backdrop-filter: blur(30px) saturate(180%); border-right: 1px solid var(--border); display: flex; flex-direction: column; }
        .sidebar-logo { padding: 0 18px; height: 64px; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid var(--divider); flex-shrink: 0; }
        .logo-gem { width: 38px; height: 38px; border-radius: 12px; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 14px var(--accent-glow); }
        .logo-gem i { color: #fff; font-size: 15px; }
        .logo-text { font-weight: 700; font-size: 0.95rem; color: var(--text-primary); letter-spacing: -0.025em; line-height: 1.1; }
        .logo-sub  { font-size: 0.58rem; font-weight: 500; color: var(--text-muted); letter-spacing: 0.05em; text-transform: uppercase; }
        .sidebar-nav { flex: 1; overflow-y: auto; padding: 10px 10px; scrollbar-width: none; }
        .sidebar-nav::-webkit-scrollbar { display: none; }
        .nav-section { font-size: 0.62rem; font-weight: 600; letter-spacing: 0.06em; text-transform: uppercase; color: var(--text-muted); padding: 18px 12px 6px; display: block; }
        .nav-item { display: flex; align-items: center; gap: 10px; padding: 9px 11px; border-radius: var(--r-md); color: var(--text-secondary); font-weight: 500; font-size: 0.82rem; text-decoration: none; transition: all 0.18s cubic-bezier(0.25,0.46,0.45,0.94); position: relative; margin-bottom: 2px; }
        .nav-item:hover { background: var(--border-2); color: var(--text-primary); }
        .nav-item.active { background: var(--nav-active-bg); color: var(--accent); font-weight: 600; }
        .nav-icon { width: 30px; height: 30px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; flex-shrink: 0; background: var(--border-2); transition: all 0.18s ease; color: inherit; }
        .nav-item.active .nav-icon { background: var(--accent); color: #fff; box-shadow: 0 3px 10px var(--accent-glow); }
        .nav-badge { font-size: 0.52rem; font-weight: 700; padding: 2px 7px; border-radius: 100px; background: var(--accent-soft); color: var(--accent); margin-left: auto; }
        .sidebar-footer { padding: 14px 14px; border-top: 1px solid var(--divider); flex-shrink: 0; }
        .user-chip { display: flex; align-items: center; gap: 10px; padding: 9px 11px; border-radius: var(--r-md); background: var(--border-2); }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--accent-2)); display: flex; align-items: center; justify-content: center; color: #fff; font-weight: 700; font-size: 0.85rem; flex-shrink: 0; box-shadow: 0 2px 8px var(--accent-glow); }

        .top-header { height: 60px; background: var(--header-bg); backdrop-filter: blur(30px) saturate(180%); -webkit-backdrop-filter: blur(30px) saturate(180%); border-bottom: 1px solid var(--divider); display: flex; align-items: center; justify-content: space-between; padding: 0 22px; position: sticky; top: 0; z-index: 30; flex-shrink: 0; }
        .hdr-btn { width: 36px; height: 36px; border-radius: 10px; background: var(--border-2); display: flex; align-items: center; justify-content: center; color: var(--text-secondary); cursor: pointer; transition: all 0.18s; border: none; font-size: 0.9rem; position: relative; }
        .hdr-btn:hover { background: var(--border); color: var(--text-primary); }
        .hdr-logout { display: flex; align-items: center; gap: 7px; padding: 7px 16px; border-radius: 100px; background: rgba(255,59,48,0.10); color: #FF3B30; font-size: 0.78rem; font-weight: 600; cursor: pointer; border: none; transition: all 0.18s; }
        .hdr-logout:hover { background: rgba(255,59,48,0.18); }

        .notif-panel { background: var(--surface); backdrop-filter: blur(40px) saturate(200%); -webkit-backdrop-filter: blur(40px) saturate(200%); border: 1px solid var(--border); border-radius: var(--r-xl); box-shadow: var(--shadow-lg); }
        .notif-row:hover { background: var(--border-2); border-radius: 12px; }

        .bottom-nav { background: var(--header-bg); backdrop-filter: blur(30px) saturate(180%); -webkit-backdrop-filter: blur(30px) saturate(180%); border-top: 1px solid var(--divider); }
        .bottom-tab { display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 8px; border-radius: 12px; color: var(--text-muted); font-size: 0.56rem; font-weight: 500; cursor: pointer; transition: all 0.18s; border: none; background: none; text-decoration: none; min-width: 52px; }
        .bottom-tab.is-active { color: var(--accent); }
        .bottom-tab i { font-size: 1.2rem; transition: all 0.18s; }
        .bottom-tab.is-active i { filter: drop-shadow(0 0 6px var(--accent-glow)); }

        .more-drawer { background: var(--surface); backdrop-filter: blur(40px) saturate(200%); -webkit-backdrop-filter: blur(40px) saturate(200%); border-radius: 20px 20px 0 0; border-top: 1px solid var(--border); }
        .drawer-row { display: flex; align-items: center; gap: 13px; padding: 11px 14px; border-radius: 12px; color: var(--text-secondary); font-weight: 500; font-size: 0.85rem; text-decoration: none; transition: all 0.15s; margin-bottom: 2px; }
        .drawer-row:hover { background: var(--border-2); color: var(--text-primary); }
        .drawer-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.88rem; flex-shrink: 0; background: var(--border-2); }
    </style>
</head>
<body x-data="{ sidebarOpen: false }">
<div class="flex h-screen overflow-hidden">

    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         x-transition:enter="transition-opacity duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display:none;" class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm lg:hidden"></div>

    <!-- ═══════ SIDEBAR ═══════ -->
    <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
           class="sidebar fixed inset-y-0 left-0 z-50 w-[252px] transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:inset-0">

        <div class="sidebar-logo">
            <div class="logo-gem"><i class="fa-solid fa-shield-halved"></i></div>
            <div>
                <div class="logo-text">EdFlow Admin</div>
                <div class="logo-sub">Control Panel</div>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ url('admin/dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-house"></i></span><span>Dashboard</span>
            </a>
            <a href="{{ route('admin.analytics.index') }}" class="nav-item {{ request()->is('admin/analytics*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-line"></i></span><span>Analytics</span>
            </a>
            <a href="{{ route('admin.student-analysis.index') }}" class="nav-item {{ request()->routeIs('admin.student-analysis.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chart-simple"></i></span><span>Student Analysis</span>
            </a>
            <a href="{{ route('admin.notices.index') }}" class="nav-item {{ request()->is('admin/notices*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-bullhorn"></i></span>
                <span style="flex:1">Notice Board</span>
                <span class="nav-badge" style="background:rgba(255,59,48,0.10);color:#FF3B30;">Live</span>
            </a>
            <a href="{{ route('admin.timetable.index') }}" class="nav-item {{ request()->routeIs('admin.timetable.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-plus"></i></span><span>Routine Builder</span>
            </a>
            <a href="{{ route('admin.exams.index') }}" class="nav-item {{ request()->routeIs('admin.exams.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-calendar-check"></i></span><span>Exam Calendar</span>
            </a>
            <a href="{{ route('admin.admit-card.index') }}" class="nav-item {{ request()->routeIs('admin.admit-card.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-export"></i></span><span>Admit Cards</span>
            </a>

            <span class="nav-section">Applications</span>
            <a href="{{ route('admin.registrations.index') }}" class="nav-item {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-signature"></i></span>
                <span style="flex:1">Student Regs.</span>
                @if(($pendingStudentRegistrations ?? 0) > 0)
                    <span class="nav-badge" style="background:rgba(255,159,10,0.12);color:#FF9F0A;">{{ $pendingStudentRegistrations }}</span>
                @endif
            </a>
            <a href="{{ route('admin.faculty-registrations.index') }}" class="nav-item {{ request()->routeIs('admin.faculty-registrations.*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chalkboard-teacher"></i></span>
                <span style="flex:1">Faculty Regs.</span>
                @if(($pendingFacultyRegistrations ?? 0) > 0)
                    <span class="nav-badge">{{ $pendingFacultyRegistrations }}</span>
                @endif
            </a>

            <span class="nav-section">Management</span>
            <a href="{{ route('admin.students.index') }}" class="nav-item {{ request()->is('admin/students*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-users"></i></span><span>Students</span>
            </a>
            <a href="{{ route('admin.teachers.index') }}" class="nav-item {{ request()->is('admin/teachers*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-chalkboard-user"></i></span><span>Teachers</span>
            </a>
            <a href="{{ route('admin.fees.index') }}" class="nav-item {{ request()->is('admin/fees*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-invoice-dollar"></i></span><span>Fees Management</span>
            </a>
            <a href="{{ route('admin.settings.index') }}" class="nav-item {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-gear"></i></span><span>System Settings</span>
            </a>
            <a href="{{ route('admin.telegram.index') }}" class="nav-item {{ request()->is('admin/telegram*') ? 'active' : '' }}">
                <span class="nav-icon" style="{{ request()->is('admin/telegram*') ? '' : 'color:#2AABEE' }}"><i class="fa-brands fa-telegram"></i></span>
                <span style="flex:1">Telegram Alerts</span>
                <span class="nav-badge" style="background:rgba(42,171,238,0.12);color:#2AABEE;">Bot</span>
            </a>

            <span class="nav-section">Academics</span>
            <a href="{{ route('admin.courses.index') }}" class="nav-item {{ request()->is('admin/courses*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-book-open"></i></span><span>Courses</span>
            </a>
            <a href="{{ route('admin.subjects.index') }}" class="nav-item {{ request()->is('admin/subjects*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-layer-group"></i></span><span>Subjects</span>
            </a>
            <a href="{{ route('admin.results.index') }}" class="nav-item {{ request()->is('admin/results*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-square-poll-vertical"></i></span><span>Publish Results</span>
            </a>
            <a href="{{ route('admin.report-cards.index') }}" class="nav-item {{ request()->is('admin/report-cards*') ? 'active' : '' }}">
                <span class="nav-icon"><i class="fa-solid fa-file-pdf"></i></span><span>Report Cards</span>
            </a>
            <a href="{{ route('admin.dropout-risk.index') }}" class="nav-item {{ request()->is('admin/dropout-risk*') ? 'active' : '' }}">
                <span class="nav-icon" style="{{ request()->is('admin/dropout-risk*') ? '' : 'color:#FF3B30' }}"><i class="fa-solid fa-triangle-exclamation"></i></span>
                <span style="flex:1">Dropout Risk</span>
                <span class="nav-badge" style="background:rgba(255,59,48,0.10);color:#FF3B30;">AI</span>
            </a>
            <a href="{{ route('admin.attendance-risk.index') }}" class="nav-item {{ request()->is('admin/attendance-risk*') ? 'active' : '' }}">
                <span class="nav-icon" style="{{ request()->is('admin/attendance-risk*') ? '' : 'color:#FF9F0A' }}"><i class="fa-solid fa-chart-line"></i></span>
                <span style="flex:1">Attendance Risk</span>
                <span class="nav-badge">AI</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <div class="user-chip">
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                <div style="overflow:hidden;flex:1;">
                    <div style="font-size:0.82rem;font-weight:600;color:var(--text-primary);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div style="font-size:0.6rem;color:var(--accent);font-weight:500;">Super Admin</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- ═══════ MAIN ═══════ -->
    <div style="flex:1;display:flex;flex-direction:column;height:100%;overflow:hidden;background:var(--bg);">
        <header class="top-header">
            <div style="display:flex;align-items:center;gap:12px;">
                <button @click="sidebarOpen = true" class="hdr-btn lg:hidden"><i class="fa-solid fa-bars"></i></button>
                <div class="hidden sm:block">
                    <x-breadcrumb />
                    <h1 style="font-size:1.05rem;font-weight:700;color:var(--text-primary);letter-spacing:-0.02em;line-height:1.2;">@yield('title', 'Control Panel')</h1>
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
                <!-- Date -->
                <div class="hidden md:flex" style="align-items:center;gap:7px;padding:6px 14px;border-radius:100px;background:var(--border-2);font-size:0.78rem;font-weight:500;color:var(--text-secondary);">
                    <i class="fa-regular fa-calendar" style="color:var(--accent);"></i>{{ date('d M, Y') }}
                </div>
                <!-- Bell -->
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button @click="open = !open" class="hdr-btn">
                        <i class="fa-solid fa-bell"></i>
                        <span style="position:absolute;top:8px;right:8px;width:7px;height:7px;background:#FF3B30;border-radius:50%;border:1.5px solid var(--bg);" class="animate-pulse"></span>
                    </button>
                    <div x-show="open" style="display:none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="notif-panel absolute right-0 mt-2 w-72 z-[9999] overflow-hidden">
                        <div style="padding:14px 16px 10px;border-bottom:1px solid var(--divider);display:flex;justify-content:space-between;align-items:center;">
                            <span style="font-size:0.9rem;font-weight:700;color:var(--text-primary);">System Alerts</span>
                            <span style="font-size:0.65rem;font-weight:700;color:var(--accent);padding:3px 9px;border-radius:100px;background:var(--accent-soft);">1 New</span>
                        </div>
                        <div style="padding:8px;">
                            <a href="{{ route('admin.registrations.index') }}" class="notif-row" style="display:flex;gap:10px;align-items:flex-start;padding:10px;text-decoration:none;border-radius:12px;">
                                <div style="width:34px;height:34px;border-radius:10px;background:rgba(255,59,48,0.10);display:flex;align-items:center;justify-content:center;color:#FF3B30;flex-shrink:0;"><i class="fa-solid fa-user-plus" style="font-size:0.75rem;"></i></div>
                                <div>
                                    <p style="font-size:0.8rem;font-weight:600;color:var(--text-primary);">New student registrations pending</p>
                                    <p style="font-size:0.62rem;color:var(--text-muted);margin-top:3px;font-weight:500;text-transform:uppercase;letter-spacing:0.06em;">Just now</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div style="width:1px;height:18px;background:var(--divider);" class="hidden sm:block"></div>
                <!-- Profile -->
                <div class="relative" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                    <button @click="profileOpen = !profileOpen" style="display:flex;align-items:center;gap:9px;padding:5px 10px;border-radius:100px;background:var(--border-2);border:none;cursor:pointer;transition:all 0.18s;">
                        <div class="hidden sm:block" style="text-align:right;">
                            <p style="font-size:0.8rem;font-weight:600;color:var(--text-primary);line-height:1.2;">{{ auth()->user()->name ?? 'Admin' }}</p>
                            <p style="font-size:0.58rem;font-weight:600;color:var(--accent);text-transform:uppercase;letter-spacing:0.08em;">Super Admin</p>
                        </div>
                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--accent),var(--accent-2));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.85rem;box-shadow:0 2px 8px var(--accent-glow);">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </button>
                    <div x-show="profileOpen" style="display:none;"
                         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                         class="notif-panel absolute right-0 mt-2 w-52 z-[9999] overflow-hidden py-2">
                        <div style="padding:12px 16px;border-bottom:1px solid var(--divider);margin-bottom:4px;">
                            <p style="font-size:0.58rem;font-weight:600;letter-spacing:0.1em;text-transform:uppercase;color:var(--text-muted);">Signed in as</p>
                            <p style="font-size:0.8rem;font-weight:600;color:var(--text-primary);margin-top:2px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->email ?? 'admin@edu.com' }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" style="display:flex;align-items:center;gap:9px;padding:9px 16px;font-size:0.8rem;font-weight:500;color:var(--text-secondary);text-decoration:none;" class="notif-row"><i class="fa-solid fa-gear"></i>Account Settings</a>
                        <div style="margin:4px 8px;border-top:1px solid var(--divider);"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" style="display:flex;align-items:center;gap:9px;padding:9px 16px;font-size:0.8rem;font-weight:500;color:#FF3B30;border:none;background:none;cursor:pointer;width:100%;text-align:left;" class="notif-row"><i class="fa-solid fa-arrow-right-from-bracket"></i>Sign Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main style="flex:1;overflow-y:auto;overflow-x:hidden;position:relative;" class="pb-24 lg:pb-0">
            <x-skeleton-ui />
            <div id="main-page-content" style="padding:24px;">@yield('content')</div>
        </main>
    </div>
</div>

<!-- ═══════ MOBILE BOTTOM NAV ═══════ -->
<div x-data="{ moreOpen: false }" class="lg:hidden">
    <div class="bottom-nav fixed bottom-0 inset-x-0 z-[60]">
        <div style="display:flex;justify-content:space-around;align-items:center;padding:6px 8px 10px;max-width:480px;margin:0 auto;">
            <a href="{{ route('admin.dashboard') }}" class="bottom-tab {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}"><i class="fa-solid fa-house"></i><span>Home</span></a>
            <a href="{{ route('admin.students.index') }}" class="bottom-tab {{ request()->is('admin/students*') ? 'is-active' : '' }}"><i class="fa-solid fa-users"></i><span>Students</span></a>
            <a href="{{ route('admin.courses.index') }}" class="bottom-tab {{ request()->is('admin/courses*') ? 'is-active' : '' }}"><i class="fa-solid fa-book"></i><span>Courses</span></a>
            <a href="{{ route('admin.analytics.index') }}" class="bottom-tab {{ request()->is('admin/analytics*') ? 'is-active' : '' }}"><i class="fa-solid fa-chart-line"></i><span>Analytics</span></a>
            <button type="button" @click="moreOpen = true" class="bottom-tab"><i class="fa-solid fa-ellipsis"></i><span>More</span></button>
        </div>
    </div>
    <div x-show="moreOpen" style="display:none;" x-transition:enter="transition-opacity duration-250" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition-opacity duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="moreOpen = false" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[70]"></div>
    <div x-show="moreOpen" style="display:none;" x-transition:enter="transition transform ease-out duration-300" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0" x-transition:leave="transition transform ease-in duration-250" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full" class="more-drawer fixed bottom-0 inset-x-0 z-[80] flex flex-col" style="max-height:88vh;">
        <div style="padding:14px 18px 10px;border-bottom:1px solid var(--divider);display:flex;justify-content:space-between;align-items:center;flex-shrink:0;">
            <div style="position:absolute;left:50%;top:9px;transform:translateX(-50%);width:36px;height:4px;border-radius:4px;background:var(--border);"></div>
            <span style="font-size:1rem;font-weight:700;color:var(--text-primary);margin-top:7px;">More</span>
            <button @click="moreOpen = false" class="hdr-btn" style="width:30px;height:30px;border-radius:8px;margin-top:7px;"><i class="fa-solid fa-xmark" style="font-size:0.85rem;"></i></button>
        </div>
        <div style="overflow-y:auto;flex:1;padding:12px 12px 28px;">
            <p style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:4px 4px 8px;">Management</p>
            <a href="{{ route('admin.teachers.index') }}" class="drawer-row"><span class="drawer-icon" style="color:var(--accent);"><i class="fa-solid fa-chalkboard-user"></i></span>Teachers</a>
            <a href="{{ route('admin.fees.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#34C759;"><i class="fa-solid fa-indian-rupee-sign"></i></span>Fee Collections</a>
            <a href="{{ route('admin.notices.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#5856D6;"><i class="fa-solid fa-bullhorn"></i></span>Notice Board</a>
            <p style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 8px;">AI & Insights</p>
            <a href="{{ route('admin.dropout-risk.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#FF3B30;"><i class="fa-solid fa-triangle-exclamation"></i></span><span style="flex:1">Dropout Risk AI</span><span class="nav-badge" style="background:rgba(255,59,48,0.10);color:#FF3B30;">AI</span></a>
            <a href="{{ route('admin.attendance-risk.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#FF9F0A;"><i class="fa-solid fa-chart-line"></i></span><span style="flex:1">Attendance Risk AI</span><span class="nav-badge">AI</span></a>
            <p style="font-size:0.62rem;font-weight:600;letter-spacing:0.06em;text-transform:uppercase;color:var(--text-muted);padding:14px 4px 8px;">System</p>
            <a href="{{ route('admin.telegram.index') }}" class="drawer-row"><span class="drawer-icon" style="color:#2AABEE;"><i class="fa-brands fa-telegram"></i></span><span style="flex:1">Telegram Alerts</span><span class="nav-badge" style="background:rgba(42,171,238,0.12);color:#2AABEE;">Bot</span></a>
            <a href="{{ route('admin.settings.index') }}" class="drawer-row"><span class="drawer-icon"><i class="fa-solid fa-gear"></i></span>System Settings</a>
            <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
                @csrf
                <button type="submit" style="width:100%;padding:13px;border-radius:14px;background:rgba(255,59,48,0.10);font-weight:600;font-size:0.85rem;color:#FF3B30;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all 0.18s;">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Secure Logout
                </button>
            </form>
        </div>
    </div>
</div>

<x-sweetalert />
</body>
</html>