<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Application | EdFlow</title>
    <meta name="description" content="Apply for student enrollment at EdFlow. Complete your institutional admission application.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['"Outfit"', 'sans-serif'] } } }
        }
    </script>
    <style>
        body { font-family: 'Outfit', sans-serif; background: #f1f5f9; }
        .step-panel { display: none; }
        .step-panel.active { display: block; }
        .field { width:100%; padding:11px 14px; border-radius:10px; border:1.5px solid #e2e8f0; background:#fff; font-size:14px; color:#1e293b; outline:none; transition:all .2s; box-sizing:border-box; }
        .field:focus { border-color:#6366f1; box-shadow:0 0 0 3px rgba(99,102,241,.1); }
        .field.error { border-color:#f43f5e; }
        .label { display:block; font-size:13px; font-weight:600; color:#475569; margin-bottom:5px; }
        .required::after { content:" *"; color:#f43f5e; }
        .step-indicator { transition: all .3s; }
        @keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
        .step-panel.active { animation: slideIn .3s ease; }
        /* Document upload card */
        .doc-card { border:2px dashed #cbd5e1; border-radius:14px; overflow:hidden; transition:all .2s; background:#f8fafc; cursor:pointer; }
        .doc-card:hover { border-color:#6366f1; background:#eef2ff; }
        .doc-card input[type=file] { display:none; }
        .doc-card-header { display:flex; align-items:center; gap:10px; padding:10px 14px; background:#fff; border-bottom:1.5px solid #e2e8f0; }
        .doc-card-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#eef2ff; color:#6366f1; font-size:14px; }
        .doc-card-title { font-size:13px; font-weight:700; color:#1e293b; line-height:1.3; }
        .doc-card-title .req-star { color:#f43f5e; margin-left:2px; }
        .doc-card-body { padding:14px; text-align:center; }
        .doc-card-hint { font-size:11px; color:#94a3b8; margin-top:2px; }
        .doc-card-chosen { font-size:11px; font-weight:700; color:#6366f1; margin-top:6px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
    </style>
</head>
<body class="min-h-screen">

{{-- Top nav bar --}}
<nav class="bg-white border-b border-slate-200 px-6 py-3 flex items-center gap-4 sticky top-0 z-30 shadow-sm">
    <a href="/" class="flex items-center gap-2 font-black text-slate-900 text-lg">
        <span class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center text-sm font-black">E</span>
        EdFlow
    </a>
    <span class="text-slate-300">|</span>
    <span class="text-slate-500 text-sm font-medium">Student Admission Application</span>
</nav>

<div class="max-w-3xl mx-auto px-4 py-8">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5 mb-6">
        <p class="font-bold text-sm mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Please fix the following errors:</p>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Progress Steps --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
        <div class="flex items-center justify-between relative">
            <div class="absolute top-5 left-0 right-0 h-0.5 bg-slate-200 z-0"></div>
            <div id="progress-line" class="absolute top-5 left-0 h-0.5 bg-indigo-500 z-0 transition-all duration-500" style="width:0%"></div>
            @php
                $steps = ['Personal', 'Contact', 'Guardian', 'Academic', 'Documents', 'Review'];
            @endphp
            @foreach($steps as $i => $label)
            <div class="step-indicator flex flex-col items-center z-10" id="step-indicator-{{ $i+1 }}">
                <div class="w-10 h-10 rounded-full border-2 border-slate-200 bg-white flex items-center justify-center text-sm font-bold text-slate-400 transition-all"
                     id="step-circle-{{ $i+1 }}">
                    <span class="step-number">{{ $i+1 }}</span>
                    <i class="fa-solid fa-check hidden step-check"></i>
                </div>
                <span class="text-xs font-semibold text-slate-400 mt-1 hidden sm:block" id="step-label-{{ $i+1 }}">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>

    {{-- THE FORM --}}
    <form method="POST" action="{{ route('register.student.store') }}"
          enctype="multipart/form-data" id="admissionForm" novalidate>
        @csrf

        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- STEP 1 — Personal Information --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        <div class="step-panel active" id="panel-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Personal Information</h2>
                <p class="text-slate-500 text-sm mb-6">Start with your basic personal details.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="label required">First Name</label>
                        <input type="text" name="first_name" class="field" value="{{ old('first_name') }}" placeholder="First" required>
                    </div>
                    <div>
                        <label class="label">Middle Name</label>
                        <input type="text" name="middle_name" class="field" value="{{ old('middle_name') }}" placeholder="Middle (optional)">
                    </div>
                    <div>
                        <label class="label required">Last Name</label>
                        <input type="text" name="last_name" class="field" value="{{ old('last_name') }}" placeholder="Last" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div>
                        <label class="label required">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="field" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}" required>
                    </div>
                    <div>
                        <label class="label required">Gender</label>
                        <select name="gender" class="field" required>
                            <option value="">Select gender</option>
                            <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                            <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                            <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
                            <option value="prefer_not" {{ old('gender')=='prefer_not'?'selected':'' }}>Prefer not to say</option>
                        </select>
                    </div>
                    <div>
                        <label class="label required">Nationality</label>
                        <input type="text" name="nationality" class="field" value="{{ old('nationality','Indian') }}" required>
                    </div>
                    <div>
                        <label class="label">Blood Group</label>
                        <select name="blood_group" class="field">
                            <option value="">Select</option>
                            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)
                                <option value="{{ $bg }}" {{ old('blood_group')==$bg?'selected':'' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Category</label>
                        <select name="category" class="field">
                            <option value="">Select</option>
                            @foreach(['General','OBC','SC','ST','EWS','Other'] as $cat)
                                <option value="{{ $cat }}" {{ old('category')==$cat?'selected':'' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Religion</label>
                        <input type="text" name="religion" class="field" value="{{ old('religion') }}" placeholder="e.g. Hindu, Islam, Christian...">
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- STEP 2 — Contact Details --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Contact Details</h2>
                <p class="text-slate-500 text-sm mb-6">Your primary contact and address information.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="label required">Email Address</label>
                        <input type="email" name="email" class="field" value="{{ old('email') }}" placeholder="your@email.com" required>
                    </div>
                    <div>
                        <label class="label required">Mobile Number</label>
                        <input type="tel" name="phone" class="field" value="{{ old('phone') }}" placeholder="+91 9876543210" required>
                    </div>
                    <div>
                        <label class="label">Alternate Phone</label>
                        <input type="tel" name="alternate_phone" class="field" value="{{ old('alternate_phone') }}" placeholder="Optional">
                    </div>
                    <div>
                        <label class="label">WhatsApp Number</label>
                        <input type="tel" name="whatsapp_number" class="field" value="{{ old('whatsapp_number') }}" placeholder="If different from mobile">
                    </div>
                </div>

                <div class="mt-4">
                    <label class="label required">Permanent Address</label>
                    <textarea name="permanent_address" class="field" rows="2" placeholder="House/Flat No., Street, Locality" required>{{ old('permanent_address') }}</textarea>
                </div>
                <div class="mt-4">
                    <label class="label required">Current Address</label>
                    <textarea name="current_address" class="field" rows="2" placeholder="If same as permanent, enter same">{{ old('current_address') }}</textarea>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="label required">City</label>
                        <input type="text" name="city" class="field" value="{{ old('city') }}" required>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="label required">State</label>
                        <input type="text" name="state" class="field" value="{{ old('state') }}" required>
                    </div>
                    <div>
                        <label class="label required">PIN Code</label>
                        <input type="text" name="postal_code" class="field" value="{{ old('postal_code') }}" required>
                    </div>
                    <div>
                        <label class="label required">Country</label>
                        <input type="text" name="country" class="field" value="{{ old('country','India') }}" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- STEP 3 — Guardian Details --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-3">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Guardian / Parent Details</h2>
                <p class="text-slate-500 text-sm mb-6">Provide details of your parent or legal guardian.</p>

                {{-- Primary Guardian --}}
                <div class="mb-6">
                    <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black">1</span>
                        Primary Guardian <span class="text-red-400 font-normal normal-case tracking-normal text-xs ml-1">(required)</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="label required">Full Name</label>
                            <input type="text" name="guardian_primary_name" class="field" value="{{ old('guardian_primary_name') }}" required>
                        </div>
                        <div>
                            <label class="label required">Relationship</label>
                            <select name="guardian_primary_relationship" class="field" required>
                                <option value="">Select</option>
                                @foreach(['Father','Mother','Grandfather','Grandmother','Brother','Sister','Uncle','Aunt','Spouse','Legal Guardian'] as $rel)
                                    <option value="{{ $rel }}" {{ old('guardian_primary_relationship')==$rel?'selected':'' }}>{{ $rel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label required">Phone</label>
                            <input type="tel" name="guardian_primary_phone" class="field" value="{{ old('guardian_primary_phone') }}" required>
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input type="email" name="guardian_primary_email" class="field" value="{{ old('guardian_primary_email') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="label">Occupation</label>
                            <input type="text" name="guardian_primary_occupation" class="field" value="{{ old('guardian_primary_occupation') }}" placeholder="e.g. Government Employee">
                        </div>
                        <div>
                            <label class="label">Annual Income</label>
                            <input type="text" name="guardian_primary_income" class="field" value="{{ old('guardian_primary_income') }}" placeholder="e.g. ₹5,00,000">
                        </div>
                    </div>
                </div>

                {{-- Secondary Guardian --}}
                <div class="mb-6 border-t border-slate-100 pt-6">
                    <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center text-xs font-black">2</span>
                        Secondary Guardian <span class="text-slate-400 font-normal normal-case tracking-normal text-xs ml-1">(optional)</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="label">Full Name</label>
                            <input type="text" name="guardian_secondary_name" class="field" value="{{ old('guardian_secondary_name') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="label">Relationship</label>
                            <select name="guardian_secondary_relationship" class="field">
                                <option value="">Select</option>
                                @foreach(['Father','Mother','Grandfather','Grandmother','Brother','Sister','Uncle','Aunt','Spouse','Legal Guardian'] as $rel)
                                    <option value="{{ $rel }}" {{ old('guardian_secondary_relationship')==$rel?'selected':'' }}>{{ $rel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="label">Phone</label>
                            <input type="tel" name="guardian_secondary_phone" class="field" value="{{ old('guardian_secondary_phone') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="label">Email</label>
                            <input type="email" name="guardian_secondary_email" class="field" value="{{ old('guardian_secondary_email') }}" placeholder="Optional">
                        </div>
                    </div>
                </div>

                {{-- Emergency Contact --}}
                <div class="border-t border-slate-100 pt-6">
                    <h3 class="text-sm font-bold text-rose-500 uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-5 h-5 rounded-full bg-rose-100 text-rose-500 flex items-center justify-center text-xs font-black"><i class="fa-solid fa-phone-volume text-[9px]"></i></span>
                        Emergency Contact <span class="text-slate-400 font-normal normal-case tracking-normal text-xs ml-1">(optional)</span>
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="label">Full Name</label>
                            <input type="text" name="guardian_emergency_name" class="field" value="{{ old('guardian_emergency_name') }}" placeholder="Optional">
                        </div>
                        <div>
                            <label class="label">Relationship</label>
                            <input type="text" name="guardian_emergency_relationship" class="field" value="{{ old('guardian_emergency_relationship') }}" placeholder="e.g. Uncle">
                        </div>
                        <div>
                            <label class="label">Phone</label>
                            <input type="tel" name="guardian_emergency_phone" class="field" value="{{ old('guardian_emergency_phone') }}" placeholder="Emergency number">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- STEP 4 — Academic Details --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Academic Details</h2>
                <p class="text-slate-500 text-sm mb-6">Your educational background and desired course.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="label required">Desired Course</label>
                        <select name="course_id" class="field" required>
                            <option value="">— Select a course —</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id')==$course->id?'selected':'' }}>
                                    {{ $course->name }}{{ $course->course_code ? ' ('.$course->course_code.')' : '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label required">Last Institution Attended</label>
                        <input type="text" name="last_institution" class="field" value="{{ old('last_institution') }}" placeholder="School / College / University name" required>
                    </div>
                    <div>
                        <label class="label">Board / University</label>
                        <input type="text" name="board_university" class="field" value="{{ old('board_university') }}" placeholder="e.g. CBSE, Mumbai University">
                    </div>
                    <div>
                        <label class="label required">Last Qualification</label>
                        <select name="last_qualification" class="field" required>
                            <option value="">Select</option>
                            @foreach(['Class 10 (SSC)','Class 12 (HSC)','Diploma','Bachelor\'s Degree','Master\'s Degree','PhD','Other'] as $q)
                                <option value="{{ $q }}" {{ old('last_qualification')==$q?'selected':'' }}>{{ $q }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Stream / Branch</label>
                        <input type="text" name="stream" class="field" value="{{ old('stream') }}" placeholder="e.g. Science, Commerce, Arts">
                    </div>
                    <div>
                        <label class="label required">Year of Passing</label>
                        <input type="text" name="passing_year" class="field" value="{{ old('passing_year') }}" placeholder="e.g. 2024" maxlength="4" required>
                    </div>
                    <div>
                        <label class="label required">Percentage / CGPA</label>
                        <input type="text" name="percentage_cgpa" class="field" value="{{ old('percentage_cgpa') }}" placeholder="e.g. 78.5% or 8.2 CGPA" required>
                    </div>
                    <div>
                        <label class="label">Roll / Registration No.</label>
                        <input type="text" name="roll_registration_no" class="field" value="{{ old('roll_registration_no') }}" placeholder="From your marksheet">
                    </div>
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- STEP 5 — Identity & Documents --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-5">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Identity &amp; Documents</h2>
                <p class="text-slate-500 text-sm mb-2">Upload supporting documents. Max 5MB per file. Accepted: JPG, PNG, PDF.</p>
                <div class="bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded-xl px-4 py-2.5 mb-6 flex items-start gap-2">
                    <i class="fa-solid fa-shield-halved mt-0.5 flex-shrink-0"></i>
                    <span>Your Aadhaar number is encrypted before storage and displayed only in masked form (XXXX XXXX XXXX) to all staff. Full number is never shown in the admin UI.</span>
                </div>

                <div class="mb-6">
                    <label class="label">Aadhaar Number</label>
                    <input type="text" name="aadhaar" class="field font-mono" value="{{ old('aadhaar') }}"
                           placeholder="XXXX XXXX XXXX" maxlength="14"
                           oninput="this.value=this.value.replace(/[^0-9\s]/g,'')">
                    <p class="text-xs text-slate-400 mt-1">Your Aadhaar is encrypted at rest and never shared.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                        $docFields = [
                            ['doc_photo',          'Applicant Photo',                  'fa-camera',                 true,  'JPG / PNG only'],
                            ['doc_aadhaar',         'Aadhaar / Govt. ID',              'fa-id-card',                false, 'PDF / Image'],
                            ['doc_marksheet_10',    'Class 10 Marksheet',               'fa-file-lines',             false, 'PDF / Image'],
                            ['doc_marksheet_12',    'Class 12 Marksheet',               'fa-file-lines',             false, 'PDF / Image'],
                            ['doc_prev_marksheet',  'Previous Qualification Marksheet', 'fa-scroll',                 false, 'PDF / Image'],
                            ['doc_birth_cert',      'Birth Certificate',                'fa-baby',                   false, 'PDF / Image'],
                            ['doc_transfer_cert',   'Transfer Certificate',             'fa-right-left',             false, 'PDF / Image'],
                            ['doc_migration_cert',  'Migration Certificate',            'fa-arrow-right-arrow-left', false, 'PDF / Image'],
                            ['doc_character_cert',  'Character Certificate',            'fa-award',                  false, 'PDF / Image'],
                            ['doc_other',           'Other Document',                   'fa-paperclip',              false, 'PDF / Image'],
                        ];
                    @endphp

                    @foreach($docFields as [$field, $label, $icon, $required, $hint])
                    <label class="doc-card" for="{{ $field }}">
                        <input type="file" name="{{ $field }}" id="{{ $field }}"
                               accept="image/jpg,image/jpeg,image/png,application/pdf"
                               onchange="showDocName(this)">
                        {{-- Card header: icon + title always visible --}}
                        <div class="doc-card-header">
                            <div class="doc-card-icon">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                            <div class="doc-card-title">
                                {{ $label }}
                                @if($required)<span class="req-star">*</span>@endif
                            </div>
                        </div>
                        {{-- Card body: upload prompt --}}
                        <div class="doc-card-body">
                            <div style="color:#94a3b8; font-size:22px; margin-bottom:4px;">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <p style="font-size:12px; color:#64748b; font-weight:600;">Click to choose file</p>
                            <p class="doc-card-hint">{{ $hint }} &bull; Max 5 MB</p>
                            <p class="doc-card-chosen" id="name-{{ $field }}">No file chosen</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- ════════════════════════════════════════════════════════════════ --}}
        {{-- STEP 6 — Review & Submit --}}
        {{-- ════════════════════════════════════════════════════════════════ --}}
        <div class="step-panel" id="panel-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Review &amp; Submit</h2>
                <p class="text-slate-500 text-sm mb-6">Please review your application before final submission.</p>

                {{-- Summary cards --}}
                <div class="space-y-4" id="reviewSummary">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Step 1 — Personal</p>
                        <div class="grid grid-cols-2 gap-2 text-sm" id="review-personal">
                            <div><span class="text-slate-400 text-xs">Name</span><p class="font-semibold text-slate-800" id="rv-name">—</p></div>
                            <div><span class="text-slate-400 text-xs">Date of Birth</span><p class="font-semibold text-slate-800" id="rv-dob">—</p></div>
                            <div><span class="text-slate-400 text-xs">Gender</span><p class="font-semibold text-slate-800 capitalize" id="rv-gender">—</p></div>
                            <div><span class="text-slate-400 text-xs">Nationality</span><p class="font-semibold text-slate-800" id="rv-nationality">—</p></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Step 2 — Contact</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-slate-400 text-xs">Email</span><p class="font-semibold text-slate-800" id="rv-email">—</p></div>
                            <div><span class="text-slate-400 text-xs">Phone</span><p class="font-semibold text-slate-800" id="rv-phone">—</p></div>
                            <div><span class="text-slate-400 text-xs">City</span><p class="font-semibold text-slate-800" id="rv-city">—</p></div>
                            <div><span class="text-slate-400 text-xs">State</span><p class="font-semibold text-slate-800" id="rv-state">—</p></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Step 3 — Guardian</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-slate-400 text-xs">Primary Guardian</span><p class="font-semibold text-slate-800" id="rv-guardian">—</p></div>
                            <div><span class="text-slate-400 text-xs">Relationship</span><p class="font-semibold text-slate-800" id="rv-guardian-rel">—</p></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-2">Step 4 — Academic</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-slate-400 text-xs">Course</span><p class="font-semibold text-slate-800" id="rv-course">—</p></div>
                            <div><span class="text-slate-400 text-xs">Last Qualification</span><p class="font-semibold text-slate-800" id="rv-qual">—</p></div>
                            <div><span class="text-slate-400 text-xs">Percentage/CGPA</span><p class="font-semibold text-slate-800" id="rv-cgpa">—</p></div>
                            <div><span class="text-slate-400 text-xs">Passing Year</span><p class="font-semibold text-slate-800" id="rv-year">—</p></div>
                        </div>
                    </div>
                </div>

                {{-- Declaration --}}
                <div class="mt-6 p-4 bg-indigo-50 border border-indigo-100 rounded-xl">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="declaration" class="mt-1 w-4 h-4 accent-indigo-600" required>
                        <span class="text-sm text-slate-700">
                            I hereby declare that all information provided in this application is <strong>true, complete, and accurate</strong> to the best of my knowledge.
                            I understand that submission of false information will result in immediate disqualification.
                        </span>
                    </label>
                </div>

                {{-- reCAPTCHA --}}
                <div class="mt-4 flex justify-center">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY','6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MfLiIiD') }}"></div>
                </div>
            </div>
        </div>

        {{-- ── Navigation Buttons ──────────────────────────────────────────── --}}
        <div class="flex items-center justify-between gap-4">
            <button type="button" id="prevBtn" onclick="changeStep(-1)"
                    class="hidden px-6 py-3 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <div class="ml-auto flex gap-3">
                <button type="button" id="nextBtn" onclick="changeStep(1)"
                        class="px-7 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition shadow-lg flex items-center gap-2">
                    Continue <i class="fa-solid fa-arrow-right"></i>
                </button>
                <button type="submit" id="submitBtn"
                        class="hidden px-7 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold rounded-xl transition shadow-lg flex items-center gap-2">
                    <i class="fa-solid fa-paper-plane"></i> Submit Application
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    const TOTAL_STEPS = 6;
    let currentStep = 1;

    function changeStep(direction) {
        if (direction === 1 && !validateStep(currentStep)) return;

        const oldPanel = document.getElementById('panel-' + currentStep);
        oldPanel.classList.remove('active');
        markStepDone(currentStep);

        currentStep += direction;
        currentStep = Math.max(1, Math.min(TOTAL_STEPS, currentStep));

        const newPanel = document.getElementById('panel-' + currentStep);
        newPanel.classList.add('active');
        activateStepIndicator(currentStep);

        if (currentStep === TOTAL_STEPS) populateReview();

        document.getElementById('prevBtn').classList.toggle('hidden', currentStep === 1);
        document.getElementById('nextBtn').classList.toggle('hidden', currentStep === TOTAL_STEPS);
        document.getElementById('submitBtn').classList.toggle('hidden', currentStep !== TOTAL_STEPS);

        updateProgressBar();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        const panel = document.getElementById('panel-' + step);
        const required = panel.querySelectorAll('[required]');
        let valid = true;
        required.forEach(el => {
            el.classList.remove('error');
            if (!el.value.trim()) {
                el.classList.add('error');
                el.scrollIntoView({ behavior:'smooth', block:'center' });
                valid = false;
            }
        });
        if (!valid) { alert('Please fill all required fields before proceeding.'); }
        return valid;
    }

    function markStepDone(step) {
        const circle = document.getElementById('step-circle-' + step);
        circle.classList.remove('border-slate-200','text-slate-400');
        circle.classList.add('border-emerald-500','bg-emerald-500','text-white');
        circle.querySelector('.step-number').classList.add('hidden');
        circle.querySelector('.step-check').classList.remove('hidden');
    }

    function activateStepIndicator(step) {
        const circle = document.getElementById('step-circle-' + step);
        // Only activate if not already done
        if (!circle.classList.contains('bg-emerald-500')) {
            circle.classList.remove('border-slate-200','text-slate-400');
            circle.classList.add('border-indigo-500','text-indigo-600','font-black');
        }
    }

    function updateProgressBar() {
        const pct = ((currentStep - 1) / (TOTAL_STEPS - 1)) * 100;
        document.getElementById('progress-line').style.width = pct + '%';
    }

    function populateReview() {
        const g = id => document.querySelector(`[name="${id}"]`)?.value ?? '—';
        const sel = id => {
            const el = document.querySelector(`[name="${id}"]`);
            return el?.options[el.selectedIndex]?.text ?? '—';
        };
        document.getElementById('rv-name').textContent = `${g('first_name')} ${g('middle_name')} ${g('last_name')}`.trim();
        document.getElementById('rv-dob').textContent = g('date_of_birth');
        document.getElementById('rv-gender').textContent = sel('gender');
        document.getElementById('rv-nationality').textContent = g('nationality');
        document.getElementById('rv-email').textContent = g('email');
        document.getElementById('rv-phone').textContent = g('phone');
        document.getElementById('rv-city').textContent = g('city');
        document.getElementById('rv-state').textContent = g('state');
        document.getElementById('rv-guardian').textContent = g('guardian_primary_name');
        document.getElementById('rv-guardian-rel').textContent = sel('guardian_primary_relationship');
        document.getElementById('rv-course').textContent = sel('course_id');
        document.getElementById('rv-qual').textContent = sel('last_qualification');
        document.getElementById('rv-cgpa').textContent = g('percentage_cgpa');
        document.getElementById('rv-year').textContent = g('passing_year');
    }

    function showFileName(input) {
        const el = document.getElementById('name-' + input.name);
        if (el) el.textContent = input.files[0]?.name ?? 'No file chosen';
    }
    // Alias used by new doc-card design
    function showDocName(input) { showFileName(input); }

    // Init
    activateStepIndicator(1);
    document.getElementById('prevBtn').classList.add('hidden');
    updateProgressBar();
</script>
</body>
</html>