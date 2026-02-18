@extends('layouts.student')

@section('title', 'My Results')

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

    .table-row-anim {
        opacity: 0;
        transform: translateX(-10px);
        animation: slideInRight 0.5s ease forwards;
    }

    @keyframes slideInRight {
        to { opacity: 1; transform: translateX(0); }
    }

    @for ($i = 1; $i <= 20; $i++)
        .table-row-anim:nth-child({{ $i }}) {
            animation-delay: {{ $i * 0.05 + 0.2 }}s;
        }
    @endfor

    /* Circular Progress Animation */
    .progress-ring__circle {
        transition: stroke-dashoffset 1.5s ease-in-out;
        transform: rotate(-90deg);
        transform-origin: 50% 50%;
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto animate-enter">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-4 border-b border-gray-200">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-gray-900">Academic Results</h1>
                <p class="text-gray-500 mt-1">Performance summary and grade report.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700 border border-blue-200">
                    Final Report
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider">Total Score</h3>
                    <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-4xl font-bold text-gray-900">{{ $totalObtained }}</span>
                    <span class="text-lg text-gray-400">/ {{ $totalMarks }}</span>
                </div>
                <p class="text-sm text-gray-500 mt-2">Aggregate score across all subjects</p>
            </div>

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300 flex items-center justify-between relative overflow-hidden">
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Percentage</h3>
                    <span class="text-4xl font-bold text-blue-600">{{ $percentage }}%</span>
                    <p class="text-sm text-gray-500 mt-2">Weighted average</p>
                </div>
                
                <div class="relative w-24 h-24">
                    <svg class="w-full h-full" viewBox="0 0 36 36">
                        <path class="text-gray-100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3" />
                        <path class="text-blue-500 progress-ring__circle" 
                              stroke-dasharray="{{ $percentage }}, 100" 
                              d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" 
                              fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                    </svg>
                </div>
            </div>

            @php
                $grade = '';
                $gradeColor = '';
                $gradeBg = '';
                
                if($percentage >= 90) { $grade = 'A+'; $gradeColor = 'text-green-600'; $gradeBg = 'bg-green-50'; }
                elseif($percentage >= 80) { $grade = 'A'; $gradeColor = 'text-emerald-600'; $gradeBg = 'bg-emerald-50'; }
                elseif($percentage >= 70) { $grade = 'B'; $gradeColor = 'text-blue-600'; $gradeBg = 'bg-blue-50'; }
                elseif($percentage >= 60) { $grade = 'C'; $gradeColor = 'text-orange-600'; $gradeBg = 'bg-orange-50'; }
                else { $grade = 'D'; $gradeColor = 'text-red-600'; $gradeBg = 'bg-red-50'; }
            @endphp

            <div class="bg-white border border-gray-100 rounded-xl p-6 shadow-sm hover:shadow-md transition-all duration-300">
                <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Overall Grade</h3>
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-full {{ $gradeBg }} flex items-center justify-center border-4 border-white shadow-sm">
                        <span class="text-2xl font-bold {{ $gradeColor }}">{{ $grade }}</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Performance Status:</p>
                        <p class="font-semibold {{ $gradeColor }}">
                            @if($percentage >= 60) Satisfactory @else Needs Improvement @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h2 class="font-semibold text-gray-800">Subject Breakdown</h2>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                            <th class="p-5 font-semibold">Subject</th>
                            <th class="p-5 font-semibold w-1/3">Performance</th> <th class="p-5 font-semibold">Score</th>
                            <th class="p-5 font-semibold">Teacher</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($marks as $mark)
                            @php
                                $subjectPercent = ($mark->total_marks > 0) ? round(($mark->marks_obtained / $mark->total_marks) * 100) : 0;
                                // Dynamic color for progress bar
                                $barColor = $subjectPercent >= 75 ? 'bg-green-500' : ($subjectPercent >= 50 ? 'bg-blue-500' : 'bg-red-400');
                            @endphp
                            <tr class="table-row-anim hover:bg-gray-50 transition-colors group">
                                <td class="p-5">
                                    <div class="font-semibold text-gray-900">{{ $mark->subject->name }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">Code: {{ substr(strtoupper($mark->subject->name), 0, 3) }}-101</div>
                                </td>

                                <td class="p-5 align-middle">
                                    <div class="w-full bg-gray-100 rounded-full h-2 mb-1">
                                        <div class="{{ $barColor }} h-2 rounded-full transition-all duration-1000 ease-out" style="width: {{ $subjectPercent }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-400 text-right">{{ $subjectPercent }}% efficiency</div>
                                </td>

                                <td class="p-5">
                                    <span class="inline-block px-3 py-1 bg-gray-100 rounded-lg font-bold text-gray-700">
                                        {{ $mark->marks_obtained }} <span class="text-gray-400 font-normal text-xs">/{{ $mark->total_marks }}</span>
                                    </span>
                                </td>

                                <td class="p-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-bold uppercase">
                                            {{ substr($mark->teacher->user->name, 0, 2) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">{{ $mark->teacher->user->name }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">No results published</p>
                                        <p class="text-sm mt-1">Check back later for updates.</p>
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