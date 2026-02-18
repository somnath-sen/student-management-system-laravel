@extends('layouts.teacher')

@section('title', 'Manage Marks')

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
    .stagger-3 { animation-delay: 0.3s; }

    /* Card Hover Effect */
    .subject-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .subject-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px -8px rgba(79, 70, 229, 0.15); /* Indigo shadow */
        border-color: rgba(99, 102, 241, 0.4);
    }

    .action-btn {
        transition: all 0.2s ease;
    }
    
    .subject-card:hover .action-btn {
        background-color: #4f46e5; /* Indigo-600 */
        color: white;
        border-color: transparent;
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-7xl mx-auto space-y-8">

        <div class="flex flex-col md:flex-row md:items-end justify-between animate-enter">
            <div>
                <p class="text-indigo-600 font-semibold tracking-wide uppercase text-xs mb-2">Examination Module</p>
                <h1 class="text-3xl font-bold text-gray-900">Marks Management</h1>
                <p class="text-gray-500 mt-2">Select a subject below to enter or update student marks.</p>
            </div>
            
            <div class="mt-4 md:mt-0">
                 <div class="bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200 text-sm text-gray-600 flex items-center gap-2">
                    <span class="flex h-2 w-2 relative">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                    </span>
                    Grading Portal Active
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-enter stagger-1">
            
            @forelse($subjects as $subject)
                <div class="subject-card bg-white rounded-xl border border-gray-200 p-6 flex flex-col justify-between h-full relative overflow-hidden group">
                    
                    <div class="absolute -right-6 -top-6 text-gray-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 6h16v2H4zm0 5h16v2H4zm0 5h16v2H4z"></path></svg>
                    </div>

                    <div>
                        <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 shadow-sm group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300 relative z-10">
                            <span class="font-bold text-xl">{{ substr($subject->name, 0, 1) }}</span>
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 mb-1 relative z-10">{{ $subject->name }}</h2>
                        <p class="text-sm text-gray-500 mb-6 relative z-10">
                            Subject Code: {{ strtoupper(substr($subject->name, 0, 3)) }}-10{{ $loop->iteration }}
                        </p>
                    </div>

                    <div class="pt-4 border-t border-gray-100 relative z-10">
                        <a href="{{ route('teacher.marks.edit', $subject) }}" 
                           class="action-btn w-full flex items-center justify-center gap-2 px-4 py-3 rounded-lg border border-gray-200 text-gray-700 font-semibold text-sm group-hover:shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit Marks
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-full py-16 text-center bg-white rounded-xl border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">No Subjects Assigned</h3>
                    <p class="text-gray-500 mt-2">You haven't been assigned any classes to grade yet.</p>
                </div>
            @endforelse

        </div>

        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg animate-enter stagger-2">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <strong>Tip:</strong> Ensure you save your changes after entering marks. Unsaved data will be lost if you refresh the page.
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection