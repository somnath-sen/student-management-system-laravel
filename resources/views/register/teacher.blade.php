<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Application | EdFlow</title>
    <meta name="description" content="Apply as a faculty member at EdFlow. Complete your professional application.">
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
        .field:focus { border-color:#7c3aed; box-shadow:0 0 0 3px rgba(124,58,237,.1); }
        .field.error { border-color:#f43f5e; }
        .label { display:block; font-size:13px; font-weight:600; color:#475569; margin-bottom:5px; }
        .required::after { content:" *"; color:#f43f5e; }
        @keyframes slideIn { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
        .step-panel.active { animation: slideIn .3s ease; }
        /* Document upload card */
        .doc-card { border:2px dashed #cbd5e1; border-radius:14px; overflow:hidden; transition:all .2s; background:#f8fafc; cursor:pointer; display:block; }
        .doc-card:hover { border-color:#7c3aed; background:#f5f3ff; }
        .doc-card input[type=file] { display:none; }
        .doc-card-header { display:flex; align-items:center; gap:10px; padding:10px 14px; background:#fff; border-bottom:1.5px solid #e2e8f0; }
        .doc-card-icon { width:32px; height:32px; border-radius:8px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:#f3f0ff; color:#7c3aed; font-size:14px; }
        .doc-card-title { font-size:13px; font-weight:700; color:#1e293b; line-height:1.3; }
        .doc-card-title .req-star { color:#f43f5e; margin-left:2px; }
        .doc-card-body { padding:14px; text-align:center; }
        .doc-card-hint { font-size:11px; color:#94a3b8; margin-top:2px; }
        .doc-card-chosen { font-size:11px; font-weight:700; color:#7c3aed; margin-top:6px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap; }
        .repeatable-row { background:#f8fafc; border:1.5px solid #e2e8f0; border-radius:14px; padding:18px; position:relative; margin-bottom:12px; }
        .repeatable-row .remove-btn { position:absolute; top:12px; right:12px; }
    </style>
</head>
<body class="min-h-screen">

<nav class="bg-white border-b border-slate-200 px-6 py-3 flex items-center gap-4 sticky top-0 z-30 shadow-sm">
    <a href="/" class="flex items-center gap-2 font-black text-slate-900 text-lg">
        <span class="w-8 h-8 rounded-lg bg-violet-600 text-white flex items-center justify-center text-sm font-black">E</span>
        EdFlow
    </a>
    <span class="text-slate-300">|</span>
    <span class="text-slate-500 text-sm font-medium">Faculty / Instructor Application</span>
</nav>

<div class="max-w-3xl mx-auto px-4 py-8">

    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 rounded-2xl p-5 mb-6">
        <p class="font-bold text-sm mb-2"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Please fix the following errors:</p>
        <ul class="list-disc list-inside text-sm space-y-1">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    {{-- Progress Steps --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
        <div class="flex items-center justify-between relative">
            <div class="absolute top-5 left-0 right-0 h-0.5 bg-slate-200 z-0"></div>
            <div id="progress-line" class="absolute top-5 left-0 h-0.5 bg-violet-500 z-0 transition-all duration-500" style="width:0%"></div>
            @php $steps = ['Personal','Contact','Professional','Education','Experience','Documents','Review']; @endphp
            @foreach($steps as $i => $label)
            <div class="flex flex-col items-center z-10" id="step-indicator-{{ $i+1 }}">
                <div class="w-10 h-10 rounded-full border-2 border-slate-200 bg-white flex items-center justify-center text-sm font-bold text-slate-400 transition-all" id="step-circle-{{ $i+1 }}">
                    <span class="step-number">{{ $i+1 }}</span>
                    <i class="fa-solid fa-check hidden step-check"></i>
                </div>
                <span class="text-xs font-semibold text-slate-400 mt-1 hidden sm:block">{{ $label }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <form method="POST" action="{{ route('register.faculty.store') }}"
          enctype="multipart/form-data" id="facultyForm" novalidate>
        @csrf

        {{-- STEP 1 — Personal --}}
        <div class="step-panel active" id="panel-1">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Personal Information</h2>
                <p class="text-slate-500 text-sm mb-6">Your basic personal details.</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div><label class="label required">First Name</label><input type="text" name="first_name" class="field" value="{{ old('first_name') }}" placeholder="First" required></div>
                    <div><label class="label">Middle Name</label><input type="text" name="middle_name" class="field" value="{{ old('middle_name') }}" placeholder="Optional"></div>
                    <div><label class="label required">Last Name</label><input type="text" name="last_name" class="field" value="{{ old('last_name') }}" placeholder="Last" required></div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div><label class="label">Date of Birth</label><input type="date" name="date_of_birth" class="field" value="{{ old('date_of_birth') }}" max="{{ date('Y-m-d') }}"></div>
                    <div>
                        <label class="label">Gender</label>
                        <select name="gender" class="field">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender')=='male'?'selected':'' }}>Male</option>
                            <option value="female" {{ old('gender')=='female'?'selected':'' }}>Female</option>
                            <option value="other" {{ old('gender')=='other'?'selected':'' }}>Other</option>
                            <option value="prefer_not" {{ old('gender')=='prefer_not'?'selected':'' }}>Prefer not to say</option>
                        </select>
                    </div>
                    <div><label class="label">Nationality</label><input type="text" name="nationality" class="field" value="{{ old('nationality','Indian') }}"></div>
                    <div>
                        <label class="label">Blood Group</label>
                        <select name="blood_group" class="field">
                            <option value="">Select</option>
                            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bg)<option value="{{ $bg }}" {{ old('blood_group')==$bg?'selected':'' }}>{{ $bg }}</option>@endforeach
                        </select>
                    </div>
                    <div>
                        <label class="label">Marital Status</label>
                        <select name="marital_status" class="field">
                            <option value="">Select</option>
                            @foreach(['Single','Married','Divorced','Widowed','Other'] as $ms)<option value="{{ $ms }}" {{ old('marital_status')==$ms?'selected':'' }}>{{ $ms }}</option>@endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 2 — Contact --}}
        <div class="step-panel" id="panel-2">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Contact Details</h2>
                <p class="text-slate-500 text-sm mb-6">Your contact and address information.</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div><label class="label required">Email Address</label><input type="email" name="email" class="field" value="{{ old('email') }}" placeholder="your@email.com" required></div>
                    <div><label class="label required">Mobile Number</label><input type="tel" name="phone" class="field" value="{{ old('phone') }}" placeholder="+91 9876543210" required></div>
                    <div><label class="label">Alternate Phone</label><input type="tel" name="alternate_phone" class="field" value="{{ old('alternate_phone') }}" placeholder="Optional"></div>
                    <div><label class="label">WhatsApp Number</label><input type="tel" name="whatsapp_number" class="field" value="{{ old('whatsapp_number') }}" placeholder="If different"></div>
                </div>
                <div class="mt-4">
                    <label class="label">Address</label>
                    <textarea name="address" class="field" rows="2" placeholder="Full residential address">{{ old('address') }}</textarea>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                    <div class="col-span-2 sm:col-span-1"><label class="label">City</label><input type="text" name="city" class="field" value="{{ old('city') }}"></div>
                    <div class="col-span-2 sm:col-span-1"><label class="label">State</label><input type="text" name="state" class="field" value="{{ old('state') }}"></div>
                    <div><label class="label">PIN Code</label><input type="text" name="postal_code" class="field" value="{{ old('postal_code') }}"></div>
                    <div><label class="label">Country</label><input type="text" name="country" class="field" value="{{ old('country','India') }}"></div>
                </div>
            </div>
        </div>

        {{-- STEP 3 — Professional --}}
        <div class="step-panel" id="panel-3">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Professional Details</h2>
                <p class="text-slate-500 text-sm mb-6">Your area of expertise and teaching preferences.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="label required">Subjects You Can Teach</label>
                        <div class="border border-slate-200 rounded-xl p-3 max-h-44 overflow-y-auto bg-white">
                            @foreach($subjects as $subject)
                            <label class="flex items-center gap-2 py-1.5 cursor-pointer hover:text-violet-700 text-sm">
                                <input type="checkbox" name="subjects[]" value="{{ $subject->id }}"
                                       class="accent-violet-600 w-4 h-4"
                                       {{ in_array($subject->id, old('subjects',[]))?'checked':'' }}>
                                {{ $subject->name }}
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-slate-400 mt-1">Select all that apply</p>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="label">Department / Faculty</label>
                            <input type="text" name="department" class="field" value="{{ old('department') }}" placeholder="e.g. Computer Science">
                        </div>
                        <div>
                            <label class="label">Preferred Designation</label>
                            <input type="text" name="designation" class="field" value="{{ old('designation') }}" placeholder="e.g. Assistant Professor">
                        </div>
                        <div>
                            <label class="label">Years of Experience</label>
                            <input type="text" name="years_experience" class="field" value="{{ old('years_experience') }}" placeholder="e.g. 5">
                        </div>
                    </div>
                    <div>
                        <label class="label">Current Institution</label>
                        <input type="text" name="current_institution" class="field" value="{{ old('current_institution') }}" placeholder="Where you currently work (if any)">
                    </div>
                    <div>
                        <label class="label">Preferred Teaching Mode</label>
                        <select name="teaching_mode" class="field">
                            <option value="">Select</option>
                            <option value="classroom" {{ old('teaching_mode')=='classroom'?'selected':'' }}>Classroom / In-person</option>
                            <option value="online"    {{ old('teaching_mode')=='online'?'selected':'' }}>Online</option>
                            <option value="hybrid"    {{ old('teaching_mode')=='hybrid'?'selected':'' }}>Hybrid</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="label">Professional Summary</label>
                        <textarea name="professional_summary" class="field" rows="3" placeholder="Brief professional bio or statement of teaching philosophy (max 2000 chars)" maxlength="2000">{{ old('professional_summary') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 4 — Education (repeatable) --}}
        <div class="step-panel" id="panel-4">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Educational Qualifications</h2>
                <p class="text-slate-500 text-sm mb-6">Add all your academic qualifications (highest first).</p>

                <div id="quals-container"></div>

                <button type="button" onclick="addQual()"
                        class="mt-2 flex items-center gap-2 px-4 py-2.5 border-2 border-dashed border-violet-300 text-violet-700 font-bold rounded-xl hover:border-violet-500 hover:bg-violet-50 transition text-sm">
                    <i class="fa-solid fa-plus"></i> Add Qualification
                </button>
            </div>
        </div>

        {{-- STEP 5 — Experience (repeatable) --}}
        <div class="step-panel" id="panel-5">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Work Experience</h2>
                <p class="text-slate-500 text-sm mb-6">List your professional teaching / academic experience.</p>

                <div id="exps-container"></div>

                <button type="button" onclick="addExp()"
                        class="mt-2 flex items-center gap-2 px-4 py-2.5 border-2 border-dashed border-violet-300 text-violet-700 font-bold rounded-xl hover:border-violet-500 hover:bg-violet-50 transition text-sm">
                    <i class="fa-solid fa-plus"></i> Add Experience
                </button>
            </div>
        </div>

        {{-- STEP 6 — Identity & Documents --}}
        <div class="step-panel" id="panel-6">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Identity &amp; Documents</h2>
                <p class="text-slate-500 text-sm mb-2">Upload supporting documents. Max 5MB per file. JPG, PNG, PDF accepted.</p>

                <div class="bg-amber-50 border border-amber-200 text-amber-700 text-xs rounded-xl px-4 py-2.5 mb-6 flex items-start gap-2">
                    <i class="fa-solid fa-shield-halved mt-0.5 flex-shrink-0"></i>
                    <span>Your Aadhaar number is encrypted before storage. It is never shown in plain text in any admin view.</span>
                </div>

                <div class="mb-6">
                    <label class="label">Aadhaar Number</label>
                    <input type="text" name="aadhaar" class="field font-mono" value="{{ old('aadhaar') }}"
                           placeholder="XXXX XXXX XXXX" maxlength="14"
                           oninput="this.value=this.value.replace(/[^0-9\s]/g,'')">
                    <p class="text-xs text-slate-400 mt-1">Encrypted at rest — never stored in plain text.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @php
                        $fDocs = [
                            ['doc_photo',           'Profile Photo',                       'fa-camera',           true],
                            ['doc_aadhaar',          'Aadhaar / Government ID',             'fa-id-card',          false],
                            ['doc_resume',           'Resume / CV',                         'fa-file-lines',       false],
                            ['doc_highest_cert',     'Highest Qualification Certificate',   'fa-graduation-cap',   false],
                            ['doc_degree_cert',      'Degree Certificate',                  'fa-scroll',           false],
                            ['doc_marksheet',        'Marksheet',                           'fa-file-circle-check',false],
                            ['doc_teaching_cert',    'Teaching / Training Certificate',     'fa-chalkboard-user',  false],
                            ['doc_experience_cert',  'Experience Certificate',              'fa-briefcase',        false],
                            ['doc_prev_employment',  'Previous Employment Proof',           'fa-building',         false],
                            ['doc_other',            'Other Document',                      'fa-paperclip',        false],
                        ];
                    @endphp
                    @foreach($fDocs as [$field, $label, $icon, $required])
                    <label class="doc-card" for="{{ $field }}">
                        <input type="file" name="{{ $field }}" id="{{ $field }}"
                               accept="image/jpg,image/jpeg,image/png,application/pdf"
                               onchange="showDocName(this)">
                        <div class="doc-card-header">
                            <div class="doc-card-icon">
                                <i class="fa-solid {{ $icon }}"></i>
                            </div>
                            <div class="doc-card-title">
                                {{ $label }}
                                @if($required)<span class="req-star">*</span>@endif
                            </div>
                        </div>
                        <div class="doc-card-body">
                            <div style="color:#94a3b8; font-size:22px; margin-bottom:4px;">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <p style="font-size:12px; color:#64748b; font-weight:600;">Click to choose file</p>
                            <p class="doc-card-hint">PDF / Image &bull; Max 5 MB</p>
                            <p class="doc-card-chosen" id="name-{{ $field }}">No file chosen</p>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- STEP 7 — Review & Submit --}}
        <div class="step-panel" id="panel-7">
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-4">
                <h2 class="text-xl font-extrabold text-slate-900 mb-1">Review &amp; Submit</h2>
                <p class="text-slate-500 text-sm mb-6">Please review your application before final submission.</p>

                <div class="space-y-4">
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-violet-600 uppercase tracking-wider mb-2">Step 1 — Personal</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-slate-400 text-xs">Name</span><p class="font-semibold text-slate-800" id="rv-name">—</p></div>
                            <div><span class="text-slate-400 text-xs">Gender</span><p class="font-semibold text-slate-800" id="rv-gender">—</p></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-violet-600 uppercase tracking-wider mb-2">Step 2 — Contact</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-slate-400 text-xs">Email</span><p class="font-semibold text-slate-800" id="rv-email">—</p></div>
                            <div><span class="text-slate-400 text-xs">Phone</span><p class="font-semibold text-slate-800" id="rv-phone">—</p></div>
                        </div>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                        <p class="text-xs font-bold text-violet-600 uppercase tracking-wider mb-2">Step 3 — Professional</p>
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <div><span class="text-slate-400 text-xs">Department</span><p class="font-semibold text-slate-800" id="rv-dept">—</p></div>
                            <div><span class="text-slate-400 text-xs">Years of Exp.</span><p class="font-semibold text-slate-800" id="rv-exp">—</p></div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 p-4 bg-violet-50 border border-violet-100 rounded-xl">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" id="declaration" class="mt-1 w-4 h-4 accent-violet-600" required>
                        <span class="text-sm text-slate-700">
                            I declare that all information provided in this application is <strong>true, complete, and accurate</strong> to the best of my knowledge.
                            I understand that misrepresentation will lead to immediate disqualification.
                        </span>
                    </label>
                </div>

                <div class="mt-4 flex justify-center">
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY','6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MfLiIiD') }}"></div>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <div class="flex items-center justify-between gap-4">
            <button type="button" id="prevBtn" onclick="changeStep(-1)"
                    class="hidden px-6 py-3 bg-white border border-slate-300 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition flex items-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Back
            </button>
            <div class="ml-auto flex gap-3">
                <button type="button" id="nextBtn" onclick="changeStep(1)"
                        class="px-7 py-3 bg-violet-600 hover:bg-violet-700 text-white font-bold rounded-xl transition shadow-lg flex items-center gap-2">
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
    const TOTAL_STEPS = 7;
    let currentStep = 1;
    let qualIdx = 0;
    let expIdx  = 0;

    // ── Qualification rows ────────────────────────────────────────────────────
    function addQual(data) {
        const idx = qualIdx++;
        const d = data || {};
        const html = `
        <div class="repeatable-row" id="qual-${idx}">
            <button type="button" class="remove-btn w-7 h-7 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center text-xs" onclick="document.getElementById('qual-${idx}').remove()">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div><label class="label required">Degree / Qualification</label>
                    <input type="text" name="qualifications[${idx}][degree]" class="field" value="${d.degree||''}" placeholder="e.g. M.Sc. Mathematics" required></div>
                <div><label class="label required">Institution Name</label>
                    <input type="text" name="qualifications[${idx}][institution]" class="field" value="${d.institution||''}" placeholder="College / University" required></div>
                <div><label class="label">University / Board</label>
                    <input type="text" name="qualifications[${idx}][university]" class="field" value="${d.university||''}" placeholder="Affiliating university"></div>
                <div><label class="label">Specialization</label>
                    <input type="text" name="qualifications[${idx}][specialization]" class="field" value="${d.specialization||''}" placeholder="e.g. Organic Chemistry"></div>
                <div><label class="label">Year of Passing</label>
                    <input type="text" name="qualifications[${idx}][passing_year]" class="field" value="${d.passing_year||''}" placeholder="e.g. 2018" maxlength="4"></div>
                <div><label class="label">% / CGPA</label>
                    <input type="text" name="qualifications[${idx}][percentage_cgpa]" class="field" value="${d.percentage_cgpa||''}" placeholder="e.g. 82% or 8.5"></div>
            </div>
        </div>`;
        document.getElementById('quals-container').insertAdjacentHTML('beforeend', html);
    }

    // ── Experience rows ───────────────────────────────────────────────────────
    function addExp(data) {
        const idx = expIdx++;
        const d = data || {};
        const html = `
        <div class="repeatable-row" id="exp-${idx}">
            <button type="button" class="remove-btn w-7 h-7 rounded-full bg-red-100 text-red-500 hover:bg-red-200 flex items-center justify-center text-xs" onclick="document.getElementById('exp-${idx}').remove()">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div class="sm:col-span-2"><label class="label required">Institution / Organisation</label>
                    <input type="text" name="experiences[${idx}][institution]" class="field" value="${d.institution||''}" placeholder="College / School / Company name" required></div>
                <div><label class="label">Designation</label>
                    <input type="text" name="experiences[${idx}][designation]" class="field" value="${d.designation||''}" placeholder="e.g. Lecturer"></div>
                <div><label class="label">Department</label>
                    <input type="text" name="experiences[${idx}][department]" class="field" value="${d.department||''}" placeholder="e.g. Physics Dept."></div>
                <div><label class="label">From Date</label>
                    <input type="date" name="experiences[${idx}][start_date]" class="field" value="${d.start_date||''}"></div>
                <div id="end-date-wrap-${idx}">
                    <label class="label">To Date</label>
                    <input type="date" name="experiences[${idx}][end_date]" class="field" value="${d.end_date||''}" id="end-date-${idx}">
                </div>
                <div class="sm:col-span-2">
                    <label class="flex items-center gap-2 cursor-pointer text-sm font-semibold text-slate-600">
                        <input type="checkbox" name="experiences[${idx}][is_current]" value="1" onchange="toggleEndDate(${idx}, this)"
                               class="accent-violet-600 w-4 h-4" ${d.is_current?'checked':''}>
                        Currently working here
                    </label>
                </div>
                <div class="sm:col-span-2">
                    <label class="label">Key Responsibilities</label>
                    <textarea name="experiences[${idx}][responsibilities]" class="field" rows="2" placeholder="Brief description of your role">${d.responsibilities||''}</textarea>
                </div>
            </div>
        </div>`;
        document.getElementById('exps-container').insertAdjacentHTML('beforeend', html);
    }

    function toggleEndDate(idx, cb) {
        const wrap = document.getElementById('end-date-wrap-' + idx);
        const input = document.getElementById('end-date-' + idx);
        if (cb.checked) {
            wrap.style.opacity = '0.4';
            wrap.style.pointerEvents = 'none';
            if (input) input.value = '';
        } else {
            wrap.style.opacity = '1';
            wrap.style.pointerEvents = '';
        }
    }

    // ── Wizard navigation ─────────────────────────────────────────────────────
    function changeStep(direction) {
        if (direction === 1 && !validateStep(currentStep)) return;

        const oldPanel = document.getElementById('panel-' + currentStep);
        oldPanel.classList.remove('active');
        markStepDone(currentStep);

        currentStep += direction;
        currentStep = Math.max(1, Math.min(TOTAL_STEPS, currentStep));

        const newPanel = document.getElementById('panel-' + currentStep);
        newPanel.classList.add('active');
        activateStep(currentStep);

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
            const isCheckbox = el.type === 'checkbox';
            const isEmpty = isCheckbox ? !el.checked : !el.value.trim();
            // Subject checkboxes — need at least one
            if (el.name === 'subjects[]') return; // handled separately
            if (isEmpty) { el.classList.add('error'); valid = false; }
        });
        // Validate subjects on step 3
        if (step === 3) {
            const checked = panel.querySelectorAll('input[name="subjects[]"]:checked');
            if (checked.length === 0) {
                alert('Please select at least one subject.'); return false;
            }
        }
        if (!valid) { alert('Please fill all required fields before continuing.'); }
        return valid;
    }

    function markStepDone(step) {
        const circle = document.getElementById('step-circle-' + step);
        circle.classList.remove('border-slate-200','text-slate-400');
        circle.classList.add('border-emerald-500','bg-emerald-500','text-white');
        circle.querySelector('.step-number').classList.add('hidden');
        circle.querySelector('.step-check').classList.remove('hidden');
    }

    function activateStep(step) {
        const circle = document.getElementById('step-circle-' + step);
        if (!circle.classList.contains('bg-emerald-500')) {
            circle.classList.remove('border-slate-200','text-slate-400');
            circle.classList.add('border-violet-500','text-violet-600','font-black');
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
        document.getElementById('rv-gender').textContent = sel('gender');
        document.getElementById('rv-email').textContent = g('email');
        document.getElementById('rv-phone').textContent = g('phone');
        document.getElementById('rv-dept').textContent = g('department') || '—';
        document.getElementById('rv-exp').textContent = g('years_experience') || '—';
    }

    function showFileName(input) {
        const el = document.getElementById('name-' + input.name);
        if (el) el.textContent = input.files[0]?.name ?? 'No file chosen';
    }
    // Alias for doc-card onchange
    function showDocName(input) { showFileName(input); }

    // Init with one blank qual and one blank exp
    addQual(); addExp();
    activateStep(1);
    document.getElementById('prevBtn').classList.add('hidden');
    updateProgressBar();
</script>
</body>
</html>