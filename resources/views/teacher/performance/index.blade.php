@extends('layouts.teacher')

@section('title', 'Subject Performance')

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

    /* Staggered Delays for Grid Items */
    .delay-100 { animation-delay: 0.1s; }
    .delay-200 { animation-delay: 0.2s; }
    .delay-300 { animation-delay: 0.3s; }

    /* Card Hover Effects */
    .subject-card {
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    }
    .subject-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        border-color: #a5b4fc; /* Indigo-300 */
    }
    .subject-card:hover .icon-bg {
        background-color: #4f46e5; /* Indigo-600 */
        color: white;
        transform: scale(1.1) rotate(3deg);
    }
    .subject-card:hover .arrow-icon {
        transform: translateX(4px);
        color: #4f46e5;
    }
</style>

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10 animate-enter">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <div class="p-2 bg-indigo-100 rounded-lg text-indigo-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Performance Analytics</h1>
            </div>
            <p class="text-gray-500 max-w-2xl">Select a subject below to view detailed student progress, marks distribution, and attendance reports.</p>
        </div>
        
        <div class="text-right hidden md:block">
            <span class="px-4 py-2 bg-white border border-gray-200 rounded-full text-xs font-semibold text-gray-600 shadow-sm">
                {{ $subjects->count() }} Active Subjects
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($subjects as $subject)
            <a href="{{ route('teacher.performance.show', $subject) }}" 
               class="subject-card group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm flex flex-col justify-between h-full animate-enter"
               style="animation-delay: {{ $loop->index * 100 }}ms">
                
                <div class="flex items-start justify-between mb-6">
                    <div class="flex items-center gap-4">
                        <div class="icon-bg w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center transition-all duration-300 shadow-inner">
                            <span class="font-bold text-lg">{{ substr($subject->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-1" title="{{ $subject->name }}">
                                {{ $subject->name }}
                            </h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-600 mt-1">
                                {{ $subject->course->name ?? 'General' }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="mt-auto border-t border-gray-50 pt-4 flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-gray-500">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>View Analytics</span>
                    </div>
                    
                    <div class="arrow-icon w-8 h-8 rounded-full flex items-center justify-center text-gray-300 transition-transform duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full animate-enter">
                <div class="flex flex-col items-center justify-center py-16 bg-white rounded-2xl border border-dashed border-gray-300 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Subjects Assigned</h3>
                    <p class="text-gray-500 max-w-sm mt-1">You haven't been assigned any subjects yet. Once assigned, they will appear here for performance tracking.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>

@endsection