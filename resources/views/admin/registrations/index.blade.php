@extends('layouts.admin')

@section('title', 'Student Registrations')

@section('content')

<style>
    .animate-enter { animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.1s; }
    .table-row { transition: all 0.2s ease; }
    .table-row:hover { background-color: #f8fafc; transform: scale(1.002); box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); z-index:10; position:relative; }
</style>

<div class="max-w-7xl mx-auto">

    @if(session('success'))
        <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-lg">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">{{ session('error') }}</div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Student Registrations</h1>
            <p class="text-gray-500 mt-1">Review applicant submissions and approve enrollments.</p>
        </div>
        <div class="flex items-center gap-3">
            @if($pendingCount > 0)
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl text-sm font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $pendingCount }} Pending
                </span>
            @endif
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 animate-enter stagger-1">
        <form method="GET" action="{{ route('admin.registrations.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name, email, application no..."
                       class="w-full border border-gray-300 rounded-lg text-sm px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <select name="status" class="border border-gray-300 rounded-lg text-sm px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none h-full">
                    <option value="all"      {{ request('status','all') === 'all'     ? 'selected' : '' }}>All Statuses</option>
                    <option value="pending"  {{ request('status') === 'pending'       ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') === 'approved'      ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') === 'rejected'      ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <select name="course_id" class="border border-gray-300 rounded-lg text-sm px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none h-full">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c->id }}" {{ request('course_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm transition">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter
            </button>
            @if(request()->anyFilled(['search','status','course_id']))
                <a href="{{ route('admin.registrations.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-600 font-semibold rounded-lg text-sm hover:bg-gray-50 transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-1">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Applicant</th>
                        <th class="px-6 py-4">App No.</th>
                        <th class="px-6 py-4">Course</th>
                        <th class="px-6 py-4">Guardian</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($registrations as $reg)
                        <tr class="table-row group">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $reg->full_name ?: $reg->name }}</div>
                                <div class="text-xs text-gray-500">{{ $reg->email }}</div>
                                @if($reg->phone)<div class="text-xs text-indigo-500 font-semibold mt-0.5">{{ $reg->phone }}</div>@endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono text-xs text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $reg->application_no ?? '—' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $reg->course?->name ?? $reg->course ?? '—' }}</div>
                                @if($reg->roll)<div class="text-xs text-gray-500">Roll: {{ $reg->roll }}</div>@endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $reg->parent_name ?? '—' }}</div>
                                <div class="text-xs text-gray-500">{{ $reg->parent_email ?? '' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                @if($reg->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>Pending
                                    </span>
                                @elseif($reg->status === 'approved')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-check mr-1"></i>Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-200">
                                        <i class="fa-solid fa-xmark mr-1"></i>Rejected
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $reg->created_at->format('M d, Y') }}<br>
                                <span class="text-xs">{{ $reg->created_at->format('h:i A') }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- View button (always visible) --}}
                                    <a href="{{ route('admin.registrations.show', $reg->id) }}"
                                       class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold rounded-lg text-xs transition border border-indigo-100">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>

                                    @if($reg->status === 'pending')
                                    {{-- Quick approve --}}
                                    <form method="POST" action="{{ route('admin.registrations.approve', $reg->id) }}"
                                          onsubmit="return confirm('Approve this student? Credentials will be emailed.')">
                                        @csrf
                                        <input type="hidden" name="roll" value="{{ $reg->roll }}">
                                        <button type="submit"
                                                class="px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-semibold rounded-lg text-xs transition border border-emerald-200">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="text-gray-300 text-4xl mb-3"><i class="fa-solid fa-inbox"></i></div>
                                <p class="text-gray-500 font-semibold">No registrations found</p>
                                <p class="text-gray-400 text-sm mt-1">Try adjusting your filters</p>
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
