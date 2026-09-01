@extends('layouts.admin')

@section('title', 'Application — ' . ($registration->application_no ?? $registration->name))

@section('content')
<style>
    .section-card { @apply bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6; }
    .info-row { @apply flex flex-col sm:flex-row sm:items-center gap-1 py-3 border-b border-gray-50 last:border-0; }
    .info-label { @apply text-xs font-semibold text-gray-400 uppercase tracking-wider sm:w-48 flex-shrink-0; }
    .info-value { @apply text-sm font-medium text-gray-800; }
    .doc-card { @apply relative group bg-gray-50 border border-gray-200 rounded-xl overflow-hidden flex flex-col items-center justify-center p-4 text-center gap-2 hover:border-indigo-400 hover:bg-indigo-50/50 transition-all; }
</style>

<div class="max-w-5xl mx-auto space-y-6">

    {{-- Flash Messages --}}
    @foreach(['success','error','warning'] as $msg)
        @if(session($msg))
            <div class="px-4 py-3 rounded-xl border text-sm font-medium
                @if($msg==='success') bg-emerald-50 border-emerald-200 text-emerald-700
                @elseif($msg==='warning') bg-amber-50 border-amber-200 text-amber-700
                @else bg-red-50 border-red-200 text-red-700 @endif">
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    {{-- ── Page Header ───────────────────────────────────────────────────────────── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.registrations.index') }}"
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition text-gray-600">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Student Application</h1>
                @if($registration->application_no)
                    <p class="text-sm text-indigo-600 font-bold font-mono">{{ $registration->application_no }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            {{-- Status Badge --}}
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $registration->status_badge_class }}">
                @if($registration->status === 'pending')
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>Pending Review
                @elseif($registration->status === 'approved')
                    <i class="fa-solid fa-check-circle mr-1 text-emerald-500"></i> Approved
                @else
                    <i class="fa-solid fa-times-circle mr-1 text-red-500"></i> Rejected
                @endif
            </span>

            {{-- Approve / Reject (only if pending) --}}
            @if($registration->status === 'pending')
                <button onclick="document.getElementById('approveModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition shadow">
                    <i class="fa-solid fa-check"></i> Approve
                </button>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 border border-red-200 font-bold rounded-xl text-sm transition">
                    <i class="fa-solid fa-xmark"></i> Reject
                </button>
            @endif
        </div>
    </div>

    {{-- ── Main Grid ─────────────────────────────────────────────────────────────── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left column: Photo + Quick Info --}}
        <div class="lg:col-span-1 space-y-6">

            {{-- Photo --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center">
                @php
                    $photoDocs = $registration->documents->where('document_type','photo');
                    $photoDoc  = $photoDocs->first();
                @endphp
                @if($photoDoc)
                    <a href="{{ route('admin.documents.view', $photoDoc->id) }}" target="_blank">
                        <img src="{{ route('admin.documents.view', $photoDoc->id) }}"
                             alt="Applicant Photo"
                             class="w-28 h-28 rounded-2xl object-cover border-4 border-indigo-100 shadow mb-4">
                    </a>
                @else
                    <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-indigo-100 to-blue-100 flex items-center justify-center mb-4 text-indigo-400">
                        <i class="fa-solid fa-user text-4xl"></i>
                    </div>
                @endif
                <h2 class="text-lg font-extrabold text-gray-900">{{ $registration->full_name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $registration->email }}</p>
                @if($registration->phone)
                    <p class="text-sm text-indigo-600 font-semibold mt-1">{{ $registration->phone }}</p>
                @endif
                @if($registration->course)
                    <div class="mt-3 inline-block bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">
                        {{ $registration->course?->name ?? $registration->course }}
                    </div>
                @endif
                <div class="mt-4 text-xs text-gray-400">
                    Submitted: {{ $registration->submitted_at?->format('d M Y, h:i A') ?? $registration->created_at->format('d M Y, h:i A') }}
                </div>
            </div>

            {{-- Audit Info --}}
            @if($registration->status !== 'pending')
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Review Audit</h3>
                <div class="space-y-2 text-sm">
                    @if($registration->status === 'approved')
                        <div class="flex justify-between"><span class="text-gray-500">Approved by</span> <span class="font-semibold text-gray-800">{{ $registration->approvedBy?->name ?? 'System' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Approved at</span> <span class="font-semibold text-gray-800">{{ $registration->approved_at?->format('d M Y') }}</span></div>
                    @endif
                    @if($registration->status === 'rejected')
                        <div class="flex justify-between"><span class="text-gray-500">Rejected by</span> <span class="font-semibold text-gray-800">{{ $registration->rejectedBy?->name ?? 'System' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Rejected at</span> <span class="font-semibold text-gray-800">{{ $registration->rejected_at?->format('d M Y') }}</span></div>
                        @if($registration->reject_reason)
                        <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-lg text-red-700 text-xs">
                            <p class="font-bold mb-1">Reason:</p>
                            <p>{{ $registration->reject_reason }}</p>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- Right column: Detail sections --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Personal Details --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-user text-indigo-500"></i> Personal Details</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50">
                    <div class="info-row"><span class="info-label">Full Name</span><span class="info-value">{{ $registration->full_name }}</span></div>
                    <div class="info-row"><span class="info-label">Date of Birth</span><span class="info-value">{{ $registration->date_of_birth?->format('d M Y') ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Gender</span><span class="info-value capitalize">{{ $registration->gender ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Nationality</span><span class="info-value">{{ $registration->nationality ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Blood Group</span><span class="info-value">{{ $registration->blood_group ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Category</span><span class="info-value">{{ $registration->category ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Religion</span><span class="info-value">{{ $registration->religion ?? '—' }}</span></div>
                    <div class="info-row">
                        <span class="info-label">Aadhaar</span>
                        <span class="info-value font-mono text-gray-500">{{ $registration->masked_aadhaar }}</span>
                    </div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-phone text-indigo-500"></i> Contact Details</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50">
                    <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $registration->email }}</span></div>
                    <div class="info-row"><span class="info-label">Phone</span><span class="info-value">{{ $registration->phone }}</span></div>
                    <div class="info-row"><span class="info-label">Alternate Phone</span><span class="info-value">{{ $registration->alternate_phone ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">WhatsApp</span><span class="info-value">{{ $registration->whatsapp_number ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Permanent Address</span><span class="info-value">{{ $registration->permanent_address ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Current Address</span><span class="info-value">{{ $registration->current_address ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">City / State</span><span class="info-value">{{ implode(', ', array_filter([$registration->city, $registration->state, $registration->postal_code])) ?: '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Country</span><span class="info-value">{{ $registration->country ?? '—' }}</span></div>
                </div>
            </div>

            {{-- Guardians --}}
            @if($registration->guardians->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-people-roof text-indigo-500"></i> Guardian / Parent Details</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($registration->guardians as $guardian)
                    <div class="px-6 py-4">
                        <p class="text-xs font-bold uppercase tracking-wider text-indigo-500 mb-3">
                            {{ ucfirst($guardian->guardian_type) }} Guardian
                        </p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-gray-400 text-xs">Name</span><p class="font-semibold text-gray-800">{{ $guardian->full_name }}</p></div>
                            <div><span class="text-gray-400 text-xs">Relationship</span><p class="font-semibold text-gray-800">{{ $guardian->relationship ?? '—' }}</p></div>
                            <div><span class="text-gray-400 text-xs">Phone</span><p class="font-semibold text-gray-800">{{ $guardian->phone ?? '—' }}</p></div>
                            <div><span class="text-gray-400 text-xs">Email</span><p class="font-semibold text-gray-800">{{ $guardian->email ?? '—' }}</p></div>
                            @if($guardian->occupation)
                            <div><span class="text-gray-400 text-xs">Occupation</span><p class="font-semibold text-gray-800">{{ $guardian->occupation }}</p></div>
                            @endif
                            @if($guardian->annual_income)
                            <div><span class="text-gray-400 text-xs">Annual Income</span><p class="font-semibold text-gray-800">{{ $guardian->annual_income }}</p></div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            {{-- Legacy parent info for old records --}}
            @if($registration->parent_name || $registration->parent_email)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-people-roof text-indigo-500"></i> Parent / Guardian</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50">
                    <div class="info-row"><span class="info-label">Name</span><span class="info-value">{{ $registration->parent_name ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $registration->parent_email ?? '—' }}</span></div>
                </div>
            </div>
            @endif
            @endif

            {{-- Academic --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-graduation-cap text-indigo-500"></i> Academic Details</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50">
                    <div class="info-row"><span class="info-label">Applied Course</span><span class="info-value font-bold text-indigo-700">{{ $registration->course?->name ?? $registration->course ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Last Institution</span><span class="info-value">{{ $registration->last_institution ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Board / University</span><span class="info-value">{{ $registration->board_university ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Last Qualification</span><span class="info-value">{{ $registration->last_qualification ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Stream</span><span class="info-value">{{ $registration->stream ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Passing Year</span><span class="info-value">{{ $registration->passing_year ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">% / CGPA</span><span class="info-value">{{ $registration->percentage_cgpa ?? '—' }}</span></div>
                    <div class="info-row"><span class="info-label">Roll / Reg No.</span><span class="info-value font-mono">{{ $registration->roll_registration_no ?? '—' }}</span></div>
                </div>
            </div>

            {{-- Documents --}}
            @if($registration->documents->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2">
                        <i class="fa-solid fa-file-alt text-indigo-500"></i>
                        Uploaded Documents
                        <span class="ml-auto text-xs font-medium text-gray-400">{{ $registration->documents->count() }} file(s)</span>
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($registration->documents as $doc)
                    <div class="relative group bg-gray-50 border border-gray-200 rounded-xl p-4 text-center hover:border-indigo-300 hover:bg-indigo-50/50 transition-all">
                        <div class="text-3xl mb-2 {{ $doc->isImage() ? 'text-blue-400' : 'text-red-400' }}">
                            <i class="fa-solid {{ $doc->isImage() ? 'fa-image' : ($doc->isPdf() ? 'fa-file-pdf' : 'fa-file') }}"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-700 mb-0.5 truncate">{{ $doc->document_label ?? $doc->document_type }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $doc->file_size_human }}</p>
                        <div class="mt-3 flex gap-2 justify-center">
                            <a href="{{ route('admin.documents.view', $doc->id) }}" target="_blank"
                               class="flex-1 text-xs py-1.5 bg-indigo-100 text-indigo-700 font-bold rounded-lg hover:bg-indigo-200 transition text-center">
                                <i class="fa-solid fa-eye mr-1"></i> View
                            </a>
                            <a href="{{ route('admin.documents.download', $doc->id) }}"
                               class="flex-1 text-xs py-1.5 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition text-center">
                                <i class="fa-solid fa-download mr-1"></i> Save
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- end right col --}}
    </div>{{-- end grid --}}
</div>

{{-- ── Approve Modal ─────────────────────────────────────────────────────────── --}}
<div id="approveModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-emerald-50 border-b border-emerald-100 px-6 py-5">
            <h3 class="text-lg font-extrabold text-emerald-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-emerald-500"></i> Approve Application
            </h3>
            <p class="text-sm text-emerald-600 mt-1">Login credentials will be auto-generated and emailed to the student.</p>
        </div>
        <form method="POST" action="{{ route('admin.registrations.approve', $registration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Roll Number <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="text" name="roll" value="{{ $registration->roll }}"
                       placeholder="e.g. 2024-CS-001"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none">
            </div>
            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition">
                    Confirm Approval
                </button>
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Reject Modal ──────────────────────────────────────────────────────────── --}}
<div id="rejectModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-red-50 border-b border-red-100 px-6 py-5">
            <h3 class="text-lg font-extrabold text-red-800 flex items-center gap-2">
                <i class="fa-solid fa-circle-xmark text-red-500"></i> Reject Application
            </h3>
            <p class="text-sm text-red-600 mt-1">Please provide a reason that will be recorded for audit purposes.</p>
        </div>
        <form method="POST" action="{{ route('admin.registrations.reject', $registration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required
                          placeholder="e.g. Documents incomplete, eligibility criteria not met..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:border-red-400 focus:ring-2 focus:ring-red-100 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit"
                        class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl text-sm transition">
                    Confirm Rejection
                </button>
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
