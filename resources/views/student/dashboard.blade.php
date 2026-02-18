@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }
    .stagger-4 { animation-delay: 0.4s; }

    /* Progress Bar Animation */
    .progress-bar-fill {
        width: 0;
        animation: fillBar 1.5s ease-out forwards;
        animation-delay: 0.5s;
    }

    @keyframes fillBar {
        to { width: var(--target-width); }
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between animate-enter">
            <div>
                <p class="text-gray-500 text-sm font-medium uppercase tracking-wider mb-1">Student Portal</p>
                <h1 class="text-3xl font-bold text-gray-900">
                    Welcome back, <span class="text-indigo-600">{{ $student->user->name }}</span>
                </h1>
            </div>
            <div class="mt-4 md:mt-0 text-right">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white rounded-full shadow-sm border border-gray-200 text-sm text-gray-600">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <span>{{ now()->format('l, d F Y') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-enter stagger-1">
            
            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all relative overflow-hidden group">
                <div class="absolute right-0 top-0 w-24 h-24 bg-indigo-50 rounded-full blur-2xl -mr-10 -mt-10 opacity-50 transition-opacity group-hover:opacity-100"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Attendance Rate</p>
                        <h3 class="text-3xl font-bold {{ $attendancePercentage >= 75 ? 'text-indigo-600' : 'text-orange-500' }} mt-2">
                            {{ $attendancePercentage }}%
                        </h3>
                    </div>
                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    </div>
                </div>
                <div class="w-full bg-gray-100 h-1.5 rounded-full mt-4 overflow-hidden">
                    <div class="h-full {{ $attendancePercentage >= 75 ? 'bg-indigo-500' : 'bg-orange-400' }} progress-bar-fill" style="--target-width: {{ $attendancePercentage }}%"></div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Classes</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalClasses }}</h3>
                    </div>
                    <div class="p-2 bg-gray-50 rounded-lg text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-4">Conducted so far</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Days Present</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-2">{{ $presentCount }}</h3>
                    </div>
                    <div class="p-2 bg-green-50 rounded-lg text-green-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-green-600 mt-4 font-medium">Keep it up!</p>
            </div>

            <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition-all">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Days Absent</p>
                        <h3 class="text-3xl font-bold text-red-500 mt-2">{{ $absentCount }}</h3>
                    </div>
                    <div class="p-2 bg-red-50 rounded-lg text-red-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-red-400 mt-4">Requires attention</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6 animate-enter stagger-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-indigo-600 px-6 py-4">
                        <h2 class="text-white font-semibold text-lg flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            My Course
                        </h2>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $course->name }}</h3>
                        @if($course->description)
                            <p class="text-gray-600 text-sm mb-4 leading-relaxed">{{ $course->description }}</p>
                        @endif
                        
                        <div class="border-t border-gray-100 pt-4 mt-4">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Enrolled Subjects</p>
                            <div class="flex flex-wrap gap-2">
                                @forelse($subjects as $subject)
                                    <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium border border-gray-200">
                                        {{ $subject->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-sm italic">No subjects enrolled</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 animate-enter stagger-3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h2 class="font-bold text-gray-800 text-lg">Subject-wise Analytics</h2>
                        <button class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">View All</button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                                    <th class="px-6 py-4 font-semibold">Subject</th>
                                    <th class="px-6 py-4 font-semibold text-center">Sessions</th>
                                    <th class="px-6 py-4 font-semibold w-1/3">Performance</th>
                                    <th class="px-6 py-4 font-semibold text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($subjectAttendance as $row)
                                    @php
                                        $subPercent = $row->total_classes > 0 ? round(($row->present_count / $row->total_classes) * 100, 2) : 0;
                                        $barColor = $subPercent >= 75 ? 'bg-indigo-500' : ($subPercent >= 60 ? 'bg-yellow-400' : 'bg-red-400');
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4">
                                            <div class="font-medium text-gray-900">{{ $row->subject->name }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <span class="text-gray-600 text-sm">
                                                <span class="font-bold text-gray-900">{{ $row->present_count }}</span> / {{ $row->total_classes }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 align-middle">
                                            <div class="flex items-center gap-3">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                    <div class="h-2 rounded-full {{ $barColor }} progress-bar-fill" style="--target-width: {{ $subPercent }}%"></div>
                                                </div>
                                                <span class="text-xs font-bold text-gray-500 w-10 text-right">{{ round($subPercent) }}%</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            @if($subPercent >= 75)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Good
                                                </span>
                                            @elseif($subPercent >= 60)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Average
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Low
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                                            No attendance data found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection