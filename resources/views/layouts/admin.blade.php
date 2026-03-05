<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Portal - @yield('title')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #FDFBF7 !important; /* Creamy white background globally */
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
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body class="text-slate-800 antialiased selection:bg-indigo-500 selection:text-white" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity 
             class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 shadow-2xl flex flex-col border-r border-slate-800">
            
            <div class="flex items-center justify-center h-20 border-b border-slate-800/60 bg-slate-900/50 backdrop-blur-md px-6">
                <div class="flex items-center gap-3 font-extrabold text-xl tracking-wide w-full">
                    <div class="bg-gradient-to-tr from-indigo-600 to-purple-600 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/30 border border-white/10">
                        <i class="fa-solid fa-shield-halved text-white text-lg"></i>
                    </div>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-slate-300">EduAdmin</span>
                </div>
            </div>

            <nav class="flex-1 overflow-y-auto py-6 space-y-1.5 px-3">
                
                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-2">Overview</p>

                <a href="{{ url('admin/dashboard') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/dashboard') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-pie w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Dashboard</span>
                </a>

                <a href="{{ route('admin.analytics.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/analytics*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chart-line w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Analytics</span>
                    <span class="text-[10px] text-white px-2.5 py-0.5 rounded-full font-bold bg-gradient-to-r from-indigo-500 to-purple-500 shadow-[0_0_10px_rgba(99,102,241,0.6)] animate-pulse">NEW</span>
                </a>

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Management</p>

                <a href="{{ route('admin.students.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/students*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-users w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Students</span>
                </a>

                <a href="{{ route('admin.teachers.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/teachers*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-chalkboard-user w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Teachers</span>
                </a>

                <p class="px-4 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 mt-6">Academics</p>

                <a href="{{ route('admin.courses.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/courses*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-book-open w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Courses</span>
                </a>

                <a href="{{ route('admin.subjects.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/subjects*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-layer-group w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm">Subjects</span>
                </a>

                <a href="{{ route('admin.results.index') }}" class="nav-link flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 group {{ request()->is('admin/results*') ? 'active' : 'text-slate-400 hover:text-white hover:bg-slate-800/50' }}">
                    <i class="fa-solid fa-square-poll-vertical w-5 text-center transition-transform group-hover:scale-110"></i>
                    <span class="font-semibold text-sm flex-1">Publish Results</span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px] opacity-50"></i>
                </a>

            </nav>

            <div class="p-4 border-t border-slate-800 bg-slate-900/80">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="flex items-center justify-center gap-2 w-full px-4 py-3 text-sm font-bold text-rose-400 bg-rose-500/10 hover:bg-rose-500/20 rounded-xl transition-colors border border-rose-500/20">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Secure Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-[#FDFBF7]">

            <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-[#F0EBE1] flex items-center justify-between px-6 lg:px-10 z-10 sticky top-0 shadow-sm">
                
                <div class="flex items-center gap-4">
                    <button @click="sidebarOpen = true" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-indigo-600 transition-colors lg:hidden focus:outline-none">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-xl font-extrabold text-slate-900 tracking-tight hidden sm:block">@yield('title', 'Control Panel')</h2>
                </div>

                <div class="flex items-center gap-3 md:gap-5">
                    
                    <div class="hidden md:flex items-center gap-2 px-4 py-2.5 bg-slate-50 rounded-xl shadow-sm border border-slate-200 text-sm font-bold text-slate-600">
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
                                <h3 class="font-bold text-slate-800">System Alerts</h3>
                                <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-md border border-indigo-100">1 New</span>
                            </div>
                            
                            <div class="max-h-80 overflow-y-auto">
                                <a href="#" class="block px-5 py-4 hover:bg-slate-50 border-b border-slate-50 transition-colors group">
                                    <div class="flex gap-3">
                                        <div class="w-8 h-8 rounded-full bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0">
                                            <i class="fa-solid fa-user-plus text-sm"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm text-slate-700 font-medium group-hover:text-indigo-600 transition-colors">3 new student registrations require your approval.</p>
                                            <p class="text-xs text-slate-400 mt-1 font-medium">10 mins ago</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="h-6 w-px bg-slate-200 mx-1"></div>

                    <div class="relative" x-data="{ profileOpen: false }" @click.outside="profileOpen = false">
                        <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 p-1.5 rounded-xl hover:bg-slate-50 transition-colors focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p class="text-sm font-extrabold text-slate-800 leading-tight">{{ auth()->user()->name ?? 'Admin' }}</p>
                                <p class="text-xs font-medium text-indigo-500">Super Admin</p>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black shadow-md border border-indigo-500">
                                {{ isset(auth()->user()->name) ? substr(auth()->user()->name, 0, 1) : 'A' }}
                            </div>
                            <i class="fa-solid fa-chevron-down text-xs text-slate-400 ml-1 hidden sm:block"></i>
                        </button>

                        <div x-show="profileOpen" style="display: none;"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                             class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-[#F0EBE1] z-50 overflow-hidden py-2">
                            
                            <div class="px-5 py-3 border-b border-[#F0EBE1] mb-2">
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Signed in as</p>
                                <p class="text-sm font-bold text-slate-900 truncate mt-1">{{ auth()->user()->email ?? 'admin@edflow.com' }}</p>
                            </div>
                            
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-5 py-2.5 text-sm font-bold text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 transition-colors">
                                <i class="fa-solid fa-gear w-4 text-center"></i> Account Settings
                            </a>
                            
                            <div class="border-t border-[#F0EBE1] my-2"></div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="flex w-full items-center gap-3 px-5 py-2.5 text-sm font-bold text-rose-600 hover:bg-rose-50 transition-colors text-left">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4 text-center"></i> Sign Out
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="animate-content w-full h-full p-4 sm:p-6 lg:p-8">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

</body>
</html>