@extends('layouts.admin')

@section('title', 'Student Registrations')

@section('content')

<style>
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }

    .table-row {
        transition: all 0.2s ease;
    }
    .table-row:hover {
        background-color: #f8fafc;
        transform: scale(1.002);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        z-index: 10;
        position: relative;
    }
</style>

<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Student Registrations</h1>
            <p class="text-gray-500 mt-1">Review applicant submissions and approve enrollments.</p>
        </div>
        
        <div class="flex gap-3">
            <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="border border-gray-300 rounded-lg text-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-1">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Applicant</th>
                        <th class="px-6 py-4">Phone Number</th>
                        <th class="px-6 py-4">Course Details</th>
                        <th class="px-6 py-4">Parent Details</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($registrations as $reg)
                        <tr class="table-row group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $reg->name }}</div>
                                <div class="text-xs text-gray-500">{{ $reg->email }}</div>
                            </td>
                            
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $reg->phone ?? 'N/A' }}</div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $reg->course }}</div>
                                @if($reg->roll)
                                    <div class="text-xs text-gray-500">Roll: {{ $reg->roll }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $reg->parent_name }}</div>
                                <div class="text-xs text-gray-500">{{ $reg->parent_email }}</div>
                            </td>

                            <td class="px-6 py-4">
                                @if($reg->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700 border border-yellow-200">Pending</span>
                                @elseif($reg->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">Approved</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">Rejected</span>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $reg->created_at->format('M d, Y') }}<br>
                                <span class="text-xs">{{ $reg->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($reg->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        <form method="POST" action="{{ route('admin.registrations.approve', $reg->id) }}" onsubmit="return confirm('Approve this student? Login credentials will be generated and emailed automatically.');" class="flex flex-col gap-1.5 items-center">
                                            @csrf
                                            <input type="text" name="roll" value="{{ $reg->roll }}" placeholder="Roll No" class="w-full text-xs px-2 py-1 border border-gray-300 rounded text-gray-700 focus:ring-emerald-500 focus:border-emerald-500 text-center">
                                            <button type="submit" class="w-full px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-semibold rounded text-xs transition border border-emerald-200">
                                                Approve
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.registrations.reject', $reg->id) }}" onsubmit="return confirm('Reject this student?');">
                                            @csrf
                                            <button type="submit" class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded text-xs transition border border-red-200">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-xs text-gray-400">Action taken</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                No registrations found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $registrations->links() }}
        </div>
    </div>
</div>

@endsection
