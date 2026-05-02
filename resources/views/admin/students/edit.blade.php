@extends('layouts.admin')

@section('title', 'Edit Student')

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
    
    /* Select Dropdown Styling */
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
            <h1 class="text-3xl font-bold text-gray-900">Edit Student Profile</h1>
            <p class="text-gray-500 mt-1">Update personal information and academic enrollment.</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="group flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Directory
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 animate-enter stagger-1">
        
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                
                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2">Personal Details</h3>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <input type="text" 
                                   name="name" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   value="{{ old('name', $student->user->name) }}" 
                                   required>
                        </div>
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="email" 
                                   name="email" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700"
                                   value="{{ old('email', $student->user->email) }}" 
                                   required>
                        </div>
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider border-b border-gray-100 pb-2">Academic Information</h3>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Roll Number / Student ID</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                            <input type="text" 
                                   name="roll_number" 
                                   class="input-field w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 font-mono"
                                   value="{{ old('roll_number', $student->roll_number) }}" 
                                   required>
                        </div>
                        @error('roll_number') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Enrolled Course</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                            <select name="course_id" 
                                    class="input-field w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 bg-white cursor-pointer" 
                                    required>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ $student->course_id == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Student Status</label>
                        <div class="relative">
                            <select name="status" 
                                    class="input-field w-full pl-4 pr-10 py-3 border border-gray-300 rounded-lg focus:outline-none text-gray-700 bg-white cursor-pointer" 
                                    required>
                                <option value="active" {{ old('status', $student->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="dropped" {{ old('status', $student->status) == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                <option value="completed" {{ old('status', $student->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>

            <div class="pt-8 mt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.students.index') }}" 
                   class="px-6 py-2.5 rounded-lg border border-gray-300 text-gray-700 font-medium hover:bg-gray-50 hover:text-gray-900 transition-colors">
                    Cancel Changes
                </a>

                <button type="submit" 
                        class="px-8 py-2.5 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Update Student
                </button>
            </div>

        </form>
    </div>
</div>
    {{-- Linked Parents --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-8 mt-6 animate-enter stagger-1">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center">
                <i class="fa-solid fa-user-group text-blue-600"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold text-gray-900">Linked Parents / Guardians</h2>
                <p class="text-xs text-gray-500 mt-0.5">Link parent accounts to enable SOS, attendance, results and fee Telegram notifications.</p>
            </div>
        </div>
        @if(session('success'))<div class="mb-4 p-3 bg-emerald-50 border border-emerald-200 rounded-lg text-sm text-emerald-700 font-medium">{{ session('success') }}</div>@endif
        @if(session('warning'))<div class="mb-4 p-3 bg-amber-50 border border-amber-200 rounded-lg text-sm text-amber-700 font-medium">{{ session('warning') }}</div>@endif
        @php $student->load('parents'); @endphp
        @if($student->parents->count() > 0)
            <div class="mb-6 space-y-2">
                @foreach($student->parents as $lp)
                <div class="flex items-center justify-between p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-emerald-200 flex items-center justify-center"><i class="fa-solid fa-user text-emerald-700 text-sm"></i></div>
                        <div><p class="text-sm font-bold text-gray-800">{{ $lp->name }}</p><p class="text-[10px] text-gray-500">{{ $lp->email }}</p></div>
                        @if($lp->telegram_chat_id)<span class="ml-2 inline-flex items-center gap-1 px-2 py-0.5 bg-blue-100 text-blue-700 text-[10px] font-bold rounded-full"><i class="fa-brands fa-telegram text-xs"></i> Telegram Connected</span>@else<span class="ml-2 inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-500 text-[10px] font-bold rounded-full">No Telegram</span>@endif
                    </div>
                    <form method="POST" action="{{ route('admin.students.unlink-parent', $student) }}" onsubmit="return confirm('Remove this parent?')">
                        @csrf<input type="hidden" name="parent_id" value="{{ $lp->id }}">
                        <button type="submit" class="text-xs font-bold text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-lg transition-colors"><i class="fa-solid fa-link-slash mr-1"></i> Unlink</button>
                    </form>
                </div>
                @endforeach
            </div>
        @else
            <div class="mb-6 p-4 bg-amber-50 border border-amber-100 rounded-xl flex items-start gap-3">
                <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-0.5"></i>
                <div><p class="text-sm font-bold text-amber-700">No parent linked yet</p><p class="text-xs text-amber-600 mt-0.5">SOS alerts and all Telegram notifications will NOT reach any parent without a link.</p></div>
            </div>
        @endif
        @php $availableParents = $allParents->whereNotIn('id', $linkedParentIds); @endphp
        @if($availableParents->count() > 0)
        <form method="POST" action="{{ route('admin.students.link-parent', $student) }}" class="flex flex-wrap items-end gap-3">
            @csrf
            <div class="flex-1 min-w-[200px]">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">Link a Parent Account</label>
                <select name="parent_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-xl text-sm text-gray-700 bg-white focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    <option value="">Select parent to link</option>
                    @foreach($availableParents as $p)<option value="{{ $p->id }}">{{ $p->name }} ({{ $p->email }}){{ $p->telegram_chat_id ? ' Telegram Connected' : '' }}</option>@endforeach
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-xl hover:bg-indigo-700 shadow transition-all"><i class="fa-solid fa-link mr-1.5"></i> Link Parent</button>
        </form>
        @else
            <p class="text-xs text-gray-400 text-center py-2">@if($allParents->count() === 0)No parent accounts exist yet.@else All parents already linked.@endif</p>
        @endif
    </div>

</div>

@endsection
