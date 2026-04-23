<x-app-layout>
    <!-- Modern Futuristic Font & Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Theme Selection Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        window.toggleTheme = function() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>

    <style>
        .dashboard-container {
            font-family: 'Outfit', sans-serif;
        }

        /* Beautiful Light & Futuristic Glassmorphism */
        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.03), inset 0 1px 0 rgba(255, 255, 255, 1);
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .dark .glass-card {
            background: rgba(24, 24, 27, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.3), inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }
        
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px -15px rgba(59, 130, 246, 0.1), inset 0 1px 0 rgba(255, 255, 255, 1);
            background: rgba(255, 255, 255, 0.9);
        }
        .dark .glass-card:hover {
            box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.6), inset 0 1px 0 rgba(255, 255, 255, 0.1);
            background: rgba(39, 39, 42, 0.8);
            border-color: rgba(255, 255, 255, 0.12);
        }

        /* Hero Banner Styling */
        .hero-banner {
            position: relative;
            background: rgba(255, 255, 255, 0.85);
            border-radius: 2.5rem;
            box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.05), inset 0 2px 0 rgba(255, 255, 255, 1);
        }
        .dark .hero-banner {
            background: rgba(15, 23, 42, 0.7);
            box-shadow: 0 20px 50px -15px rgba(0, 0, 0, 0.4), inset 0 1px 0 rgba(255, 255, 255, 0.05);
        }
        
        /* Entrance Animations */
        .fade-in-up {
            animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
            transform: translateY(30px);
        }
        @keyframes fadeInUp {
            to { opacity: 1; transform: translateY(0); }
        }
        
        /* Floating Light Orbs */
        @keyframes drift {
            0% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
            33% { transform: translate(40px, -50px) scale(1.1) rotate(10deg); }
            66% { transform: translate(-30px, 40px) scale(0.9) rotate(-5deg); }
            100% { transform: translate(0px, 0px) scale(1) rotate(0deg); }
        }
        .animate-drift { animation: drift 20s ease-in-out infinite; }
        .delay-2000 { animation-delay: 2s; }
        .delay-4000 { animation-delay: 4s; }
        
        /* Sweep Animation for Glossy Effects */
        @keyframes sweep {
            0% { transform: translateX(-150%) skewX(-15deg); }
            100% { transform: translateX(250%) skewX(-15deg); }
        }
        
        .stagger-1 { animation-delay: 0.1s; }
        .stagger-2 { animation-delay: 0.2s; }
        .stagger-3 { animation-delay: 0.3s; }
    </style>

    <!-- Floating Theme Toggle Button -->
    <button onclick="toggleTheme()" class="fixed bottom-8 right-8 z-50 w-14 h-14 rounded-full bg-white dark:bg-zinc-800 border border-gray-100 dark:border-gray-700 shadow-2xl hover:scale-110 active:scale-95 transition-all flex items-center justify-center focus:outline-none group">
        <i class="fa-solid fa-moon dark:hidden text-[22px] text-blue-500 group-hover:-rotate-12 transition-transform"></i>
        <i class="fa-solid fa-sun hidden dark:block text-[24px] text-yellow-500 group-hover:rotate-12 transition-transform"></i>
    </button>

    <!-- Main Dashboard Container -->
    <div class="dashboard-container relative w-full pt-10 pb-20 min-h-screen overflow-hidden">
        
        <!-- Deep Light-Themed Background Elements -->
        <div class="absolute inset-0 z-0 pointer-events-none">
            <!-- Super serene and bright gradient background -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-50 via-indigo-50/50 to-purple-50 dark:from-zinc-950 dark:via-slate-950 dark:to-zinc-950 transition-colors duration-700"></div>

            <!-- Glowing Light Orbs - Big, Soft, and Futuristic -->
            <div class="absolute -top-[10%] left-[10%] w-[600px] h-[600px] bg-cyan-300/40 dark:bg-cyan-600/10 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[100px] animate-drift transition-colors duration-700"></div>
            <div class="absolute bottom-[10%] right-[5%] w-[800px] h-[800px] bg-indigo-300/30 dark:bg-indigo-600/10 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[120px] animate-drift delay-2000 transition-colors duration-700"></div>
            <div class="absolute top-[30%] left-[40%] w-[500px] h-[500px] bg-purple-300/30 dark:bg-purple-600/10 rounded-full mix-blend-multiply dark:mix-blend-screen filter blur-[90px] animate-drift delay-4000 transition-colors duration-700"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10 relative z-10">
            
            <!-- Beautiful Simple Page Header -->
            <div class="flex items-center gap-5 pt-4 fade-in-up">
                <div class="w-14 h-14 rounded-full bg-white dark:bg-zinc-800 flex items-center justify-center shadow-lg shadow-blue-500/10 border border-gray-100 dark:border-white/10">
                    <i class="fa-solid fa-shapes text-blue-500 text-xl"></i>
                </div>
                <div>
                    <h2 class="font-extrabold text-3xl sm:text-4xl text-gray-800 dark:text-white tracking-tight leading-tight transition-colors">
                        Dashboard
                    </h2>
                    <p class="text-gray-500 dark:text-gray-400 font-medium text-lg transition-colors">Welcome to your portal.</p>
                </div>
            </div>

            <!-- Light & Airy Welcome Banner -->
            <div class="hero-banner overflow-hidden fade-in-up stagger-1 backdrop-blur-2xl">
                <div class="relative p-8 sm:p-12 overflow-hidden flex flex-col md:flex-row items-center justify-between gap-10">
                    
                    <div class="relative z-10 flex items-center gap-6 sm:gap-8 w-full md:w-auto">
                        
                        <!-- Simple Beautiful Avatar -->
                        <div class="relative shrink-0 group cursor-pointer" onclick="window.location.href='{{ route('profile.edit') }}'">
                            <div class="absolute inset-0 bg-blue-400 rounded-full blur-xl opacity-20 group-hover:opacity-40 transition duration-500"></div>
                            <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-white dark:bg-zinc-800 border-2 border-white dark:border-zinc-700 flex items-center justify-center shadow-[0_10px_30px_rgba(59,130,246,0.1)] overflow-hidden transition-all duration-300 group-hover:scale-105">
                                <i class="fa-solid fa-face-smile text-4xl sm:text-5xl text-blue-500/80 dark:text-blue-400 group-hover:text-blue-600 transition-colors duration-300"></i>
                            </div>
                            <!-- Online Status Dot -->
                            <div class="absolute top-2 right-2 w-5 h-5 sm:w-6 sm:h-6 rounded-full bg-emerald-400 border-4 border-white dark:border-slate-800 shadow-sm"></div>
                        </div>
                        
                        <div>
                            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-50 dark:bg-emerald-500/10 border border-emerald-100 dark:border-emerald-500/20 mb-3 transition-colors">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-widest">Online</span>
                            </div>
                            <h3 class="text-3xl sm:text-4xl font-extrabold text-gray-800 dark:text-white tracking-tight mb-2 transition-colors">
                                Hello, {{ Auth::user()->name }}
                            </h3>
                            <p class="text-gray-500 dark:text-gray-400 font-medium text-[15px] sm:text-lg leading-relaxed transition-colors max-w-md">
                                Manage your classes, view your progress, and edit your profile settings here.
                            </p>
                        </div>
                    </div>
                    
                    <div class="relative z-10 hidden md:flex flex-col items-end gap-3 shrink-0">
                        <div class="px-8 py-6 rounded-[2rem] bg-white/60 dark:bg-black/20 border border-white/80 dark:border-white/5 backdrop-blur-md flex flex-col items-center shadow-sm transition-colors duration-500 hover:bg-white dark:hover:bg-zinc-900 w-full">
                            <span class="text-[11px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-[0.2em] mb-2">Today is</span>
                            <div class="flex items-center gap-2.5 text-lg font-bold text-gray-700 dark:text-gray-200 tracking-wide transition-colors">
                                <i class="fa-regular fa-calendar-check text-blue-500"></i>
                                {{ now()->format('l, F j') }}
                            </div>
                        </div>
                        
                        <!-- Beautiful Glossy Animated Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="relative group w-full px-6 py-4 rounded-[1.5rem] font-bold text-rose-500 overflow-hidden transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm hover:shadow-[0_15px_30px_rgba(244,63,94,0.2)] border border-rose-100 dark:border-rose-900 bg-white/80 dark:bg-rose-500/10 backdrop-blur-md">
                                <div class="absolute inset-0 bg-gradient-to-r from-rose-400 to-red-500 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <div class="absolute inset-0 bg-white/40 group-hover:bg-transparent -translate-x-[150%] skew-x-[-15deg] group-hover:animate-[sweep_1s_ease-in-out_infinite]"></div>
                                <span class="relative z-10 flex items-center justify-center gap-2 group-hover:text-white transition-colors duration-300 tracking-wide">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Demonstration of Skeleton Loading System -->
            <div x-data="{ isLoading: true }" x-init="setTimeout(() => isLoading = false, 2500)" class="w-full">
                
                <!-- Skeleton UI (Shown while loading) -->
                <div x-show="isLoading" class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                    <!-- Profile Card Skeleton -->
                    <x-skeleton.card class="h-[280px]" />
                    
                    <!-- Notice Card Skeleton -->
                    <div class="md:col-span-2">
                        <x-skeleton.card class="h-[280px]" />
                    </div>
                    
                    <!-- Recent Activity Table Skeleton -->
                    <div class="md:col-span-3 mt-4">
                        <div class="mb-6 px-4">
                            <x-skeleton.text lines="1" class="w-1/4 mb-2" />
                            <x-skeleton.text lines="1" class="w-1/3 opacity-60" />
                        </div>
                        <x-skeleton.table rows="4" />
                    </div>
                </div>

                <!-- Actual Content (Shown after loading) -->
                <div x-show="!isLoading" 
                     x-transition:enter="transition ease-out duration-700 delay-100"
                     x-transition:enter-start="opacity-0 transform translate-y-8"
                     x-transition:enter-end="opacity-100 transform translate-y-0"
                     style="display: none;"
                     class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    
                    <!-- Action Card: Profile -->
                    <a href="{{ route('profile.edit') }}" class="glass-card block rounded-[2.5rem] p-8 group outline-none h-full min-h-[280px]">
                        <div class="flex flex-col h-full justify-between gap-10">
                            <div class="flex items-start justify-between">
                                <div class="w-16 h-16 rounded-full bg-blue-50 dark:bg-blue-500/10 flex items-center justify-center text-blue-500 group-hover:bg-blue-500 group-hover:text-white transition-all duration-300 shadow-inner group-hover:shadow-[0_10px_20px_rgba(59,130,246,0.3)] group-hover:scale-110">
                                    <i class="fa-solid fa-user-pen text-2xl"></i>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white dark:bg-white/5 flex items-center justify-center text-gray-400 shadow-sm group-hover:bg-blue-50 group-hover:text-blue-600 transition-all">
                                    <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform duration-300"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">My Profile</h3>
                                <p class="text-gray-500 dark:text-gray-400 font-medium text-[15px] leading-relaxed transition-colors">Update your personal information and adjust your account settings.</p>
                            </div>
                        </div>
                    </a>

                    <!-- Notice Card -->
                    <div class="md:col-span-2 glass-card rounded-[2.5rem] p-8 sm:p-10 flex flex-col justify-center relative overflow-hidden group min-h-[280px]">
                        <div class="flex flex-col md:flex-row items-center md:items-start gap-8 relative z-10 text-center md:text-left">
                            
                            <!-- Simple Icon -->
                            <div class="shrink-0 w-24 h-24 rounded-full bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center text-amber-500 shadow-inner relative overflow-hidden group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute w-full h-full bg-amber-400/20 rounded-full animate-ping opacity-30"></div>
                                <i class="fa-solid fa-clock text-4xl"></i>
                            </div>
                            
                            <div class="flex-1">
                                <div class="flex items-center justify-center md:justify-start gap-2 mb-3">
                                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                    <h4 class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-widest">Pending</h4>
                                </div>
                                
                                <h3 class="text-2xl sm:text-3xl font-bold text-gray-800 dark:text-white mb-4 tracking-tight transition-colors">
                                    Account Review
                                </h3>
                                
                                <p class="text-[16px] text-gray-500 dark:text-gray-300 font-medium leading-relaxed max-w-xl mb-8 transition-colors">
                                    Your account is currently under review by our team. Once you are approved, your classes and dashboard features will appear right here.
                                </p>

                                <div class="inline-flex items-center gap-3 px-6 py-4 rounded-full bg-white dark:bg-white/5 border border-gray-100 dark:border-white/10 shadow-sm transition-colors w-full sm:w-auto justify-center md:justify-start hover:bg-gray-50 dark:hover:bg-white/10">
                                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                                    <span class="text-sm font-semibold text-gray-600 dark:text-gray-300">Check back soon or contact support.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>