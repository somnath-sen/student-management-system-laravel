<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Student Portal - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Smooth Fade In Animation for Content */
        .animate-enter {
            animation: fadeUp 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
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
        }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-30 w-64 bg-slate-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col">
            
            <div class="flex items-center justify-center h-16 border-b border-slate-800 bg-slate-900">
                <div class="flex items-center gap-3 font-bold text-xl tracking-wide">
                    <div class="bg-indigo-600 p-1.5 rounded-lg shadow-lg shadow-indigo-500/30">
                        <i data-lucide="graduation-cap" class="w-6 h-6 text-white"></i>
                    </div>
                    <span>StudentPanel</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1">
                
                <a href="{{ route('student.dashboard') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/dashboard') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('student.attendance.index') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/attendance*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="calendar-check" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">Attendance</span>
                </a>

                <a href="{{ route('student.results.index') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/results*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="trophy" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">Results</span>
                </a>

                <a href="{{ route('student.marksheet.show') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/marksheet*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="file-text" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">Marksheet</span>
                </a>

                <a href="{{ route('student.performance.index') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/performance*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="bar-chart-2" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">Performance</span>
                </a>  

            
                <a href="{{ route('student.emergency') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/emergency*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="shield-alert" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">Emergency Assistance</span>
                </a>
 

                <a href="{{ route('student.details') }}" 
                   class="nav-link flex items-center gap-3 px-6 py-3.5 transition-all duration-200 group {{ request()->is('student/details*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="user-circle" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span class="font-medium">My Profile</span>
                </a>

            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-900/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-500 flex items-center justify-center font-bold text-white shadow-md">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="overflow-hidden">
                        <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-slate-400 truncate">Student</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden">

            <header class="h-16 bg-white/80 backdrop-blur-md border-b border-gray-200 flex items-center justify-between px-6 z-10 sticky top-0">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="p-2 rounded-md text-gray-600 hover:bg-gray-100 lg:hidden">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h2 class="text-xl font-bold text-gray-800 tracking-tight">@yield('title')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <button class="relative p-2 text-gray-400 hover:text-indigo-600 transition-colors">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-red-600 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                <div class="animate-enter max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>

        </div>

    </div>

    <script>
        // Initialize Icons
        lucide.createIcons();
    </script>
</body>
</html>