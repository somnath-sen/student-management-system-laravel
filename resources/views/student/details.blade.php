@extends('layouts.student')

@section('title', 'My Profile')

@section('content')

<!-- Modern Typography Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    /* ================= PURE MODERN LIGHT THEME ================= */
    .profile-light-theme {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #0f172a; /* Slate 900 */
        color-scheme: light !important;
    }

    /* Animations */
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-up {
        animation: fadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    .stagger-1 { animation-delay: 0.05s; }
    .stagger-2 { animation-delay: 0.12s; }
    .stagger-3 { animation-delay: 0.2s; }

    /* Gamification Animations */
    @keyframes flicker {
        0%, 100% { transform: scale(1) rotate(-3deg); }
        50% { transform: scale(1.15) rotate(3deg); }
    }
    .flame-icon { animation: flicker 1.6s ease-in-out infinite; display: inline-block; }

    @keyframes spinStar {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .spin-star { animation: spinStar 4s linear infinite; display: inline-block; }

    /* Mini ID Card on White Canvas */
    .mini-id-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08);
        transition: all 0.3s ease;
    }
    .mini-id-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 16px 32px -6px rgba(99, 102, 241, 0.18);
    }
</style>

<div class="profile-light-theme max-w-7xl mx-auto space-y-7 pb-12">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-up">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 flex items-center justify-center text-emerald-600 shrink-0">
                    <i class="fa-solid fa-circle-check text-base"></i>
                </div>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-sm p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm animate-fade-up">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-xl bg-rose-100 flex items-center justify-center text-rose-600 shrink-0 mt-0.5">
                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-bold">Please check the following errors:</p>
                    <ul class="text-xs list-disc list-inside mt-1 space-y-0.5 font-medium">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- ================= 1. HERO PROFILE CARD (LIGHT THEME) ================= -->
    <div class="relative bg-white rounded-3xl border border-slate-200/90 shadow-sm overflow-hidden animate-fade-up">
        
        <!-- Header Campus Gradient Banner -->
        <div class="h-44 sm:h-52 w-full relative overflow-hidden bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_30%,rgba(255,255,255,0.22)_0%,transparent_60%)]"></div>
            <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:16px_16px]"></div>
            
            <!-- Campus Badge inside banner -->
            <div class="absolute top-5 right-6 flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold tracking-wide shadow-sm">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>EdFlow Student Portal</span>
            </div>
        </div>

        <div class="px-6 sm:px-10 pb-8 relative">
            
            <!-- Avatar & Profile Details Flex Container -->
            <div class="flex flex-col lg:flex-row items-start lg:items-end justify-between gap-6 -mt-20 sm:-mt-24">
                
                <!-- Left: Photo + Identity -->
                <div class="flex flex-col sm:flex-row items-start sm:items-end gap-6 w-full lg:w-auto">
                    
                    <!-- Avatar with Photo Upload Controls -->
                    <div class="relative group shrink-0">
                        <div class="w-36 h-36 sm:w-40 sm:h-40 rounded-3xl bg-white p-2 shadow-xl border-2 border-slate-100 overflow-hidden relative">
                            <div class="w-full h-full rounded-2xl bg-gradient-to-br from-indigo-50 to-slate-100 flex items-center justify-center overflow-hidden">
                                @if($student->profile_photo_url)
                                    <img id="profile-display-img" src="{{ $student->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                                @else
                                    <span id="profile-initials-badge" class="text-4xl sm:text-5xl font-black text-indigo-600 uppercase tracking-tight">
                                        {{ $student->initials }}
                                    </span>
                                @endif
                            </div>

                            <!-- Live Photo Trigger Button on Hover / Mobile -->
                            <button type="button" onclick="openPhotoModal()" class="absolute inset-2 rounded-2xl bg-slate-900/60 text-white flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 focus:opacity-100 transition-opacity duration-200 cursor-pointer backdrop-blur-sm" title="Change Profile Photo">
                                <i class="fa-solid fa-camera text-xl mb-1"></i>
                                <span class="text-[11px] font-bold">Update Photo</span>
                            </button>
                        </div>

                        <!-- Active Online Dot -->
                        <div class="absolute bottom-1 right-1 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full shadow-md flex items-center justify-center" title="Active Account">
                            <div class="w-1.5 h-1.5 bg-white rounded-full"></div>
                        </div>
                    </div>

                    <!-- Identity Headings -->
                    <div class="space-y-2">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                Verified Student
                            </span>
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                <i class="fa-solid fa-shield-halved text-[10px]"></i>
                                Status: {{ ucfirst($student->status ?? 'Active') }}
                            </span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">{{ $user->name ?? 'Student' }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs sm:text-sm font-semibold text-slate-600">
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-id-badge text-indigo-500"></i>
                                Roll No: <strong class="text-slate-900">{{ $student->roll_number ?? 'N/A' }}</strong>
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-envelope text-slate-400"></i>
                                {{ $user->email }}
                            </span>
                            <span class="text-slate-300">•</span>
                            <span class="inline-flex items-center gap-1.5">
                                <i class="fa-solid fa-graduation-cap text-indigo-500"></i>
                                {{ $course->name ?? 'Course Not Assigned' }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Right: Quick Actions -->
                <div class="flex flex-wrap items-center gap-3 w-full lg:w-auto justify-start lg:justify-end">
                    
                    <!-- Photo Button -->
                    <button type="button" onclick="openPhotoModal()" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 text-xs sm:text-sm font-bold shadow-sm hover:bg-slate-50 transition-all">
                        <i class="fa-solid fa-camera text-indigo-500"></i>
                        <span>{{ $student->profile_photo_url ? 'Change Photo' : 'Upload Photo' }}</span>
                    </button>

                    <!-- Smart Campus ID Link -->
                    <a href="{{ route('student.smart-id') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-50 border border-indigo-200 text-indigo-700 text-xs sm:text-sm font-bold shadow-sm hover:bg-indigo-100 transition-all">
                        <i class="fa-solid fa-qrcode text-indigo-600"></i>
                        <span>Smart Campus ID</span>
                    </a>

                    <!-- Account Edit Settings -->
                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs sm:text-sm font-bold shadow-sm hover:bg-indigo-600 transition-all">
                        <i class="fa-solid fa-gear"></i>
                        <span>Edit Account</span>
                    </a>

                </div>

            </div>

            <!-- Profile Completion Metric Bar -->
            <div class="mt-7 pt-5 border-t border-slate-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 text-xs">
                        <i class="fa-solid fa-chart-pie"></i>
                    </div>
                    <div>
                        <span class="text-xs font-black text-slate-700">Profile Completeness:</span>
                        <span class="text-xs font-bold text-indigo-600 ml-1">{{ $profileCompletion }}%</span>
                    </div>
                </div>
                
                <div class="w-full sm:w-72 flex items-center gap-3">
                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-emerald-500 rounded-full transition-all duration-1000" style="width: {{ $profileCompletion }}%"></div>
                    </div>
                    <span class="text-[11px] font-bold text-slate-400">
                        @if($profileCompletion >= 100)
                            Completed
                        @else
                            {{ 100 - $profileCompletion }}% left
                        @endif
                    </span>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 2. GAMIFICATION BANNER (LIGHT THEME) ================= -->
    <div class="animate-fade-up stagger-1">
        <div class="flex items-center gap-2 mb-3.5">
            <span class="text-xs font-black text-slate-500 uppercase tracking-wider flex items-center gap-1.5">
                <i class="fa-solid fa-trophy text-amber-500"></i>
                Student Power & Activity Stats
            </span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

            <!-- Total XP Card -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-indigo-300 transition-all">
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-indigo-600 uppercase tracking-widest">Total XP</span>
                        <div class="text-3xl font-black text-slate-900 mt-1">
                            {{ number_format($gamification->total_points ?? 0) }}
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            {{ number_format(($gamification->total_points ?? 0) % 1000) }} / 1,000 to next level
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-bolt"></i>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full transition-all duration-700" 
                             style="width: {{ min(100, (($gamification->total_points ?? 0) % 1000) / 10) }}%"></div>
                    </div>
                    <div class="flex justify-between text-[10px] font-bold text-slate-400 mt-1.5">
                        <span>{{ floor(($gamification->total_points ?? 0) / 1000) * 1000 }} XP</span>
                        <span>{{ (floor(($gamification->total_points ?? 0) / 1000) + 1) * 1000 }} XP</span>
                    </div>
                </div>
            </div>

            <!-- Current Level Card -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-pink-300 transition-all">
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
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-pink-600 uppercase tracking-widest">Level Progress</span>
                        <div class="text-3xl font-black text-slate-900 mt-1">{{ $title }}</div>
                        <div class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-0.5 rounded-full bg-gradient-to-r from-pink-500 to-rose-500 text-white text-[10px] font-black uppercase tracking-wider">
                            <span class="spin-star">★</span> Level {{ $lvl }}
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl shrink-0 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-award"></i>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-slate-100 text-xs font-medium text-slate-500">
                    @if($lvl >= 20)
                        🏆 Maximum level tier unlocked!
                    @elseif($lvl >= 10)
                        🚀 {{ 20 - $lvl }} more levels to Grandmaster!
                    @else
                        💪 Keep learning — {{ 10 - $lvl }} levels to Expert!
                    @endif
                </div>
            </div>

            <!-- Day Streak Card -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/90 shadow-sm relative overflow-hidden group hover:border-amber-300 transition-all">
                @php $streak = $gamification->current_streak ?? 0; @endphp
                <div class="flex items-start justify-between">
                    <div>
                        <span class="text-[11px] font-bold text-amber-600 uppercase tracking-widest">Daily Streak</span>
                        <div class="text-3xl font-black text-slate-900 mt-1 flex items-baseline gap-2">
                            <span>{{ $streak }}</span>
                            <span class="text-xs font-bold text-slate-400">days</span>
                        </div>
                        <p class="text-xs text-slate-500 font-medium mt-1">
                            @if($streak >= 7)
                                🔥 {{ $streak }}-Day Master! Keep the momentum!
                            @elseif($streak > 0)
                                {{ 7 - $streak }} more days for a weekly badge!
                            @else
                                Log in daily to build streak points!
                            @endif
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl shrink-0 group-hover:scale-110 transition-transform">
                        <span class="flame-icon">🔥</span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex items-center gap-1.5">
                        @for($d = 1; $d <= 7; $d++)
                            <div class="flex-1 h-2 rounded-full {{ $d <= ($streak % 7 ?: ($streak > 0 ? 7 : 0)) ? 'bg-gradient-to-r from-amber-400 to-orange-500 shadow-sm' : 'bg-slate-100' }}"></div>
                        @endfor
                    </div>
                    <div class="flex justify-between text-[9px] font-bold text-slate-400 mt-1.5 uppercase">
                        <span>Mon</span><span>Tue</span><span>Wed</span><span>Thu</span><span>Fri</span><span>Sat</span><span>Sun</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- ================= 3. BENTO GRID: ACADEMICS + REGISTRATION + ID ================= -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">

        <!-- Column 1 & 2: Main Academic & Registration Details -->
        <div class="lg:col-span-2 space-y-7 animate-fade-up stagger-2">

            <!-- Card: Academic Information (Light Theme) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7">
                <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900">Academic Track & Enrollment</h2>
                            <p class="text-xs text-slate-500 font-medium">Official degree curriculum and institutional track</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold border border-emerald-200">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active Enrollment
                    </span>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Enrolled Course</span>
                        <div class="text-base font-black text-slate-900 mt-1">
                            {{ $course->name ?? 'Course Not Assigned' }}
                        </div>
                        @if(isset($course) && $course->course_code)
                            <div class="inline-flex items-center gap-1 mt-2 px-2 py-0.5 rounded-md bg-indigo-50 text-indigo-700 text-[10px] font-bold">
                                <i class="fa-solid fa-hashtag text-[8px]"></i>
                                {{ $course->course_code }}
                            </div>
                        @endif
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Student Roll / ID</span>
                        <div class="text-base font-black text-indigo-600 mt-1">
                            {{ $student->roll_number ?? 'STU-PENDING' }}
                        </div>
                        <div class="text-xs text-slate-500 font-medium mt-1">
                            Official campus registration roll
                        </div>
                    </div>

                    <div class="sm:col-span-2 p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Course Syllabus Overview</span>
                        <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-medium mt-1">
                            {{ $course->description ?? 'No syllabus description defined for this academic course.' }}
                        </p>
                    </div>

                </div>
            </div>

            <!-- Card: Registration Information (Real Timestamps) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7">
                <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-id-card-clip"></i>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900">Registration & Admission Details</h2>
                            <p class="text-xs text-slate-500 font-medium">Permanent admission record & original submission timestamp</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-200">
                        <i class="fa-solid fa-certificate text-[10px]"></i>
                        {{ $registration->application_no ?? ('APP-' . str_pad($student->id, 5, '0', STR_PAD_LEFT)) }}
                    </span>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

                    <!-- REAL REGISTRATION TIMESTAMP (Date & Time) -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-indigo-50/70 to-purple-50/70 border border-indigo-100">
                        <div class="flex items-center gap-1.5 text-indigo-600 text-xs font-black uppercase tracking-wider">
                            <i class="fa-solid fa-calendar-check"></i>
                            Registered On
                        </div>
                        @php
                            $submittedTime = $registration->submitted_at 
                                ?? $registration->created_at 
                                ?? $student->created_at;
                        @endphp
                        <div class="text-sm font-black text-slate-900 mt-1.5">
                            {{ $submittedTime ? $submittedTime->format('d F Y') : 'Not Available' }}
                        </div>
                        <div class="text-xs font-bold text-indigo-600 mt-0.5">
                            <i class="fa-regular fa-clock text-[10px] mr-1"></i>
                            {{ $submittedTime ? $submittedTime->format('h:i A') : 'Time N/A' }}
                        </div>
                    </div>

                    <!-- REAL APPROVAL TIMESTAMP -->
                    <div class="p-4 rounded-2xl bg-gradient-to-br from-emerald-50/70 to-teal-50/70 border border-emerald-100">
                        <div class="flex items-center gap-1.5 text-emerald-600 text-xs font-black uppercase tracking-wider">
                            <i class="fa-solid fa-circle-check"></i>
                            Approved On
                        </div>
                        @php
                            $approvedTime = $registration->approved_at 
                                ?? $student->created_at;
                        @endphp
                        <div class="text-sm font-black text-slate-900 mt-1.5">
                            {{ $approvedTime ? $approvedTime->format('d F Y') : 'Active' }}
                        </div>
                        <div class="text-xs font-bold text-emerald-600 mt-0.5">
                            <i class="fa-regular fa-clock text-[10px] mr-1"></i>
                            {{ $approvedTime ? $approvedTime->format('h:i A') : 'Verified' }}
                        </div>
                    </div>

                    <!-- APPLICATION STATUS -->
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Admission Status</span>
                        <div class="text-sm font-black text-slate-900 mt-1.5 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            {{ ucfirst($registration->status ?? 'Approved') }}
                        </div>
                        <div class="text-xs text-slate-500 font-medium mt-0.5">
                            Official Admission Cleared
                        </div>
                    </div>

                    <!-- DATE OF BIRTH -->
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Date of Birth</span>
                        <div class="text-sm font-black text-slate-900 mt-1.5">
                            {{ ($registration && $registration->date_of_birth) ? $registration->date_of_birth->format('d F Y') : '03 March 2003' }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium mt-0.5">
                            Initial Login PIN
                        </div>
                    </div>

                    <!-- GENDER / NATIONALITY -->
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Gender & Nationality</span>
                        <div class="text-sm font-black text-slate-900 mt-1.5">
                            {{ ucfirst($registration->gender ?? 'Unspecified') }} • {{ $registration->nationality ?? 'Indian' }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium mt-0.5">
                            Verified Identification
                        </div>
                    </div>

                    <!-- BLOOD GROUP -->
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Blood Group</span>
                        <div class="text-sm font-black text-rose-600 mt-1.5 flex items-center gap-1.5">
                            <i class="fa-solid fa-droplet text-rose-500"></i>
                            {{ $student->blood_group ?? ($registration->blood_group ?? 'Not Set') }}
                        </div>
                        <div class="text-[11px] text-slate-400 font-medium mt-0.5">
                            Smart Campus ID Synced
                        </div>
                    </div>

                </div>
            </div>

            <!-- Card: Contact & Emergency Information -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7">
                <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-address-book"></i>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900">Contact & Guardian Directory</h2>
                            <p class="text-xs text-slate-500 font-medium">Communication channels, residential address & SOS contact</p>
                        </div>
                    </div>
                    <a href="{{ route('student.smart-id') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 inline-flex items-center gap-1">
                        <span>Edit Guardian Info</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Primary Phone</span>
                        <div class="text-sm font-black text-slate-900 mt-1 flex items-center gap-2">
                            <i class="fa-solid fa-phone text-indigo-500 text-xs"></i>
                            {{ $student->phone ?? ($registration->phone ?? 'Not Provided') }}
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Parent / Guardian Name</span>
                        <div class="text-sm font-black text-slate-900 mt-1 flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-indigo-500 text-xs"></i>
                            {{ $student->parent_name ?? ($registration->parent_name ?? 'Not Provided') }}
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Emergency SOS Phone</span>
                        <div class="text-sm font-black text-rose-600 mt-1 flex items-center gap-2">
                            <i class="fa-solid fa-truck-medical text-rose-500 text-xs"></i>
                            {{ $student->emergency_phone ?? 'Not Configured' }}
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-100">
                        <span class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Residential Location</span>
                        <div class="text-xs font-semibold text-slate-700 mt-1 leading-relaxed">
                            {{ $student->home_address ?? ($registration->permanent_address ?? 'Address not updated') }}
                        </div>
                    </div>

                </div>
            </div>

            <!-- Card: Enrolled Subjects Grid -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6 sm:p-7">
                <div class="flex items-center justify-between pb-5 border-b border-slate-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-lg">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900">Enrolled Academic Subjects</h2>
                            <p class="text-xs text-slate-500 font-medium">Knowledge modules under your course curriculum</p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-100 text-slate-700 text-xs font-black">
                        {{ isset($subjects) ? $subjects->count() : 0 }} Subjects
                    </span>
                </div>

                <div class="mt-6">
                    @if(isset($subjects) && $subjects->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach($subjects as $subject)
                                <div class="p-4 rounded-2xl bg-slate-50/80 border border-slate-200/70 flex items-start gap-3.5 hover:border-indigo-300 transition-all">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black text-base shrink-0 shadow-sm">
                                        {{ strtoupper(substr($subject->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-sm font-black text-slate-900 truncate" title="{{ $subject->name }}">{{ $subject->name }}</h3>
                                        <div class="mt-1 flex items-center gap-2">
                                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-white text-slate-600 border border-slate-200 text-[10px] font-bold">
                                                <i class="fa-solid fa-barcode text-[8px]"></i>
                                                {{ $subject->subject_code ?? 'CODE N/A' }}
                                            </span>
                                            <span class="text-[10px] font-bold text-emerald-600">
                                                Enrolled
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3 text-slate-400">
                                <i class="fa-solid fa-folder-open text-xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-700">No subjects currently assigned</p>
                            <p class="text-xs text-slate-400 mt-1">Your academic coordinator will register your active subjects soon.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <!-- Column 3: Smart Campus ID Live Preview & Account Details -->
        <div class="space-y-7 animate-fade-up stagger-3">

            <!-- Card: SMART CAMPUS ID PREVIEW (Light Theme) -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
                    <h2 class="text-xs font-black text-slate-500 uppercase tracking-wider flex items-center gap-2">
                        <i class="fa-solid fa-id-badge text-indigo-500"></i>
                        Digital Campus ID Card
                    </h2>
                    <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-600 border border-emerald-200">
                        Live Preview
                    </span>
                </div>

                <!-- Miniature Physical ID Card Preview -->
                <div class="mini-id-card overflow-hidden text-center relative max-w-[280px] mx-auto">
                    <!-- Top ID Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-4 py-3.5 text-white">
                        <div class="flex items-center justify-center gap-1.5 text-xs font-black tracking-wider uppercase">
                            <i class="fa-solid fa-graduation-cap text-xs"></i>
                            EdFlow Academy
                        </div>
                        <p class="text-[9px] font-bold text-indigo-200 tracking-widest uppercase mt-0.5">Smart Campus ID</p>
                    </div>

                    <!-- Photo (Unified source of truth) -->
                    <div class="pt-4 pb-1">
                        <div class="w-20 h-20 rounded-full mx-auto p-1 bg-white shadow-md border-2 border-indigo-200 overflow-hidden flex items-center justify-center">
                            @if($student->profile_photo_url)
                                <img src="{{ $student->profile_photo_url }}" alt="{{ $user->name }}" class="w-full h-full object-cover rounded-full">
                            @else
                                <span class="text-xl font-black text-indigo-600 uppercase">{{ $student->initials }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Student Info -->
                    <div class="px-4 pb-3">
                        <h3 class="text-sm font-black text-slate-900 leading-tight mt-1">{{ $user->name }}</h3>
                        <p class="text-[11px] font-bold text-indigo-600 mt-0.5 truncate">{{ $course->name ?? 'Student' }}</p>
                        
                        <div class="mt-2.5 pt-2 border-t border-slate-100 flex items-center justify-around text-center">
                            <div>
                                <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider block">Roll No</span>
                                <span class="text-xs font-black text-slate-800">{{ $student->roll_number ?? 'N/A' }}</span>
                            </div>
                            <div class="w-px h-6 bg-slate-100"></div>
                            <div>
                                <span class="text-[8px] font-bold text-slate-400 uppercase tracking-wider block">Blood Group</span>
                                <span class="text-xs font-black text-rose-600">{{ $student->blood_group ?? 'N/A' }}</span>
                            </div>
                        </div>

                        <!-- Scannable Dynamic QR Code -->
                        <div class="mt-3 p-2 bg-white rounded-xl border border-slate-200 inline-block shadow-sm">
                            {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(80)->color(30, 41, 59)->generate($verifyUrl) !!}
                        </div>
                        <p class="text-[8px] font-bold text-slate-400 uppercase tracking-wider mt-1">Official Verification QR</p>
                    </div>
                </div>

                <div class="mt-5 space-y-2.5">
                    <a href="{{ route('student.smart-id') }}" class="w-full py-2.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-sm transition-all">
                        <i class="fa-solid fa-expand"></i>
                        <span>Open & Download Smart ID</span>
                    </a>
                    <p class="text-[11px] text-slate-400 text-center font-medium leading-tight">
                        The same photo uploaded on your profile is automatically embedded in this Smart Campus ID.
                    </p>
                </div>
            </div>

            <!-- Card: Account & Security Metrics -->
            <div class="bg-white rounded-3xl border border-slate-200/90 shadow-sm p-6">
                <h2 class="text-xs font-black text-slate-500 uppercase tracking-wider flex items-center gap-2 pb-4 border-b border-slate-100 mb-4">
                    <i class="fa-solid fa-shield-check text-emerald-500"></i>
                    Account & Security Status
                </h2>

                <div class="space-y-3.5">
                    
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Account Type</span>
                        <span class="font-black text-slate-800 bg-slate-100 px-2.5 py-1 rounded-lg">Student Portal</span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Initial Login PIN</span>
                        <span class="font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">DOB (DDMMYYYY)</span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Joined Platform</span>
                        <span class="font-bold text-slate-700">
                            {{ $user->created_at ? $user->created_at->format('d M Y') : 'N/A' }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Last Seen</span>
                        <span class="font-bold text-emerald-600 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                            {{ $user->activity_status }}
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span class="font-medium text-slate-500">Telegram Sync</span>
                        @if($user->hasTelegramConnected())
                            <span class="font-bold text-sky-600 flex items-center gap-1">
                                <i class="fa-brands fa-telegram"></i> Connected
                            </span>
                        @else
                            <span class="font-medium text-slate-400">Not Linked</span>
                        @endif
                    </div>

                </div>

                <div class="mt-5 pt-4 border-t border-slate-100">
                    <a href="{{ route('profile.edit') }}" class="w-full py-2.5 px-4 rounded-xl border border-slate-200 hover:bg-slate-50 font-bold text-xs text-slate-700 flex items-center justify-center gap-2 transition-all">
                        <i class="fa-solid fa-lock"></i>
                        <span>Change Password</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- ================= PROFILE PHOTO UPLOAD MODAL (LIGHT THEME) ================= -->
<div id="photo-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300 p-4">
    <div class="bg-white rounded-3xl border border-slate-200 shadow-2xl max-w-md w-full p-6 sm:p-7 transform scale-95 transition-transform duration-300" id="photo-modal-content">
        
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h3 class="text-base font-black text-slate-900 flex items-center gap-2">
                <i class="fa-solid fa-camera text-indigo-500"></i>
                Update Student Profile Photo
            </h3>
            <button type="button" onclick="closePhotoModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <i class="fa-solid fa-xmark text-base"></i>
            </button>
        </div>

        <form action="{{ route('student.profile.photo.upload') }}" method="POST" enctype="multipart/form-data" id="photo-upload-form" class="mt-5 space-y-5">
            @csrf

            <!-- Interactive Preview Area -->
            <div class="flex flex-col items-center justify-center">
                <div class="w-32 h-32 rounded-3xl bg-slate-50 border-2 border-dashed border-indigo-200 p-1 flex items-center justify-center overflow-hidden relative shadow-inner">
                    <img id="modal-preview-img" src="{{ $student->profile_photo_url ?? '' }}" class="{{ $student->profile_photo_url ? '' : 'hidden' }} w-full h-full object-cover rounded-2xl" alt="Preview">
                    <div id="modal-preview-placeholder" class="{{ $student->profile_photo_url ? 'hidden' : 'flex' }} flex-col items-center justify-center text-slate-400">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-indigo-400 mb-1"></i>
                        <span class="text-[11px] font-bold">Select File</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 font-medium mt-3 text-center">
                    JPG, JPEG, or PNG format. Maximum size: 5 MB.
                </p>
            </div>

            <!-- Hidden File Input -->
            <input type="file" name="photo" id="modal-file-input" accept="image/png, image/jpeg, image/jpg" class="hidden" onchange="handleFileSelected(event)">

            <!-- Select File Button -->
            <div class="flex justify-center">
                <button type="button" onclick="document.getElementById('modal-file-input').click()" class="px-5 py-2 rounded-xl bg-indigo-50 text-indigo-600 hover:bg-indigo-100 text-xs font-bold transition-all flex items-center gap-2">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Choose Photo From Computer</span>
                </button>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-between gap-3">
                @if($student->profile_photo_url)
                    <!-- Remove Photo Form Trigger -->
                    <button type="button" onclick="submitDeletePhoto()" class="text-xs font-bold text-rose-600 hover:text-rose-700 p-2 flex items-center gap-1">
                        <i class="fa-solid fa-trash-can"></i>
                        <span>Remove Photo</span>
                    </button>
                @else
                    <div></div>
                @endif

                <div class="flex items-center gap-2">
                    <button type="button" onclick="closePhotoModal()" class="px-4 py-2 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 hover:bg-slate-50 transition-all">
                        Cancel
                    </button>
                    <button type="submit" id="save-photo-btn" disabled class="px-5 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-not-allowed text-white text-xs font-bold transition-all shadow-sm flex items-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Save Photo</span>
                    </button>
                </div>
            </div>

        </form>

        <!-- Hidden Form for Removal -->
        <form action="{{ route('student.profile.photo.delete') }}" method="POST" id="delete-photo-form" class="hidden">
            @csrf
            @method('DELETE')
        </form>

    </div>
</div>

<script>
    function openPhotoModal() {
        const modal = document.getElementById('photo-modal');
        const content = document.getElementById('photo-modal-content');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        modal.classList.add('opacity-100');
        content.classList.remove('scale-95');
        content.classList.add('scale-100');
    }

    function closePhotoModal() {
        const modal = document.getElementById('photo-modal');
        const content = document.getElementById('photo-modal-content');
        modal.classList.add('opacity-0', 'pointer-events-none');
        modal.classList.remove('opacity-100');
        content.classList.add('scale-95');
        content.classList.remove('scale-100');
    }

    function handleFileSelected(event) {
        const file = event.target.files[0];
        if (!file) return;

        // Validation for file size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('File size exceeds the 5 MB limit. Please select a smaller photo.');
            event.target.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const previewImg = document.getElementById('modal-preview-img');
            const placeholder = document.getElementById('modal-preview-placeholder');
            const saveBtn = document.getElementById('save-photo-btn');

            previewImg.src = e.target.result;
            previewImg.classList.remove('hidden');
            placeholder.classList.add('hidden');
            saveBtn.disabled = false;
        };
        reader.readAsDataURL(file);
    }

    function submitDeletePhoto() {
        if (confirm('Are you sure you want to remove your profile photo? Your default initials will be displayed.')) {
            document.getElementById('delete-photo-form').submit();
        }
    }

    // Close modal on Escape key or outside click
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closePhotoModal();
    });
    document.getElementById('photo-modal').addEventListener('click', function (e) {
        if (e.target === this) closePhotoModal();
    });
</script>

@endsection