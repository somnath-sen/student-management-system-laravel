<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Portal - @yield('title')</title>
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
            background-color: #FDFBF7 !important; /* Creamy white background */
        }
        
        /* Smooth Content Entrance */
        .animate-content {
            animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Sidebar Active State Styling */
        .nav-link.active {
            background: rgba(99, 102, 241, 0.15); /* Indigo tint */
            color: #818cf8; /* Indigo-400 */
            border-right: 3px solid #6366f1;
            font-weight: 700;
        }

        /* Premium Scrollbar */
        /* Skeleton Shimmer Animation */
        .shimmer {
            background: #f1f5f9;
            background-image: linear-gradient(
                90deg,
                rgba(255, 255, 255, 0) 0,
                rgba(255, 255, 255, 0.6) 20%,
                rgba(255, 255, 255, 0) 40%,
                rgba(255, 255, 255, 0) 100%
            );
            background-repeat: no-repeat;
            background-size: 800px 100%;
            animation: shimmer 1.5s infinite linear forwards;
        }
        @keyframes shimmer {
            0% { background-position: -468px 0; }
            100% { background-position: 468px 0; }
        }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">


    
    <div class="flex h-screen overflow-hidden">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="hidden lg:hidden fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="hidden lg:flex fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex-col border-r border-slate-800">
            
            <div class="flex items-center justify-center h-20 border-b border-slate-800/60 bg-slate-900/50 backdrop-blur-md px-6">
                <div class="flex items-center gap-3 font-extrabold text-xl tracking-wide w-full">
                    <div class="bg-gradient-to-tr from-indigo-600 to-purple-600 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 border border-white/10">
                        <i class="fa-solid fa-chalkboard-user text-white text-lg"></i>
                    </div>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">TeacherPanel</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1.5 px-3">
                
                <a href="{{ route('teacher.dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.dashboard') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>

                <a href="{{ route('teacher.timetable') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.timetable.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-calendar-days w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">My Schedule</span>
                </a>

                <a href="{{ route('teacher.attendance.create') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.attendance.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-clipboard-user w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Mark Attendance</span>
                </a>

                <a href="{{ route('teacher.marks.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.marks.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-file-pen w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Student Marks</span>
                </a>

                <a href="{{ route('teacher.performance.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.performance.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Performance</span>
                    <span class="text-[10px] text-white px-2.5 py-0.5 rounded-full font-bold bg-gradient-to-r from-indigo-500 to-purple-500 shadow-[0_0_10px_rgba(99,102,241,0.6)] animate-pulse">NEW</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tools</p>
                </div>
                <a href="{{ route('studyai.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('studyai.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-300 hover:bg-indigo-600/10 hover:text-indigo-400' }}">
                    <i class="fa-solid fa-robot w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-bold text-sm flex-1">StudyAI</span>
                    <span class="text-[10px] text-white px-2.5 py-0.5 rounded-full font-bold bg-gradient-to-r from-indigo-500 to-purple-500 shadow-[0_0_10px_rgba(99,102,241,0.6)] animate-pulse">NEW</span>
                </a>

                <div class="pt-4 pb-2 px-4">
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-wider">Settings</p>
                </div>

                <a href="{{ route('teacher.emergency') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.emergency.*') ? 'active' : 'text-slate-400 hover:text-rose-400 hover:bg-rose-500/10' }}">
                    <i class="fa-solid fa-shield-halved w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Emergency Info</span>
                    <span class="text-[10px] text-white px-2.5 py-0.5 rounded-full font-bold bg-gradient-to-r from-rose-500 to-red-500 shadow-[0_0_10px_rgba(244,63,94,0.6)] animate-pulse">NEW</span>
                </a>

                <a href="{{ route('teacher.details') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->routeIs('teacher.details.*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-user w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">My Profile</span>
                </a>

            </nav>

            <div class="p-5 border-t border-slate-800 bg-slate-900/80">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white shadow-inner border border-indigo-400">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden flex-1">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-indigo-400 truncate font-medium">Instructor Account</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FDFBF7]">

            <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-[#F0EBE1] flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0 shadow-sm">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-indigo-600 transition-colors lg:hidden focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div class="hidden sm:flex flex-col justify-center">
                        <x-breadcrumb />
                        <h2 class="text-xl font-extrabold text-slate-900 tracking-tight leading-none">@yield('title')</h2>
                    </div>
                </div>

                <div class="flex items-center gap-4 md:gap-6">
                    
                    <div class="hidden md:flex items-center gap-2 px-4 py-2 bg-slate-50 rounded-xl shadow-sm border border-slate-200 text-sm font-bold text-slate-600">
                        <i class="fa-regular fa-calendar text-indigo-500"></i>
                        <span>{{ date('d M, Y') }}</span>
                    </div>

                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="relative p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all outline-none">
                            <i class="fa-solid fa-bell text-lg"></i>
                            <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white animate-pulse"></span>
                        </button>

                        <div x-show="open" style="display: none;"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-80 bg-white rounded-2xl shadow-2xl border border-[#F0EBE1] z-50 overflow-hidden">
                            
                            <div class="px-5 py-4 border-b border-[#F0EBE1] bg-[#FDFBF7] flex justify-between items-center">
                                <h3 class="font-bold text-slate-800">Notifications</h3>
                                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100">1 New</span>
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto">
                                <a href="#" class="block px-5 py-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group">
                                    <div class="flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-bullhorn text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-700 font-medium group-hover:text-indigo-600 transition-colors">Welcome to your new Teacher Portal!</p>
                                            <p class="text-xs text-slate-400 mt-1 font-medium">Just now</p>
                                        </div>
                                    </div>
                                </a>
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

            <main class="flex-1 overflow-x-hidden overflow-y-auto relative pb-24 lg:pb-0">
                <!-- Skeleton UI (Shown by default) -->
                <div id="skeleton-loader" class="w-full h-full p-4 md:p-8 absolute inset-0 z-10 bg-[#FAFAF7] overflow-hidden">
                    <div class="max-w-7xl mx-auto space-y-8">
                        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div class="w-1/2">
                                <x-skeleton.text lines="2" />
                            </div>
                            <div class="shimmer h-14 w-40 rounded-2xl"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <x-skeleton.card />
                            <x-skeleton.card />
                            <x-skeleton.card />
                            <x-skeleton.card />
                        </div>

                        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                            <div class="xl:col-span-2 space-y-8">
                                <x-skeleton.card class="h-48" />
                                <x-skeleton.table rows="4" />
                            </div>
                            <div class="xl:col-span-1 space-y-8">
                                <x-skeleton.card class="h-64" />
                                <x-skeleton.table rows="3" />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actual Content (Hidden by default) -->
                <div id="actual-content" style="opacity: 0; visibility: hidden;" class="animate-content w-full h-full relative z-20">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    <script>
        // Skeleton Loader Logic
        window.addEventListener('load', function () {
            const skeleton = document.getElementById('skeleton-loader');
            const content = document.getElementById('actual-content');
            
            if (skeleton && content) {
                setTimeout(() => {
                    skeleton.style.opacity = '0';
                    skeleton.style.visibility = 'hidden';
                    skeleton.style.transition = 'opacity 0.4s ease-in-out';
                    
                    content.style.visibility = 'visible';
                    content.style.opacity = '1';
                    content.style.transition = 'opacity 0.4s ease-in-out';
                    
                    setTimeout(() => skeleton.remove(), 400); 
                }, 300);
            }
        });
    </script>

    <!-- Mobile Bottom Navigation (Teacher) -->
    <div x-data="{ moreDrawerOpen: false }" class="lg:hidden">
        <!-- Bottom Nav Bar -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[calc(100%-2.5rem)] max-w-md bg-white/80 backdrop-blur-3xl border border-white/60 rounded-[2rem] z-[60] shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] overflow-hidden">
            <div class="flex justify-around items-center px-2 py-2">
                <a href="{{ route('teacher.dashboard') }}" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 {{ request()->routeIs('teacher.dashboard') ? 'text-blue-500' : 'text-slate-400 hover:text-blue-400' }}">
                    <i class="fa-solid fa-chart-pie text-xl mb-1 transition-transform {{ request()->routeIs('teacher.dashboard') ? 'scale-110 drop-shadow-md' : '' }}"></i>
                    <span class="text-[10px] font-bold">Dashboard</span>
                </a>
                
                <a href="{{ route('teacher.attendance.create') }}" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 {{ request()->routeIs('teacher.attendance.*') ? 'text-emerald-500' : 'text-slate-400 hover:text-emerald-400' }}">
                    <i class="fa-solid fa-clipboard-user text-xl mb-1 transition-transform {{ request()->routeIs('teacher.attendance.*') ? 'scale-110 drop-shadow-md' : '' }}"></i>
                    <span class="text-[10px] font-bold">Attendance</span>
                </a>

                <a href="{{ route('teacher.marks.index') }}" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 {{ request()->routeIs('teacher.marks.*') ? 'text-amber-500' : 'text-slate-400 hover:text-amber-400' }}">
                    <i class="fa-solid fa-file-pen text-xl mb-1 transition-transform {{ request()->routeIs('teacher.marks.*') ? 'scale-110 drop-shadow-md' : '' }}"></i>
                    <span class="text-[10px] font-bold">Marks</span>
                </a>

                <a href="{{ route('teacher.performance.index') }}" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 {{ request()->routeIs('teacher.performance.*') ? 'text-purple-500' : 'text-slate-400 hover:text-purple-400' }}">
                    <i class="fa-solid fa-chart-line text-xl mb-1 transition-transform {{ request()->routeIs('teacher.performance.*') ? 'scale-110 drop-shadow-md' : '' }}"></i>
                    <span class="text-[10px] font-bold">Performance</span>
                </a>

                <button type="button" @click="moreDrawerOpen = true" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] text-slate-400 hover:text-rose-500 transition-all active:scale-90 active:opacity-70">
                    <i class="fa-solid fa-layer-group text-xl mb-1"></i>
                    <span class="text-[10px] font-bold">More</span>
                </button>
            </div>
        </div>

        <!-- Slide-up Drawer Overlay -->
        <div x-show="moreDrawerOpen" style="display: none;" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="moreDrawerOpen = false"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[70]"></div>

        <!-- Slide-up Drawer Content -->
        <div x-show="moreDrawerOpen" style="display: none;"
             x-transition:enter="transition transform ease-[cubic-bezier(0.2,0.8,0.2,1)] duration-500"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition transform ease-in duration-300"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-3xl rounded-t-[2.5rem] z-[80] shadow-[0_-20px_40px_-20px_rgba(0,0,0,0.1)] overflow-hidden flex flex-col max-h-[85vh] border-t border-white/50">
            
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 z-10 bg-white/50 backdrop-blur-xl">
                <div class="absolute top-2.5 left-1/2 -translate-x-1/2 w-12 h-1.5 bg-slate-200 rounded-full"></div>
                <h3 class="font-bold text-slate-800 text-lg mt-3">More Options</h3>
                <button type="button" @click="moreDrawerOpen = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors active:scale-90">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            
            <div class="overflow-y-auto flex-1 px-4 py-4 space-y-2 pb-8">
                <a href="{{ route('teacher.timetable') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-blue-500"><i class="fa-solid fa-calendar-days"></i></div>
                    <span class="font-bold text-sm flex-1">My Schedule</span>
                </a>

                <p class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-4">Tools & AI</p>
                <a href="{{ route('studyai.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-purple-50 text-slate-700 hover:text-purple-700 transition-all active:scale-95 border border-purple-100/50">
                    <div class="w-10 h-10 rounded-xl bg-purple-500 shadow-sm flex items-center justify-center text-white"><i class="fa-solid fa-robot"></i></div>
                    <span class="font-bold text-sm flex-1">StudyAI Assistant</span>
                </a>

                <p class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-4">Settings</p>
                <a href="{{ route('teacher.emergency') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 transition-all active:scale-95 border border-rose-100">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-red-500"><i class="fa-solid fa-shield-halved"></i></div>
                    <span class="font-bold text-sm flex-1">Emergency Info</span>
                </a>
                <a href="{{ route('teacher.details') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-slate-100 text-slate-700 transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-500"><i class="fa-solid fa-user"></i></div>
                    <span class="font-bold text-sm flex-1">My Profile</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-4 mb-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-4 rounded-2xl bg-gray-900 text-white font-bold text-sm hover:bg-gray-800 transition-all active:scale-95 shadow-lg">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>
    <x-page-transition />
</body>
</html>