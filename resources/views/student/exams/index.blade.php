@extends('layouts.student')

@section('title', 'Exam Schedule')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl shadow-sm">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">Exam Schedule</h2>
                <p class="text-sm font-medium text-slate-500 mt-1">View your upcoming examination dates and times.</p>
            </div>
        </div>
        <a href="{{ route('student.admit-card.show') }}" class="px-5 py-2.5 bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-sm font-bold rounded-xl shadow-sm transition-colors flex items-center gap-2">
            <i class="fa-solid fa-file-export"></i> View Admit Card
        </a>
    </div>

    @if($nextExam)
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg border border-indigo-500 overflow-hidden relative">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
            <div class="p-6 md:p-8 relative z-10 flex flex-col md:flex-row items-center gap-6 md:gap-8 text-white">
                <div class="bg-white/20 p-4 rounded-2xl backdrop-blur-sm border border-white/20 text-center min-w-[100px]">
                    <p class="text-3xl font-black">{{ $nextExam->exam_date->format('d') }}</p>
                    <p class="text-sm font-bold uppercase tracking-widest mt-1">{{ $nextExam->exam_date->format('M Y') }}</p>
                </div>
                <div class="flex-1 text-center md:text-left">
                    <span class="inline-block px-3 py-1 bg-white/20 text-white text-[10px] font-black uppercase tracking-widest rounded-full backdrop-blur-sm border border-white/20 mb-3">Next Upcoming Exam</span>
                    <h3 class="text-2xl font-bold">{{ $nextExam->subject_name }}</h3>
                    <div class="flex flex-col sm:flex-row items-center sm:gap-6 mt-3 text-sm font-medium text-indigo-100">
                        <p class="flex items-center gap-2"><i class="fa-regular fa-clock"></i> {{ $nextExam->exam_time }}</p>
                        <p class="flex items-center gap-2 mt-1 sm:mt-0"><i class="fa-solid fa-hashtag"></i> {{ $nextExam->subject_code ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        @if($exams->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/80 border-b border-slate-100">
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @foreach($exams as $exam)
                            @php
                                $isPast = $exam->exam_date->isPast() && !$exam->exam_date->isToday();
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors {{ $isPast ? 'opacity-60 bg-slate-50/30' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl {{ $isPast ? 'bg-slate-100 text-slate-500' : 'bg-indigo-50 text-indigo-600' }} flex flex-col items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-black leading-none">{{ $exam->exam_date->format('d') }}</span>
                                            <span class="text-[9px] font-bold uppercase tracking-wider mt-0.5">{{ $exam->exam_date->format('M') }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold {{ $isPast ? 'text-slate-600' : 'text-slate-800' }}">{{ $exam->exam_date->format('l') }}</p>
                                            <p class="text-xs font-medium text-slate-500 flex items-center gap-1.5 mt-0.5">
                                                <i class="fa-regular fa-clock"></i> {{ $exam->exam_time }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-bold {{ $isPast ? 'text-slate-600' : 'text-slate-800' }}">{{ $exam->subject_name }}</p>
                                    <p class="text-xs font-medium {{ $isPast ? 'text-slate-500' : 'text-indigo-600' }} mt-0.5">{{ $exam->subject_code ?? 'N/A' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($isPast)
                                        <span class="px-3 py-1 bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest rounded-md border border-slate-200">Completed</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-md border border-emerald-200">Upcoming</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 text-slate-300 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fa-regular fa-calendar-xmark text-3xl"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800 mb-1">No Exams Scheduled</h3>
                <p class="text-sm font-medium text-slate-500">Your exam schedule has not been published yet. Please check back later.</p>
            </div>
        @endif
    </div>

</div>
@endsection
