@extends('layouts.teacher')

@section('title', 'Teacher Dashboard')

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

    /* Staggered Animation for Grid Items */
    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }
    .stagger-3 { animation-delay: 0.3s; }

    .subject-card {
        opacity: 0;
        animation: slideUpCard 0.6s ease-out forwards;
    }

    @keyframes slideUpCard {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Generate delays for cards */
    @for ($i = 1; $i <= 10; $i++)
        .subject-card:nth-child({{ $i }}) {
            animation-delay: {{ $i * 0.1 + 0.3 }}s;
        }
    @endfor

    /* Hover Effects */
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between animate-enter">
            <div>
                <p class="text-indigo-600 font-semibold tracking-wide uppercase text-xs mb-2">Instructor Portal</p>
                <h1 class="text-3xl font-bold text-gray-900">
                    Welcome back, <span class="text-indigo-600">{{ auth()->user()->name }}</span>
                </h1>
                <p class="text-gray-500 mt-2">Here is an overview of your assigned classes and curriculum.</p>
            </div>
            <div class="mt-4 md:mt-0">
                <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 text-sm text-gray-600 flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                    Active Session: {{ date('Y') }}
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-enter stagger-1">
            <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl p-6 text-white shadow-lg shadow-indigo-200">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-indigo-100 text-sm font-medium">Total Subjects</p>
                        <h3 class="text-3xl font-bold mt-1">{{ $subjects->count() }}</h3>
                    </div>
                    <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                </div>
                <p class="text-xs text-indigo-100 mt-4 opacity-80">Assigned for this semester</p>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-scale cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Add Material</h3>
                        <p class="text-xs text-gray-500">Upload notes or assignments</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover-scale cursor-pointer group">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-gray-800">Attendance</h3>
                        <p class="text-xs text-gray-500">Mark or view records</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="animate-enter stagger-2">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">My Subjects</h2>
                <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">{{ $subjects->count() }} Classes</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($subjects as $subject)
                    <div class="subject-card bg-white rounded-xl border border-gray-200 p-6 hover-scale relative overflow-hidden group">
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
                        
                        <div class="flex justify-between items-start mb-4">
                            <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <span class="font-bold text-lg">{{ substr($subject->name, 0, 1) }}</span>
                            </div>
                            <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs rounded uppercase font-semibold tracking-wide">
                                Sub-{{ $loop->iteration }}
                            </span>
                        </div>

                        <h3 class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors">{{ $subject->name }}</h3>
                        <p class="text-sm text-gray-500 mb-6">Manage curriculum, students, and grading.</p>

                        <div class="border-t border-gray-100 pt-4 flex items-center justify-between">
                            <button class="text-sm font-medium text-indigo-600 hover:text-indigo-800 transition-colors flex items-center gap-1">
                                View Details 
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center bg-white rounded-xl border border-dashed border-gray-300">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No Subjects Assigned</h3>
                        <p class="text-gray-500 text-sm mt-1 max-w-xs mx-auto">It looks like you haven't been assigned any subjects yet. Please contact the administrator.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

@endsection