<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FDFBF7 !important; 
        }
        
        .animate-content {
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        .nav-link.active {
            background: rgba(99, 102, 241, 0.15); 
            color: #818cf8; 
            border-right: 3px solid #6366f1;
            font-weight: 700;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <div id="edflow-loader" class="fixed inset-0 z-[99999] bg-[#FDFBF7] flex flex-col items-center justify-center transition-all duration-700 ease-in-out">
        <div class="relative w-32 h-32 flex items-center justify-center mb-4">
            <div class="absolute inset-0 border-4 border-transparent border-t-indigo-600 border-r-indigo-600 rounded-full animate-spin shadow-[0_0_15px_rgba(79,70,229,0.4)]"></div>
            <div class="absolute inset-2 border-4 border-transparent border-l-purple-600 border-b-purple-600 rounded-full animate-[spin_1.5s_linear_infinite_reverse] shadow-[0_0_15px_rgba(147,51,234,0.4)]"></div>
            
            <div class="relative w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center border border-slate-200 animate-pulse">
                <i class="fa-solid fa-graduation-cap text-3xl text-indigo-600"></i>
            </div>
        </div>
        
        <h2 class="text-xs font-black tracking-[0.3em] text-slate-500 uppercase flex items-center gap-2">
            Student Portal 
            <span class="flex gap-1">
                <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 0ms;"></span>
                <span class="w-1.5 h-1.5 bg-purple-600 rounded-full animate-bounce" style="animation-delay: 150ms;"></span>
                <span class="w-1.5 h-1.5 bg-indigo-600 rounded-full animate-bounce" style="animation-delay: 300ms;"></span>
            </span>
        </h2>
    </div>
    
    <div class="flex h-screen overflow-hidden">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col border-r border-slate-800">
            
            <div class="flex items-center justify-center h-20 border-b border-slate-800/60 bg-slate-900/50 backdrop-blur-md px-6">
                <div class="flex items-center gap-3 font-extrabold text-xl tracking-wide w-full">
                    <div class="bg-gradient-to-tr from-indigo-600 to-purple-600 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 border border-white/10">
                        <i class="fa-solid fa-graduation-cap text-white text-lg"></i>
                    </div>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">StudentPanel</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1.5 px-3">
                <a href="{{ route('student.dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.dashboard') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>

                <a href="{{ route('student.timetable') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.timetable.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-calendar-days w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Class Routine</span>
                </a>

                <a href="{{ route('student.attendance.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.attendance.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-calendar-check w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Attendance</span>
                </a>

                <a href="{{ route('student.admit-card.show') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.admit-card.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-id-card w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Admit Card</span>
                </a>

                <a href="{{ route('student.results.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.results.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-trophy w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Results</span>
                </a>

                <a href="{{ route('student.marksheet.show') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.marksheet.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-file-invoice w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Marksheet</span>
                </a>

                <a href="{{ route('student.performance.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.performance.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-arrow-trend-up w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Performance</span>
                </a>  

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Financials</p>

                <a href="{{ route('student.fees.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.fees.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-credit-card w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">My Fees</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tools</p>
                </div>
                <a href="{{ route('studyai.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('studyai.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-indigo-600/10 hover:text-indigo-400' }}">
                    <i class="fa-solid fa-robot w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-bold text-sm flex-1">StudyAI</span>
                    <span class="text-[9px] text-indigo-300 px-2 py-0.5 rounded border border-indigo-500/50 font-black tracking-wider uppercase group-hover:bg-indigo-500 group-hover:text-white transition-colors">AI</span>
                </a>

                <a href="{{ route('student.suggestions') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.suggestions*') ? 'bg-gradient-to-r from-purple-600/80 to-rose-600/80 text-white shadow-lg shadow-purple-600/30' : 'text-slate-300 hover:bg-gradient-to-r hover:from-purple-600/10 hover:to-rose-600/10 hover:text-purple-300' }}">
                    <i class="fa-solid fa-brain w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-bold text-sm flex-1">AI Suggestions</span>
                    <span class="text-[9px] bg-gradient-to-r from-purple-500 to-rose-500 text-white px-2 py-0.5 rounded font-black tracking-wider uppercase">NEW</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Settings</p>
                </div>

                <a href="{{ route('student.location') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.location.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-location-crosshairs w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Family Tracker</span>
                    <span class="flex items-center gap-1.5 text-[9px] text-rose-400 px-2 py-0.5 rounded border border-rose-500/30 font-black tracking-wider uppercase group-hover:bg-rose-500/20 transition-colors">
                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-pulse"></span> Live
                    </span>
                </a>
                
                <a href="{{ route('student.smart-id') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.smart-id.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-id-badge w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Smart ID Card</span>
                    <span class="text-[9px] text-slate-500 px-2 py-0.5 rounded border border-slate-600 font-black tracking-wider uppercase group-hover:border-emerald-500 group-hover:text-emerald-400 group-hover:bg-emerald-500/10 transition-colors">QR</span>
                </a>

                <a href="{{ route('student.emergency') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.emergency.*') ? 'active' : 'text-slate-400 hover:text-rose-400 hover:bg-rose-500/10' }}">
                    <i class="fa-solid fa-shield-halved w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Emergency Info</span>
                </a>

                <a href="{{ route('student.details') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('student.details.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-user w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">My Profile</span>
                </a>
            </nav>

            <div class="p-5 border-t border-slate-800 bg-slate-900/80">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-700 flex items-center justify-center font-bold text-white shadow-inner border border-slate-600">
                        {{ substr(auth()->user()->name ?? 'S', 0, 1) }}
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name ?? 'Student' }}</p>
                        <p class="text-xs text-indigo-400 truncate font-medium">Student Account</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FDFBF7]">

            <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-[#F0EBE1] flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0 shadow-sm">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="p-2 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-indigo-600 transition-colors lg:hidden">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight hidden sm:block">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-4 md:gap-6">
                    
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="relative p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all outline-none">
                            <i class="fa-solid fa-bell text-lg"></i>
                            @if(isset($latestNotices) && $latestNotices->count() > 0)
                                <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
                            @endif
                        </button>

                        <div x-show="open" style="display: none;"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-80 sm:w-96 bg-white rounded-2xl shadow-2xl border border-[#F0EBE1] z-50 overflow-hidden">
                            
                            <div class="px-5 py-4 border-b border-[#F0EBE1] bg-[#FDFBF7] flex justify-between items-center">
                                <h3 class="font-bold text-slate-800">Campus Alerts</h3>
                                @if(isset($latestNotices) && $latestNotices->count() > 0)
                                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100">{{ $latestNotices->count() }} New</span>
                                @endif
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto">
                                @if(isset($latestNotices) && $latestNotices->count() > 0)
                                    @foreach($latestNotices as $notice)
                                        @php
                                            $iconColors = [
                                                'Urgent' => 'bg-rose-50 text-rose-600',
                                                'Exam' => 'bg-indigo-50 text-indigo-600',
                                                'Holiday' => 'bg-emerald-50 text-emerald-600',
                                                'General' => 'bg-blue-50 text-blue-600',
                                            ];
                                            $iconClass = $iconColors[$notice->category] ?? $iconColors['General'];
                                        @endphp
                                        <a href="{{ route('student.notices.show', $notice) }}" class="block px-5 py-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group">
                                            <div class="flex gap-4">
                                                <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 {{ $iconClass }}">
                                                    <i class="fa-solid fa-bullhorn text-sm"></i>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm text-slate-800 font-bold group-hover:text-indigo-600 transition-colors truncate">{{ $notice->title }}</p>
                                                    <p class="text-xs text-slate-500 mt-1 font-medium truncate">{{ Str::limit($notice->content, 40) }}</p>
                                                    <p class="text-[10px] text-slate-400 mt-1.5 font-bold uppercase tracking-wider">{{ $notice->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('student.dashboard') }}" class="block text-center px-5 py-3 text-xs font-bold text-indigo-600 hover:bg-indigo-50 transition-colors">
                                        View All on Dashboard
                                    </a>
                                @else
                                    <div class="p-6 text-center">
                                        <div class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-2 text-slate-400">
                                            <i class="fa-solid fa-check text-lg"></i>
                                        </div>
                                        <p class="text-sm font-bold text-slate-600">No new alerts</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-2 px-4 py-2.5 text-sm font-bold text-rose-600 bg-rose-50 hover:bg-rose-100 border border-rose-100 hover:border-rose-200 rounded-xl transition-colors shadow-sm">
                            <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            <span class="hidden sm:inline">Sign Out</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="animate-content w-full h-full">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    <script>
        // Page Loader Logic
        window.addEventListener('load', function () {
            const loader = document.getElementById('edflow-loader');
            if (loader) {
                setTimeout(() => {
                    loader.style.opacity = '0';
                    loader.style.visibility = 'hidden';
                    setTimeout(() => {
                        loader.remove();
                    }, 700); 
                }, 500); 
            }
        });
    </script>
</body>
</html>