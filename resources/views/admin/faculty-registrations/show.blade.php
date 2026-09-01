@extends('layouts.admin')

@section('title', 'Faculty Application — ' . ($facultyRegistration->application_no ?? $facultyRegistration->name))

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

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

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.faculty-registrations.index') }}"
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition text-gray-600">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-2xl font-extrabold text-gray-900">Faculty Application</h1>
                @if($facultyRegistration->application_no)
                    <p class="text-sm text-indigo-600 font-bold font-mono">{{ $facultyRegistration->application_no }}</p>
                @endif
            </div>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold border {{ $facultyRegistration->status_badge_class }}">
                @if($facultyRegistration->status === 'pending')
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>Pending Review
                @elseif($facultyRegistration->status === 'approved')
                    <i class="fa-solid fa-check-circle mr-1 text-emerald-500"></i>Approved
                @else
                    <i class="fa-solid fa-times-circle mr-1 text-red-500"></i>Rejected
                @endif
            </span>
            @if($facultyRegistration->status === 'pending')
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Photo + Quick Info --}}
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col items-center text-center">
                @php $photoDoc = $facultyRegistration->documents->where('document_type','photo')->first(); @endphp
                @if($photoDoc)
                    <img src="{{ route('admin.documents.view', $photoDoc->id) }}"
                         alt="Photo" class="w-28 h-28 rounded-2xl object-cover border-4 border-purple-100 shadow mb-4">
                @else
                    <div class="w-28 h-28 rounded-2xl bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center mb-4 text-purple-400">
                        <i class="fa-solid fa-chalkboard-user text-4xl"></i>
                    </div>
                @endif
                <h2 class="text-lg font-extrabold text-gray-900">{{ $facultyRegistration->full_name }}</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $facultyRegistration->email }}</p>
                @if($facultyRegistration->phone)
                    <p class="text-sm text-indigo-600 font-semibold mt-1">{{ $facultyRegistration->phone }}</p>
                @endif
                @if($facultyRegistration->department || $facultyRegistration->designation)
                    <div class="mt-3 space-y-1">
                        @if($facultyRegistration->designation)
                            <div class="inline-block bg-purple-50 border border-purple-100 text-purple-700 text-xs font-bold px-3 py-1 rounded-full">{{ $facultyRegistration->designation }}</div>
                        @endif
                        @if($facultyRegistration->department)
                            <div class="inline-block bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full">{{ $facultyRegistration->department }}</div>
                        @endif
                    </div>
                @endif
                @if($resolvedSubjects->count())
                    <div class="mt-3 flex flex-wrap gap-1 justify-center">
                        @foreach($resolvedSubjects as $sub)
                            <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5 rounded-full">{{ $sub->name }}</span>
                        @endforeach
                    </div>
                @endif
                <div class="mt-4 text-xs text-gray-400">
                    Submitted: {{ $facultyRegistration->submitted_at?->format('d M Y, h:i A') ?? $facultyRegistration->created_at->format('d M Y, h:i A') }}
                </div>
            </div>

            @if($facultyRegistration->status !== 'pending')
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Review Audit</h3>
                <div class="space-y-2 text-sm">
                    @if($facultyRegistration->status === 'approved')
                        <div class="flex justify-between"><span class="text-gray-500">Approved by</span><span class="font-semibold text-gray-800">{{ $facultyRegistration->approvedBy?->name ?? 'System' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Approved at</span><span class="font-semibold text-gray-800">{{ $facultyRegistration->approved_at?->format('d M Y') }}</span></div>
                    @endif
                    @if($facultyRegistration->status === 'rejected')
                        <div class="flex justify-between"><span class="text-gray-500">Rejected by</span><span class="font-semibold text-gray-800">{{ $facultyRegistration->rejectedBy?->name ?? 'System' }}</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Rejected at</span><span class="font-semibold text-gray-800">{{ $facultyRegistration->rejected_at?->format('d M Y') }}</span></div>
                        @if($facultyRegistration->reject_reason)
                        <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-lg text-red-700 text-xs">
                            <p class="font-bold mb-1">Reason:</p><p>{{ $facultyRegistration->reject_reason }}</p>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Right: Details --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Personal --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-user text-purple-500"></i> Personal Details</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50 text-sm">
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Full Name</span><span class="font-medium text-gray-800">{{ $facultyRegistration->full_name }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Date of Birth</span><span class="font-medium text-gray-800">{{ $facultyRegistration->date_of_birth?->format('d M Y') ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Gender</span><span class="font-medium text-gray-800 capitalize">{{ $facultyRegistration->gender ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Nationality</span><span class="font-medium text-gray-800">{{ $facultyRegistration->nationality ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Blood Group</span><span class="font-medium text-gray-800">{{ $facultyRegistration->blood_group ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Marital Status</span><span class="font-medium text-gray-800 capitalize">{{ $facultyRegistration->marital_status ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Aadhaar</span><span class="font-mono text-gray-500">{{ $facultyRegistration->masked_aadhaar }}</span></div>
                </div>
            </div>

            {{-- Contact --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-phone text-purple-500"></i> Contact</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50 text-sm">
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Email</span><span class="font-medium text-gray-800">{{ $facultyRegistration->email }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Phone</span><span class="font-medium text-gray-800">{{ $facultyRegistration->phone }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">WhatsApp</span><span class="font-medium text-gray-800">{{ $facultyRegistration->whatsapp_number ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Address</span><span class="font-medium text-gray-800">{{ $facultyRegistration->address ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">City / State</span><span class="font-medium text-gray-800">{{ implode(', ', array_filter([$facultyRegistration->city, $facultyRegistration->state, $facultyRegistration->postal_code])) ?: '—' }}</span></div>
                </div>
            </div>

            {{-- Professional --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-briefcase text-purple-500"></i> Professional</h3>
                </div>
                <div class="px-6 py-2 divide-y divide-gray-50 text-sm">
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Department</span><span class="font-medium text-gray-800">{{ $facultyRegistration->department ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Designation</span><span class="font-medium text-gray-800">{{ $facultyRegistration->designation ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Teaching Mode</span><span class="font-medium text-gray-800 capitalize">{{ $facultyRegistration->teaching_mode ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Years of Exp.</span><span class="font-medium text-gray-800">{{ $facultyRegistration->years_experience ?? $facultyRegistration->experience ?? '—' }}</span></div>
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Current Institution</span><span class="font-medium text-gray-800">{{ $facultyRegistration->current_institution ?? '—' }}</span></div>
                    @if($facultyRegistration->professional_summary)
                    <div class="flex py-3"><span class="w-48 text-xs font-semibold text-gray-400 uppercase tracking-wider flex-shrink-0">Summary</span><span class="font-medium text-gray-800">{{ $facultyRegistration->professional_summary }}</span></div>
                    @endif
                </div>
            </div>

            {{-- Qualifications --}}
            @if($facultyRegistration->qualifications->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-graduation-cap text-purple-500"></i> Educational Qualifications</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($facultyRegistration->qualifications as $q)
                    <div class="px-6 py-4 grid grid-cols-2 sm:grid-cols-3 gap-3 text-sm">
                        <div><span class="text-xs text-gray-400">Degree</span><p class="font-bold text-gray-800">{{ $q->degree }}</p></div>
                        <div><span class="text-xs text-gray-400">Institution</span><p class="font-semibold text-gray-800">{{ $q->institution }}</p></div>
                        <div><span class="text-xs text-gray-400">University</span><p class="font-semibold text-gray-800">{{ $q->university ?? '—' }}</p></div>
                        <div><span class="text-xs text-gray-400">Specialization</span><p class="font-semibold text-gray-800">{{ $q->specialization ?? '—' }}</p></div>
                        <div><span class="text-xs text-gray-400">Year</span><p class="font-semibold text-gray-800">{{ $q->passing_year ?? '—' }}</p></div>
                        <div><span class="text-xs text-gray-400">% / CGPA</span><p class="font-semibold text-gray-800">{{ $q->percentage_cgpa ?? '—' }}</p></div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Experiences --}}
            @if($facultyRegistration->experiences->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2"><i class="fa-solid fa-building text-purple-500"></i> Work Experience</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($facultyRegistration->experiences as $exp)
                    <div class="px-6 py-4">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="font-bold text-gray-900">{{ $exp->designation ?? 'Faculty' }} @if($exp->department)<span class="text-indigo-600">· {{ $exp->department }}</span>@endif</p>
                                <p class="text-sm font-semibold text-gray-600">{{ $exp->institution }}</p>
                            </div>
                            @if($exp->is_current)
                                <span class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0">Current</span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 mt-1">
                            {{ $exp->start_date?->format('M Y') ?? '?' }}
                            — {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('M Y') ?? '?') }}
                        </p>
                        @if($exp->responsibilities)
                        <p class="text-sm text-gray-600 mt-2">{{ $exp->responsibilities }}</p>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Documents --}}
            @if($facultyRegistration->documents->count())
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2">
                        <i class="fa-solid fa-file-alt text-purple-500"></i> Uploaded Documents
                        <span class="ml-auto text-xs font-medium text-gray-400">{{ $facultyRegistration->documents->count() }} file(s)</span>
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-2 sm:grid-cols-3 gap-3">
                    @foreach($facultyRegistration->documents as $doc)
                    <div class="relative bg-gray-50 border border-gray-200 rounded-xl p-4 text-center hover:border-purple-300 hover:bg-purple-50/50 transition-all">
                        <div class="text-3xl mb-2 {{ $doc->isImage() ? 'text-blue-400' : 'text-red-400' }}">
                            <i class="fa-solid {{ $doc->isImage() ? 'fa-image' : ($doc->isPdf() ? 'fa-file-pdf' : 'fa-file') }}"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-700 mb-0.5 truncate">{{ $doc->document_label ?? $doc->document_type }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ $doc->file_size_human }}</p>
                        <div class="mt-3 flex gap-2 justify-center">
                            <a href="{{ route('admin.documents.view', $doc->id) }}" target="_blank"
                               class="flex-1 text-xs py-1.5 bg-purple-100 text-purple-700 font-bold rounded-lg hover:bg-purple-200 transition text-center">
                                <i class="fa-solid fa-eye mr-1"></i>View
                            </a>
                            <a href="{{ route('admin.documents.download', $doc->id) }}"
                               class="flex-1 text-xs py-1.5 bg-gray-100 text-gray-700 font-bold rounded-lg hover:bg-gray-200 transition text-center">
                                <i class="fa-solid fa-download mr-1"></i>Save
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

{{-- Approve Modal --}}
<div id="approveModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-emerald-50 border-b border-emerald-100 px-6 py-5">
            <h3 class="text-lg font-extrabold text-emerald-800 flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Approve Faculty Application</h3>
            <p class="text-sm text-emerald-600 mt-1">Login credentials will be generated and emailed automatically.</p>
        </div>
        <form method="POST" action="{{ route('admin.faculty-registrations.approve', $facultyRegistration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Employee ID <span class="text-gray-400 font-normal">(leave blank to auto-generate)</span></label>
                <input type="text" name="employee_id" placeholder="e.g. FAC-2024-001"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition">Confirm Approval</button>
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

{{-- Reject Modal --}}
<div id="rejectModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-red-50 border-b border-red-100 px-6 py-5">
            <h3 class="text-lg font-extrabold text-red-800 flex items-center gap-2"><i class="fa-solid fa-circle-xmark text-red-500"></i> Reject Application</h3>
        </div>
        <form method="POST" action="{{ route('admin.faculty-registrations.reject', $facultyRegistration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required placeholder="e.g. Credentials unverifiable, position closed..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:border-red-400 focus:ring-2 focus:ring-red-100 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl text-sm transition">Confirm Rejection</button>
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">Cancel</button>
            </div>
        </form>
    </div>
</div>

@endsection
