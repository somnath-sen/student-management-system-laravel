@extends('layouts.admin')

@section('title', 'Student Application — ' . ($registration->application_no ?? $registration->name))

@section('content')
<style>
    /* ── Page Animations ── */
    .fade-in  { animation: fadeInUp 0.5s cubic-bezier(.2,.8,.2,1) both; }
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
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-bottom: 1px solid #e5e7eb;
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
        background: linear-gradient(135deg, #4f46e5 0%, #6366f1 50%, #818cf8 100%);
        padding: 28px 20px 50px;
        text-align: center;
        position: relative;
    }
    .avatar-ring {
        width: 90px; height: 90px;
        border-radius: 20px;
        border: 4px solid rgba(255,255,255,.4);
        object-fit: cover;
        margin: 0 auto 12px;
        display: block;
        background: rgba(255,255,255,.15);
    }
    .avatar-placeholder {
        width: 90px; height: 90px;
        border-radius: 20px;
        background: rgba(255,255,255,.2);
        margin: 0 auto 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 36px; color: rgba(255,255,255,.8);
    }
    .profile-name {
        color: #fff;
        font-size: 18px;
        font-weight: 800;
        line-height: 1.2;
    }
    .profile-sub {
        color: rgba(255,255,255,.75);
        font-size: 12px;
        margin-top: 3px;
    }
    .profile-body {
        padding: 20px;
        margin-top: -28px;
    }
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

    /* ── Guardian Grid ── */
    .guardian-card {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        background: #fafafa;
    }
    .guardian-type-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .08em;
        padding: 3px 10px;
        border-radius: 999px;
    }

    /* ── Document Card ── */
    .doc-card {
        border-radius: 12px;
        border: 1.5px solid #e5e7eb;
        padding: 16px 12px;
        text-align: center;
        transition: all .2s ease;
        background: #fafafa;
        cursor: pointer;
    }
    .doc-card:hover { border-color: #6366f1; background: #eef2ff; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(99,102,241,.12); }

    /* ── Audit Box ── */
    .audit-box {
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        background: #f9fafb;
        padding: 16px;
    }
    .audit-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f3f4f6; }
    .audit-row:last-child { border-bottom: none; }

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

    /* ── Print strip ── */
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
            <a href="{{ route('admin.registrations.index') }}"
               class="w-9 h-9 flex items-center justify-center rounded-xl bg-gray-100 hover:bg-gray-200 transition text-gray-600">
                <i class="fa-solid fa-arrow-left text-sm"></i>
            </a>
            <div>
                <h1 class="text-xl font-extrabold text-gray-900 leading-tight">Student Application</h1>
                @if($registration->application_no)
                    <p class="text-xs text-indigo-600 font-bold font-mono mt-0.5">{{ $registration->application_no }}</p>
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
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold border {{ $statusColors[$registration->status] ?? 'bg-gray-50 text-gray-600 border-gray-200' }}">
                {!! $statusIcons[$registration->status] ?? '' !!}
                {{ ucfirst($registration->status) }}
            </span>

            {{-- Print --}}
            <button onclick="window.print()" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-gray-50 hover:bg-gray-100 text-gray-600 border border-gray-200 font-semibold rounded-xl text-xs transition">
                <i class="fa-solid fa-print"></i> Print
            </button>

            @if($registration->status === 'pending')
                <button onclick="document.getElementById('approveModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl text-sm transition shadow-sm shadow-emerald-200">
                    <i class="fa-solid fa-check"></i> Approve
                </button>
                <button onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-red-50 text-red-600 border border-red-200 font-bold rounded-xl text-sm transition">
                    <i class="fa-solid fa-xmark"></i> Reject
                </button>
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
                    @php $photoDoc = $registration->documents->where('document_type','photo')->first(); @endphp
                    @if($photoDoc)
                        <img src="{{ route('admin.documents.view', $photoDoc->id) }}"
                             alt="Photo" class="avatar-ring">
                    @else
                        <div class="avatar-placeholder">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    @endif
                    <p class="profile-name">{{ $registration->full_name }}</p>
                    <p class="profile-sub">{{ $registration->email }}</p>
                    @if($registration->phone)
                        <p class="profile-sub mt-1"><i class="fa-solid fa-phone mr-1 opacity-70"></i>{{ $registration->phone }}</p>
                    @endif
                </div>

                <div class="profile-body">
                    {{-- Course Pill --}}
                    @if($registration->course)
                        <div class="stat-pill">
                            <div class="stat-pill-icon bg-indigo-100 text-indigo-600">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div>
                                <p class="stat-pill-label">Applied Course</p>
                                <p class="stat-pill-value">{{ $registration->course?->name ?? $registration->course }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- App No --}}
                    @if($registration->application_no)
                        <div class="stat-pill">
                            <div class="stat-pill-icon bg-purple-100 text-purple-600">
                                <i class="fa-solid fa-hashtag"></i>
                            </div>
                            <div>
                                <p class="stat-pill-label">Application No.</p>
                                <p class="stat-pill-value font-mono text-indigo-600">{{ $registration->application_no }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Roll --}}
                    @if($registration->roll)
                        <div class="stat-pill">
                            <div class="stat-pill-icon bg-sky-100 text-sky-600">
                                <i class="fa-solid fa-id-badge"></i>
                            </div>
                            <div>
                                <p class="stat-pill-label">Roll Number</p>
                                <p class="stat-pill-value">{{ $registration->roll }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Submitted --}}
                    <div class="stat-pill">
                        <div class="stat-pill-icon bg-gray-100 text-gray-500">
                            <i class="fa-solid fa-calendar"></i>
                        </div>
                        <div>
                            <p class="stat-pill-label">Submitted On</p>
                            <p class="stat-pill-value">{{ ($registration->submitted_at ?? $registration->created_at)->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>

                    {{-- Blood Group --}}
                    @if($registration->blood_group)
                        <div class="stat-pill">
                            <div class="stat-pill-icon bg-red-100 text-red-500">
                                <i class="fa-solid fa-droplet"></i>
                            </div>
                            <div>
                                <p class="stat-pill-label">Blood Group</p>
                                <p class="stat-pill-value">{{ $registration->blood_group }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Review Audit --}}
            @if($registration->status !== 'pending')
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-gray-100 text-gray-500">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <h3>Review Audit</h3>
                </div>
                <div class="px-5 py-4">
                    @if($registration->status === 'approved')
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Approved by</span>
                            <span class="text-xs font-bold text-gray-800">{{ $registration->approvedBy?->name ?? 'System' }}</span>
                        </div>
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Approved on</span>
                            <span class="text-xs font-bold text-gray-800">{{ $registration->approved_at?->format('d M Y, h:i A') }}</span>
                        </div>
                    @endif
                    @if($registration->status === 'rejected')
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Rejected by</span>
                            <span class="text-xs font-bold text-gray-800">{{ $registration->rejectedBy?->name ?? 'System' }}</span>
                        </div>
                        <div class="audit-row">
                            <span class="text-xs text-gray-500 font-medium">Rejected on</span>
                            <span class="text-xs font-bold text-gray-800">{{ $registration->rejected_at?->format('d M Y, h:i A') }}</span>
                        </div>
                        @if($registration->reject_reason)
                            <div class="mt-3 p-3 bg-red-50 border border-red-100 rounded-xl text-xs text-red-700">
                                <p class="font-bold mb-1"><i class="fa-solid fa-circle-info mr-1"></i>Reason</p>
                                <p>{{ $registration->reject_reason }}</p>
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
                    <div class="card-icon bg-indigo-100 text-indigo-600"><i class="fa-solid fa-user"></i></div>
                    <h3>Personal Details</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell">
                        <span class="info-label">First Name</span>
                        <span class="info-value">{{ $registration->first_name ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Last Name</span>
                        <span class="info-value">{{ $registration->last_name ?? '—' }}</span>
                    </div>
                    @if($registration->middle_name)
                    <div class="info-cell">
                        <span class="info-label">Middle Name</span>
                        <span class="info-value">{{ $registration->middle_name }}</span>
                    </div>
                    @endif
                    <div class="info-cell">
                        <span class="info-label">Date of Birth</span>
                        <span class="info-value">{{ $registration->date_of_birth?->format('d M Y') ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Gender</span>
                        <span class="info-value capitalize">{{ str_replace('_', ' ', $registration->gender ?? '—') }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Nationality</span>
                        <span class="info-value">{{ $registration->nationality ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Blood Group</span>
                        <span class="info-value">{{ $registration->blood_group ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Category</span>
                        <span class="info-value">{{ $registration->category ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Religion</span>
                        <span class="info-value">{{ $registration->religion ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Aadhaar (Masked)</span>
                        <span class="info-value font-mono text-sm text-gray-500">{{ $registration->masked_aadhaar }}</span>
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
                        <span class="info-value text-indigo-600">{{ $registration->email }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Phone</span>
                        <span class="info-value">{{ $registration->phone }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Alternate Phone</span>
                        <span class="info-value {{ !$registration->alternate_phone ? 'empty' : '' }}">{{ $registration->alternate_phone ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">WhatsApp</span>
                        <span class="info-value {{ !$registration->whatsapp_number ? 'empty' : '' }}">{{ $registration->whatsapp_number ?? 'Not provided' }}</span>
                    </div>
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Permanent Address</span>
                        <span class="info-value">{{ $registration->permanent_address ?? '—' }}</span>
                    </div>
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Current Address</span>
                        <span class="info-value {{ $registration->current_address === $registration->permanent_address ? 'text-gray-400' : '' }}">
                            {{ $registration->current_address ?? '—' }}
                            @if($registration->current_address && $registration->current_address === $registration->permanent_address)
                                <span class="text-xs text-gray-400 font-normal ml-1">(same as permanent)</span>
                            @endif
                        </span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">City / State</span>
                        <span class="info-value">{{ implode(', ', array_filter([$registration->city, $registration->state])) ?: '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Postal / Country</span>
                        <span class="info-value">{{ implode(', ', array_filter([$registration->postal_code, $registration->country])) ?: '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- ③  Academic Details --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-violet-100 text-violet-600"><i class="fa-solid fa-graduation-cap"></i></div>
                    <h3>Academic Details</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Applied Course</span>
                        <span class="info-value text-indigo-700 text-base">{{ $registration->course?->name ?? $registration->course ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Last Qualification</span>
                        <span class="info-value">{{ $registration->last_qualification ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Stream</span>
                        <span class="info-value">{{ $registration->stream ?? '—' }}</span>
                    </div>
                    <div class="info-cell" style="grid-column: span 2;">
                        <span class="info-label">Last Institution</span>
                        <span class="info-value">{{ $registration->last_institution ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Board / University</span>
                        <span class="info-value">{{ $registration->board_university ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Passing Year</span>
                        <span class="info-value">{{ $registration->passing_year ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Percentage / CGPA</span>
                        <span class="info-value text-emerald-700 font-bold">{{ $registration->percentage_cgpa ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Roll / Reg. No.</span>
                        <span class="info-value font-mono">{{ $registration->roll_registration_no ?? '—' }}</span>
                    </div>
                </div>
            </div>

            {{-- ④  Guardian / Parent Details --}}
            @if($registration->guardians->count())
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-orange-100 text-orange-600"><i class="fa-solid fa-people-roof"></i></div>
                    <h3>Guardian / Parent Details</h3>
                    <span class="ml-auto text-xs text-gray-400">{{ $registration->guardians->count() }} guardian(s)</span>
                </div>
                <div class="p-4 space-y-4">
                    @foreach($registration->guardians as $guardian)
                    @php
                        $gColors = [
                            'primary'   => ['bg-indigo-50 text-indigo-700 border-indigo-200', 'bg-indigo-100 text-indigo-600'],
                            'secondary' => ['bg-sky-50 text-sky-700 border-sky-200', 'bg-sky-100 text-sky-600'],
                            'emergency' => ['bg-red-50 text-red-700 border-red-200', 'bg-red-100 text-red-500'],
                        ];
                        $gc = $gColors[$guardian->guardian_type] ?? $gColors['primary'];
                    @endphp
                    <div class="guardian-card">
                        <div class="px-4 py-3 flex items-center gap-3 bg-white border-b border-gray-100">
                            <span class="guardian-type-badge border {{ $gc[0] }}">
                                @if($guardian->guardian_type === 'primary') <i class="fa-solid fa-star text-[9px]"></i>
                                @elseif($guardian->guardian_type === 'emergency') <i class="fa-solid fa-heart-pulse text-[9px]"></i>
                                @endif
                                {{ ucfirst($guardian->guardian_type) }} Guardian
                            </span>
                        </div>
                        <div class="info-grid p-2">
                            <div class="info-cell">
                                <span class="info-label">Full Name</span>
                                <span class="info-value">{{ $guardian->full_name }}</span>
                            </div>
                            <div class="info-cell">
                                <span class="info-label">Relationship</span>
                                <span class="info-value">{{ $guardian->relationship ?? '—' }}</span>
                            </div>
                            <div class="info-cell">
                                <span class="info-label">Phone</span>
                                <span class="info-value">{{ $guardian->phone ?? '—' }}</span>
                            </div>
                            <div class="info-cell">
                                <span class="info-label">Email</span>
                                <span class="info-value {{ !$guardian->email ? 'empty' : '' }}">{{ $guardian->email ?? 'Not provided' }}</span>
                            </div>
                            @if($guardian->occupation)
                            <div class="info-cell">
                                <span class="info-label">Occupation</span>
                                <span class="info-value">{{ $guardian->occupation }}</span>
                            </div>
                            @endif
                            @if($guardian->annual_income)
                            <div class="info-cell">
                                <span class="info-label">Annual Income</span>
                                <span class="info-value">{{ $guardian->annual_income }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @elseif($registration->parent_name || $registration->parent_email)
            {{-- Legacy guardian --}}
            <div class="detail-card">
                <div class="detail-card-header">
                    <div class="card-icon bg-orange-100 text-orange-600"><i class="fa-solid fa-people-roof"></i></div>
                    <h3>Parent / Guardian</h3>
                </div>
                <div class="info-grid p-2">
                    <div class="info-cell">
                        <span class="info-label">Parent Name</span>
                        <span class="info-value">{{ $registration->parent_name ?? '—' }}</span>
                    </div>
                    <div class="info-cell">
                        <span class="info-label">Parent Email</span>
                        <span class="info-value">{{ $registration->parent_email ?? '—' }}</span>
                    </div>
                </div>
            </div>
            @endif

            {{-- ⑤  Uploaded Documents --}}
            @if($registration->documents->count())
            <div class="detail-card fade-in-3">
                <div class="detail-card-header">
                    <div class="card-icon bg-teal-100 text-teal-600"><i class="fa-solid fa-folder-open"></i></div>
                    <h3>Uploaded Documents</h3>
                    <span class="ml-auto text-xs font-semibold text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">
                        {{ $registration->documents->count() }} file(s)
                    </span>
                </div>
                <div class="p-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($registration->documents as $doc)
                    <div class="doc-card">
                        <div class="text-3xl mb-2 {{ $doc->isImage() ? 'text-blue-400' : 'text-red-400' }}">
                            <i class="fa-solid {{ $doc->isImage() ? 'fa-image' : ($doc->isPdf() ? 'fa-file-pdf' : 'fa-file') }}"></i>
                        </div>
                        <p class="text-xs font-bold text-gray-700 truncate w-full px-1">{{ $doc->document_label ?? $doc->document_type }}</p>
                        <p class="text-xs text-gray-400 mb-3">{{ $doc->file_size_human }}</p>
                        <div class="flex gap-1.5 justify-center w-full">
                            <a href="{{ route('admin.documents.view', $doc->id) }}" target="_blank"
                               class="flex-1 text-xs py-1.5 bg-indigo-100 text-indigo-700 font-bold rounded-lg hover:bg-indigo-200 transition text-center">
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
            <h3 class="text-lg font-extrabold">Approve Application</h3>
            <p class="text-sm text-emerald-100 mt-1">Login credentials will be auto-generated and emailed to the student.</p>
        </div>
        <form method="POST" action="{{ route('admin.registrations.approve', $registration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Roll Number <span class="text-gray-400 font-normal">(optional)</span></label>
                <input type="text" name="roll" value="{{ $registration->roll }}" placeholder="e.g. 2024-CS-001"
                       class="w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none">
            </div>
            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-3 text-xs text-emerald-800 space-y-1.5">
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> A student account will be created</div>
                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-emerald-500"></i> A parent account will be linked</div>
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
        <form method="POST" action="{{ route('admin.registrations.reject', $registration->id) }}" class="p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-1.5">Reason for Rejection <span class="text-red-500">*</span></label>
                <textarea name="reason" rows="4" required placeholder="e.g. Documents incomplete, eligibility criteria not met..."
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

{{-- Close modals on ESC --}}
<script>
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            document.getElementById('approveModal')?.classList.add('hidden');
            document.getElementById('rejectModal')?.classList.add('hidden');
        }
    });
    // Close on backdrop click
    ['approveModal','rejectModal'].forEach(id => {
        document.getElementById(id)?.addEventListener('click', function(e) {
            if (e.target === this) this.classList.add('hidden');
        });
    });
</script>
@endsection
