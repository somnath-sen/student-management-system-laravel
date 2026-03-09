@extends('layouts.admin')

@section('title', 'Add Teacher')

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

    /* Input Focus Transition */
    .input-field {
        transition: all 0.3s ease;
    }
    .input-field:focus {
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); /* Indigo-100 */
        border-color: #6366f1; /* Indigo-500 */
        transform: translateY(-1px);
    }
    
    /* Subject Card Selection */
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
            <h1 class="text-3xl font-bold text-slate-900">Add New Teacher</h1>
            <p class="text-slate-500 mt-1 font-medium">Register a new faculty member and assign subjects.</p>
        </div>
        <a href="{{ route('admin.teachers.index') }}" class="group flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors">
            <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Back to Directory
        </a>
    </div>

    <form method="POST" action="{{ route('admin.teachers.store') }}">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1 space-y-6 animate-enter stagger-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#F0EBE1]">
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider border-b border-[#F0EBE1] pb-3 mb-5 flex items-center gap-2">
                        <i class="fa-solid fa-id-badge text-indigo-500"></i> Faculty Credentials
                    </h3>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Full Name <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-user text-slate-400"></i>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:outline-none text-slate-700 font-medium bg-[#FDFBF7]"
                                   placeholder="Jane Smith"
                                   value="{{ old('name', request('name')) }}"
                                   required 
                                   autofocus>
                        </div>
                        @error('name') <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Email Address <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-envelope text-slate-400"></i>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:outline-none text-slate-700 font-medium bg-[#FDFBF7]"
                                   placeholder="teacher@school.com"
                                   value="{{ old('email', request('email')) }}"
                                   required>
                        </div>
                        @error('email') <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Employee ID <span class="text-rose-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fa-solid fa-hashtag text-slate-400"></i>
                            </div>
                            <input type="text" 
                                   name="employee_id" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-slate-300 rounded-xl focus:outline-none text-slate-700 font-mono font-bold tracking-wide uppercase bg-[#FDFBF7]"
                                   placeholder="FAC-001"
                                   value="{{ old('employee_id') }}"
                                   required>
                        </div>
                        @error('employee_id') <p class="text-rose-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 flex items-start gap-4">
                        <div class="p-2 bg-indigo-100 text-indigo-600 rounded-lg shrink-0 mt-0.5">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-indigo-900">Auto-Generated Security</h4>
                            <p class="text-xs text-indigo-700 mt-1 leading-relaxed font-medium">
                                A secure, randomized 10-character password will be automatically generated for this instructor. It will be emailed directly to them upon account creation.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <div class="lg:col-span-2 space-y-6 animate-enter stagger-2">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-[#F0EBE1] h-full flex flex-col">
                    <div class="flex justify-between items-center border-b border-[#F0EBE1] pb-3 mb-5">
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider flex items-center gap-2">
                            <i class="fa-solid fa-book-open-reader text-indigo-500"></i> Assign Subjects
                        </h3>
                        <span class="text-xs font-bold text-slate-400 bg-slate-50 px-2 py-1 rounded-md border border-slate-200">Select at least one</span>
                    </div>

                    @error('subjects')
                        <div class="mb-5 bg-rose-50 border border-rose-100 text-rose-600 px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-sm">
                            <i class="fa-solid fa-circle-exclamation"></i>
                            {{ $message }}
                        </div>
                    @enderror

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 flex-1">
                        @foreach($subjects as $subject)
                            <label class="relative cursor-pointer group">
                                <input type="checkbox" 
                                       name="subjects[]" 
                                       value="{{ $subject->id }}" 
                                       class="peer sr-only"
                                       {{ in_array($subject->id, old('subjects', [])) ? 'checked' : '' }}>
                                
                                <div class="subject-card p-4 rounded-xl border border-slate-200 bg-[#FDFBF7] hover:border-indigo-300 hover:bg-white flex items-center justify-between cursor-pointer">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg bg-white border border-slate-200 text-slate-500 flex items-center justify-center font-black text-sm peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition-colors shadow-sm">
                                            {{ substr($subject->name, 0, 1) }}
                                        </div>
                                        <div class="text-sm font-bold text-slate-700 peer-checked:text-indigo-900 transition-colors">
                                            {{ $subject->name }}
                                        </div>
                                    </div>
                                    
                                    <div class="check-icon w-6 h-6 bg-indigo-600 rounded-full flex items-center justify-center text-white opacity-0 transform scale-50 transition-all duration-200 shadow-md">
                                        <i class="fa-solid fa-check text-xs"></i>
                                    </div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                    
                    @if($subjects->isEmpty())
                        <div class="flex flex-col items-center justify-center py-12 text-center h-full">
                            <div class="w-16 h-16 bg-[#FDFBF7] border border-[#F0EBE1] rounded-full flex items-center justify-center mb-4">
                                <i class="fa-solid fa-folder-open text-2xl text-slate-300"></i>
                            </div>
                            <p class="text-slate-600 font-bold text-lg">No subjects available.</p>
                            <p class="text-sm text-slate-400 font-medium mt-1">Please add subjects to the system first.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>

        <div class="mt-8 border-t border-[#F0EBE1] pt-8 flex items-center justify-end gap-4 animate-enter stagger-2">
            <a href="{{ route('admin.teachers.index') }}" 
               class="px-6 py-3 rounded-xl border border-slate-300 text-slate-700 font-bold hover:bg-slate-50 hover:text-slate-900 transition-colors shadow-sm">
                Cancel
            </a>

            <button type="submit" 
                    class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                <i class="fa-solid fa-user-tie"></i>
                Create Teacher & Send Email
            </button>
        </div>

    </form>
</div>

@endsection