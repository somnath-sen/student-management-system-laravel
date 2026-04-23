@extends('layouts.student')

@section('title', 'EdFlow | Student Dashboard')

@section('content')
<div 
    x-data="{ 
        count: 0, 
        target: {{ $stats->total_points ?? 0 }},
        init() {
            let start = 0;
            let duration = 2000;
            let stepTime = Math.abs(Math.floor(duration / this.target));
            if (this.target > 0) {
                let timer = setInterval(() => {
                    start += Math.ceil(this.target / 100);
                    if (start >= this.target) {
                        this.count = this.target;
                        clearInterval(timer);
                    } else {
                        this.count = start;
                    }
                }, 20);
            }
        }
    }"
    class="min-h-screen bg-[#FAFAF7] text-[#1F2937] font-sans relative overflow-hidden p-4 md:p-8"
>
    <!-- Background Decor -->
    <div class="fixed top-0 left-0 w-full h-full pointer-events-none z-0">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-[120px] opacity-30 animate-pulse"></div>
        <div class="absolute top-1/2 -right-24 w-80 h-80 bg-cyan-200 rounded-full mix-blend-multiply filter blur-[100px] opacity-30 animate-pulse" style="animation-delay: 2s;"></div>
        <div class="absolute -bottom-24 left-1/3 w-96 h-96 bg-pink-100 rounded-full mix-blend-multiply filter blur-[120px] opacity-30 animate-pulse" style="animation-delay: 4s;"></div>
    </div>

    <!-- Animated Particles (Simplified CSS) -->
    <style>
        @keyframes float {
            0% { transform: translateY(0px) translateX(0px); }
            50% { transform: translateY(-20px) translateX(10px); }
            100% { transform: translateY(0px) translateX(0px); }
        }
        .particle {
            position: absolute;
            background: linear-gradient(135deg, rgba(139, 92, 246, 0.2), rgba(6, 182, 212, 0.2));
            border-radius: 50%;
            pointer-events: none;
            z-index: 0;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.4);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.05);
        }
        .text-gradient-purple {
            background: linear-gradient(135deg, #8B5CF6, #D946EF);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .progress-gradient {
            background: linear-gradient(90deg, #8B5CF6, #06B6D4);
        }
    </style>

    <div class="max-w-7xl mx-auto relative z-10 space-y-8">
        
        <!-- Header Section -->
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-4xl font-black tracking-tight text-gray-900">
                    Welcome, <span class="text-gradient-purple">{{ $student->user->name }}</span>
                </h1>
                <p class="text-gray-500 font-medium mt-1">Ready to level up your learning journey today?</p>
            </div>
            <!-- Digital Clock + Active Status Widget -->
            <div class="glass-card px-5 py-3 rounded-2xl flex items-center gap-4 min-w-[220px]">
                <!-- Status Dot -->
                <div class="relative flex-shrink-0">
                    <div class="w-10 h-10 rounded-full bg-emerald-50 flex items-center justify-center shadow-inner">
                        <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                    </div>
                    <!-- Ping ring -->
                    <span class="absolute inset-0 rounded-full animate-ping bg-emerald-400 opacity-20"></span>
                </div>

                <div class="flex flex-col leading-tight">
                    <!-- Active label -->
                    <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.2em]">● Active Now</p>

                    <!-- Digital Clock -->
                    <div id="dashboard-clock" class="flex items-baseline gap-[2px] mt-0.5">
                        <span id="clock-hours"   class="clock-digit text-2xl font-black text-gray-800 tabular-nums">00</span>
                        <span class="text-xl font-black text-gray-400 clock-colon select-none">:</span>
                        <span id="clock-minutes" class="clock-digit text-2xl font-black text-gray-800 tabular-nums">00</span>
                        <span class="text-xl font-black text-gray-400 clock-colon select-none">:</span>
                        <span id="clock-seconds" class="clock-digit text-lg font-black text-gray-400 tabular-nums">00</span>
                        <span id="clock-ampm"    class="text-[10px] font-black text-gray-400 uppercase ml-1 self-start mt-1 tracking-wider">AM</span>
                    </div>

                    <!-- Date -->
                    <p id="clock-date" class="text-[9px] font-bold text-gray-400 uppercase tracking-widest mt-0.5"></p>
                </div>
            </div>

            <style>
                .clock-digit {
                    display: inline-block;
                    transition: opacity 0.15s ease, transform 0.15s ease;
                }
                .clock-digit.flip {
                    opacity: 0;
                    transform: translateY(-4px);
                }
                .clock-colon {
                    animation: colonBlink 1s step-end infinite;
                }
                @keyframes colonBlink {
                    0%, 100% { opacity: 1; }
                    50%       { opacity: 0.2; }
                }
            </style>

            <script>
                (function () {
                    const days   = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
                    const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

                    function setDigit(el, val) {
                        if (el.textContent !== val) {
                            el.classList.add('flip');
                            setTimeout(() => {
                                el.textContent = val;
                                el.classList.remove('flip');
                            }, 150);
                        }
                    }

                    function pad(n) { return String(n).padStart(2, '0'); }

                    function tick() {
                        const now  = new Date();
                        let   hrs  = now.getHours();
                        const min  = now.getMinutes();
                        const sec  = now.getSeconds();
                        const ampm = hrs >= 12 ? 'PM' : 'AM';
                        hrs = hrs % 12 || 12;

                        setDigit(document.getElementById('clock-hours'),   pad(hrs));
                        setDigit(document.getElementById('clock-minutes'), pad(min));
                        setDigit(document.getElementById('clock-seconds'), pad(sec));

                        const ampmEl = document.getElementById('clock-ampm');
                        if (ampmEl.textContent !== ampm) ampmEl.textContent = ampm;

                        const dateEl = document.getElementById('clock-date');
                        const dateStr = days[now.getDay()] + ', ' + months[now.getMonth()] + ' ' + now.getDate();
                        if (dateEl.textContent !== dateStr) dateEl.textContent = dateStr;
                    }

                    tick();
                    setInterval(tick, 1000);
                })();
            </script>
        </header>

        <!-- Stats Grid (Top Row) -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- XP Card -->
            <div class="glass-card p-6 rounded-3xl group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 flex items-center justify-center text-purple-600">
                        <i class="fa-solid fa-bolt-lightning text-2xl"></i>
                    </div>
                    <span class="text-xs font-black text-purple-500 bg-purple-50 px-2 py-1 rounded-lg">TOTAL XP</span>
                </div>
                <h3 class="text-4xl font-black tabular-nums" x-text="count">0</h3>
                <p class="text-sm font-bold text-gray-400 mt-1">Experience Points</p>
            </div>

            <!-- Level Card -->
            <div class="glass-card p-6 rounded-3xl group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-cyan-50 flex items-center justify-center text-cyan-600">
                        <i class="fa-solid fa-award text-2xl"></i>
                    </div>
                    <span class="text-xs font-black text-cyan-500 bg-cyan-50 px-2 py-1 rounded-lg">LEVEL</span>
                </div>
                <h3 class="text-4xl font-black">Lvl. {{ $stats->level ?? 1 }}</h3>
                <div class="mt-4 space-y-2">
                    @php
                        $nextLevelXP = ($stats->level ?? 1) * 1000;
                        $currentLevelXP = (($stats->level ?? 1) - 1) * 1000;
                        $progressXP = ($stats->total_points ?? 0) - $currentLevelXP;
                        $percentage = min(100, max(0, ($progressXP / 1000) * 100));
                    @endphp
                    <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden">
                        <div class="h-full progress-gradient transition-all duration-1000" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-[10px] font-bold text-gray-400 flex justify-between uppercase">
                        <span>{{ $progressXP }} / 1000 XP</span>
                        <span>{{ round($percentage) }}%</span>
                    </p>
                </div>
            </div>

            <!-- Attendance Rate -->
            <div class="glass-card p-6 rounded-3xl group hover:scale-[1.02] transition-transform duration-300">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <i class="fa-solid fa-calendar-check text-2xl"></i>
                    </div>
                    <span class="text-xs font-black text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">ATTENDANCE</span>
                </div>
                <h3 class="text-4xl font-black">{{ $attendancePercentage ?? 0 }}%</h3>
                <p class="text-sm font-bold text-gray-400 mt-1">Average Presence</p>
            </div>

            <!-- Current Streak -->
            <div class="glass-card p-6 rounded-3xl flex flex-col justify-between group hover:scale-[1.02] transition-transform duration-300 relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 opacity-10 group-hover:opacity-20 transition-opacity">
                    <i class="fa-solid fa-fire text-8xl text-orange-500"></i>
                </div>
                <div class="flex justify-between items-start relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-600">
                        <i class="fa-solid fa-fire-flame-simple text-2xl"></i>
                    </div>
                    <span class="text-xs font-black text-orange-500 bg-orange-50 px-2 py-1 rounded-lg">STREAK</span>
                </div>
                <div class="relative z-10 mt-4">
                    <h3 class="text-4xl font-black">{{ $stats->current_streak ?? 0 }}</h3>
                    <p class="text-sm font-bold text-gray-400 mt-1">Day Streak 🔥</p>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            
            <!-- Main Content Area (Left) -->
            <div class="xl:col-span-2 flex flex-col space-y-8">
                
                <!-- 🧠 AI Suggestions Teaser Widget -->
                <section class="relative overflow-hidden rounded-[2.5rem] group hover:shadow-2xl transition-shadow duration-500"
                         style="background: linear-gradient(135deg, rgba(124,58,237,0.05) 0%, rgba(229,0,64,0.03) 100%); border: 1px solid rgba(124,58,237,0.1); box-shadow: 0 8px 32px rgba(31,38,135,0.04);">
                    <!-- Blurred orbs -->
                    <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full opacity-20 pointer-events-none group-hover:scale-110 transition-transform duration-700" style="background: radial-gradient(circle, #7C3AED, transparent); filter: blur(40px);"></div>
                    <div class="absolute -bottom-8 -left-8 w-40 h-40 rounded-full opacity-15 pointer-events-none group-hover:scale-110 transition-transform duration-700" style="background: radial-gradient(circle, #E50040, transparent); filter: blur(40px);"></div>

                    <div class="relative z-10 p-8 flex flex-col md:flex-row items-start md:items-center gap-6">
                        <!-- Icon -->
                        <div class="shrink-0 w-16 h-16 rounded-2xl flex items-center justify-center text-3xl shadow-lg ring-4 ring-white"
                             style="background: linear-gradient(135deg, #7C3AED, #E50040);">
                             🧠
                        </div>

                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1.5">
                                <span class="text-[10px] font-black uppercase tracking-widest text-purple-600 bg-purple-50 border border-purple-100 px-2 py-0.5 rounded-full shadow-sm">AI-Powered</span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-rose-600 bg-rose-50 border border-rose-100 px-2 py-0.5 rounded-full shadow-sm">Personalized</span>
                            </div>
                            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Your AI Study Coach is Ready</h2>
                            <p class="text-gray-500 font-medium text-sm mt-1 max-w-lg leading-relaxed">
                                Get AI-powered study recommendations based on your marks, attendance, and performance trends.
                            </p>

                            @php
                                $weakCount = \App\Models\Mark::with('subject')
                                    ->whereHas('student', fn($q) => $q->where('user_id', Auth::id()))
                                    ->get()
                                    ->filter(fn($m) => $m->total_marks > 0 && ($m->marks_obtained / $m->total_marks) * 100 < 50)
                                    ->count();
                            @endphp

                            @if($weakCount > 0)
                            <div class="mt-4 inline-flex items-center gap-2 text-xs font-black text-red-600 bg-red-50 border border-red-100 px-3 py-1.5 rounded-full shadow-sm">
                                <i class="fa-solid fa-triangle-exclamation text-xs animate-pulse"></i>
                                {{ $weakCount }} subject{{ $weakCount > 1 ? 's' : '' }} need{{ $weakCount === 1 ? 's' : '' }} attention
                            </div>
                            @endif
                        </div>

                        <!-- CTA -->
                        <a href="{{ route('student.suggestions') }}"
                           class="shrink-0 inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl font-black text-sm text-white shadow-xl hover:scale-105 hover:-translate-y-1 active:scale-95 transition-all duration-300 group/cta"
                           style="background: linear-gradient(135deg, #7C3AED, #E50040); box-shadow: 0 10px 25px -5px rgba(124,58,237,0.4);">
                            <i class="fa-solid fa-brain group-hover/cta:animate-pulse"></i>
                            View My AI Plan
                            <i class="fa-solid fa-arrow-right transition-transform group-hover/cta:translate-x-1"></i>
                        </a>
                    </div>
                </section>

                <!-- Subject Analytics -->
                <div class="glass-card rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-8 border-b border-gray-100/60 flex justify-between items-center bg-white/40">
                        <div>
                            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Subject Analytics</h2>
                            <p class="text-sm font-medium text-gray-500 mt-0.5">Attendance & performance tracked per subject</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-indigo-50 to-blue-50 flex items-center justify-center text-indigo-500 shadow-sm border border-white">
                            <i class="fa-solid fa-chart-pie text-xl"></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/80 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-y border-gray-100/60">
                                    <th class="px-8 py-4">Subject</th>
                                    <th class="px-8 py-4 text-center">Classes</th>
                                    <th class="px-8 py-4">Progress Range</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50/80">
                                @forelse($subjectAttendance as $row)
                                    @php
                                        $subPercent = $row->total_classes > 0 ? round(($row->present_count / $row->total_classes) * 100) : 0;
                                        $color = $subPercent >= 75 ? 'linear-gradient(90deg, #34d399, #10b981)' : ($subPercent >= 60 ? 'linear-gradient(90deg, #fcd34d, #f59e0b)' : 'linear-gradient(90deg, #fda4af, #f43f5e)');
                                    @endphp
                                    <tr class="group hover:bg-violet-50/30 transition-colors duration-200">
                                        <td class="px-8 py-5">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400 font-bold border border-gray-100 group-hover:bg-white transition-colors">
                                                    {{ strtoupper(substr($row->subject->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <span class="font-black text-gray-700 group-hover:text-violet-700 transition-colors">{{ $row->subject->name ?? 'Unknown' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 text-center">
                                            <span class="inline-flex items-center justify-center px-3 py-1 rounded-full bg-gray-50 border border-gray-100 text-xs font-bold text-gray-500 shadow-sm group-hover:bg-white transition-colors">
                                                <span class="text-gray-900 mr-1">{{ $row->present_count }}</span> / {{ $row->total_classes }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 w-72">
                                            <div class="flex items-center gap-4">
                                                <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden shadow-inner hidden md:block">
                                                    <div class="h-full rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $subPercent }}%; background: {{ $color }}"></div>
                                                </div>
                                                <span class="text-xs font-black text-gray-500 tabular-nums w-10 text-right">{{ $subPercent }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-12 text-center">
                                            <div class="inline-flex flex-col items-center justify-center p-6 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                                                <i class="fa-solid fa-chart-bar text-3xl text-gray-300 mb-3 block"></i>
                                                <p class="text-gray-400 font-bold text-sm">No analytics data yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Campus Feed Row -->
                <section class="glass-card rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="absolute right-0 top-0 p-8 opacity-[0.03] pointer-events-none group-hover:scale-110 transition-transform duration-700">
                        <i class="fa-solid fa-satellite-dish text-[16rem] -rotate-12"></i>
                    </div>
                    
                    <div class="flex justify-between items-center mb-8 relative z-10 border-b border-gray-100/60 pb-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 flex items-center justify-center text-rose-500 shadow-sm border border-white">
                                <i class="fa-solid fa-bullhorn text-xl animate-bounce"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-black text-gray-800 tracking-tight">Campus Feed</h2>
                                <p class="text-sm font-medium text-gray-500 mt-0.5">Stay updated with latest announcements</p>
                            </div>
                        </div>
                        <span class="px-4 py-1.5 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-rose-100 shadow-sm hidden sm:inline-block relative">
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full animate-ping"></span>
                            <span class="absolute -top-1 -right-1 w-2.5 h-2.5 bg-rose-500 rounded-full"></span>
                            Live Updates
                        </span>
                    </div>

                    <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($notices as $notice)
                            @php
                                $colors = [
                                    'Urgent' => 'from-rose-500 to-pink-500 shadow-rose-200',
                                    'Exam' => 'from-violet-500 to-purple-500 shadow-violet-200',
                                    'Holiday' => 'from-emerald-400 to-teal-500 shadow-emerald-200',
                                    'General' => 'from-blue-400 to-cyan-500 shadow-blue-200',
                                ];
                                $colorClass = $colors[$notice->category] ?? $colors['General'];
                            @endphp
                            <div class="group/notice bg-white p-6 rounded-[2rem] border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-center mb-4">
                                        <span class="px-3 py-1.5 bg-gradient-to-r {{ $colorClass }} text-white rounded-xl text-[9px] font-black uppercase tracking-wider shadow-md">
                                            {{ $notice->category }}
                                        </span>
                                        <div class="flex items-center gap-1.5 text-gray-400">
                                            <i class="fa-regular fa-clock text-[10px]"></i>
                                            <span class="text-[10px] font-bold">{{ $notice->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-black text-gray-800 line-clamp-2 mb-2 leading-tight group-hover/notice:text-violet-600 transition-colors">{{ $notice->title }}</h3>
                                    <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed mb-4">{{ $notice->content }}</p>
                                </div>
                                <div class="pt-4 border-t border-gray-50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 text-xs border border-slate-100">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">By {{ $notice->author->name ?? 'Administration' }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-gray-50/50 rounded-3xl border border-dashed border-gray-200">
                                <i class="fa-solid fa-envelope-open-text text-4xl text-gray-300 mb-4"></i>
                                <p class="text-gray-400 font-bold">No campus updates at the moment.</p>
                                <p class="text-[10px] uppercase tracking-widest font-black text-gray-400 mt-2">Check back later</p>
                            </div>
                        @endforelse
                    </div>
                </section>

            </div>

            <!-- Sidebar Area (Right) -->
            <div class="xl:col-span-1 flex flex-col space-y-8">
                
                <!-- My Program -->
                <div class="glass-card rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="bg-gradient-to-br from-[#8B5CF6] to-[#D946EF] p-8 pb-14 relative overflow-hidden group">
                        <div class="absolute -right-4 -top-4 opacity-20 group-hover:scale-110 transition-transform duration-500">
                            <i class="fa-solid fa-graduation-cap text-[#fff] text-8xl"></i>
                        </div>
                        <div class="relative z-10 block">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-5 border border-white/30 shadow-inner">
                                <i class="fa-solid fa-book-open-reader text-white text-xl"></i>
                            </div>
                            <h2 class="text-[10px] font-black uppercase tracking-widest text-white/80 mb-1">My Program</h2>
                            <p class="text-xl font-black text-white leading-tight">{{ $course->name ?? 'Not Assigned' }}</p>
                        </div>
                    </div>
                    <div class="p-8 -mt-8 bg-white/95 backdrop-blur-xl rounded-[2.5rem] border-t border-gray-100 shadow-[0_-8px_30px_rgba(0,0,0,0.05)] relative z-20">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Enrolled Subjects</p>
                                <span class="text-[10px] font-black text-violet-500 bg-violet-50 px-2 py-0.5 rounded-full">{{ count($subjects) }} Total</span>
                            </div>
                            <div class="flex flex-wrap gap-2">
                                @forelse($subjects as $subject)
                                    <span class="px-4 py-2 bg-[#FAFAF7] border border-gray-100 rounded-xl text-xs font-black text-gray-700 shadow-sm hover:border-violet-200 hover:bg-violet-50 hover:text-violet-700 cursor-default transition-colors">
                                        {{ $subject->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 italic text-xs block w-full text-center py-4">No subjects enrolled.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Subject Announcements Widget --}}
                @php
                    $studentRecord = auth()->user()->student;
                @endphp
                <div id="announcements" class="glass-card rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 border-b border-gray-100/80 flex items-center justify-between bg-white/40">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-violet-50 flex items-center justify-center text-violet-600 shadow-sm border border-white">
                                <i class="fa-solid fa-bell text-lg"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-black text-gray-800 tracking-tight">Messages</h2>
                                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Teacher Broadcasts</p>
                            </div>
                        </div>
                        <span id="total-unread-badge" class="hidden items-center justify-center w-8 h-8 text-xs font-black text-white bg-red-500 rounded-full shadow-lg shadow-red-200 animate-bounce">0</span>
                    </div>
                    <div class="divide-y divide-gray-50/80">
                        @forelse($subjects as $subject)
                            @php
                                $subjectMsgCount = \App\Models\BroadcastMessage::where('subject_id', $subject->id)->count();
                                $readCount = $studentRecord ? \App\Models\MessageRead::where('student_id', $studentRecord->id)
                                    ->whereHas('message', fn($q) => $q->where('subject_id', $subject->id))
                                    ->where('seen', true)->count() : 0;
                                $unread = max(0, $subjectMsgCount - $readCount);
                            @endphp
                            <a href="{{ route('student.broadcast.index', $subject->id) }}"
                               class="flex items-center justify-between px-6 py-4.5 hover:bg-violet-50/50 transition-colors group/msg">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-violet-100 to-indigo-50 flex items-center justify-center text-violet-600 font-black text-sm shadow-sm border border-white group-hover/msg:bg-gradient-to-br group-hover/msg:from-violet-500 group-hover/msg:to-indigo-600 group-hover/msg:text-white transition-all duration-300">
                                        {{ strtoupper(substr($subject->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-black text-gray-700 group-hover/msg:text-violet-700 transition-colors">{{ $subject->name }}</p>
                                        <p class="text-[10px] text-gray-400 font-bold mt-0.5">{{ $subjectMsgCount }} announcement{{ $subjectMsgCount != 1 ? 's' : '' }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3">
                                    @if($unread > 0)
                                        <span class="subject-unread-badge flex items-center justify-center min-w-[24px] h-[24px] px-1.5 text-[10px] font-black text-white bg-violet-600 rounded-full shadow-sm ring-2 ring-violet-100"
                                              data-subject-id="{{ $subject->id }}">{{ $unread }}</span>
                                    @else
                                        <span class="subject-unread-badge text-[12px] font-bold text-emerald-400 bg-emerald-50 w-6 h-6 rounded-full flex items-center justify-center" data-subject-id="{{ $subject->id }}">✓</span>
                                    @endif
                                    <i class="fa-solid fa-chevron-right text-xs text-gray-300 group-hover/msg:text-violet-500 transition-colors group-hover/msg:translate-x-1"></i>
                                </div>
                            </a>
                        @empty
                            <div class="p-8 text-center text-gray-400 italic text-sm">No subjects enrolled.</div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Badges -->
                <div class="glass-card p-8 rounded-[2.5rem] space-y-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-center bg-transparent border-0">
                        <div>
                            <h2 class="text-xl font-black text-gray-800 tracking-tight">Recent Badges</h2>
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Achievements</p>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
                            <i class="fa-solid fa-medal"></i>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-5">
                        @php $badgeCount = 0; @endphp
                        @foreach($badges as $badge)
                            @if($badgeCount < 3)
                                <div class="flex flex-col items-center gap-3 group cursor-help" title="{{ $badge->description }}">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center text-3xl shadow-sm border border-white group-hover:rotate-[15deg] group-hover:scale-110 group-hover:shadow-lg transition-all duration-300 ring-2 ring-transparent group-hover:ring-orange-200">
                                        {!! $badge->icon !!}
                                    </div>
                                    <span class="text-[9px] font-black text-gray-600 uppercase tracking-wide text-center line-clamp-1 bg-gray-50 px-2 py-1 rounded-lg w-full">{{ $badge->name }}</span>
                                </div>
                                @php $badgeCount++; @endphp
                            @endif
                        @endforeach

                        @for($i = $badgeCount; $i < 3; $i++)
                            <div class="flex flex-col items-center gap-3 opacity-40 grayscale group">
                                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center text-2xl border border-dashed border-gray-300">
                                    <i class="fa-solid fa-lock text-gray-400 group-hover:animate-bounce"></i>
                                </div>
                                <span class="text-[9px] font-black text-gray-500 uppercase tracking-tighter w-full text-center">Locked</span>
                            </div>
                        @endfor
                    </div>
                    @if(count($badges) > 0)
                    <div class="pt-4 border-t border-gray-100 text-center">
                        <a href="#" class="text-xs font-black text-violet-600 hover:text-violet-700 uppercase tracking-widest group inline-flex items-center gap-1">
                            View All Badges <i class="fa-solid fa-arrow-right-long text-transparent group-hover:text-violet-600 -translate-x-2 group-hover:translate-x-0 transition-all opacity-0 group-hover:opacity-100"></i>
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <!-- Extra Particle Script for visual flair -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.querySelector('div[x-data]');
            for (let i = 0; i < 15; i++) {
                const p = document.createElement('div');
                p.className = 'particle';
                const size = Math.random() * 6 + 2;
                p.style.width = `${size}px`;
                p.style.height = `${size}px`;
                p.style.left = `${Math.random() * 100}%`;
                p.style.top = `${Math.random() * 100}%`;
                p.style.animation = `float ${Math.random() * 10 + 10}s linear infinite`;
                p.style.opacity = Math.random() * 0.5;
                container.appendChild(p);
            }
        });

        // ── Unread Badge Polling every 5s ──────────────────────────
        function refreshUnreadBadge() {
            fetch('{{ route("student.broadcast.unread") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(data => {
                const badge = document.getElementById('total-unread-badge');
                const navBadge = document.getElementById('unread-broadcast-badge');
                if (badge) {
                    badge.textContent = data.count;
                    badge.style.display = data.count > 0 ? 'flex' : 'none';
                }
                if (navBadge) {
                    navBadge.textContent = data.count;
                    navBadge.style.display = data.count > 0 ? 'flex' : 'none';
                }
            })
            .catch(() => {});
        }
        refreshUnreadBadge();
        setInterval(refreshUnreadBadge, 5000);
    </script>
</div>
@endsection