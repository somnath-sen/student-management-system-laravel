@extends('layouts.teacher')

@section('title', 'Performance Detail - ' . $subject->name)

@section('content')

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Table Row Hover */
    .table-row {
        transition: background-color 0.2s ease;
    }
    .table-row:hover {
        background-color: #f8fafc; /* Slate-50 */
    }
</style>

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <div class="flex items-center gap-3">
                <a href="{{ route('teacher.performance.index') }}" class="p-2 rounded-full hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-3xl font-bold text-gray-900">Performance Report</h1>
            </div>
            <p class="text-gray-500 mt-1 ml-12">Detailed analysis for <span class="font-semibold text-indigo-600">{{ $subject->name }}</span></p>
        </div>

        <div class="flex items-center gap-3">
            <span class="px-3 py-1 bg-white border border-gray-200 rounded-full text-xs font-semibold text-gray-600 shadow-sm">
                {{ $students->count() }} Students Enrolled
            </span>
            <button onclick="window.print()" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-indigo-600 shadow-sm transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </button>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter" style="animation-delay: 0.1s;">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Student Name</th>
                        <th class="px-6 py-4 w-1/4">Attendance</th>
                        <th class="px-6 py-4 w-1/4">Marks Avg.</th>
                        <th class="px-6 py-4 text-center">Final Score</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($students as $index => $student)
                        @php
                            $data = $analytics[$student->id];
                            $color = $data['color']; 
                            // Map 'green' to specific tailwind classes safely if using dynamic strings
                            $badgeClass = match($color) {
                                'green' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'blue'  => 'bg-blue-100 text-blue-700 border-blue-200',
                                'yellow'=> 'bg-amber-100 text-amber-700 border-amber-200', 
                                'red'   => 'bg-rose-100 text-rose-700 border-rose-200',
                                default => 'bg-gray-100 text-gray-700 border-gray-200'
                            };
                            $barColor = match($color) {
                                'green' => 'bg-emerald-500',
                                'blue'  => 'bg-blue-500',
                                'yellow'=> 'bg-amber-500', 
                                'red'   => 'bg-rose-500',
                                default => 'bg-gray-500'
                            };
                        @endphp

                        <tr class="table-row animate-enter" style="animation-delay: {{ ($index * 50) + 100 }}ms;">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-sm border border-indigo-100">
                                        {{ substr($student->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $student->user->name }}</div>
                                        <div class="text-xs text-gray-500">ID: {{ $student->roll_number ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $data['attendancePercentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: {{ $data['attendancePercentage'] }}%"></div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-sm font-medium text-gray-700">{{ $data['marksPercentage'] }}%</span>
                                </div>
                                <div class="w-full bg-gray-100 rounded-full h-1.5">
                                    <div class="bg-purple-500 h-1.5 rounded-full" style="width: {{ $data['marksPercentage'] }}%"></div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-bold text-gray-800">{{ $data['performanceScore'] }}%</span>
                            </td>

                            <td class="px-6 py-4 text-right">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $badgeClass }}">
                                    {{ $data['category'] }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">No Students Found</h3>
                                    <p class="text-gray-500 mt-1">There are no students enrolled in this subject yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex justify-between items-center">
            <span>Score Calculation: (Attendance + Marks) / 2</span>
            <span>Generated on {{ now()->format('M d, Y') }}</span>
        </div>
    </div>
</div>

@endsection