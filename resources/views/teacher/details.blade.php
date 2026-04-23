@extends('layouts.teacher')

@section('title', 'My Profile')

@section('content')

<!-- Import Cool Modern Font: Outfit -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ================= DYNAMIC VIBRANT BACKGROUND ================= */
    body {
        background: linear-gradient(-45deg, #e0f2fe, #f0fdf4, #fdf4ff, #eef2ff, #f3e8ff, #fff1f2);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        font-family: 'Outfit', sans-serif !important;
        position: relative;
    }

    body::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(255, 255, 255, 0.4); 
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
        background: linear-gradient(135deg, #10b981 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        color: #3b82f6; 
    }

    .text-glow {
        background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    /* Pulse Bubbles Floating Background */
    .bubble {
        position: absolute;
        border-radius: 50%;
        filter: blur(50px);
        z-index: -1;
        animation: float 12s infinite ease-in-out alternate;
    }
    .b-1 { width: 350px; height: 350px; background: rgba(59, 130, 246, 0.2); top: -100px; left: -100px; }
    .b-2 { width: 450px; height: 450px; background: rgba(16, 185, 129, 0.15); bottom: -100px; right: -100px; animation-duration: 16s; }
    .b-3 { width: 250px; height: 250px; background: rgba(139, 92, 246, 0.15); top: 30%; left: 40%; animation-duration: 14s; }

    @keyframes float {
        100% { transform: translateY(40px) scale(1.1); }
    }

    /* Pop Buttons */
    .btn-pop {
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        border: none;
        color: white;
        transition: all 0.3s cubic-bezier(0.25, 1, 0.5, 1);
        box-shadow: 0 10px 20px rgba(139, 92, 246, 0.3);
    }
    .btn-pop:hover {
        transform: scale(1.05) translateY(-2px);
        box-shadow: 0 15px 25px rgba(139, 92, 246, 0.5);
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
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
                <div class="absolute inset-0 bg-gradient-to-tr from-emerald-400/80 via-blue-500/80 to-indigo-500/80 mix-blend-multiply"></div>
                <!-- Shimmer highlight -->
                <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent -translate-x-full hover:animate-[shimmer_2s_infinite]"></div>
            </div>

            <div class="px-6 md:px-12 pb-10 relative">
                
                <!-- Awesome Floating Avatar -->
                <div class="absolute -top-20 md:-top-24 left-6 md:left-12">
                    <div class="w-36 h-36 md:w-44 md:h-44 rounded-[2.5rem] -rotate-3 bg-white p-2 shadow-2xl hover:rotate-0 hover:scale-105 transition-all duration-500 z-10 relative">
                        <div class="w-full h-full rounded-[2rem] bg-gradient-to-br from-blue-50 to-emerald-50 flex items-center justify-center text-5xl md:text-7xl font-black text-vibrant shadow-inner overflow-hidden">
                            {{ isset($user->name) ? substr($user->name, 0, 1) : 'T' }}
                        </div>
                        <!-- Active Dot -->
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 bg-emerald-400 border-4 border-white rounded-full shadow-lg flex items-center justify-center animate-bounce">
                            <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-24 md:pt-6 md:pl-56 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-white/50 border border-white/80 rounded-full mb-3 shadow-sm">
                            <span class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></span>
                            <span class="text-[11px] font-bold text-slate-600 uppercase tracking-widest">Faculty Member</span>
                        </div>
                        <h1 class="text-4xl md:text-5xl font-black text-slate-800 tracking-tight">{{ $user->name ?? 'Instructor' }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-3 mt-4 text-[15px] font-semibold">
                            <span class="flex items-center gap-2 bg-white/70 text-indigo-700 px-4 py-2 rounded-2xl border border-white shadow-sm">
                                <i class="fa-solid fa-id-badge text-indigo-400 text-lg"></i>
                                Employee ID: <span class="font-black text-indigo-900">{{ isset($teacher) && $teacher->employee_id ? $teacher->employee_id : 'PENDING' }}</span>
                            </span>
                            <span class="flex items-center gap-2 bg-white/70 text-slate-600 px-4 py-2 rounded-2xl border border-white shadow-sm">
                                <i class="fa-solid fa-envelope-open-text text-blue-400 text-lg"></i>
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

        <!-- ================= BENTO GRID ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
            
            <!-- Specs Column -->
            <div class="space-y-6 lg:gap-8 lg:col-span-1">
                
                <!-- Metrics Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-6 animate-enter stagger-2">
                    
                    <!-- Subject Count Card -->
                    <div class="glass-card p-6 flex items-center gap-5 hover:bg-white/80 transition-colors cursor-default">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-100 to-blue-200 rounded-[1.5rem] flex items-center justify-center text-indigo-500 text-2xl shadow-inner rotate-3">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-0.5">Assigned</p>
                            <h3 class="text-3xl font-black text-slate-800 leading-none">{{ isset($subjects) ? $subjects->count() : 0 }}<span class="text-sm text-slate-400 font-bold ml-1">Classes</span></h3>
                        </div>
                    </div>

                    <!-- Session Card -->
                    <div class="glass-card p-6 flex items-center gap-5 hover:bg-white/80 transition-colors cursor-default">
                        <div class="w-16 h-16 bg-gradient-to-br from-emerald-100 to-teal-200 rounded-[1.5rem] flex items-center justify-center text-emerald-500 text-2xl shadow-inner -rotate-3">
                            <i class="fa-solid fa-calendar-check"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-0.5">Session</p>
                            <h3 class="text-3xl font-black text-slate-800 leading-none">{{ date('Y') }}<span class="text-sm text-slate-400 font-bold ml-1">Term</span></h3>
                        </div>
                    </div>

                </div>

                <!-- Identity Summary -->
                <div class="glass-card p-6 animate-enter stagger-3 h-full">
                    <h2 class="text-[12px] font-black text-slate-400 uppercase tracking-[0.2em] mb-5 px-2 flex items-center gap-2">
                        <i class="fa-solid fa-shield-halved text-indigo-400 text-lg"></i> System Access
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="bg-white/60 p-4 rounded-3xl border border-white shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-500 flex items-center justify-center"><i class="fa-solid fa-fingerprint"></i></div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest">Clearance</p>
                                    <p class="font-black text-slate-700">Level 2 (Instructor)</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white/60 p-4 rounded-3xl border border-white shadow-sm flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-500 flex items-center justify-center"><i class="fa-solid fa-signal"></i></div>
                                <div>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest">Network Status</p>
                                    <p class="font-black text-slate-700">Online & Active</p>
                                </div>
                            </div>
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
                                <i class="fa-solid fa-layer-group text-blue-500"></i> Assigned Classes
                            </h2>
                            <p class="text-[14px] text-slate-500 mt-1 font-medium">Courses you are currently administering.</p>
                        </div>
                        <div class="bg-blue-600 text-white text-xs px-4 py-2 rounded-xl font-bold border border-blue-400 shadow-lg shadow-blue-500/30">
                            Semester 1 Active
                        </div>
                    </div>

                    <div class="p-4 flex-1">
                        @if(isset($subjects) && $subjects->count() > 0)
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @foreach($subjects as $subject)
                                    <!-- Playful Subject Card -->
                                    <div class="group flex items-center p-4 bg-white/60 border border-white/80 rounded-[1.5rem] shadow-sm hover:shadow-xl hover:-translate-y-1 hover:bg-white transition-all duration-300">
                                        
                                        <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-blue-100 to-emerald-100 rounded-2xl flex items-center justify-center text-blue-600 font-black text-2xl shadow-inner group-hover:scale-110 group-hover:-rotate-6 transition-transform duration-300">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        
                                        <div class="ml-5 flex-1">
                                            <h3 class="text-[16px] font-black text-slate-800 group-hover:text-vibrant transition-colors">{{ $subject->name }}</h3>
                                            <div class="inline-block mt-1.5 px-2.5 py-1 bg-slate-100 text-[10px] font-bold text-slate-500 tracking-widest uppercase rounded-lg border border-slate-200">
                                                Code: {{ $subject->subject_code ?? strtoupper(substr($subject->name, 0, 3)) . '-10' . $loop->iteration }}
                                            </div>
                                        </div>

                                        <div class="w-10 h-10 rounded-full bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-400 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all shadow-sm">
                                            <i class="fa-solid fa-arrow-right -rotate-45 group-hover:rotate-0 transition-transform"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full py-16 text-center">
                                <div class="relative w-32 h-32 mb-6">
                                    <div class="absolute inset-0 bg-blue-200 rounded-full animate-ping opacity-50"></div>
                                    <div class="relative w-full h-full bg-white/80 backdrop-blur-sm border-2 border-white rounded-[2rem] shadow-xl rotate-12 flex items-center justify-center">
                                        <i class="fa-solid fa-chalkboard text-5xl text-slate-300 -rotate-12"></i>
                                    </div>
                                </div>
                                <p class="text-slate-800 font-black text-2xl mb-2">No active classes</p>
                                <p class="text-[15px] text-slate-500 font-medium max-w-sm">No courses have been assigned to your profile yet. Please contact admin.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection