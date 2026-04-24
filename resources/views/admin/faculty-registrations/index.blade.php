@extends('layouts.admin')

@section('title', 'Faculty Registrations')

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
    .stagger-2 { animation-delay: 0.2s; }

    .table-row { transition: all 0.2s ease; }
    .table-row:hover {
        background-color: #f8fafc;
        transform: scale(1.002);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        z-index: 10;
        position: relative;
    }

    /* Modal Backdrop */
    .modal-overlay {
        position: fixed; inset: 0; z-index: 999;
        background: rgba(15,23,42,0.6);
        backdrop-filter: blur(4px);
        display: flex; align-items: center; justify-content: center;
        padding: 1rem;
        animation: fadeIn 0.2s ease;
    }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }

    .modal-box {
        background: #fff;
        border-radius: 20px;
        max-width: 500px; width: 100%;
        box-shadow: 0 25px 60px -12px rgba(0,0,0,0.25);
        animation: slideUp 0.25s cubic-bezier(0.2, 0.8, 0.2, 1);
        overflow: hidden;
    }
    @keyframes slideUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
</style>

<div class="max-w-7xl mx-auto">

    {{-- Flash Messages --}}
    @foreach(['success', 'error', 'warning'] as $msg)
        @if(session($msg))
            <div class="mb-4 px-4 py-3 rounded-lg relative border
                @if($msg === 'success') bg-emerald-50 border-emerald-200 text-emerald-700
                @elseif($msg === 'warning') bg-amber-50 border-amber-200 text-amber-700
                @else bg-red-50 border-red-200 text-red-700 @endif">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Faculty Registrations</h1>
            <p class="text-gray-500 mt-1">Review faculty applications and approve new instructors.</p>
        </div>
        <div class="flex flex-wrap gap-3 items-center">
            @if($pendingCount > 0)
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-amber-50 border border-amber-200 text-amber-700 rounded-xl text-sm font-bold">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    {{ $pendingCount }} Pending Review
                </span>
            @endif
        </div>
    </div>

    {{-- Filters & Search --}}
    <div class="bg-white rounded-xl border border-gray-200 p-4 mb-6 animate-enter stagger-1">
        <form method="GET" action="{{ route('admin.faculty-registrations.index') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="w-full border border-gray-300 rounded-lg text-sm px-4 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none">
            </div>
            <div>
                <select name="status" class="border border-gray-300 rounded-lg text-sm px-3 py-2.5 focus:ring-indigo-500 focus:border-indigo-500 outline-none h-full">
                    <option value="all"      {{ request('status', 'all') == 'all'      ? 'selected' : '' }}>All Statuses</option>
                    <option value="pending"  {{ request('status') == 'pending'          ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved'         ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected'         ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm transition">
                <i class="fa-solid fa-magnifying-glass mr-1"></i> Filter
            </button>
            @if(request()->anyFilled(['search', 'status']))
                <a href="{{ route('admin.faculty-registrations.index') }}" class="px-4 py-2.5 border border-gray-300 text-gray-600 font-semibold rounded-lg text-sm hover:bg-gray-50 transition">
                    Clear
                </a>
            @endif
        </form>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-2">
        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                        <th class="px-6 py-4">Applicant</th>
                        <th class="px-6 py-4">Subjects</th>
                        <th class="px-6 py-4">Qualification</th>
                        <th class="px-6 py-4">Department</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($registrations as $reg)
                        @php
                            $subjectIds = array_filter(explode(',', $reg->subjects));
                            $subjectNames = $subjectIds
                                ? $subjects->whereIn('id', $subjectIds)->pluck('name')->toArray()
                                : [];
                        @endphp
                        <tr class="table-row group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 text-white flex items-center justify-center font-black text-sm flex-shrink-0">
                                        {{ strtoupper(substr($reg->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $reg->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $reg->email }}</div>
                                        <div class="text-xs text-gray-400">{{ $reg->phone }}</div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 max-w-[180px]">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($subjectNames as $name)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100">{{ $name }}</span>
                                    @empty
                                        <span class="text-xs text-gray-400 italic">{{ $reg->subjects }}</span>
                                    @endforelse
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $reg->qualification }}</div>
                                @if($reg->experience)
                                    <div class="text-xs text-gray-500 mt-0.5"><i class="fa-solid fa-clock text-gray-400 mr-1"></i>{{ $reg->experience }}</div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($reg->department)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">{{ $reg->department }}</span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                @if($reg->status === 'pending')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Pending
                                    </span>
                                @elseif($reg->status === 'approved')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        <i class="fa-solid fa-circle-check text-emerald-500"></i> Approved
                                    </span>
                                    @if($reg->approved_at)
                                        <div class="text-[10px] text-gray-400 mt-1">{{ $reg->approved_at->format('M d, Y') }}</div>
                                    @endif
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700 border border-red-200">
                                        <i class="fa-solid fa-circle-xmark text-red-500"></i> Rejected
                                    </span>
                                    @if($reg->reject_reason)
                                        <div class="text-[10px] text-gray-400 mt-1 max-w-[120px] truncate" title="{{ $reg->reject_reason }}">
                                            {{ $reg->reject_reason }}
                                        </div>
                                    @endif
                                @endif
                            </td>

                            <td class="px-6 py-4 text-gray-500">
                                {{ $reg->created_at->format('M d, Y') }}<br>
                                <span class="text-xs">{{ $reg->created_at->format('h:i A') }}</span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($reg->status === 'pending')
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Approve Button → triggers modal --}}
                                        <button type="button"
                                            onclick="openApproveModal({{ $reg->id }}, '{{ addslashes($reg->name) }}')"
                                            class="px-3 py-1.5 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 font-semibold rounded-lg text-xs transition border border-emerald-200 flex items-center gap-1">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </button>

                                        {{-- Reject Button → triggers modal --}}
                                        <button type="button"
                                            onclick="openRejectModal({{ $reg->id }}, '{{ addslashes($reg->name) }}')"
                                            class="px-3 py-1.5 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg text-xs transition border border-red-200 flex items-center gap-1">
                                            <i class="fa-solid fa-xmark"></i> Reject
                                        </button>
                                    </div>
                                @elseif($reg->status === 'approved')
                                    <form method="POST" action="{{ route('admin.faculty-registrations.resend', $reg->id) }}"
                                        data-confirm="This will generate a NEW password and send it to {{ addslashes($reg->email) }}. Continue?">
                                        @csrf
                                        <button type="submit"
                                            class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-semibold rounded-lg text-xs transition border border-indigo-200 flex items-center gap-1 mx-auto">
                                            <i class="fa-solid fa-paper-plane"></i> Resend Credentials
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400">Action taken</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="w-14 h-14 bg-gray-100 rounded-full flex items-center justify-center text-gray-300">
                                        <i class="fa-solid fa-briefcase text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">No faculty registrations found.</p>
                                    @if(request()->anyFilled(['search', 'status']))
                                        <a href="{{ route('admin.faculty-registrations.index') }}" class="text-sm text-indigo-600 hover:underline">Clear filters</a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($registrations->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>
</div>

{{-- ============================================================ --}}
{{-- APPROVE CONFIRMATION MODAL                                    --}}
{{-- ============================================================ --}}
<div id="approveModal" class="modal-overlay" style="display:none;" onclick="closeModalOnBackdrop(event, 'approveModal')">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 p-6 text-white text-center">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-user-check text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold">Approve Faculty Application</h3>
            <p class="text-emerald-100 text-sm mt-1" id="approveModalSubtitle">Confirm to create account.</p>
        </div>
        <div class="p-6">
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-4 mb-5 text-sm text-emerald-800">
                <ul class="space-y-1.5">
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> A secure password will be auto-generated</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> A teacher account will be created</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Subjects will be assigned automatically</li>
                    <li class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Credentials will be emailed to the faculty</li>
                </ul>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                {{-- Employee ID Field --}}
                <div class="mb-5">
                    <label for="employee_id_input" class="block text-sm font-bold text-gray-700 mb-1.5">
                        Employee ID <span class="text-gray-400 font-normal text-xs">(leave blank to auto-generate)</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">FAC-</span>
                        <input id="employee_id_input" type="text" name="employee_id"
                            placeholder="e.g. EMP001 or leave blank"
                            class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-emerald-500 focus:border-emerald-500 outline-none transition"
                            maxlength="20">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">If blank, a random ID like <code class="bg-gray-100 px-1 rounded">FAC-XXXXXX</code> will be assigned.</p>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="closeApproveModal()"
                        class="flex-1 py-3 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-xl transition text-sm shadow-lg shadow-emerald-500/30">
                        <i class="fa-solid fa-check mr-1.5"></i> Yes, Approve
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ============================================================ --}}
{{-- REJECT REASON MODAL                                           --}}
{{-- ============================================================ --}}
<div id="rejectModal" class="modal-overlay" style="display:none;" onclick="closeModalOnBackdrop(event, 'rejectModal')">
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-br from-red-500 to-rose-600 p-6 text-white text-center">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-user-xmark text-2xl"></i>
            </div>
            <h3 class="text-xl font-bold">Reject Application</h3>
            <p class="text-red-100 text-sm mt-1" id="rejectModalSubtitle">Provide an optional reason.</p>
        </div>
        <div class="p-6">
            <form id="rejectForm" method="POST">
                @csrf
                <label class="block text-sm font-bold text-gray-700 mb-2">Reason for Rejection <span class="text-gray-400 font-normal">(optional)</span></label>
                <textarea name="reason" rows="3"
                    placeholder="e.g. Insufficient qualifications, incomplete application ..."
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-red-500 focus:border-red-500 outline-none resize-none mb-5"></textarea>
                <div class="flex gap-3">
                    <button type="button" onclick="closeRejectModal()"
                        class="flex-1 py-3 border border-gray-200 text-gray-600 font-semibold rounded-xl hover:bg-gray-50 transition text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition text-sm shadow-lg shadow-red-500/30">
                        <i class="fa-solid fa-xmark mr-1.5"></i> Reject Application
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openApproveModal(id, name) {
        document.getElementById('approveModalSubtitle').textContent = `Approving application for: ${name}`;
        document.getElementById('approveForm').action = `/admin/faculty-registrations/${id}/approve`;
        document.getElementById('employee_id_input').value = '';
        document.getElementById('approveModal').style.display = 'flex';
    }

    function closeApproveModal() {
        document.getElementById('approveModal').style.display = 'none';
    }

    function openRejectModal(id, name) {
        document.getElementById('rejectModalSubtitle').textContent = `Rejecting application for: ${name}`;
        document.getElementById('rejectForm').action = `/admin/faculty-registrations/${id}/reject`;
        document.getElementById('rejectModal').style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    function closeModalOnBackdrop(event, modalId) {
        // Only close if the click is directly on the overlay backdrop (not on the modal box inside it)
        if (event.target.id === modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
    }

    // Close modals with ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.getElementById('approveModal').style.display = 'none';
            document.getElementById('rejectModal').style.display = 'none';
        }
    });
</script>

@endsection
