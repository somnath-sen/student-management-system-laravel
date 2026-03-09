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
        <a href="{{ route('admin.students.index') }}" class="group flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Back to Directory
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 animate-enter stagger-1">
        
        <form method="POST" action="{{ route('admin.students.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2">Account Details</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none text-gray-700 font-medium"
                                   placeholder="John Doe"
                                   value="{{ old('name', request('name')) }}" 
                                   required 
                                   autofocus>
                        </div>
                        @error('name') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none text-gray-700 font-medium"
                                   placeholder="student@example.com"
                                   value="{{ old('email', request('email')) }}" 
                                   required>
                        </div>
                        @error('email') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex items-start gap-4">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg shrink-0 mt-0.5">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-indigo-900">Auto-Generated Security</h4>
                            <p class="text-xs text-indigo-700 mt-1 leading-relaxed font-medium">
                                A secure, randomized 10-character password will be automatically generated for this student. It will be emailed directly to them upon account creation.
                            </p>
                        </div>
                    </div>
                    
                </div>

                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2">Academic Information</h3>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Roll Number <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   name="roll_number" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none text-gray-700 font-mono font-bold tracking-wide uppercase"
                                   placeholder="e.g. 2023-CS-001"
                                   value="{{ old('roll_number') }}" 
                                   required>
                        </div>
                        @error('roll_number') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Assign Course <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-book-open text-gray-400"></i>
                            </div>
                            <select name="course_id" 
                                    class="input-field w-full pl-10 pr-10 py-3 border border-gray-300 rounded-xl focus:outline-none text-gray-700 bg-white cursor-pointer font-medium" 
                                    required>
                                <option value="" disabled selected>-- Select Program --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        @error('course_id') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

            </div>

            <div class="pt-8 mt-8 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.students.index') }}" 
                   class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-bold hover:bg-gray-50 hover:text-gray-900 transition-colors shadow-sm">
                    Cancel
                </a>

                <button type="submit" 
                        class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-user-plus"></i>
                    Create Student & Send Email
                </button>
            </div>

        </form>
    </div>
</div>

@endsection