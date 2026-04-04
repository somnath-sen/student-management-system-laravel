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
            <div class="glass-card px-6 py-3 rounded-2xl flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center text-amber-500 shadow-inner">
                    <i class="fa-solid fa-fire-flame-curved text-xl animate-bounce"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Login Streak</p>
                    <p class="text-xl font-black text-gray-800">{{ $stats->current_streak ?? 0 }} Days</p>
                </div>
            </div>
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

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Program & Gamification -->
            <div class="lg:col-span-1 space-y-8">
                <!-- My Program -->
                <div class="glass-card rounded-[2.5rem] overflow-hidden">
                    <div class="bg-gradient-to-br from-[#8B5CF6] to-[#D946EF] p-8 pb-12">
                        <i class="fa-solid fa-graduation-cap text-white/40 text-4xl mb-4"></i>
                        <h2 class="text-2xl font-black text-white">My Program</h2>
                        <p class="text-white/80 font-medium text-sm mt-1">{{ $course->name ?? 'Not Assigned' }}</p>
                    </div>
                    <div class="p-8 -mt-8 bg-white/90 backdrop-blur rounded-[2.5rem] border-t border-white/50">
                        <div class="space-y-4">
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Enrolled Subjects</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse($subjects as $subject)
                                    <span class="px-4 py-2 bg-[#FAFAF7] border border-gray-100 rounded-2xl text-xs font-black text-gray-700 shadow-sm">
                                        {{ $subject->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 italic text-sm">No subjects enrolled.</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Badges -->
                <div class="glass-card p-8 rounded-[2.5rem] space-y-6">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-black">Recent Badges</h2>
                        <i class="fa-solid fa-medal text-purple-400"></i>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        @php $badgeCount = 0; @endphp
                        @foreach($badges as $badge)
                            @if($badgeCount < 3)
                                <div class="flex flex-col items-center gap-2 group cursor-help" title="{{ $badge->description }}">
                                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-amber-50 to-orange-100 flex items-center justify-center text-3xl shadow-sm border border-white group-hover:rotate-12 transition-transform">
                                        {!! $badge->icon !!}
                                    </div>
                                    <span class="text-[10px] font-black text-gray-500 uppercase tracking-tighter text-center line-clamp-1">{{ $badge->name }}</span>
                                </div>
                                @php $badgeCount++; @endphp
                            @endif
                        @endforeach

                        @for($i = $badgeCount; $i < 3; $i++)
                            <div class="flex flex-col items-center gap-2 opacity-30 grayscale">
                                <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-3xl border border-dashed border-gray-300">
                                    <i class="fa-solid fa-lock text-xl text-gray-400"></i>
                                </div>
                                <span class="text-[10px] font-black text-gray-500 uppercase tracking-tighter">Locked</span>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Right Column: Subject Analytics -->
            <div class="lg:col-span-2 space-y-8">
                <div class="glass-card rounded-[2.5rem] overflow-hidden">
                    <div class="p-8 border-b border-gray-100 flex justify-between items-center">
                        <div>
                            <h2 class="text-2xl font-black">Subject Analytics</h2>
                            <p class="text-sm font-medium text-gray-400">Attendance & performance tracked per subject</p>
                        </div>
                        <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-500">
                            <i class="fa-solid fa-chart-line text-xl"></i>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="bg-gray-50/50 text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">
                                    <th class="px-8 py-4">Subject</th>
                                    <th class="px-8 py-4 text-center">Classes</th>
                                    <th class="px-8 py-4">Progress</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @forelse($subjectAttendance as $row)
                                    @php
                                        $subPercent = $row->total_classes > 0 ? round(($row->present_count / $row->total_classes) * 100) : 0;
                                        $color = $subPercent >= 75 ? '#14B8A6' : ($subPercent >= 60 ? '#FBBF24' : '#F43F5E');
                                    @endphp
                                    <tr class="group hover:bg-white/50 transition-colors">
                                        <td class="px-8 py-6">
                                            <span class="font-black text-gray-800">{{ $row->subject->name ?? 'Unknown' }}</span>
                                        </td>
                                        <td class="px-8 py-6 text-center">
                                            <span class="text-sm font-bold text-gray-500">
                                                <span class="text-gray-900">{{ $row->present_count }}</span> / {{ $row->total_classes }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-6 w-64">
                                            <div class="flex items-center gap-4">
                                                <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden">
                                                    <div class="h-full rounded-full transition-all duration-1000" style="width: {{ $subPercent }}%; background-color: {{ $color }}"></div>
                                                </div>
                                                <span class="text-xs font-black text-gray-400 w-8">{{ $subPercent }}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-8 py-12 text-center text-gray-400 font-medium">No analytics data found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Campus Feed Row -->
        <section class="glass-card rounded-[2.5rem] p-8 md:p-12 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-12 opacity-5 pointer-events-none">
                <i class="fa-solid fa-rss text-[12rem] rotate-12"></i>
            </div>
            
            <div class="flex justify-between items-center mb-10 relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500">
                        <i class="fa-solid fa-bullhorn animate-pulse"></i>
                    </div>
                    <h2 class="text-2xl font-black">Campus Feed</h2>
                </div>
                <span class="px-4 py-1 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black uppercase tracking-widest border border-rose-100">Live Updates</span>
            </div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($notices as $notice)
                    @php
                        $colors = [
                            'Urgent' => 'from-rose-500 to-pink-500',
                            'Exam' => 'from-indigo-500 to-purple-500',
                            'Holiday' => 'from-emerald-500 to-teal-500',
                            'General' => 'from-blue-500 to-cyan-500',
                        ];
                        $colorClass = $colors[$notice->category] ?? $colors['General'];
                    @endphp
                    <div class="group bg-white p-6 rounded-3xl border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 bg-gradient-to-r {{ $colorClass }} text-white rounded-lg text-[9px] font-black uppercase tracking-wider">
                                    {{ $notice->category }}
                                </span>
                                <span class="text-[10px] font-bold text-gray-400">{{ $notice->created_at->diffForHumans() }}</span>
                            </div>
                            <h3 class="text-lg font-black text-gray-800 line-clamp-1 mb-2">{{ $notice->title }}</h3>
                            <p class="text-sm text-gray-500 line-clamp-3 leading-relaxed">{{ $notice->content }}</p>
                        </div>
                        <div class="mt-6 pt-4 border-t border-gray-50 flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-xs">
                                <i class="fa-solid fa-signature"></i>
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter">By {{ $notice->author->name ?? 'Admin' }}</span>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-gray-400 italic">No campus updates at the moment.</div>
                @endforelse
            </div>
        </section>

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
    </script>
</div>
@endsection