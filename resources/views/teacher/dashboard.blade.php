@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

@section('content')

<style>
    /* ================= PREMIUM ANIMATIONS ================= */
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Staggered Delays */
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-500 { animation-delay: 500ms; }

    /* Interactive Cards */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.05), 0 4px 8px -4px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="min-h-screen bg-[#FDFBF7] text-slate-800 font-sans p-4 sm:p-6 lg:p-8 transition-colors duration-300">
    
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between animate-fade-up">
            <div>
                <p class="text-indigo-600 font-semibold tracking-wider uppercase text-xs mb-1 flex items-center gap-2">
                    <i class="fa-solid fa-chalkboard-user"></i> Instructor Portal
                </p>
                <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">
                    Welcome back, <span class="text-indigo-600">{{ auth()->user()->name ?? 'Professor' }}</span>
                </h1>
                <p class="text-slate-500 mt-2 font-medium">Manage your classes, record attendance, and evaluate student performance.</p>
            </div>
            <div class="mt-4 md:mt-0 flex gap-3">
                <div class="bg-white px-4 py-2.5 rounded-xl shadow-sm border border-[#F0EBE1] text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <span class="relative flex h-2.5 w-2.5">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-500"></span>
                    </span>
                    Academic Session: {{ date('Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-up delay-100">
            
            <div class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-6 text-white shadow-md relative overflow-hidden group">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-white opacity-5 rounded-full z-0 group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 flex justify-between items-start">
                    <div>
                        <p class="text-indigo-100 text-xs font-semibold uppercase tracking-wider mb-1">My Subjects</p>
                        <h3 class="text-4xl font-bold tracking-tight">{{ $subjects->count() ?? 0 }}</h3>
                    </div>
                    <div class="w-12 h-12 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-book-open text-xl"></i>
                    </div>
                </div>
                <p class="text-xs text-indigo-100/80 mt-4 font-medium relative z-10">Assigned for this semester</p>
            </div>

            <a href="{{ route('teacher.attendance.create') }}" class="stat-card bg-white rounded-2xl p-6 border border-[#F0EBE1] cursor-pointer group flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-500 group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-clipboard-user text-xl"></i>
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-emerald-500 transform group-hover:translate-x-1 transition-all"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">Mark Attendance</h3>
                    <p class="text-xs text-slate-500 mt-1">Record daily student presence</p>
                </div>
            </a>

            <a href="{{ route('teacher.marks.index') }}" class="stat-card bg-white rounded-2xl p-6 border border-[#F0EBE1] cursor-pointer group flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-500 group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-file-pen text-xl"></i>
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-amber-500 transform group-hover:translate-x-1 transition-all"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">Upload Marks</h3>
                    <p class="text-xs text-slate-500 mt-1">Grade assignments and exams</p>
                </div>
            </a>

            <a href="{{ route('teacher.performance.index') }}" class="stat-card bg-white rounded-2xl p-6 border border-[#F0EBE1] cursor-pointer group flex flex-col justify-between h-full">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:bg-sky-500 group-hover:text-white transition-colors duration-300">
                        <i class="fa-solid fa-chart-line text-xl"></i>
                    </div>
                    <i class="fa-solid fa-arrow-right text-slate-300 group-hover:text-sky-500 transform group-hover:translate-x-1 transition-all"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-lg">Performance</h3>
                    <p class="text-xs text-slate-500 mt-1">View class analytics & trends</p>
                </div>
            </a>
        </div>

        <div class="animate-fade-up delay-200">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-layer-group text-indigo-500"></i> My Assigned Subjects
                </h2>
                <span class="text-xs font-semibold text-slate-600 bg-[#F5F0E6] px-3 py-1.5 rounded-md border border-[#EBE4D5]">
                    {{ $subjects->count() ?? 0 }} Classes
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($subjects as $index => $subject)
                    <div class="stat-card bg-white rounded-2xl border border-[#F0EBE1] p-6 relative overflow-hidden group flex flex-col h-full">
                        
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-10 h-10 rounded-lg bg-[#FDFBF7] text-slate-700 flex items-center justify-center border border-[#F0EBE1] group-hover:border-indigo-300 transition-colors">
                                <span class="font-bold text-lg">{{ substr($subject->name, 0, 1) }}</span>
                            </div>
                            <span class="text-slate-400 text-[10px] uppercase font-bold tracking-wider">
                                Sub-{{ $index + 1 }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors">{{ $subject->name }}</h3>
                        <p class="text-sm text-slate-500 mb-6 leading-relaxed">Manage your curriculum, student records, and grading for this subject.</p>

                        <div class="border-t border-[#F0EBE1] pt-4 mt-auto flex items-center justify-between gap-3">
                            <a href="{{ route('teacher.marks.edit', $subject->id) }}" class="flex-1 text-center py-2 px-3 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-lg transition-colors border border-indigo-100">
                                Edit Marks
                            </a>
                            <a href="{{ route('teacher.performance.show', $subject->id) }}" class="p-2 border border-[#F0EBE1] hover:border-slate-300 text-slate-600 rounded-lg transition-colors tooltip" title="View Analysis">
                                <i class="fa-solid fa-chart-pie"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-16 text-center bg-white rounded-2xl border border-dashed border-[#EBE4D5]">
                        <div class="w-16 h-16 bg-[#FDFBF7] rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400 border border-[#F0EBE1]">
                            <i class="fa-solid fa-folder-open text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1">No Subjects Assigned</h3>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto">You haven't been assigned any subjects for this semester yet. Please contact the Administration.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="animate-fade-up delay-300 mt-8">
            <div class="bg-slate-900 rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between border border-slate-800 relative overflow-hidden shadow-lg">
                <div class="absolute top-1/2 left-0 -translate-y-1/2 w-64 h-64 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="flex items-center gap-5 mb-5 md:mb-0 relative z-10">
                    <div class="w-14 h-14 rounded-xl bg-gradient-to-tr from-indigo-500 to-blue-500 p-0.5 shadow-lg">
                        <div class="w-full h-full bg-slate-900 rounded-[10px] flex items-center justify-center text-indigo-300">
                            <i class="fa-solid fa-robot text-xl"></i>
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">StudyAI Assistant</h3>
                        <p class="text-slate-400 text-sm mt-1">Generate lesson plans, quizzes, and summaries instantly.</p>
                    </div>
                </div>
                <a href="{{ route('studyai.index') }}" class="px-6 py-2.5 bg-white text-slate-900 hover:bg-slate-100 font-bold rounded-lg transition-transform transform hover:-translate-y-0.5 flex items-center gap-2 w-full md:w-auto justify-center shadow-sm relative z-10">
                    Launch AI <i class="fa-solid fa-sparkles text-indigo-600 text-sm"></i>
                </a>
            </div>
        </div>

    </div>
</div>

@endsection