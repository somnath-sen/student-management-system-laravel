<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        
        /* Page Entrance Animation */
        .animate-enter {
            animation: fadeUp 0.5s ease-out forwards;
            opacity: 0;
            transform: translateY(15px);
        }

        @keyframes fadeUp {
            to { opacity: 1; transform: translateY(0); }
        }

        /* Sidebar Link Active Glow */
        .nav-link.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.1) 0%, rgba(99, 102, 241, 0) 100%);
            border-left: 4px solid #6366f1;
            color: #818cf8;
        }
        
        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #1e293b; }
        ::-webkit-scrollbar-thumb { background: #475569; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #64748b; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'w-64' : 'w-20'" 
               class="bg-slate-900 text-white transition-all duration-300 ease-in-out flex flex-col shadow-2xl z-20">
            
            <div class="h-16 flex items-center justify-center border-b border-slate-800 transition-all">
                <div class="flex items-center gap-3 font-bold text-xl tracking-wider">
                    <div class="bg-indigo-600 p-1.5 rounded-lg">
                        <i data-lucide="graduation-cap" class="w-6 h-6 text-white"></i>
                    </div>
                    <span x-show="sidebarOpen" x-transition.opacity.duration.300ms>EduAdmin</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1">
                
                <a href="/admin/dashboard" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/dashboard') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.courses.index') }}" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/courses*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="book-open" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Courses</span>
                </a>

                <a href="{{ route('admin.subjects.index') }}" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/subjects*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="layers" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Subjects</span>
                </a>

                <a href="{{ route('admin.students.index') }}" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/students*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="users" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Students</span>
                </a>

                <a href="{{ route('admin.teachers.index') }}" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/teachers*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="briefcase" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Teachers</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/analytics*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="bar-chart-2" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Analytics</span>
                </a>

                <a href="{{ route('admin.results.index') }}" 
                   class="nav-link flex items-center gap-4 px-6 py-3 transition-all duration-200 group {{ request()->is('admin/results*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
                    <i data-lucide="clipboard-check" class="w-5 h-5 transition-transform group-hover:scale-110"></i>
                    <span x-show="sidebarOpen" class="font-medium">Publish Results</span>
                </a>

            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center gap-4 w-full px-2 py-2 text-slate-400 hover:text-red-400 transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span x-show="sidebarOpen" class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">

            <header class="h-16 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-200 flex items-center justify-between px-6 z-10">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-lg hover:bg-gray-100 text-gray-600 transition-colors">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <h1 class="text-xl font-bold text-gray-800 tracking-tight">@yield('title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center gap-4" x-data="{ open: false }">
                    <div class="relative">
                        <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-3 focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500">Administrator</p>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-indigo-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold shadow-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <i data-lucide="chevron-down" class="w-4 h-4 text-gray-400"></i>
                        </button>

                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-100 py-1 z-50">
                            
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm text-gray-500">Signed in as</p>
                                <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition-colors">
                                Profile Settings
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
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
        // Initialize Lucide Icons
        lucide.createIcons();
    </script>
</body>
</html>