@extends('layouts.student')

@section('title', 'My Profile')

@section('content')

<style>
    /* ================= FORCE LIGHT BACKGROUND ================= */
    body {
        background-color: #FDFBF7 !important; /* Premium Creamy White */
    }

    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }

    /* Hover Lift Effect */
    .hover-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px -6px rgba(0, 0, 0, 0.05), 0 4px 8px -4px rgba(0, 0, 0, 0.03);
    }
</style>

<div class="min-h-screen text-slate-800 p-4 sm:p-6 lg:p-8 font-sans">
    
    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-[#F0EBE1] overflow-hidden mb-8 animate-enter relative">
            
            <div class="h-40 md:h-52 w-full bg-gradient-to-r from-indigo-600 via-purple-600 to-indigo-800 relative">
                <div class="absolute inset-0 bg-white/10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.2) 1px, transparent 0); background-size: 24px 24px;"></div>
            </div>

            <div class="px-6 md:px-10 pb-8 relative">
                
                <div class="absolute -top-16 md:-top-20 left-6 md:left-10">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white bg-white shadow-xl flex items-center justify-center overflow-hidden relative">
                        <div class="w-full h-full bg-slate-50 flex items-center justify-center text-indigo-600 text-5xl font-black uppercase">
                            {{ isset($user->name) ? substr($user->name, 0, 1) : 'S' }}
                        </div>
                        <div class="absolute bottom-3 right-3 w-6 h-6 bg-emerald-500 border-4 border-white rounded-full" title="Active Student"></div>
                    </div>
                </div>

                <div class="pt-20 md:pt-4 md:pl-48 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    
                    <div>
                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">{{ $user->name ?? 'Student Name' }}</h1>
                        
                        <div class="flex flex-wrap items-center gap-3 mt-3 text-sm font-bold">
                            <span class="flex items-center gap-1.5 bg-indigo-50 text-indigo-700 px-3 py-1.5 rounded-lg border border-indigo-100">
                                <i class="fa-solid fa-id-card"></i>
                                Roll No: <span class="font-black">{{ $student->roll_number ?? 'N/A' }}</span>
                            </span>
                            <span class="flex items-center gap-1.5 bg-slate-50 text-slate-600 px-3 py-1.5 rounded-lg border border-slate-200">
                                <i class="fa-solid fa-envelope"></i>
                                {{ $user->email ?? 'No email provided' }}
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('profile.edit') }}" class="inline-flex items-center justify-center px-6 py-3 bg-slate-900 text-white font-bold rounded-xl shadow-md hover:bg-indigo-600 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200 w-full md:w-auto group">
                        <i class="fa-solid fa-user-pen mr-2 group-hover:scale-110 transition-transform"></i>
                        Edit Profile
                    </a>

                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6 lg:col-span-1 animate-enter stagger-1">
                
                <div class="bg-white rounded-2xl shadow-sm border border-[#F0EBE1] overflow-hidden hover-card">
                    <div class="p-6 border-b border-[#F0EBE1] bg-[#FDFBF7]">
                        <h2 class="text-xs font-black text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-indigo-500"></i> Academic Program
                        </h2>
                    </div>
                    
                    <div class="p-6">
                        @if(isset($course))
                            <h3 class="text-xl font-bold text-slate-900 leading-tight">{{ $course->name }}</h3>
                            <p class="text-sm text-slate-500 mt-2 leading-relaxed font-medium">{{ $course->description ?? 'No description available for this course.' }}</p>
                            
                            <div class="mt-6 pt-5 border-t border-[#F0EBE1] flex justify-between items-center">
                                <span class="text-sm font-bold text-slate-400 uppercase tracking-wider">Status</span>
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-black uppercase tracking-wide border border-emerald-200">
                                    Enrolled
                                </span>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                    <i class="fa-solid fa-book-open-reader"></i>
                                </div>
                                <p class="text-slate-500 font-medium">No course assigned yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-[#F0EBE1] overflow-hidden hover-card">
                    <div class="p-6">
                        <h2 class="text-xs font-black text-slate-400 uppercase tracking-wider mb-5">Account Summary</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-[#FDFBF7] rounded-xl border border-[#F0EBE1]">
                                <div class="text-3xl font-black text-indigo-600">{{ isset($subjects) ? $subjects->count() : 0 }}</div>
                                <div class="text-xs font-bold text-slate-500 uppercase mt-1">Subjects</div>
                            </div>
                            <div class="text-center p-4 bg-[#FDFBF7] rounded-xl border border-[#F0EBE1]">
                                <div class="text-3xl font-black text-emerald-500"><i class="fa-solid fa-check"></i></div>
                                <div class="text-xs font-bold text-slate-500 uppercase mt-1">Active</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-2 animate-enter stagger-2">
                <div class="bg-white rounded-2xl shadow-sm border border-[#F0EBE1] overflow-hidden min-h-[300px] flex flex-col">
                    
                    <div class="p-6 border-b border-[#F0EBE1] bg-[#FDFBF7] flex items-center justify-between">
                        <h2 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                            <i class="fa-solid fa-book text-indigo-500"></i> Enrolled Subjects
                        </h2>
                        <span class="bg-indigo-100 text-indigo-700 text-xs px-3 py-1.5 rounded-lg font-bold border border-indigo-200">
                            {{ isset($subjects) ? $subjects->count() : 0 }} Total
                        </span>
                    </div>

                    <div class="p-6 flex-1">
                        @if(isset($subjects) && $subjects->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($subjects as $subject)
                                    <div class="group flex items-center p-4 bg-[#FDFBF7] border border-[#F0EBE1] rounded-xl hover:border-indigo-300 hover:bg-white transition-all duration-300 hover:shadow-sm cursor-default">
                                        
                                        <div class="flex-shrink-0 w-12 h-12 bg-white border border-[#F0EBE1] rounded-lg flex items-center justify-center text-indigo-500 font-black text-lg shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        
                                        <div class="ml-4">
                                            <h3 class="text-sm font-bold text-slate-900 group-hover:text-indigo-700 transition-colors">{{ $subject->name }}</h3>
                                            <p class="text-xs font-bold text-slate-400 mt-1 tracking-wide uppercase">
                                                Code: {{ substr(strtoupper($subject->name), 0, 3) }}-{{ rand(100,200) }}
                                            </p>
                                        </div>

                                        <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300">
                                            <i class="fa-solid fa-chevron-right text-indigo-400 text-sm"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full py-10 text-center">
                                <div class="w-16 h-16 bg-[#FDFBF7] border border-[#F0EBE1] rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-folder-open text-2xl text-slate-300"></i>
                                </div>
                                <p class="text-slate-600 font-bold text-lg">No subjects assigned yet.</p>
                                <p class="text-sm text-slate-400 font-medium mt-1">Contact your administrator for enrollment.</p>
                            </div>
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection