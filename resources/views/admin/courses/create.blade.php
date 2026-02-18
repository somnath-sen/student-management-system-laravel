@extends('layouts.admin')

@section('title', 'Add Course')

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

    /* Input Focus Transition */
    .input-field {
        transition: all 0.3s ease;
    }
    .input-field:focus {
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); /* Indigo-100 */
        border-color: #6366f1; /* Indigo-500 */
        transform: translateY(-1px);
    }
</style>

<div class="max-w-3xl mx-auto">

    <div class="flex items-center justify-between mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Create New Course</h1>
            <p class="text-gray-500 mt-1">Add a new curriculum to the academic program.</p>
        </div>
        <a href="{{ route('admin.courses.index') }}" class="group flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 animate-enter stagger-1">
        
        <form method="POST" action="{{ route('admin.courses.store') }}" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Course Name <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <input type="text" 
                           name="name" 
                           class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 placeholder-gray-400"
                           placeholder="e.g. Bachelor of Computer Science"
                           value="{{ old('name') }}" 
                           required 
                           autofocus>
                </div>
                @error('name')
                    <p class="flex items-center gap-1 text-red-600 text-xs mt-2 animate-pulse">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Description <span class="text-gray-400 font-normal">(Optional)</span>
                </label>
                <textarea name="description" 
                          rows="4"
                          class="input-field w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 placeholder-gray-400"
                          placeholder="Enter a brief overview of the course content...">{{ old('description') }}</textarea>
            </div>

            <div class="pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                
                <a href="{{ route('admin.courses.index') }}" 
                   class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 transition-colors">
                    Cancel
                </a>

                <button type="submit" 
                        class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Save Course
                </button>
            </div>

        </form>
    </div>
</div>

@endsection