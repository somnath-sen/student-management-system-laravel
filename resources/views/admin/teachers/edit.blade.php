@extends('layouts.admin')

@section('title', 'Edit Teacher')

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

    /* Input Focus Transition */
    .input-field {
        transition: all 0.3s ease;
    }
    .input-field:focus {
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); /* Indigo-100 */
        border-color: #6366f1; /* Indigo-500 */
        transform: translateY(-1px);
    }

    /* Custom Checkbox Card Styling */
    .subject-card {
        transition: all 0.2s ease;
    }
    .peer:checked + .subject-card {
        border-color: #6366f1;
        background-color: #eef2ff; /* Indigo-50 */
        box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.1);
    }
    .peer:checked + .subject-card .check-icon {
        opacity: 1;
        transform: scale(1);
    }
</style>

<div class="max-w-5xl mx-auto">

    <div class="flex items-center justify-between mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Teacher Profile</h1>
            <p class="text-gray-500 mt-1">Update faculty details and subject allocations.</p>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="group flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Directory
        </a>
    </div>

    <form method="POST" action="{{ route('admin.teachers.update', $teacher) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6 animate-enter stagger-1">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide border-b border-gray-100 pb-3 mb-4">
                        Faculty Details
                    </h3>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   value="{{ old('name', $teacher->user->name) }}" 
                                   required>
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   value="{{ old('email', $teacher->user->email) }}" 
                                   required>
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Employee ID</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <input type="text" 
                                   name="employee_id" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 font-mono"
                                   value="{{ old('employee_id', $teacher->employee_id) }}" 
                                   required>
                        </div>
                        @error('employee_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6 animate-enter stagger-2">
                <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 h-full">
                    <div class="flex justify-between items-center border-b border-gray-100 pb-3 mb-4">
                        <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide">
                            Assign Subjects
                        </h3>
                        <span class="text-xs text-gray-500">Select all that apply</span>
                    </div>

                    @error('subjects')
                        <div class="mb-4 bg-red-50 text-red-600 px-4 py-2 rounded-lg text-sm flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($subjects as $subject)
                            <label class="relative cursor-pointer group">
                                <input type="checkbox" 
                                       name="subjects[]" 
                                       value="{{ $subject->id }}" 
                                       class="peer sr-only"
                                       {{ $teacher->subjects->contains($subject->id) ? 'checked' : '' }}>
                                
                                <div class="subject-card p-4 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-gray-50 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded bg-gray-100 text-gray-500 flex items-center justify-center font-bold text-xs peer-checked:bg-indigo-200 peer-checked:text-indigo-700">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        <div class="text-sm font-medium text-gray-700 peer-checked:text-indigo-900">
                                            {{ $subject->name }}
                                        </div>
                                    </div>
                                    
                                    <div class="check-icon w-5 h-5 bg-indigo-600 rounded-full flex items-center justify-center text-white opacity-0 transform scale-50 transition-all duration-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    
                    @if($subjects->isEmpty())
                        <div class="text-center py-8 text-gray-400">
                            No subjects available to assign.
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="mt-8 border-t border-gray-200 pt-6 flex items-center justify-end gap-4 animate-enter stagger-2">
            <a href="{{ route('admin.teachers.index') }}" 
               class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:text-gray-900 transition-colors">
                Cancel
            </a>

            <button type="submit" 
                    class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Update Teacher Profile
            </button>
        </div>

    </form>
</div>

@endsection