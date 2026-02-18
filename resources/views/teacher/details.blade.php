@extends('layouts.teacher')

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

    /* Hover Effects */
    .hover-card {
        transition: all 0.3s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
        border-color: #818cf8;
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8 animate-enter">
            
            <div class="h-48 w-full bg-gradient-to-r from-indigo-800 to-blue-900 relative">
                <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 24px 24px;"></div>
            </div>

            <div class="px-8 pb-6 relative">
                
                <div class="absolute -top-16 left-8">
                    <div class="w-32 h-32 rounded-full border-4 border-white bg-indigo-600 text-white flex items-center justify-center text-4xl font-bold shadow-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="absolute bottom-2 right-2 w-6 h-6 bg-green-500 border-4 border-white rounded-full"></div>
                </div>

                <div class="pt-20 md:pt-4 md:pl-40 flex flex-col md:flex-row justify-between items-start md:items-center">
                    
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-1 rounded border border-indigo-100 font-semibold uppercase">
                                Faculty
                            </span>
                            <span class="text-gray-500 text-sm flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                                {{ $user->email }}
                            </span>
                        </div>
                    </div>

                    <button class="px-6 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors shadow-lg shadow-gray-200">
                        Edit Profile
                    </button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <div class="lg:col-span-1 space-y-6 animate-enter stagger-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                        <div class="p-1.5 bg-indigo-100 rounded text-indigo-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h2 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Identity Card</h2>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Employee ID</p>
                            <p class="text-lg font-mono font-medium text-gray-800 bg-gray-50 p-2 rounded border border-gray-100">
                                {{ $teacher->employee_id }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-gray-400 font-bold uppercase mb-1">Status</p>
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                <span class="text-sm font-medium text-gray-700">Active Staff Member</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6 animate-enter stagger-2">
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="bg-indigo-600 text-white p-6 rounded-xl shadow-lg shadow-indigo-200 relative overflow-hidden">
                        <div class="absolute -right-6 -top-6 w-24 h-24 bg-white opacity-10 rounded-full"></div>
                        
                        <p class="text-indigo-100 text-sm font-medium">Assigned Subjects</p>
                        <h3 class="text-4xl font-bold mt-1">{{ $subjects->count() }}</h3>
                    </div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <p class="text-gray-500 text-sm font-medium">Current Session</p>
                        <h3 class="text-3xl font-bold text-gray-800 mt-1">{{ date('Y') }}</h3>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-bold text-gray-800">Assigned Classes</h2>
                        <span class="text-xs font-medium text-indigo-600 bg-indigo-50 px-2 py-1 rounded">Semester 1</span>
                    </div>

                    <div class="p-6">
                        @if($subjects->count())
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($subjects as $subject)
                                    <div class="hover-card flex items-start gap-4 p-4 rounded-xl border border-gray-200 bg-white hover:border-indigo-300 transition-all cursor-default">
                                        <div class="w-10 h-10 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center font-bold flex-shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-800">{{ $subject->name }}</h4>
                                            <p class="text-xs text-gray-500 mt-1">Code: {{ strtoupper(substr($subject->name, 0, 3)) }}-10{{ $loop->iteration }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-10">
                                <div class="w-12 h-12 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                </div>
                                <p class="text-gray-500 font-medium">No subjects assigned.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection