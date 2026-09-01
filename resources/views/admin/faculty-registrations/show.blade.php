@extends('layouts.admin')

@section('title', 'Faculty Application — ' . ($facultyRegistration->application_no ?? $facultyRegistration->name))

@section('content')
<style>
    /* ── Page Animations ── */
    .fade-in   { animation: fadeInUp 0.5s cubic-bezier(.2,.8,.2,1) both; }
    .fade-in-2 { animation: fadeInUp 0.5s cubic-bezier(.2,.8,.2,1) 0.1s both; }
    .fade-in-3 { animation: fadeInUp 0.5s cubic-bezier(.2,.8,.2,1) 0.2s both; }
    @keyframes fadeInUp { from { opacity:0; transform:translateY(18px); } to { opacity:1; transform:translateY(0); } }

    /* ── Section Card ── */
    .detail-card {
        background: #fff;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 4px 12px rgba(0,0,0,.03);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .detail-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 22px;
        background: linear-gradient(135deg, #faf5ff 0%, #f3e8ff 100%);
        border-bottom: 1px solid #e9d5ff;
    }
    .detail-card-header .card-icon {
        width: 34px; height: 34px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }
    .detail-card-header h3 {
        font-size: 14px;
        font-weight: 700;
        color: #374151;
        letter-spacing: .01em;
    }

    /* ── Info Grid ── */
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        padding: 0 10px;
    }
    @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }

    .info-cell {
        padding: 13px 12px;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .info-cell:last-child, .info-cell:nth-last-child(2):nth-child(odd) {
        border-bottom: none;
    }
    .info-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .08em;
        color: #9ca3af;
    }
    .info-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #1f2937;
        word-break: break-word;
    }
    .info-value.empty { color: #d1d5db; font-weight: 500; font-style: italic; }

    /* ── Profile Sidebar ── */
    .profile-sidebar {
        background: #fff;
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,.05);
        overflow: hidden;
    }
    .profile-hero {
        background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 50%, #a78bfa 100%);
        padding: 28px 20px 50px;
        text-align: center;
        position: relative;
    }
    .avatar-placeholder {
        width: 90px; height: 90px;
        border-radius: 20px;
        background: rgba(255,255,255,.2);
        margin: 0 auto 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px; color: rgba(255,255,255,.8);
    }
    .avatar-ring {
        width: 90px; height: 90px;
        border-radius: 20px;
        border: 4px solid rgba(255,255,255,.4);
        object-fit: cover;
        margin: 0 auto 12px;
        display: block;
    }
    .profile-name { color: #fff; font-size: 18px; font-weight: 800; line-height: 1.2; }
    .profile-sub  { color: rgba(255,255,255,.75); font-size: 12px; margin-top: 3px; }
    .profile-body { padding: 20px; margin-top: -28px; }

    .stat-pill {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
    }
    .stat-pill-icon {
        width: 32px; height: 32px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }
    .stat-pill-label { font-size: 10px; color: #9ca3af; font-weight: 600; text-transform: uppercase; letter-spacing: .06em; }
    .stat-pill-value { font-size: 13px; color: #1f2937; font-weight: 700; }

    /* ── Subject Tags ── */
    .subject-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #ede9fe;
        color: #6d28d9;
        border: 1px solid #ddd6fe;
    }

    /* ── Timeline ── */
    .timeline-item {
        position: relative;
        padding-left: 24px;
        padding-bottom: 20px;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: 7px;
        top: 24px;
        bottom: 0;
        width: 2px;
        background: #e5e7eb;
    }
    .timeline-item:last-child::before { display: none; }
    .timeline-dot {
        position: absolute;
        left: 0;
        top: 4px;
        width: 16px; height: 16px;
        border-radius: 50%;
        border: 2.5px solid #fff;
        box-shadow: 0 0 0 2px currentColor;
        display: flex; align-items: center; justify-content: center;
        font-size: 7px;
        background: currentColor;
    }

    /* ── Qual Cards ── */
    .qual-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 0;
    }
    @media (max-width: 640px) { .qual-row { grid-template-columns: 1fr 1fr; } }

    /* ── Document Card ── */
    .doc-card {
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        padding: 16px 12px;
        text-align: center;
        transition: all .2s ease;
        background: #fafafa;
    }
    .doc-card:hover { border-color: #8b5cf6; background: #f5f3ff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(139,92,246,.12); }

    /* ── Action Bar ── */
    .action-bar {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 16px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,.04);
    }

    /* ── Audit Box ── */
    .audit-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f3f4f6; }
    .audit-row:last-child { border-bottom: none; }

    @media print {
        .no-print { display: none !important; }
        .detail-card, .profile-sidebar { box-shadow: none !important; }
    }
</style>

<div class="max-w-6xl mx-auto">

    {{-- Flash Messages --}}
    @foreach(['success','error','warning'] as $msg)
        @if(session($msg))
            <div class="mb-4 px-4 py-3 rounded-xl border text-sm font-semibold
                @if($msg==='success') bg-emerald-50 border-emerald-200 text-emerald-700
                @elseif($msg==='warning') bg-amber-50 border-amber-200 text-amber-700
                @else bg-red-50 border-red-200 text-red-700 @endif">
                <i class="fa-solid fa-{{ $msg==='success' ? 'circle-check' : ($msg==='warning' ? 'triangle-exclamation' : 'circle-xmark') }} mr-2"></i>
                {{ session($msg) }}
            </div>
        @endif
    @endforeach

    {{-- ── Action Bar ── --}}
    <div class="action-bar fade-in no-print">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.faculty-registrations.index') }}"
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition text-gray-600">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-gray-900 leading-tight">Faculty Application</h1>
                @if($facultyRegistration->application_no)
                    <p class="text-xs text-purple-600 font-bold font-mono mt-0.5">{{ $facultyRegistration->application_no }}</p>
                @endif
            </div>
        </div>

        <div class="flex items-center gap-2 flex-wrap">
            {{-- Status Badge --}}
            @php
                $statusColors = [
                    'pending'  => 'bg-amber-50 text-amber-700 border-amber-200',
                    'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'rejected' => 'bg-red-50 text-red-700 border-red-200',
                ];
                $statusIcons = [
                    'pending'  => '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>',
                    'approved' => '<i class="fa-solid fa-circle-check text-emerald-500"></i>',
                    'rejected' => '<i class="fa-solid fa-circle-xmark text-red-500"></i>',
                ];
            @endphp
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border {{ $statusColors[$facultyRegistration->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }}">
                {!! $statusIcons[$facultyRegistration->status] ?? '' !!}
                {{ ucfirst($facultyRegistration->status) }}
            </span>

            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200 font-semibold rounded-xl text-xs transition">
                <i class="fa-solid fa-print"></i> Print
            </button>

            @if($facultyRegistration->status === 'pending')
                <button onclick="document.getElementById('approveModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-emerald-200">
                    <i class="fa-solid fa-check"></i> Approve
                </button>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-red-50 text-red-600 border border-red-200 font-bold rounded-xl text-sm transition">
                    <i class="fa-solid fa-xmark"></i> Reject
                </button>
            @elseif($facultyRegistration->status === 'approved')
                <form method="POST" action="{{ route('admin.faculty-registrations.resend', $facultyRegistration->id) }}"
                      onsubmit="return confirm('Resend credentials to {{ addslashes($facultyRegistration->email) }}?')">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 border border-indigo-200 font-bold rounded-xl text-sm transition">
                        <i class="fa-solid fa-paper-plane"></i> Resend Credentials
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- ── Main Layout ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

        {{-- ────── LEFT SIDEBAR ────── --}}
        <div class="lg:col-span-4 space-y-4 fade-in">

            {{-- Profile Card --}}
            <div class="profile-sidebar">
                <div class="profile-hero">
                    @php $photoDoc = $facultyRegistration->documents->where('document_type','photo')->first(); @endphp
                    @if($photoDoc)
                        <img src="{{ route('admin.documents.view', $photoDoc->id) }}"
                             alt="Photo" class="avatar-ring">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                    @endif
                    <p class="profile-name">{{ $facultyRegistration->full_name }}</p>
                    <p class="profile-sub">{{ $facultyRegistration->email }}</p>
                    @if($facultyRegistration->phone)
                        <p class="profile-sub mt-1"><i class="fa-solid fa-phone mr-1 opacity-70"></i>{{ $facultyRegistration->phone }}</p>
                    @endif
                    @if($facultyRegistration->designation || $facultyRegistration->department)
                        <div class="mt-3 flex flex-wrap gap-1.5 justify-center">
                            @if($facultyRegistration->designation)
                                <span class="text-xs font-bold bg-white/20 text-white/90 px-3 py-1 rounded-full">{{ $facultyRegistration->designation }}</span>
                            @endif
                            @if($facultyRegistration->department)
                                <span class="text-xs font-bold bg-white/15 text-white/80 px-3 py-1 rounded-full">{{ $facultyRegistration->department }}</span>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="profile-body">
                    {{-- Application No --}}
                    @if($facultyRegistration->application_no)
                    <div class="stat-pill">
                        <div class="stat-pill-icon bg-purple-100 text-purple-600"><i class="fa-solid fa-hashtag"></i></div>
                        <div>
                            <p class="stat-pill-label">Application No.</p>
                            <p class="stat-pill-value font-mono text-purple-600">{{ $facultyRegistration->application_no }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Subjects --}}
                    @if($resolvedSubjects->count())
                    <div class="stat-pill items-start">
                        <div class="stat-pill-icon bg-indigo-100 text-indigo-600 mt-0.5"><i class="fa-solid fa-book"></i></div>
                        <div>
                            <p class="stat-pill-label mb-1.5">Teaching Subjects</p>
                            <div class="flex flex-wrap gap-1">
                                @foreach($resolvedSubjects as $sub)
                                    <span class="subject-tag">{{ $sub->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Experience --}}
                    @if($facultyRegistration->years_experience || $facultyRegistration->experience)
                    <div class="stat-pill">
                        <div class="stat-pill-icon bg-amber-100 text-amber-600"><i class="fa-solid fa-clock"></i></div>
                        <div>
                            <p class="stat-pill-label">Experience</p>
                            <p class="stat-pill-value">{{ $facultyRegistration->years_experience ?? $facultyRegistration->experience }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Teaching Mode --}}
                    @if($facultyRegistration->teaching_mode)
                    <div class="stat-pill">
                        <div class="stat-pill-icon bg-sky-100 text-sky-600"><i class="fa-solid fa-chalkboard"></i></div>
                        <div>
                            <p class="stat-pill-label">Teaching Mode</p>
                            <p class="stat-pill-value capitalize">{{ $facultyRegistration->teaching_mode }}</p>
                        </div>
                    </div>
                    @endif

                    {{-- Submitted --}}
                    <div class="stat-pill">
                        <div class="stat-pill-icon bg-gray-100 text-gray-500"><i class="fa-solid fa-calendar"></i></div>
                        <div>
                            <p class="stat-pill-label">Submitted On</p>
                            <p class="stat-pill-value">{{ ($facultyRegistration->submitted_at ?? $facultyRegistration->created_at)->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Blood Group --}}
                    @if($facultyRegistration->blood_group)
                    <div class="stat-pill">
                        <div class="stat-pill-icon bg-red-100 text-red-500"><i class="fa-solid fa-droplet"></i></div>
                        <div>
                            <p class="stat-pill-label">Blood Group</p>
                            <p class="stat-pill-value">{{ $facultyRegistration->blood_group }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Review Audit --}}
            @if($facultyRegistration->status !== 'pending')
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-purple-100 text-purple-600"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3>Review Audit</h3>
                </div>
                <div class="px-5 py-4">
                    @if($facultyRegistration->status === 'approved')
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Approved by</span>
                            <span class="text-xs font-bold text-gray-800">{{ $facultyRegistration->approvedBy?->name ?? 'System' }}</span>
                        </div>
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Approved on</span>
                            <span class="text-xs font-bold text-gray-800">{{ $facultyRegistration->approved_at?->format('d M Y, h:i A') }}</span>
                        </div>
                    @endif
                    @if($facultyRegistration->status === 'rejected')
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Rejected by</span>
                            <span class="text-xs font-bold text-gray-800">{{ $facultyRegistration->rejectedBy?->name ?? 'System' }}</span>
                        </div>
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Rejected on</span>
                            <span class="text-xs font-bold text-gray-800">{{ $facultyRegistration->rejected_at?->format('d M Y, h:i A') }}</span>
                        </div>
                        @if($facultyRegistration->reject_reason)
                            <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-xl text-xs text-red-700">
                                <p class="font-bold mb-1"><i class="fa-solid fa-circle-info mr-1"></i>Reason</p>
                                <p>{{ $facultyRegistration->reject_reason }}</p>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            @endif

        </div>

        {{-- ────── RIGHT CONTENT ────── --}}
        <div class="lg:col-span-8 space-y-4 fade-in-2">

            {{-- ①  Personal Details --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-purple-100 text-purple-600"><i class="fa-solid fa-user"></i></div>
                    <h3>Personal Details</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell">
                        <span class="info-label">First Name</span>
                        <span class="info-value">{{ $facultyRegistration->first_name ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Last Name</span>
                        <span class="info-value">{{ $facultyRegistration->last_name ?? '—' }}</span>
                    </div>
                    @if($facultyRegistration->middle_name)
                    <div class="info-cell">
                        <span class="info-label">Middle Name</span>
                        <span class="info-value">{{ $facultyRegistration->middle_name }}</span>
                    </div>
                    @endif
                    <div class="info-cell">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ $facultyRegistration->date_of_birth?->format('d M Y') ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Gender</span>
                        <span class="info-value capitalize">{{ str_replace('_', ' ', $facultyRegistration->gender ?? '—') }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Nationality</span>
                        <span class="info-value">{{ $facultyRegistration->nationality ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Blood Group</span>
                        <span class="info-value">{{ $facultyRegistration->blood_group ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Marital Status</span>
                        <span class="info-value capitalize">{{ $facultyRegistration->marital_status ?? '—' }}</span>
                    </div>
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Aadhaar (Masked)</span>
                        <span class="info-value font-mono text-gray-500 text-sm">{{ $facultyRegistration->masked_aadhaar }}</span>
                    </div>
                </div>
            </div>

            {{-- ②  Contact Details --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-sky-100 text-sky-600"><i class="fa-solid fa-phone"></i></div>
                    <h3>Contact Details</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell">
                        <span class="info-label">Email</span>
                        <span class="info-value text-purple-600">{{ $facultyRegistration->email }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{ $facultyRegistration->phone }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Alternate Phone</span>
                        <span class="info-value {{ !$facultyRegistration->alternate_phone ? 'empty' : '' }}">{{ $facultyRegistration->alternate_phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">WhatsApp</span>
                        <span class="info-value {{ !$facultyRegistration->whatsapp_number ? 'empty' : '' }}">{{ $facultyRegistration->whatsapp_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Address</span>
                        <span class="info-value">{{ $facultyRegistration->address ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">City / State</span>
                        <span class="info-value">{{ implode(', ', array_filter([$facultyRegistration->city, $facultyRegistration->state])) ?: '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Postal / Country</span>
                        <span class="info-value">{{ implode(', ', array_filter([$facultyRegistration->postal_code, $facultyRegistration->country])) ?: '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- ③  Professional Details --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-amber-100 text-amber-600"><i class="fa-solid fa-briefcase"></i></div>
                    <h3>Professional Details</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell">
                        <span class="info-label">Department</span>
                        <span class="info-value">{{ $facultyRegistration->department ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Designation</span>
                        <span class="info-value">{{ $facultyRegistration->designation ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Years of Experience</span>
                        <span class="info-value">{{ $facultyRegistration->years_experience ?? $facultyRegistration->experience ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Teaching Mode</span>
                        <span class="info-value capitalize">{{ $facultyRegistration->teaching_mode ?? '—' }}</span>
                    </div>
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Current Institution</span>
                        <span class="info-value">{{ $facultyRegistration->current_institution ?? '—' }}</span>
                    </div>
                    @if($resolvedSubjects->count())
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Teaching Subjects</span>
                        <div class="flex flex-wrap gap-1.5 mt-1">
                            @foreach($resolvedSubjects as $sub)
                                <span class="subject-tag"><i class="fa-solid fa-circle-dot text-[8px]"></i>{{ $sub->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    @if($facultyRegistration->professional_summary)
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Professional Summary</span>
                        <span class="info-value text-gray-600 font-normal leading-relaxed text-sm">{{ $facultyRegistration->professional_summary }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ④  Educational Qualifications --}}
            @if($facultyRegistration->qualifications->count())
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-violet-100 text-violet-600"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h3>Educational Qualifications</h3>
                    <span class="ml-auto text-xs text-gray-400 font-semibold bg-white/70 px-2 py-0.5 rounded-full">{{ $facultyRegistration->qualifications->count() }} record(s)</span>
                </div>
                <div class="divide-y divide-gray-50">
                    @foreach($facultyRegistration->qualifications as $i => $q)
                    <div class="p-5">
                        <div class="flex items-start gap-3 mb-3">
                            <div class="w-8 h-8 rounded-lg bg-violet-100 text-violet-600 flex items-center justify-center font-black text-sm flex-shrink-0">
                                {{ $i + 1 }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $q->degree }}</p>
                                <p class="text-sm text-gray-500">{{ $q->institution }}</p>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-x-6 gap-y-3 pl-11">
                            @if($q->university)
                            <div>
                                <p class="info-label">University</p>
                                <p class="info-value text-sm">{{ $q->university }}</p>
                            </div>
                            @endif
                            @if($q->specialization)
                            <div>
                                <p class="info-label">Specialization</p>
                                <p class="info-value text-sm">{{ $q->specialization }}</p>
                            </div>
                            @endif
                            @if($q->passing_year)
                            <div>
                                <p class="info-label">Passing Year</p>
                                <p class="info-value text-sm">{{ $q->passing_year }}</p>
                            </div>
                            @endif
                            @if($q->percentage_cgpa)
                            <div>
                                <p class="info-label">% / CGPA</p>
                                <p class="info-value text-sm text-emerald-700 font-bold">{{ $q->percentage_cgpa }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            {{-- Legacy single qualification --}}
            @if($facultyRegistration->qualification)
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-violet-100 text-violet-600"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h3>Qualification</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Highest Qualification</span>
                        <span class="info-value">{{ $facultyRegistration->qualification }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endif

            {{-- ⑤  Work Experience --}}
            @if($facultyRegistration->experiences->count())
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-teal-100 text-teal-600"><i class="fa-solid fa-building"></i></div>
                    <h3>Work Experience</h3>
                    <span class="ml-auto text-xs text-gray-400 font-semibold bg-white/70 px-2 py-0.5 rounded-full">{{ $facultyRegistration->experiences->count() }} entry(ies)</span>
                </div>
                <div class="p-5 space-y-0">
                    @foreach($facultyRegistration->experiences as $exp)
                    <div class="timeline-item {{ $exp->is_current ? 'text-teal-600' : 'text-gray-400' }}">
                        <div class="timeline-dot {{ $exp->is_current ? 'bg-teal-500' : 'bg-gray-300' }}">
                            @if($exp->is_current)<i class="fa-solid fa-circle text-white text-[5px]"></i>@endif
                        </div>
                        <div class="bg-gray-50 border border-gray-100 rounded-xl p-4">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div>
                                    <p class="font-bold text-gray-900 text-sm">
                                        {{ $exp->designation ?? 'Faculty' }}
                                        @if($exp->department)
                                            <span class="text-purple-600"> · {{ $exp->department }}</span>
                                        @endif
                                    </p>
                                    <p class="text-sm text-gray-600 font-medium">{{ $exp->institution }}</p>
                                </div>
                                @if($exp->is_current)
                                    <span class="bg-teal-50 border border-teal-200 text-teal-700 text-xs font-bold px-2 py-0.5 rounded-full flex-shrink-0">Current</span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 font-semibold">
                                <i class="fa-regular fa-calendar mr-1"></i>
                                {{ $exp->start_date?->format('M Y') ?? '?' }}
                                &nbsp;–&nbsp;
                                {{ $exp->is_current ? 'Present' : ($exp->end_date?->format('M Y') ?? '?') }}
                            </p>
                            @if($exp->responsibilities)
                                <p class="text-xs text-gray-500 mt-2 leading-relaxed">{{ $exp->responsibilities }}</p>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ⑥  Uploaded Documents --}}
            @if($facultyRegistration->documents->count())
            <div class="detail-card fade-in-3">
                <div class="detail-card-header">
                    <div class="card-icon bg-teal-100 text-teal-600"><i class="fa-solid fa-folder-open"></i></div>
                    <h3>Uploaded Documents</h3>
                    <span class="ml-auto text-xs font-semibold text-gray-400 bg-white/70 px-2 py-0.5 rounded-full">
                        {{ $facultyRegistration->documents->count() }} file(s)
                    </span>
                </div>
                <div class="p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($facultyRegistration->documents as $doc)
                    <div class="doc-card">
                        <div class="text-3xl mb-2 {{ $doc->isImage() ? 'text-blue-400' : 'text-red-400' }}">
                            <i class="fa-solid {{ $doc->isImage() ? 'fa-image' : ($doc->isPdf() ? 'fa-file-pdf' : 'fa-file') }}"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-700 truncate w-full px-1">{{ $doc->document_label ?? $doc->document_type }}</p>
                        <p class="text-xs text-gray-400 mb-3">{{ $doc->file_size_human }}</p>
                        <div class="flex gap-1.5 justify-center w-full">
                            <a href="{{ route('admin.documents.view', $doc->id) }}" target="_blank"
                               class="flex-1 text-xs py-1.5 bg-purple-100 text-purple-700 font-bold rounded-lg hover:bg-purple-200 transition text-center">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.documents.download', $doc->id) }}"
                               class="flex-1 text-xs py-1.5 bg-gray-100 text-gray-600 font-bold rounded-lg hover:bg-gray-200 transition text-center">
                                <i class="fa-solid fa-download"></i>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>{{-- end right col --}}
    </div>
</div>

{{-- ── Approve Modal ── --}}
<div id="approveModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-gradient-to-br from-emerald-500 to-teal-500 px-6 py-5 text-white text-center">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-user-check text-xl"></i>
            </div>
            <h3 class="text-lg font-extrabold">Approve Faculty Application</h3>
            <p class="text-sm text-emerald-100 mt-1">Login credentials will be generated and emailed automatically.</p>
        </div>
        <form method="POST" action="{{ route('admin.faculty-registrations.approve', $facultyRegistration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Employee ID <span class="text-gray-400 font-normal">(leave blank to auto-generate)</span></label>
                <div class="relative">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-bold">FAC-</span>
                    <input type="text" name="employee_id" placeholder="e.g. 2024-001"
                           class="w-full pl-12 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none" maxlength="20">
                </div>
                <p class="text-xs text-gray-400 mt-1">If blank, a random ID like <code class="bg-gray-100 px-1 rounded">FAC-XXXXXX</code> will be assigned.</p>
            </div>
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 text-xs text-emerald-800 space-y-1.5">
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> A teacher account will be created</div>
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Subjects will be assigned automatically</div>
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> Credentials will be emailed</div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition">
                    <i class="fa-solid fa-check mr-1.5"></i>Confirm Approval
                </button>
                <button type="button" onclick="document.getElementById('approveModal').classList.add('hidden')"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ── Reject Modal ── --}}
<div id="rejectModal" class="hidden fixed inset-0 z-50 bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
        <div class="bg-gradient-to-br from-red-500 to-rose-500 px-6 py-5 text-white text-center">
            <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-user-xmark text-xl"></i>
            </div>
            <h3 class="text-lg font-extrabold">Reject Application</h3>
            <p class="text-sm text-red-100 mt-1">Please provide a reason for audit purposes.</p>
        </div>
        <form method="POST" action="{{ route('admin.faculty-registrations.reject', $facultyRegistration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required placeholder="e.g. Credentials unverifiable, position closed..."
                          class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:border-red-400 focus:ring-2 focus:ring-red-100 outline-none resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="flex-1 py-2.5 bg-red-500 hover:bg-red-600 text-white font-bold rounded-xl text-sm transition">
                    <i class="fa-solid fa-xmark mr-1.5"></i>Confirm Rejection
                </button>
                <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="flex-1 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-sm transition">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.getElementById('approveModal')?.classList.add('hidden');
            document.getElementById('rejectModal')?.classList.add('hidden');
        }
    });
    ['approveModal','rejectModal'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });
</script>
@endsection
