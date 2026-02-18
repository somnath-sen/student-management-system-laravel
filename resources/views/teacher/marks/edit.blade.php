@extends('layouts.teacher')

@section('title', 'Edit Marks - ' . $subject->name)

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

    /* Input Styling */
    .mark-input {
        transition: all 0.2s ease;
        text-align: center;
        font-weight: 600;
    }
    
    /* Interactive State */
    .mark-input:not(:disabled):focus {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2);
        border-color: #4f46e5;
    }

    /* Locked State */
    .mark-input:disabled {
        background-color: #f3f4f6;
        color: #6b7280;
        cursor: not-allowed;
        border-color: #e5e7eb;
    }

    .table-row-hover:hover {
        background-color: #f9fafb;
    }
</style>

<div class="min-h-screen bg-gray-50 text-gray-800 p-6 font-sans">
    
    <div class="max-w-5xl mx-auto">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 animate-enter">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <span class="px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wide {{ $isLocked ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' }}">
                        {{ $isLocked ? 'Finalized' : 'Editing Mode' }}
                    </span>
                    <span class="text-gray-400 text-sm">/ {{ $subject->name }}</span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900">Modify Results</h1>
            </div>

            @if(! $isLocked)
                <form method="POST" 
                      action="{{ route('teacher.marks.lock', $subject) }}" 
                      onsubmit="return confirm('⚠️ ARE YOU SURE?\n\nLocking this result will prevent any further changes. This action cannot be undone by you.')">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-red-200 text-red-600 rounded-lg hover:bg-red-50 hover:border-red-300 transition-all shadow-sm">
                        <svg class="w-4 h-4 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        <span class="font-semibold">Lock Results</span>
                    </button>
                </form>
            @endif
        </div>

        @if($isLocked)
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6 animate-enter stagger-1 shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">
                            This result sheet is locked.
                        </p>
                        <p class="text-xs text-red-600 mt-1">
                            Marks can no longer be edited. Contact the administrator if this is an error.
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ route('teacher.marks.update', $subject) }}">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-1">
                
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h2 class="font-bold text-gray-800">Student Gradebook</h2>
                    @if(!$isLocked)
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            Editable
                        </span>
                    @endif
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-white text-gray-500 text-xs uppercase tracking-wider border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 font-semibold">Student Name</th>
                                <th class="px-6 py-3 font-semibold text-center w-40">Current Marks</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($students as $student)
                                <tr class="table-row-hover group transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-sm border border-indigo-100">
                                                {{ substr($student->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $student->user->name }}</p>
                                                <p class="text-xs text-gray-400">Roll: {{ $student->roll_number ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <div class="relative inline-block">
                                            <input type="number" 
                                                   name="marks[{{ $student->id }}]" 
                                                   value="{{ $marks[$student->id]->marks_obtained ?? '' }}"
                                                   class="mark-input w-24 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none"
                                                   min="0" 
                                                   max="100"
                                                   {{ $isLocked ? 'disabled' : '' }}>
                                            
                                            @if($isLocked)
                                                <div class="absolute -right-6 top-2.5 text-gray-300">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(! $isLocked)
                    <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                        <p class="text-sm text-gray-500">
                            Changes are not permanent until you click Update.
                        </p>
                        <button type="submit" class="px-8 py-3 bg-blue-600 text-white font-bold rounded-lg shadow-lg hover:bg-blue-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Update Marks
                        </button>
                    </div>
                @endif

            </div>
        </form>

    </div>
</div>

@endsection