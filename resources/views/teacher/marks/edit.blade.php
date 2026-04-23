@extends('layouts.teacher')

@section('title', 'Edit Marks - ' . $subject->name)

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

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }

    /* Input Styling */
    .mark-input {
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 800;
        font-size: 1.125rem;
    }
    
    /* Interactive State */
    .mark-input:not(:disabled):focus {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        border-color: #4f46e5;
        background-color: #ffffff;
    }

    /* Locked State */
    .mark-input:disabled {
        background-color: #f8fafc;
        color: #94a3b8;
        cursor: not-allowed;
        border-color: #e2e8f0;
    }

    .table-row-hover { transition: background-color 0.2s; }
    .table-row-hover:hover { background-color: #f8fafc; }
</style>

<div class="min-h-screen bg-slate-50 text-slate-800 p-6 font-sans">
    
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 animate-enter">
            <div>
                <a href="{{ route('teacher.marks.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 mb-3 inline-flex items-center gap-1.5 transition-colors">
                    <i class="fa-solid fa-arrow-left"></i> Back to Subjects
                </a>
                <div class="flex items-center gap-3 mb-1">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Grade Entry</h1>
                    <span class="px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider {{ $isLocked ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $isLocked ? 'Finalized' : 'Editing Mode' }}
                    </span>
                </div>
                <p class="text-slate-500 font-medium mt-1">
                    Course: <span class="text-slate-700 font-bold">{{ $subject->course->name ?? 'General' }}</span>
                    @if($subject->course && $subject->course->course_code)
                        <span class="text-indigo-600 font-bold text-sm ml-2">({{ $subject->course->course_code }})</span>
                    @endif
                </p>
            </div>

            @if(! $isLocked)
                <form method="POST" action="{{ route('teacher.marks.lock', $subject) }}" onsubmit="return confirm('⚠️ ARE YOU SURE?\n\nLocking this result will prevent any further changes. This allows the Admin to publish the grades. This action cannot be undone by you.')" class="mt-4 md:mt-0">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-rose-200 text-rose-600 rounded-xl hover:bg-rose-50 hover:border-rose-300 transition-all shadow-sm font-bold text-sm">
                        <i class="fa-solid fa-lock group-hover:animate-pulse"></i> Lock Results
                    </button>
                </form>
            @endif
        </div>

        @if($isLocked)
            <div class="bg-rose-50 border border-rose-200 p-5 rounded-2xl mb-6 animate-enter stagger-1 shadow-sm flex gap-4 items-start">
                <div class="w-10 h-10 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-shield-halved text-lg"></i>
                </div>
                <div>
                    <h3 class="text-sm font-bold text-rose-800">Result Sheet Locked</h3>
                    <p class="text-sm text-rose-600 mt-1 font-medium">These marks have been finalized and submitted to the administration. They can no longer be edited. Contact the admin if you need to request an override.</p>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('teacher.marks.update', $subject) }}" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden animate-enter stagger-1">
            @csrf
            @method('PUT')

            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                <div>
                    <h2 class="font-bold text-slate-800 text-lg">Student Roster</h2>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Maximum Marks: <span class="font-bold text-slate-700">100</span></p>
                </div>
                @if(!$isLocked)
                    <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 flex items-center gap-1.5">
                        <i class="fa-solid fa-pen-to-square"></i> Editable
                    </span>
                @endif
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-white">
                        <tr class="border-b border-slate-200">
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider w-2/3">Student Information</th>
                            <th class="py-4 px-6 text-xs font-black text-slate-400 uppercase tracking-wider text-center w-1/3">Marks Obtained</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($students as $student)
                            <tr class="table-row-hover group">
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-sm border border-indigo-100 shadow-inner group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            {{ substr($student->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900">{{ $student->user->name }}</p>
                                            <p class="text-xs font-medium text-slate-400 mt-0.5">Roll No: {{ $student->roll_number ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6 text-center">
                                    <div class="relative inline-flex items-center justify-center">
                                        <input type="number" 
                                               name="marks[{{ $student->id }}]" 
                                               value="{{ $marks[$student->id]->marks_obtained ?? '' }}"
                                               class="mark-input w-28 px-3 py-2.5 border border-slate-300 rounded-xl focus:outline-none bg-slate-50 placeholder-slate-300"
                                               min="0" 
                                               max="100"
                                               placeholder="-"
                                               {{ $isLocked ? 'disabled' : 'required' }}>
                                        
                                        @if($isLocked)
                                            <div class="absolute -right-6 text-slate-300">
                                                <i class="fa-solid fa-lock text-sm"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(! $isLocked)
                <div class="p-6 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <p class="text-sm font-medium text-slate-500 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-indigo-400"></i> Changes are not permanent until updated.
                    </p>
                    <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 hover:shadow-lg transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cloud-arrow-up"></i> Update Grades
                    </button>
                </div>
            @endif

        </form>

    </div>
</div>

@endsection