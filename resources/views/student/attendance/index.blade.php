@extends('layouts.student')

@section('title', 'My Attendance')

@section('content')

@php
    $totalClasses = $attendances->count();
    $totalPresent = $attendances->where('present', true)->count();
    $attendanceRate = $totalClasses > 0 ? round(($totalPresent / $totalClasses) * 100) : 0;
@endphp

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .table-row-anim { opacity: 0; transform: translateX(-10px); animation: slideInRight 0.5s ease forwards; }
    @keyframes slideInRight { to { opacity: 1; transform: translateX(0); } }
    @for ($i = 1; $i <= 20; $i++) .table-row-anim:nth-child({{ $i }}) { animation-delay: {{ $i * 0.05 + 0.2 }}s; } @endfor

    /* ================= CALENDAR HEATMAP STYLES ================= */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 8px;
    }
    .day-box {
        aspect-ratio: 1 / 1;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.875rem;
        transition: transform 0.2s;
    }
    .day-box:hover { transform: scale(1.1); cursor: pointer; }
    
    .day-empty { background-color: transparent; }
    .day-nodata { background-color: #f1f5f9; color: #94a3b8; border: 1px dashed #cbd5e1; }
    .day-present { background-color: #10b981; color: white; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3); }
    .day-absent { background-color: #ef4444; color: white; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto animate-enter">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">My Attendance</h1>
                <p class="text-gray-500 mt-1">Academic Performance Overview</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="bg-white border border-gray-200 rounded-lg px-4 py-2 text-sm shadow-sm">
                    <span class="text-gray-500">Session:</span>
                    <span class="text-gray-900 font-bold ml-1">{{ date('Y') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Classes</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-gray-800">{{ $totalClasses }}</span>
                    <span class="text-sm text-gray-500">sessions</span>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Attendance Score</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-4xl font-bold {{ $attendanceRate >= 75 ? 'text-green-600' : 'text-orange-500' }}">
                        {{ $attendanceRate }}%
                    </span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3">
                    <div class="{{ $attendanceRate >= 75 ? 'bg-green-500' : 'bg-orange-400' }} h-1.5 rounded-full transition-all duration-1000" style="width: {{ $attendanceRate }}%"></div>
                </div>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-shadow">
                <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Days Absent</p>
                <div class="mt-2 flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-red-500">{{ $totalClasses - $totalPresent }}</span>
                    <span class="text-sm text-gray-500">days</span>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mb-8 p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900"><i class="fa-regular fa-calendar-check text-indigo-500 mr-2"></i> Monthly Heatmap ({{ date('F Y') }})</h2>
                <div class="flex gap-4 text-xs font-medium text-gray-500">
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-green-500"></div> Present</div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded-full bg-red-500"></div> Absent</div>
                    <div class="flex items-center gap-1"><div class="w-3 h-3 rounded border border-dashed border-gray-300 bg-gray-50"></div> No Class</div>
                </div>
            </div>

            @php
                // Generate current month calendar logic
                $daysInMonth = \Carbon\Carbon::now()->daysInMonth;
                $firstDayOfMonth = \Carbon\Carbon::now()->startOfMonth()->dayOfWeek; // 0 (Sun) to 6 (Sat)
            @endphp

            <div class="calendar-grid max-w-2xl mx-auto">
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Sun</div>
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Mon</div>
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Tue</div>
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Wed</div>
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Thu</div>
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Fri</div>
                <div class="text-center text-xs font-bold text-gray-400 uppercase">Sat</div>

                @for($i = 0; $i < $firstDayOfMonth; $i++)
                    <div class="day-empty"></div>
                @endfor

                @for($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        // Format date to match dictionary keys (e.g., "2026-03-05")
                        $dateString = \Carbon\Carbon::now()->setDay($day)->format('Y-m-d');
                        
                        $statusClass = 'day-nodata'; // Default gray
                        
                        if(isset($calendarData[$dateString])) {
                            $statusClass = $calendarData[$dateString] == 1 ? 'day-present' : 'day-absent';
                        }
                    @endphp
                    <div class="day-box {{ $statusClass }}" title="{{ \Carbon\Carbon::parse($dateString)->format('M d') }}">
                        {{ $day }}
                    </div>
                @endfor
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="font-bold text-gray-800">Detailed Record</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200 text-gray-500 text-xs uppercase tracking-wider">
                            <th class="p-4 font-semibold">Date</th>
                            <th class="p-4 font-semibold">Subject</th>
                            <th class="p-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($attendances as $attendance)
                            <tr class="table-row-anim hover:bg-indigo-50/50 transition-colors group">
                                <td class="p-4 text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                                </td>

                                <td class="p-4 text-gray-900 font-semibold group-hover:text-indigo-600 transition-colors">
                                    {{ $attendance->subject->name }}
                                </td>

                                <td class="p-4">
                                    @if($attendance->present)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 border border-green-200">
                                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                                            Present
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 border border-red-200">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full mr-1.5"></span>
                                            Absent
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="p-8 text-center text-gray-400">
                                    <div class="flex flex-col items-center">
                                        <svg class="w-10 h-10 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        No attendance records found yet.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection