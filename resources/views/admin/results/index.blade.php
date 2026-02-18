@extends('layouts.admin')

@section('title', 'Publish Results')

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

    /* Table Row Hover Effect */
    .table-row {
        transition: all 0.2s ease;
    }
    .table-row:hover {
        background-color: #f8fafc; /* Slate-50 */
        transform: scale(1.002);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        z-index: 10;
        position: relative;
    }
</style>

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Result Publication</h1>
            <p class="text-gray-500 mt-1">Manage visibility of student results. Locked results appear here.</p>
        </div>
        
        <div class="bg-indigo-50 text-indigo-700 px-4 py-2 rounded-lg border border-indigo-100 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-bold">{{ $subjects->count() }}</span> Subjects Found
        </div>
    </div>

    @if(session('success'))
        <div class="animate-enter mb-6">
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <div>
                    <h3 class="text-sm font-medium text-emerald-800">Success</h3>
                    <p class="text-sm text-emerald-700 mt-1">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-1">
        
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h2 class="font-bold text-gray-800 text-sm uppercase tracking-wide">Locked Subjects List</h2>
            <div class="text-xs text-gray-400 italic">Only locked results can be published</div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-white text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Subject Name</th>
                        <th class="px-6 py-4">Course / Class</th>
                        <th class="px-6 py-4 text-center">Current Status</th>
                        <th class="px-6 py-4 text-right">Visibility Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($subjects as $subject)
                        @php
                            $published = $subject->marks->first()->is_published ?? false;
                        @endphp

                        <tr class="table-row group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-500 font-bold text-lg group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                        {{ substr($subject->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $subject->name }}</div>
                                        <div class="text-xs text-gray-400">Code: SUB-{{ $subject->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full bg-gray-50 text-gray-600 text-xs font-medium border border-gray-200">
                                    {{ $subject->course->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($published)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                                        Hidden (Draft)
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-right">
                                @if(! $published)
                                    <form method="POST" action="{{ route('admin.results.publish', $subject) }}">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Publish Now
                                        </button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('admin.results.unpublish', $subject) }}" onsubmit="return confirm('⚠️ Are you sure? This will hide results from students immediately.');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-medium rounded-lg transition-colors duration-200">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.325m-3.641 4.166l15.856 10.15m-1.857-1.857l1.857 1.857"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path></svg>
                                            Unpublish
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
                                    <h3 class="text-lg font-medium text-gray-900">No Locked Results Found</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">Results must be "Locked" by teachers before they appear here for final publication.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 text-xs text-gray-500 flex justify-between">
            <span>Only locked result sheets are visible here.</span>
            <span>Admin Control Panel</span>
        </div>
    </div>
</div>

@endsection