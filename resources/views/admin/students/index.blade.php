@extends('layouts.admin')

@section('title', 'Manage Students')

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

    /* Table Row Hover */
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
            <h1 class="text-3xl font-bold text-gray-900">Student Directory</h1>
            <p class="text-gray-500 mt-1">Manage enrollments, profiles, and academic details.</p>
        </div>
        
        <div class="flex gap-3">
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search students..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm w-64">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <a href="{{ route('admin.students.create') }}" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                Add Student
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-1">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">#</th>
                        <th class="px-6 py-4">Student Profile</th>
                        <th class="px-6 py-4">Academic Info</th>
                        <th class="px-6 py-4">Enrolled Course</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($students as $student)
                        <tr class="table-row group">
                            <td class="px-6 py-4 text-gray-400 text-sm">
                                {{ $loop->iteration }}
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-sm border border-indigo-200">
                                        {{ substr($student->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $student->user->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $student->user->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded bg-gray-100 text-gray-700 font-mono text-xs border border-gray-200 font-semibold tracking-wide">
                                    {{ $student->roll_number }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $student->course->name }}
                                </span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.students.edit', $student) }}" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:text-indigo-600 hover:border-indigo-300 transition-all shadow-sm" title="Edit Student">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.students.destroy', $student) }}" onsubmit="return confirm('⚠️ Are you sure you want to remove this student? This action cannot be undone.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-white border border-gray-200 rounded-lg text-gray-600 hover:text-red-600 hover:border-red-300 transition-all shadow-sm" title="Delete Student">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900">No Students Found</h3>
                                    <p class="text-gray-500 mt-1 max-w-sm">Get started by adding a new student to the system.</p>
                                    <a href="{{ route('admin.students.create') }}" class="mt-4 text-indigo-600 font-medium hover:underline">Register New Student &rarr;</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200 flex items-center justify-between text-xs text-gray-500">
            <span>Showing {{ count($students) }} records</span>
            <span>Admin Control Panel</span>
        </div>
    </div>
</div>

@endsection