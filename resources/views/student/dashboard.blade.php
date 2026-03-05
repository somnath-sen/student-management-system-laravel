@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')

<style>
    /* ================= FORCE LIGHT BACKGROUND ================= */
    body {
        background-color: #F9FAFB !important; /* Tailwind gray-50 */
    }

    /* ================= ANIMATIONS ================= */
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }

    /* Progress Bar Animation */
    .progress-bar-fill {
        width: 0;
        animation: fillBar 1.2s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: 0.4s;
    }

    @keyframes fillBar {
        to { width: var(--target-width); }
    }

    /* Interactive Cards */
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.05), 0 4px 8px -4px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="min-h-screen text-gray-800 font-sans p-4 sm:p-6 lg:p-8 transition-colors duration-300">
    
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between animate-fade-up">
            <div>
                <p class="text-indigo-600 text-sm font-bold uppercase tracking-wider mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-user-graduate"></i> Student Portal
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Welcome back, <span class="text-indigo-600">{{ isset($student->user) ? $student->user->name : 'Student' }}</span>
                </h1>
                <p class="text-gray-500 mt-2 font-medium">Here is your academic overview and attendance summary.</p>
            </div>
            <div class="mt-4 md:mt-0 text-right">
                <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-white rounded-xl shadow-sm border border-gray-200 text-sm font-bold text-gray-700">
                    <i class="fa-regular fa-calendar text-indigo-500"></i>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-up delay-100">
            
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-full blur-2xl -mr-10 -mt-10 opacity-50 transition-opacity group-hover:opacity-100"></div>
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Attendance Rate</p>
                        <h3 class="text-4xl font-black {{ ($attendancePercentage ?? 0) >= 75 ? 'text-indigo-600' : 'text-orange-500' }} mt-2">
                            {{ $attendancePercentage ?? 0 }}%
                        </h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-chart-pie text-xl"></i>
                    </div>
                </div>
                <div class="w-full bg-gray-100 h-2 rounded-full mt-5 overflow-hidden relative z-10">
                    <div class="h-full rounded-full {{ ($attendancePercentage ?? 0) >= 75 ? 'bg-indigo-500' : 'bg-orange-400' }} progress-bar-fill" style="--target-width: {{ $attendancePercentage ?? 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Classes</p>
                        <h3 class="text-3xl font-black text-gray-900 mt-2">{{ $totalClasses ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-gray-50 text-gray-600 flex items-center justify-center">
                        <i class="fa-solid fa-person-chalkboard text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-400 font-medium mt-4"><i class="fa-solid fa-clock-rotate-left mr-1"></i> Conducted so far</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Days Present</p>
                        <h3 class="text-3xl font-black text-emerald-600 mt-2">{{ $presentCount ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-check text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-emerald-600 font-bold mt-4"><i class="fa-solid fa-arrow-trend-up mr-1"></i> Keep it up!</p>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover-card flex flex-col justify-between">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Days Absent</p>
                        <h3 class="text-3xl font-black text-rose-500 mt-2">{{ $absentCount ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-500 flex items-center justify-center">
                        <i class="fa-solid fa-calendar-xmark text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-rose-500 font-bold mt-4"><i class="fa-solid fa-circle-exclamation mr-1"></i> Requires attention</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6 animate-fade-up delay-200">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
                    
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5 relative overflow-hidden">
                        <div class="absolute right-0 top-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-4 -mt-4"></div>
                        <h2 class="text-white font-bold text-lg flex items-center gap-2 relative z-10">
                            <i class="fa-solid fa-graduation-cap"></i> My Program
                        </h2>
                    </div>
                    
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">{{ isset($course) ? $course->name : 'Not Assigned' }}</h3>
                        
                        @if(isset($course) && $course->description)
                            <p class="text-gray-600 text-sm mb-6 leading-relaxed flex-1">{{ $course->description }}</p>
                        @else
                            <p class="text-gray-400 text-sm mb-6 flex-1 italic">No program description available.</p>
                        @endif
                        
                        <div class="border-t border-gray-100 pt-5 mt-auto">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Enrolled Subjects</p>
                            <div class="flex flex-wrap gap-2">
                                @if(isset($subjects) && $subjects->count() > 0)
                                    @foreach($subjects as $subject)
                                        <span class="px-3 py-1.5 bg-gray-50 text-gray-700 rounded-lg text-xs font-bold border border-gray-200 shadow-sm">
                                            {{ $subject->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="px-3 py-1.5 bg-gray-50 text-gray-400 rounded-lg text-xs font-medium border border-dashed border-gray-200">
                                        No subjects enrolled
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 animate-fade-up delay-300">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden h-full flex flex-col">
                    
                    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <h2 class="font-bold text-gray-800 text-lg flex items-center gap-2">
                            <i class="fa-solid fa-chart-pie text-indigo-500"></i> Subject-wise Analytics
                        </h2>
                        <a href="{{ route('student.attendance.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-bold flex items-center gap-1 group">
                            View All <i class="fa-solid fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                                    <th class="px-6 py-4 font-bold">Subject</th>
                                    <th class="px-6 py-4 font-bold text-center">Sessions</th>
                                    <th class="px-6 py-4 font-bold w-1/3">Performance</th>
                                    <th class="px-6 py-4 font-bold text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @if(isset($subjectAttendance) && count($subjectAttendance) > 0)
                                    @foreach($subjectAttendance as $row)
                                        @php
                                            $subPercent = $row->total_classes > 0 ? round(($row->present_count / $row->total_classes) * 100, 2) : 0;
                                            $barColor = $subPercent >= 75 ? 'bg-indigo-500' : ($subPercent >= 60 ? 'bg-amber-400' : 'bg-rose-500');
                                            $badgeColor = $subPercent >= 75 ? 'bg-emerald-100 text-emerald-700 border-emerald-200' : 
                                                         ($subPercent >= 60 ? 'bg-amber-100 text-amber-700 border-amber-200' : 
                                                                              'bg-rose-100 text-rose-700 border-rose-200');
                                            $badgeText = $subPercent >= 75 ? 'Good' : ($subPercent >= 60 ? 'Average' : 'Low');
                                        @endphp
                                        <tr class="hover:bg-gray-50 transition-colors">
                                            <td class="px-6 py-4">
                                                <div class="font-bold text-gray-900">{{ $row->subject->name ?? 'Unknown' }}</div>
                                            </td>
                                            <td class="px-6 py-4 text-center">
                                                <span class="text-gray-500 text-sm font-medium">
                                                    <span class="font-black text-gray-900">{{ $row->present_count }}</span> / {{ $row->total_classes }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 align-middle">
                                                <div class="flex items-center gap-3">
                                                    <div class="flex-1 bg-gray-100 rounded-full h-2 overflow-hidden relative">
                                                        <div class="h-2 rounded-full {{ $barColor }} progress-bar-fill" style="--target-width: {{ $subPercent }}%"></div>
                                                    </div>
                                                    <span class="text-xs font-black text-gray-500 w-10 text-right">{{ round($subPercent) }}%</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeColor }}">
                                                    {{ $badgeText }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400 border border-gray-100">
                                                <i class="fa-solid fa-clipboard-question text-xl"></i>
                                            </div>
                                            <p class="text-gray-500 font-medium">No attendance data recorded yet.</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection