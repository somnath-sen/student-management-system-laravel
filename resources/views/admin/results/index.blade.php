@extends('layouts.admin')

@section('title', 'Publish Results')

@section('content')

<style>
    .animate-enter { animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.1s; }
    .table-row { transition: all 0.2s ease; }
    .table-row:hover { background-color: #f8fafc; }
</style>

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Result Publication</h1>
            <p class="text-gray-500 mt-1">Publish or unpublish all student results <strong>by course</strong>. One click covers all subjects.</p>
        </div>
        <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg border border-indigo-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold">{{ $courses->count() }}</span> Courses Found
        </div>
    </div>

    @if(session('success'))
        <div class="animate-enter mb-6">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <p class="text-sm font-medium text-emerald-800">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-1">

        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 text-sm uppercase tracking-wide">All Courses with Marks</h2>
            <div class="text-xs text-gray-400 italic">Published = visible to all students in that course</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-white text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4 text-center">Subjects with Marks</th>
                        <th class="px-6 py-4 text-center">Current Status</th>
                        <th class="px-6 py-4 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($courses as $course)
                        @php
                            // A course is "published" if ALL its subjects' marks are locked
                            $totalMarks   = $course->subjects->flatMap->marks->count();
                            $lockedMarks  = $course->subjects->flatMap->marks->where('is_locked', true)->count();
                            $published    = $totalMarks > 0 && $lockedMarks === $totalMarks;
                            $partial      = $lockedMarks > 0 && $lockedMarks < $totalMarks;
                        @endphp

                        <tr class="table-row group">
                            {{-- Course Name --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg group-hover:bg-indigo-100 transition-colors">
                                        {{ substr($course->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $course->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $course->subjects->count() }} subject(s) &middot; {{ $totalMarks }} mark records</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Subjects Count --}}
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 rounded-full bg-gray-50 text-gray-600 text-xs font-bold border border-gray-200">
                                    {{ $course->subjects->count() }}
                                </span>
                            </td>

                            {{-- Status Badge --}}
                            <td class="px-6 py-4 text-center">
                                @if($published)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        Published
                                    </span>
                                @elseif($partial)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                        <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                        Partial ({{ $lockedMarks }}/{{ $totalMarks }})
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                        Hidden (Draft)
                                    </span>
                                @endif
                            </td>

                            {{-- Action Button --}}
                            <td class="px-6 py-4 text-right">
                                @if($published)
                                    <form method="POST" action="{{ route('admin.results.unpublish', $course) }}"
                                          data-confirm="⚠️ Unpublish all results for {{ addslashes($course->name) }}? Students will no longer see their marks.">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.953 9.953 0 014.132-5.411m-3.641 4.166l3.29 3.29m7.532-7.532L21 21M3 3l3.59 3.59"></path></svg>
                                            Unpublish
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.results.publish', $course) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Publish All Results
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">No Courses with Marks Found</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">Teachers must enter and lock marks first before results can be published here.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex justify-between">
            <span>Publishing a course makes all its subject results visible to enrolled students.</span>
            <span>Admin Control Panel</span>
        </div>
    </div>
</div>

@endsection