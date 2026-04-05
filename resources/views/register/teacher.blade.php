<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Application | EdFlow</title>
    <meta name="description" content="Apply to join the EdFlow educator network. Submit your faculty registration application for admin review.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FDFBF7; }
        .bg-dots {
            background-image: radial-gradient(rgba(99, 102, 241, 0.12) 1px, transparent 1px);
            background-size: 24px 24px;
        }
        @keyframes blob {
            0%   { transform: translate(0px, 0px) scale(1); }
            33%  { transform: translate(30px, -50px) scale(1.1); }
            66%  { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 15s infinite alternate; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .animation-delay-6000 { animation-delay: 6s; }
        .form-field {
            width: 100%; padding: 12px 16px; border-radius: 12px;
            border: 1.5px solid #e2e8f0; background: rgba(255,255,255,0.7);
            font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px;
            color: #1e293b; outline: none; transition: all 0.2s ease;
            box-sizing: border-box;
        }
        .form-field:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 4px rgba(99,102,241,0.08); }
        .form-field.is-error { border-color: #f43f5e; }
        .subject-checkbox { display: none; }
        .subject-label {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 6px 14px; border-radius: 999px; border: 1.5px solid #e2e8f0;
            background: white; font-size: 13px; font-weight: 600; color: #64748b;
            cursor: pointer; transition: all 0.2s ease; user-select: none;
        }
        .subject-label:hover { border-color: #a5b4fc; color: #4f46e5; background: #eef2ff; }
        .subject-checkbox:checked + .subject-label {
            border-color: #6366f1;
            background: linear-gradient(135deg, #6366f1, #7c3aed);
            color: white; box-shadow: 0 3px 10px rgba(99,102,241,0.3);
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .form-card { animation: slideUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        @keyframes successPop {
            0%   { transform: scale(0); opacity: 0; }
            70%  { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
        .success-icon { animation: successPop 0.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        @keyframes floatUp {
            0%   { transform: translateY(100vh) scale(0); opacity: 0; }
            10%  { opacity: 1; transform: translateY(80vh) scale(1); }
            90%  { opacity: 1; }
            100% { transform: translateY(-10vh) scale(0); opacity: 0; }
        }
        .particle { position: absolute; border-radius: 50%; animation: floatUp linear infinite; bottom: -10%; }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-purple-500 selection:text-white relative">

    <div class="fixed inset-0 overflow-hidden pointer-events-none z-0 bg-dots">
        <div class="absolute top-[-10%] left-[-10%] w-[40vw] h-[40vw] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob bg-indigo-300"></div>
        <div class="absolute top-[20%] right-[-10%] w-[35vw] h-[35vw] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-2000 bg-purple-300"></div>
        <div class="absolute bottom-[-20%] left-[20%] w-[45vw] h-[45vw] rounded-full mix-blend-multiply filter blur-3xl opacity-40 animate-blob animation-delay-4000 bg-pink-300"></div>
        <div class="absolute bottom-[10%] right-[10%] w-[30vw] h-[30vw] rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-6000 bg-emerald-200"></div>
        <div class="particle bg-indigo-400/20"  style="left:10%;  width:20px; height:20px; animation-duration:12s; animation-delay:0s;"></div>
        <div class="particle bg-purple-400/20"  style="left:30%;  width:40px; height:40px; animation-duration:18s; animation-delay:2s;"></div>
        <div class="particle bg-pink-400/20"    style="left:60%;  width:15px; height:15px; animation-duration:10s; animation-delay:5s;"></div>
        <div class="particle bg-emerald-400/20" style="left:80%;  width:30px; height:30px; animation-duration:22s; animation-delay:1s;"></div>
        <div class="particle bg-indigo-400/20"  style="left:45%;  width:25px; height:25px; animation-duration:16s; animation-delay:7s;"></div>
    </div>

    <div class="relative z-10 min-h-screen py-12 px-4 sm:px-6 lg:px-8 flex flex-col justify-center">
        <div class="max-w-3xl mx-auto w-full">

            <div class="text-center mb-10">
                <a href="/" class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-white/80 backdrop-blur-sm text-purple-600 mb-4 hover:bg-white transition-all shadow-md hover:shadow-lg hover:-translate-y-1 border border-purple-100">
                    <i class="fa-solid fa-chalkboard-user text-2xl"></i>
                </a>
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight drop-shadow-sm">Faculty Application Portal</h1>
                <p class="mt-3 text-slate-600 font-medium text-lg drop-shadow-sm">Join our global network of educators. Applications reviewed within 2–3 business days.</p>
            </div>

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl p-5 mb-6 flex items-start gap-4 shadow-sm">
                    <div class="success-icon w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <i class="fa-solid fa-check text-emerald-600 text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-emerald-900">Application Submitted Successfully!</p>
                        <p class="text-sm mt-0.5">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="form-card bg-white/90 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/50 overflow-hidden relative">

                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-500 via-pink-500 to-indigo-500"></div>

                <form method="POST" action="{{ route('register.faculty.store') }}" class="p-8 space-y-8">
                    @csrf

                    @if($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl p-4 text-sm">
                            <p class="font-bold mb-2 flex items-center gap-2">
                                <i class="fa-solid fa-circle-exclamation"></i> Please fix the following errors:
                            </p>
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Section 1: Personal --}}
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/60 pb-2 mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-user text-indigo-400"></i> Personal Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="name">
                                    Full Name <span class="text-rose-500">*</span>
                                </label>
                                <input id="name" type="text" name="name" required
                                    value="{{ old('name') }}" placeholder="Dr. John Smith"
                                    class="form-field {{ $errors->has('name') ? 'is-error' : '' }}">
                                @error('name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="email">
                                    Email Address <span class="text-rose-500">*</span>
                                </label>
                                <input id="email" type="email" name="email" required
                                    value="{{ old('email') }}" placeholder="john@university.edu"
                                    class="form-field {{ $errors->has('email') ? 'is-error' : '' }}">
                                @error('email')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="phone">
                                    Phone Number <span class="text-rose-500">*</span>
                                </label>
                                <input id="phone" type="tel" name="phone" required
                                    value="{{ old('phone') }}" placeholder="+91 98765 43210"
                                    class="form-field {{ $errors->has('phone') ? 'is-error' : '' }}">
                                @error('phone')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="department">
                                    Department <span class="text-slate-400 font-normal">(optional)</span>
                                </label>
                                <input id="department" type="text" name="department"
                                    value="{{ old('department') }}" placeholder="e.g. Computer Science"
                                    class="form-field {{ $errors->has('department') ? 'is-error' : '' }}">
                                @error('department')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    {{-- Section 2: Academic --}}
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-200/60 pb-2 mb-5 flex items-center gap-2">
                            <i class="fa-solid fa-graduation-cap text-purple-400"></i> Academic Profile
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="qualification">
                                    Highest Qualification <span class="text-rose-500">*</span>
                                </label>
                                <input id="qualification" type="text" name="qualification" required
                                    value="{{ old('qualification') }}" placeholder="e.g. Ph.D. in Mathematics"
                                    class="form-field {{ $errors->has('qualification') ? 'is-error' : '' }}">
                                @error('qualification')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2" for="experience">
                                    Teaching Experience <span class="text-slate-400 font-normal">(optional)</span>
                                </label>
                                <input id="experience" type="text" name="experience"
                                    value="{{ old('experience') }}" placeholder="e.g. 5 years"
                                    class="form-field {{ $errors->has('experience') ? 'is-error' : '' }}">
                                @error('experience')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        {{-- Subject Multi-Select Pills --}}
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-3">
                                Subject(s) Expertise <span class="text-rose-500">*</span>
                                <span class="ml-2 text-xs text-slate-400 font-normal">Click to select all that apply</span>
                            </label>

                            @if(isset($subjects) && $subjects->count() > 0)
                                <div class="flex flex-wrap gap-2 p-4 bg-slate-50/80 rounded-xl border {{ $errors->has('subjects') ? 'border-rose-300 bg-rose-50/30' : 'border-slate-200' }} min-h-[60px] transition-all">
                                    @foreach($subjects as $subject)
                                        <div>
                                            <input type="checkbox"
                                                id="subject_{{ $subject->id }}"
                                                name="subjects[]"
                                                value="{{ $subject->id }}"
                                                class="subject-checkbox"
                                                @if(is_array(old('subjects')) && in_array($subject->id, old('subjects'))) checked @endif>
                                            <label for="subject_{{ $subject->id }}" class="subject-label">
                                                <i class="fa-solid fa-circle-check text-xs"></i>
                                                {{ $subject->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('subjects')<p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                                @error('subjects.*')<p class="text-rose-500 text-xs mt-1.5">{{ $message }}</p>@enderror
                            @else
                                <div class="p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-700">
                                    <i class="fa-solid fa-triangle-exclamation mr-2"></i>
                                    No subjects available yet. Please contact administration.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Terms --}}
                    <div class="bg-purple-50/50 backdrop-blur-sm p-5 rounded-xl border border-purple-100 shadow-inner">
                        <label class="flex items-start gap-3 cursor-pointer group">
                            <input id="terms" type="checkbox" required
                                class="mt-1 w-5 h-5 text-purple-600 rounded border-slate-300 focus:ring-purple-500 cursor-pointer flex-shrink-0">
                            <span class="text-sm text-slate-700 leading-relaxed font-medium group-hover:text-purple-900 transition-colors">
                                I confirm that all provided information is accurate and authentic. I understand that false information may result in rejection or account termination. I consent to EdFlow verifying my credentials.
                            </span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button id="submitBtn" type="submit"
                        class="w-full py-4 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl font-bold text-lg shadow-lg hover:shadow-purple-500/30 transition-all flex items-center justify-center gap-2 hover:-translate-y-0.5 active:translate-y-0">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span>Submit Faculty Application</span>
                    </button>
                </form>
            </div>

            <div class="text-center mt-8 flex items-center justify-center gap-4 flex-wrap">
                <a href="/login" class="text-sm font-bold text-slate-500 hover:text-indigo-600 transition-colors bg-white/50 px-4 py-2 rounded-full backdrop-blur-sm border border-white">
                    <i class="fa-solid fa-arrow-right-to-bracket mr-1.5"></i>Already have an account? Login
                </a>
                <a href="/" class="text-sm font-bold text-slate-500 hover:text-purple-600 transition-colors bg-white/50 px-4 py-2 rounded-full backdrop-blur-sm border border-white">
                    <i class="fa-solid fa-house mr-1.5"></i>Return to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>