@extends('layouts.student')

@section('title', 'My Marksheet')

@section('content')

@php
    // The controller already filters marks by is_locked = true (published)
    // is_locked = true means the result has been published by admin
    $publishedMarks = $marks; // all marks passed in are already published
    $hasPublished = $publishedMarks->count() > 0;
    
    $totalMax = $publishedMarks->sum('total_marks');
    $totalObtained = $publishedMarks->sum('marks_obtained');
    $percentage = $totalMax > 0 ? round(($totalObtained / $totalMax) * 100, 2) : 0;

    // ✅ FIXED: Using an anonymous function (Closure) prevents PHP Redeclaration Errors
    $getGrade = function($percent) {
        if($percent >= 90) return ['grade' => 'A+', 'color' => 'text-emerald-600', 'bg' => 'bg-emerald-100'];
        if($percent >= 80) return ['grade' => 'A', 'color' => 'text-emerald-500', 'bg' => 'bg-emerald-50'];
        if($percent >= 70) return ['grade' => 'B+', 'color' => 'text-blue-600', 'bg' => 'bg-blue-100'];
        if($percent >= 60) return ['grade' => 'B', 'color' => 'text-blue-500', 'bg' => 'bg-blue-50'];
        if($percent >= 50) return ['grade' => 'C', 'color' => 'text-amber-600', 'bg' => 'bg-amber-100'];
        if($percent >= 40) return ['grade' => 'D', 'color' => 'text-amber-500', 'bg' => 'bg-amber-50'];
        return ['grade' => 'F', 'color' => 'text-rose-600', 'bg' => 'bg-rose-100'];
    };
@endphp

<style>
    .animate-enter { animation: fadeUp 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .table-row-anim { opacity: 0; transform: translateX(-10px); animation: slideInRight 0.5s ease forwards; }
    @keyframes slideInRight { to { opacity: 1; transform: translateX(0); } }
    @for ($i = 1; $i <= 20; $i++) .table-row-anim:nth-child({{ $i }}) { animation-delay: {{ $i * 0.05 + 0.2 }}s; } @endfor
</style>

<div class="max-w-5xl mx-auto">

    @if(!$hasPublished && $marks->count() > 0)
        <div class="mb-6 bg-amber-50 border border-amber-200 p-4 rounded-xl shadow-sm flex items-center gap-3 animate-enter">
            <i class="fa-solid fa-lock text-amber-500 text-xl"></i>
            <div>
                <h3 class="text-sm font-bold text-amber-800">Results Locked</h3>
                <p class="text-xs font-medium text-amber-700 mt-0.5">Your examinations have been graded, but the administration has not published them yet.</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden animate-enter border border-slate-200">
        
        <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

        <div class="p-8 border-b border-slate-100 flex flex-col md:flex-row md:items-center justify-between gap-6 bg-slate-50/50">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Official Transcript</h1>
                <p class="text-slate-500 mt-1 font-medium"><i class="fa-regular fa-calendar mr-1"></i> Academic Session: {{ date('Y') }}</p>
                @if($student->course && $student->course->course_code)
                    <p class="text-indigo-600 mt-1 font-bold text-sm uppercase"><i class="fa-solid fa-graduation-cap mr-1"></i> Course ID: {{ $student->course->course_code }}</p>
                @endif
            </div>

            <div>
                @if($hasPublished)
                    <div class="flex gap-2">
                        <a href="{{ route('student.marksheet.pdf') }}" target="_blank" class="group inline-flex items-center gap-2 bg-slate-100 hover:bg-slate-200 text-slate-800 px-5 py-2.5 rounded-xl font-bold shadow-sm hover:shadow transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-file-pdf text-rose-500 group-hover:scale-110 transition-transform"></i> Marksheet
                        </a>
                        <a href="{{ route('student.report-card.download') }}" target="_blank" class="group inline-flex items-center gap-2 bg-slate-900 hover:bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-bold shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-certificate group-hover:scale-110 transition-transform"></i> Report Card
                        </a>
                    </div>
                @else
                    <button disabled class="inline-flex items-center gap-2 bg-slate-100 text-slate-400 px-6 py-3 rounded-xl font-bold cursor-not-allowed border border-slate-200">
                        <i class="fa-solid fa-clock"></i> Pending Publication
                    </button>
                @endif
            </div>
        </div>

        @if($hasPublished)
            <div class="grid grid-cols-1 md:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-slate-100 border-b border-slate-100">
                <div class="p-6 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1">Total Score</p>
                    <p class="text-3xl font-black text-slate-900">{{ number_format($totalObtained, 0) }} <span class="text-sm text-slate-400">/ {{ number_format($totalMax, 0) }}</span></p>
                </div>
                <div class="p-6 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-1">Percentage</p>
                    <p class="text-3xl font-black text-indigo-600">{{ $percentage }}%</p>
                </div>
                <div class="p-6 text-center hover:bg-slate-50 transition-colors">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Overall Grade</p>
                    @php $overallGrade = $getGrade($percentage); @endphp
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl font-black text-xl {{ $overallGrade['bg'] }} {{ $overallGrade['color'] }} shadow-sm">
                        {{ $overallGrade['grade'] }}
                    </span>
                </div>
                <div class="p-6 text-center hover:bg-slate-50 transition-colors flex flex-col justify-center items-center">
                    <p class="text-xs font-black text-slate-400 uppercase tracking-wider mb-2">Status</p>
                    @if($percentage >= 40)
                        <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-emerald-500 text-white shadow-sm flex items-center gap-1"><i class="fa-solid fa-check"></i> PASSED</span>
                    @else
                        <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-rose-500 text-white shadow-sm flex items-center gap-1"><i class="fa-solid fa-xmark"></i> FAILED</span>
                    @endif
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200">
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider w-1/2">Subject</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider text-center">Score</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider text-center">Grade</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($publishedMarks as $mark)
                            @php
                                $rowPercent = $mark->total_marks > 0 ? ($mark->marks_obtained / $mark->total_marks) * 100 : 0;
                                $rowGrade = $getGrade($rowPercent);
                            @endphp
                            <tr class="table-row-anim hover:bg-slate-50 transition-colors group">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-900 text-lg">{{ $mark->subject->name }}</div>
                                    <div class="text-xs font-bold text-slate-400 mt-0.5">{{ $mark->subject->subject_code ?? 'SUB-'.$mark->subject->id }}</div>
                                </td>
                                
                                <td class="py-4 px-6 text-center">
                                    <div class="font-black text-slate-800 text-xl">{{ number_format($mark->marks_obtained, 0) }}</div>
                                    <div class="text-xs text-slate-400 font-medium">out of {{ number_format($mark->total_marks, 0) }}</div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <span class="inline-block px-3 py-1 rounded-lg font-bold text-sm {{ $rowGrade['bg'] }} {{ $rowGrade['color'] }} border border-transparent group-hover:border-current transition-colors">
                                        {{ $rowGrade['grade'] }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 p-4 text-center border-t border-slate-200">
                <p class="text-xs font-medium text-slate-400"><i class="fa-solid fa-shield-halved mr-1"></i> This is a verified, computer-generated official marksheet.</p>
            </div>
        @else
            <div class="p-16 text-center">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <i class="fa-solid fa-file-circle-xmark text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-800">No Grades Available</h3>
                <p class="text-slate-500 font-medium mt-1">Check back later after the administration publishes the results.</p>
            </div>
        @endif
        
    </div>
</div>
@endsection