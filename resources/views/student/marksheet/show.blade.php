@extends('layouts.student')

@section('title', 'My Marksheet')

@section('content')

@php
    // Calculate summary stats on the fly for the dashboard header
    $publishedMarks = $marks->where('is_published', true);
    $hasPublished = $publishedMarks->count() > 0;
    
    $totalMax = $marks->sum('total_marks');
    $totalObtained = $marks->sum('marks_obtained');
    $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0;
@endphp

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

    /* Staggered delay for table rows */
    @for ($i = 1; $i <= 20; $i++)
        .table-row-anim:nth-child({{ $i }}) {
            animation-delay: {{ $i * 0.05 + 0.3 }}s;
        }
    @endfor
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-5xl mx-auto">

        @if(session('error'))
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm animate-enter">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-enter border border-gray-100">
            
            <div class="h-2 bg-gradient-to-r from-blue-500 to-indigo-600"></div>

            <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Official Marksheet</h1>
                    <p class="text-gray-500 mt-1">Academic Session: {{ date('Y') }}</p>
                </div>

                <div>
                    @if($hasPublished)
                        <a href="{{ route('student.marksheet.pdf') }}" 
                           class="group inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-lg shadow-blue-500/30 transition-all transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Download PDF
                        </a>
                    @else
                        <button onclick="alert('Sorry, your result has not been published yet.')" 
                                class="inline-flex items-center gap-2 bg-gray-100 text-gray-400 px-6 py-3 rounded-xl font-semibold cursor-not-allowed border border-gray-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            Result Pending
                        </button>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x divide-gray-100 bg-gray-50/50">
                <div class="p-6 text-center">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Obtained</p>
                    <p class="text-2xl font-bold text-gray-800 mt-1">{{ $totalObtained }} <span class="text-sm text-gray-400 font-medium">/ {{ $totalMax }}</span></p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Percentage</p>
                    <p class="text-2xl font-bold text-blue-600 mt-1">{{ $percentage }}%</p>
                </div>
                <div class="p-6 text-center">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Result Status</p>
                    <span class="inline-flex items-center mt-2 px-3 py-1 rounded-full text-xs font-medium {{ $percentage >= 40 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $percentage >= 40 ? 'PASS' : 'FAIL' }}
                    </span>
                </div>
            </div>

            <div class="overflow-x-auto p-2">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="text-gray-500 text-xs uppercase tracking-wider border-b border-gray-100">
                            <th class="p-5 font-semibold bg-gray-50 rounded-tl-lg">Subject</th>
                            <th class="p-5 font-semibold bg-gray-50 text-center">Marks Obtained</th>
                            <th class="p-5 font-semibold bg-gray-50 text-center">Total Marks</th>
                            <th class="p-5 font-semibold bg-gray-50 text-right rounded-tr-lg">Performance</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($marks as $mark)
                            @php
                                $rowPercent = $mark->total_marks > 0 ? ($mark->marks_obtained / $mark->total_marks) * 100 : 0;
                            @endphp
                            <tr class="table-row-anim hover:bg-blue-50/30 transition-colors group">
                                <td class="p-5">
                                    <div class="font-semibold text-gray-800">{{ $mark->subject->name }}</div>
                                </td>
                                
                                <td class="p-5 text-center">
                                    <span class="inline-block px-3 py-1 bg-white border border-gray-200 rounded-md shadow-sm font-bold text-gray-700 group-hover:border-blue-200 group-hover:text-blue-600 transition-colors">
                                        {{ $mark->marks_obtained }}
                                    </span>
                                </td>

                                <td class="p-5 text-center text-gray-500 font-medium">
                                    {{ $mark->total_marks }}
                                </td>

                                <td class="p-5 text-right align-middle">
                                    <div class="flex items-center justify-end gap-3">
                                        <div class="w-24 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                            <div class="h-full {{ $rowPercent >= 40 ? 'bg-blue-500' : 'bg-red-400' }} rounded-full" style="width: {{ $rowPercent }}%"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-12 text-center text-gray-400">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3">
                                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <p>No results have been released yet.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-gray-50 p-4 text-center border-t border-gray-100">
                <p class="text-xs text-gray-400">This is a computer-generated marksheet.</p>
            </div>
            
        </div>
    </div>
</div>

@endsection