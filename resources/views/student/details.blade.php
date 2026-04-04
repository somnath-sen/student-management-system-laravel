@extends('layouts.student')

@section('title', 'My Profile')

@section('content')

<!-- Import Cool Modern Font: Outfit -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ================= DYNAMIC VIBRANT BACKGROUND ================= */
    body {
        background: linear-gradient(-45deg, #fceadd, #f8b195, #f67280, #c06c84, #6c5b7b, #355c7d);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        font-family: 'Outfit', sans-serif !important;
        position: relative;
    }

    body::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.4); /* Lightens the gradient softly */
        z-index: -1;
        pointer-events: none;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* Core Animations */
    @keyframes bounceInUp {
        0% { opacity: 0; transform: translateY(40px) scale(0.9); }
        70% { transform: translateY(-10px) scale(1.02); opacity: 1; }
        100% { transform: translateY(0) scale(1); opacity: 1; }
    }

    .animate-enter {
        animation: bounceInUp 0.8s cubic-bezier(0.25, 1, 0.5, 1) forwards;
        opacity: 0;
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.25s; }
    .stagger-3 { animation-delay: 0.4s; }

    /* Super Glassmorphism Panels */
    .glass-card {
        background: rgba(255, 255, 255, 0.65);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border: 1px solid rgba(255, 255, 255, 0.8);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(255, 255, 255, 0.5) inset;
        border-radius: 28px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.12), 0 1px 3px rgba(255, 255, 255, 0.8) inset;
        background: rgba(255, 255, 255, 0.85);
    }

    /* Vibrant Text Gradients */
    .text-vibrant {
        background: linear-gradient(135deg, #FF6B6B 0%, #a21caf 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #a21caf; /* Fallback */
    }

    .text-blue-glow {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Pulse Bubbles Floating Background */
    .bubble {
        position: absolute;
        border-radius: 50%;
        filter: blur(40px);
        z-index: -1;
        animation: float 10s infinite ease-in-out alternate;
    }
    .b-1 { width: 300px; height: 300px; background: rgba(59, 130, 246, 0.3); top: -100px; left: -100px; }
    .b-2 { width: 400px; height: 400px; background: rgba(236, 72, 153, 0.2); bottom: -100px; right: -100px; animation-duration: 14s; }
    .b-3 { width: 250px; height: 250px; background: rgba(16, 185, 129, 0.2); top: 40%; left: 30%; animation-duration: 12s; }

    @keyframes float {
        100% { transform: translateY(40px) scale(1.1); }
    }

    /* Pop Buttons */
    .btn-pop {
        background: linear-gradient(135deg, #6366f1 0%, #ec4899 100%);
        border: none;
        color: white;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 10px 20px rgba(236, 72, 153, 0.3);
    }
    .btn-pop:hover {
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 15px 25px rgba(236, 72, 153, 0.5);
    }

    /* =========== GAMIFICATION STATS =========== */
    .gami-card {
        position: relative;
        border-radius: 24px;
        padding: 1.5rem;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid rgba(255,255,255,0.6);
        cursor: default;
    }
    .gami-card:hover {
        transform: translateY(-6px) scale(1.02);
    }
    .gami-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: rgba(255,255,255,0.55);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        z-index: 0;
    }
    .gami-card > * { position: relative; z-index: 1; }

    /* XP Card */
    .gami-xp { box-shadow: 0 12px 40px rgba(99,102,241,0.25); }
    .gami-xp:hover { box-shadow: 0 20px 50px rgba(99,102,241,0.35); }

    /* Level Card */
    .gami-level { box-shadow: 0 12px 40px rgba(236,72,153,0.25); }
    .gami-level:hover { box-shadow: 0 20px 50px rgba(236,72,153,0.4); }

    /* Streak Card */
    .gami-streak { box-shadow: 0 12px 40px rgba(251,146,60,0.25); }
    .gami-streak:hover { box-shadow: 0 20px 50px rgba(251,146,60,0.4); }

    /* Glow icon bg */
    .icon-glow {
        width: 56px; height: 56px;
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.6rem;
        flex-shrink: 0;
    }

    /* XP Progress bar */
    .xp-bar-track {
        height: 8px;
        background: rgba(99,102,241,0.15);
        border-radius: 99px;
        overflow: hidden;
        margin-top: 10px;
    }
    .xp-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, #6366f1, #ec4899);
        border-radius: 99px;
        transition: width 1.2s cubic-bezier(0.22, 1, 0.36, 1);
    }

    /* Flame streak animation */
    @keyframes flicker {
        0%, 100% { transform: scale(1) rotate(-3deg); }
        50% { transform: scale(1.15) rotate(3deg); }
    }
    .flame-icon { animation: flicker 1.5s ease-in-out infinite; display: inline-block; }

    /* Star spin */
    @keyframes spinStar {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .spin-star { animation: spinStar 4s linear infinite; display: inline-block; }

    /* Counter count-up */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .count-anim { animation: countUp 0.9s ease forwards; }

    /* Level badge ring */
    .level-ring {
        width: 72px; height: 72px;
        border-radius: 50%;
        background: conic-gradient(from 0deg, #f43f5e 0%, #ec4899 45%, #a855f7 80%, #f1f5f9 80%);
        display: flex; align-items: center; justify-content: center;
        box-shadow: 0 0 0 4px white, 0 6px 20px rgba(236,72,153,0.4);
        flex-shrink: 0;
    }
    .level-ring-inner {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, #fdf2f8, #fce7f3);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.7rem;
        font-weight: 900;
        background: linear-gradient(135deg, #f43f5e, #a855f7);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

</style>

<!-- Floating Ambient Lights -->
<div class="bubble b-1 hidden md:block"></div>
<div class="bubble b-2 hidden md:block"></div>
<div class="bubble b-3 hidden md:block"></div>

<div class="min-h-screen p-4 sm:p-6 lg:p-10 relative z-10">
    
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- ================= HERO PROFILE FLAG ================= -->
        <div class="glass-card overflow-hidden animate-enter stagger-1 relative">
            
            <!-- Colorful Banner -->
            <div class="h-44 md:h-56 w-full relative overflow-hidden bg-white">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-blue-500/80 via-purple-500/80 to-pink-500/80 mix-blend-multiply"></div>
                <!-- Shimmer highlight -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full hover:animate-[shimmer_2s_infinite]"></div>
            </div>

            <div class="px-6 md:px-12 pb-10 relative">
                
                <!-- Awesome Floating Avatar -->
                <div class="absolute -top-20 md:-top-24 left-6 md:left-12">
                    <div class="w-36 h-36 md:w-44 md:h-44 rounded-[2.5rem] rotate-3 bg-white p-2 shadow-2xl hover:rotate-0 hover:scale-105 transition-all duration-500 z-10 relative">
                        <div class="w-full h-full rounded-[2rem] bg-gradient-to-br from-indigo-100 to-pink-100 flex items-center justify-center text-5xl md:text-7xl font-black text-vibrant shadow-inner overflow-hidden">
                            {{ isset($user->name) ? substr($user->name, 0, 1) : 'S' }}
                        </div>
                        <!-- Active Dot -->
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-400 border-4 border-white rounded-full shadow-lg flex items-center justify-center animate-bounce">
                            <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-24 md:pt-6 md:pl-56 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/50 border border-white/80 rounded-full mb-3 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-pink-500 animate-pulse"></span>
                            <span class="text-[11px] font-bold text-slate-600 uppercase tracking-widest">Verified Student</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-black text-slate-800 tracking-tight">{{ $user->name ?? 'Student Name' }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-3 mt-4 text-[15px] font-semibold">
                            <span class="flex items-center gap-2 bg-white/70 text-indigo-700 px-4 py-2 rounded-2xl border border-white shadow-sm">
                                <i class="fa-solid fa-id-badge text-indigo-400 text-lg"></i>
                                Roll No: <span class="font-black text-indigo-900">{{ $student->roll_number ?? 'N/A' }}</span>
                            </span>
                            <span class="flex items-center gap-2 bg-white/70 text-slate-600 px-4 py-2 rounded-2xl border border-white shadow-sm">
                                <i class="fa-solid fa-envelope-open-text text-pink-400 text-lg"></i>
                                {{ $user->email ?? 'No email provided' }}
                            </span>
                        </div>
                    </div>

                    <!-- CTA Edit -->
                    <a href="{{ route('profile.edit') }}" class="btn-pop inline-flex items-center justify-center px-8 py-3.5 font-bold rounded-2xl w-full md:w-auto text-[15px] tracking-wide">
                        <i class="fa-solid fa-wand-magic-sparkles mr-2 text-white/90 text-lg"></i>
                        Customize Profile
                    </a>

                </div>
            </div>
        </div>

        <!-- ================= GAMIFICATION BANNER ================= -->
        <div class="animate-enter stagger-2">
            <div class="flex items-center gap-2 mb-4">
                <span class="text-[11px] font-black text-slate-500 uppercase tracking-[0.2em]">🏆 Your Power Stats</span>
                <div class="flex-1 h-px bg-gradient-to-r from-slate-200 to-transparent"></div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                {{-- ===== TOTAL XP CARD ===== --}}
                <div class="gami-card gami-xp">
                    {{-- Decorative blobs --}}
                    <div class="absolute -top-6 -right-6 w-28 h-28 rounded-full bg-indigo-400/20 blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full bg-purple-400/20 blur-xl pointer-events-none"></div>

                    <div class="flex items-start gap-4">
                        <div class="icon-glow bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-400/40">
                            <i class="fa-solid fa-bolt text-white"></i>
                        </div>
                        <div class="flex-1">
                            <div class="text-[11px] font-black text-indigo-400 uppercase tracking-widest mb-1">Total XP</div>
                            <div class="text-4xl font-black text-slate-800 count-anim" id="xp-count">
                                {{ number_format($gamification->total_points ?? 0) }}
                            </div>
                            <div class="text-[12px] text-slate-500 font-semibold mt-1">
                                {{ number_format(($gamification->total_points ?? 0) % 1000) }} / 1000 to next level
                            </div>
                        </div>
                    </div>

                    {{-- XP Progress bar --}}
                    <div class="xp-bar-track mt-3">
                        <div class="xp-bar-fill" id="xp-bar" style="width: 0%"
                            data-pct="{{ min(100, (($gamification->total_points ?? 0) % 1000) / 10) }}"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold text-slate-400 mt-1.5 px-0.5">
                        <span>{{ floor(($gamification->total_points ?? 0) / 1000) * 1000 }} XP</span>
                        <span>{{ (floor(($gamification->total_points ?? 0) / 1000) + 1) * 1000 }} XP</span>
                    </div>
                </div>

                {{-- ===== LEVEL CARD ===== --}}
                <div class="gami-card gami-level">
                    <div class="absolute -top-6 -right-6 w-28 h-28 rounded-full bg-pink-400/20 blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full bg-rose-400/20 blur-xl pointer-events-none"></div>

                    <div class="flex items-center gap-4">
                        {{-- Level ring --}}
                        <div class="level-ring">
                            <div class="level-ring-inner">{{ $gamification->level ?? 1 }}</div>
                        </div>

                        <div class="flex-1">
                            <div class="text-[11px] font-black text-pink-400 uppercase tracking-widest mb-1">Current Level</div>
                            @php
                                $lvl = $gamification->level ?? 1;
                                $title = match(true) {
                                    $lvl >= 20 => 'Grandmaster',
                                    $lvl >= 15 => 'Master',
                                    $lvl >= 10 => 'Expert',
                                    $lvl >= 5  => 'Advanced',
                                    $lvl >= 3  => 'Intermediate',
                                    default    => 'Beginner',
                                };
                            @endphp
                            <div class="text-2xl font-black text-slate-800">{{ $title }}</div>
                            <div class="inline-flex items-center gap-1.5 mt-2 px-3 py-1 bg-gradient-to-r from-pink-500 to-rose-500 text-white text-[10px] font-black rounded-full shadow-md shadow-pink-400/30 uppercase tracking-wider">
                                <span class="spin-star text-yellow-300">★</span> Level {{ $lvl }}
                            </div>
                        </div>
                    </div>

                    <p class="mt-4 text-[12px] text-slate-500 font-medium bg-white/50 rounded-xl px-3 py-2.5 border border-white/80">
                        @if($lvl >= 20) 🏆 You've reached the pinnacle!
                        @elseif($lvl >= 10) 🚀 {{ 20 - $lvl }} more levels to Grandmaster!
                        @else 💪 Keep learning — {{ 10 - $lvl }} levels to Expert!
                        @endif
                    </p>
                </div>

                {{-- ===== DAY STREAK CARD ===== --}}
                <div class="gami-card gami-streak">
                    <div class="absolute -top-6 -right-6 w-28 h-28 rounded-full bg-orange-400/20 blur-2xl pointer-events-none"></div>
                    <div class="absolute -bottom-4 -left-4 w-20 h-20 rounded-full bg-amber-400/20 blur-xl pointer-events-none"></div>

                    <div class="flex items-start gap-4">
                        <div class="icon-glow bg-gradient-to-br from-orange-400 to-red-500 shadow-lg shadow-orange-400/40">
                            <span class="flame-icon text-2xl">🔥</span>
                        </div>
                        <div class="flex-1">
                            <div class="text-[11px] font-black text-orange-400 uppercase tracking-widest mb-1">Day Streak</div>
                            <div class="flex items-baseline gap-2">
                                <div class="text-4xl font-black text-slate-800 count-anim">{{ $gamification->current_streak ?? 0 }}</div>
                                <div class="text-[13px] font-bold text-slate-500">days</div>
                            </div>
                        </div>
                    </div>

                    {{-- Streak dots --}}
                    @php $streak = $gamification->current_streak ?? 0; @endphp
                    <div class="mt-4 flex items-center gap-2">
                        @for($d = 1; $d <= 7; $d++)
                            <div class="flex-1 h-2 rounded-full transition-all {{ $d <= ($streak % 7 ?: ($streak > 0 ? 7 : 0)) ? 'bg-gradient-to-r from-orange-400 to-red-500 shadow shadow-orange-400/50' : 'bg-slate-200' }}"></div>
                        @endfor
                    </div>
                    <div class="flex justify-between text-[9px] font-bold text-slate-400 mt-1.5 uppercase tracking-wider">
                        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                    </div>

                    @if($streak >= 7)
                        <div class="mt-3 text-[12px] text-orange-600 font-black bg-orange-50 border border-orange-200 rounded-xl px-3 py-2 text-center">
                            🔥 {{ $streak }}-Day Warrior! Keep it up!
                        </div>
                    @elseif($streak > 0)
                        <div class="mt-3 text-[12px] text-slate-500 font-semibold bg-white/50 rounded-xl px-3 py-2 border border-white text-center">
                            {{ 7 - $streak }} more days for a weekly badge!
                        </div>
                    @else
                        <div class="mt-3 text-[12px] text-slate-400 font-semibold bg-white/50 rounded-xl px-3 py-2 border border-white text-center">
                            Login daily to build your streak! 📅
                        </div>
                    @endif
                </div>

            </div><!-- /grid -->
        </div><!-- /gamification banner -->

        <!-- ================= BENTO GRID ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Specs Column -->
            <div class="space-y-6 lg:gap-8 lg:col-span-1">
                
                <!-- Course Card -->
                <div class="glass-card p-8 animate-enter stagger-2 h-full flex flex-col">
                    <div class="flex items-center justify-between border-b border-black/5 pb-4 mb-5">
                        <h2 class="text-[13px] font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-indigo-500 text-lg"></i> Academic Track
                        </h2>
                    </div>
                    
                    <div class="flex-1 flex flex-col justify-between">
                        @if(isset($course))
                            <div>
                                <h3 class="text-3xl font-black text-slate-800 leading-tight mb-3 text-blue-glow">{{ $course->name }}</h3>
                                <p class="text-[15px] text-slate-500 leading-relaxed font-medium bg-white/40 p-4 rounded-xl border border-white shadow-inner min-h-[50px]">{{ $course->description ?? 'No specific parameters defined.' }}</p>
                            </div>
                            
                            <div class="mt-6 pt-5 flex justify-between items-center">
                                <span class="text-[12px] font-black text-slate-400 uppercase tracking-widest">Current Status</span>
                                <span class="px-4 py-1.5 bg-gradient-to-r from-emerald-400 to-teal-400 text-white rounded-xl text-xs font-black uppercase tracking-wider shadow-lg shadow-emerald-500/30">
                                    Enrolled
                                </span>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="w-20 h-20 bg-white shadow-xl rounded-[2rem] rotate-12 flex items-center justify-center mx-auto mb-6">
                                    <i class="fa-solid fa-book-open text-3xl text-pink-400 -rotate-12"></i>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 mb-2">No Course Yet</h3>
                                <p class="text-sm text-slate-500 font-medium">Please wait for admin assignment.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Metrics Card -->
                <div class="glass-card p-6 animate-enter stagger-3">
                    <h2 class="text-[12px] font-black text-slate-400 uppercase tracking-[0.2em] mb-5 px-2">Account Metrics</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-5 bg-white/60 rounded-3xl border border-white shadow-sm hover:shadow-md hover:bg-white transition-all">
                            <div class="w-12 h-12 bg-indigo-100 text-indigo-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl"><i class="fa-solid fa-cubes-stacked"></i></div>
                            <div class="text-3xl font-black text-slate-800 mb-1">{{ isset($subjects) ? $subjects->count() : 0 }}</div>
                            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Subjects</div>
                        </div>
                        <div class="text-center p-5 bg-white/60 rounded-3xl border border-white shadow-sm hover:shadow-md hover:bg-white transition-all">
                            <div class="w-12 h-12 bg-pink-100 text-pink-500 rounded-full flex items-center justify-center mx-auto mb-3 text-xl"><i class="fa-solid fa-heart-circle-check"></i></div>
                            <div class="text-3xl font-black text-slate-800 mb-1">On</div>
                            <div class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Status</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Subject Grid Column -->
            <div class="lg:col-span-2 animate-enter stagger-2">
                <div class="glass-card overflow-hidden h-full flex flex-col relative p-2">
                    
                    <div class="p-6 md:px-8 bg-white/40 rounded-[1.5rem] flex flex-col sm:flex-row sm:items-center justify-between gap-4 border border-white shadow-sm mb-2">
                        <div>
                            <h2 class="text-2xl font-black text-slate-800 flex items-center gap-3">
                                <i class="fa-solid fa-layer-group text-pink-500"></i> My Subjects
                            </h2>
                            <p class="text-[14px] text-slate-500 mt-1 font-medium">Knowledge areas you are currently exploring.</p>
                        </div>
                        <div class="bg-indigo-600 text-white text-xs px-4 py-2 rounded-xl font-bold border border-indigo-400 shadow-lg shadow-indigo-500/30">
                            {{ isset($subjects) ? $subjects->count() : 0 }} Total Let's Go! 🚀
                        </div>
                    </div>

                    <div class="p-4 flex-1">
                        @if(isset($subjects) && $subjects->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($subjects as $subject)
                                    <!-- Playful Subject Card -->
                                    <div class="group flex items-center p-4 bg-white/60 border border-white/80 rounded-[1.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 hover:bg-white transition-all duration-300">
                                        
                                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-2xl flex items-center justify-center text-indigo-600 font-black text-2xl shadow-inner group-hover:scale-110 group-hover:rotate-6 transition-transform duration-300">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        
                                        <div class="ml-5 flex-1">
                                            <h3 class="text-[16px] font-black text-slate-800 group-hover:text-vibrant transition-colors">{{ $subject->name }}</h3>
                                            <div class="inline-block mt-1.5 px-2.5 py-1 bg-slate-100 text-[10px] font-bold text-slate-500 tracking-widest uppercase rounded-lg border border-slate-200">
                                                ID-{{ rand(100,200) }}
                                            </div>
                                        </div>

                                        <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-600 transition-all shadow-sm">
                                            <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full py-16 text-center">
                                <div class="relative w-32 h-32 mb-6">
                                    <div class="absolute inset-0 bg-pink-200 rounded-full animate-ping opacity-50"></div>
                                    <div class="relative w-full h-full bg-white/80 backdrop-blur-sm border-2 border-white rounded-[2rem] shadow-xl rotate-12 flex items-center justify-center">
                                        <i class="fa-solid fa-folder-tree text-5xl text-slate-300 -rotate-12"></i>
                                    </div>
                                </div>
                                <p class="text-slate-800 font-black text-2xl mb-2">No subjects found</p>
                                <p class="text-[15px] text-slate-500 font-medium max-w-sm">Looks like your backpack is empty right now. Admin will load it up soon!</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script>
    // Animate XP progress bar on load
    document.addEventListener('DOMContentLoaded', function () {
        const bar = document.getElementById('xp-bar');
        if (bar) {
            const pct = parseFloat(bar.getAttribute('data-pct')) || 0;
            setTimeout(() => { bar.style.width = pct + '%'; }, 300);
        }
    });
</script>

@endsection