@extends('layouts.admin')

@section('title', 'Add Student')

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
    
    /* Custom Select Arrow */
    select {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
        -webkit-appearance: none;
        appearance: none;
    }
</style>

<div class="max-w-4xl mx-auto">

    <div class="flex items-center justify-between mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Register New Student</h1>
            <p class="text-gray-500 mt-1">Create a new student profile and assign credentials.</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="group flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Directory
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 animate-enter stagger-1">
        
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2">Account Details</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   placeholder="John Doe"
                                   value="{{ old('name') }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   placeholder="student@example.com"
                                   value="{{ old('email') }}" 
                                   required>
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ show: false }">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            
                            <input :type="show ? 'text' : 'password'" 
                                   name="password" 
                                   class="input-field w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   placeholder="••••••••"
                                   required>
                            
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-indigo-600 focus:outline-none cursor-pointer">
                                <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.325m-3.641 4.166l15.856 10.15m-1.857-1.857l1.857 1.857"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                            </button>
                        </div>
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2">Academic Information</h3>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Roll Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <input type="text" 
                                   name="roll_number" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 font-mono"
                                   placeholder="e.g. 2023-CS-001"
                                   value="{{ old('roll_number') }}" 
                                   required>
                        </div>
                        @error('roll_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Course <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <select name="course_id" 
                                    class="input-field w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 bg-white cursor-pointer" 
                                    required>
                                <option value="" disabled selected>-- Select Program --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>

            <div class="pt-8 mt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.students.index') }}" 
                   class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Cancel
                </a>

                <button type="submit" 
                        class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Create Student
                </button>
            </div>

        </form>
    </div>
</div>

@endsection