@extends('layouts.admin')

@section('title', 'Report Cards')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Report Cards Manager</h1>
            <p class="text-sm text-slate-500 mt-1">Generate and distribute professional report cards.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-xl">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-check text-emerald-500 mr-3"></i>
                <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl">
            <div class="flex items-center">
                <i class="fa-solid fa-circle-exclamation text-rose-500 mr-3"></i>
                <p class="text-rose-700 font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-200 bg-slate-50 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Student Directory</h3>
            <div class="relative">
                <i class="fa-solid fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Search students..." class="pl-10 pr-4 py-2 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 outline-none w-64">
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="p-4 font-bold border-b border-slate-200">Student Name</th>
                        <th class="p-4 font-bold border-b border-slate-200">Roll No</th>
                        <th class="p-4 font-bold border-b border-slate-200">Course</th>
                        <th class="p-4 font-bold border-b border-slate-200 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                    {{ substr($student->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $student->user->name }}</p>
                                    <p class="text-xs text-slate-500">{{ $student->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="p-4">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-xs font-bold rounded-lg">{{ $student->roll_number }}</span>
                        </td>
                        <td class="p-4">
                            <span class="text-sm font-medium text-slate-600">{{ $student->course->name ?? 'N/A' }}</span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('admin.report-cards.show', $student->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 text-sm font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition-all">
                                <span>Manage</span>
                                <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4">
                                    <i class="fa-solid fa-users-slash text-2xl text-slate-400"></i>
                                </div>
                                <p class="text-lg font-bold text-slate-700">No Students Found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
