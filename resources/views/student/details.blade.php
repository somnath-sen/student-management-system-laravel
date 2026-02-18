@extends('layouts.student')

@section('title', 'My Profile')

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

    /* Hover Lift Effect */
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto">

        <div class="relative mb-8 animate-enter">
            <div class="h-48 w-full bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-md overflow-hidden relative">
                <div class="absolute inset-0 bg-white/10" style="background-image: radial-gradient(circle at 2px 2px, rgba(255,255,255,0.2) 1px, transparent 0); background-size: 24px 24px;"></div>
            </div>

            <div class="px-8 pb-4 flex flex-col md:flex-row items-end -mt-16 relative z-10">
                
                <div class="relative">
                    <div class="w-32 h-32 rounded-full border-4 border-white bg-white shadow-lg flex items-center justify-center overflow-hidden">
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-indigo-600 text-4xl font-bold uppercase">
                            {{ substr($user->name, 0, 1) }}{{ substr(strrchr($user->name, " "), 1, 1) }}
                        </div>
                    </div>
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full" title="Active Student"></div>
                </div>

                <div class="mt-4 md:mt-0 md:ml-6 flex-1 text-center md:text-left">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 mt-2 text-sm text-gray-600">
                        <span class="flex items-center gap-1 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            Roll No: <span class="font-semibold text-gray-800">{{ $student->roll_number }}</span>
                        </span>
                        <span class="flex items-center gap-1 bg-white px-3 py-1 rounded-full shadow-sm border border-gray-100">
                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                            {{ $user->email }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6 lg:col-span-1 animate-enter stagger-1">
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover-card">
                    <div class="p-6">
                        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Academic Program</h2>
                        
                        @if($course)
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 leading-tight">{{ $course->name }}</h3>
                                    <p class="text-sm text-gray-500 mt-2 leading-relaxed">{{ $course->description }}</p>
                                </div>
                            </div>
                            <div class="mt-6 pt-4 border-t border-gray-100 flex justify-between items-center text-sm">
                                <span class="text-gray-500">Status</span>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold uppercase">Enrolled</span>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-gray-400 italic">No course assigned yet.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover-card">
                    <h2 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Summary</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-800">{{ $subjects->count() }}</div>
                            <div class="text-xs text-gray-500">Subjects</div>
                        </div>
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <div class="text-2xl font-bold text-gray-800">Active</div>
                            <div class="text-xs text-gray-500">Account</div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="lg:col-span-2 animate-enter stagger-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 min-h-[300px]">
                    
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-lg font-bold text-gray-800">Enrolled Subjects</h2>
                        <span class="bg-indigo-100 text-indigo-700 text-xs px-2 py-1 rounded-full font-medium">{{ $subjects->count() }} Total</span>
                    </div>

                    @if($subjects->count())
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($subjects as $subject)
                                <div class="group flex items-center p-4 bg-gray-50 border border-gray-200 rounded-xl hover:border-indigo-300 hover:bg-indigo-50/30 transition-all duration-300">
                                    <div class="flex-shrink-0 w-10 h-10 bg-white rounded-lg flex items-center justify-center text-indigo-500 shadow-sm group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    </div>
                                    
                                    <div class="ml-4">
                                        <h3 class="text-sm font-bold text-gray-900 group-hover:text-indigo-700 transition-colors">{{ $subject->name }}</h3>
                                        <p class="text-xs text-gray-500 mt-0.5">Subject Code: {{ substr(strtoupper($subject->name), 0, 3) }}-{{ rand(100,200) }}</p>
                                    </div>

                                    <div class="ml-auto opacity-0 group-hover:opacity-100 transition-opacity -translate-x-2 group-hover:translate-x-0 duration-300">
                                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex flex-col items-center justify-center h-48 text-center">
                            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <p class="text-gray-500 font-medium">No subjects assigned yet.</p>
                            <p class="text-sm text-gray-400 mt-1">Contact your administrator for enrollment.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@endsection