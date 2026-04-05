<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $student->user->name }} | EdFlow Verified ID</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <meta name="theme-color" content="#4f46e5">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Pulsing SOS ring for emergency call button */
        @keyframes sos-ring {
            0%   { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7); }
            70%  { box-shadow: 0 0 0 18px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }
        .sos-pulse { animation: sos-ring 1.6s infinite; }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.5s ease-out forwards; }
        .delay-1 { animation-delay: 0.1s; opacity: 0; }
        .delay-2 { animation-delay: 0.2s; opacity: 0; }
        .delay-3 { animation-delay: 0.3s; opacity: 0; }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-slate-100 via-indigo-50 to-slate-100 min-h-screen flex flex-col items-center justify-start p-4 py-8">

    <!-- Verified Badge -->
    <div class="mb-5 fade-up">
        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-xs font-black bg-emerald-500 text-white shadow-lg shadow-emerald-500/30">
            <i class="fa-solid fa-shield-check"></i> VERIFIED STUDENT IDENTITY
        </span>
    </div>

    <div class="w-full max-w-sm fade-up delay-1">

        <!-- Profile Header Card -->
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-3xl p-6 text-center shadow-2xl shadow-indigo-500/30 relative overflow-hidden mb-4">
            <!-- Decorative rings -->
            <div class="absolute -top-10 -right-10 w-40 h-40 border border-white/10 rounded-full"></div>
            <div class="absolute -bottom-10 -left-10 w-48 h-48 border border-white/10 rounded-full"></div>

            <div class="relative z-10">
                <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center text-5xl font-black text-indigo-600 shadow-xl border-4 border-white/20">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
                <h1 class="text-2xl font-black text-white mt-4 tracking-tight">{{ $student->user->name }}</h1>
                <p class="text-indigo-200 font-semibold text-sm mt-1">{{ $student->course->name ?? 'Enrolled Student' }}</p>
                <div class="inline-flex items-center gap-2 mt-3 px-3 py-1 bg-white/15 rounded-full border border-white/20">
                    <i class="fa-solid fa-id-badge text-indigo-200 text-xs"></i>
                    <span class="text-white font-bold text-xs tracking-wider">Roll No: {{ $student->roll_number ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        <!-- Emergency Section -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-4 fade-up delay-2">
            
            <!-- Section Header -->
            <div class="bg-rose-50 border-b border-rose-100 px-5 py-3 flex items-center gap-2">
                <i class="fa-solid fa-truck-medical text-rose-500"></i>
                <h2 class="text-xs font-black text-rose-600 uppercase tracking-widest">Emergency Contact</h2>
            </div>

            <div class="p-5 space-y-4">
                
                <!-- Guardian Name -->
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-shield text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Guardian / Parent</p>
                        <p class="text-base font-black text-slate-900 mt-0.5">{{ $student->parent_name ?? 'Not Provided' }}</p>
                    </div>
                </div>

                <!-- Emergency Phone + CALL BUTTON -->
                @if($student->emergency_phone)
                    <a href="tel:{{ $student->emergency_phone }}"
                       class="sos-pulse flex items-center gap-4 bg-red-600 hover:bg-red-700 active:scale-95 transition-all p-5 rounded-2xl shadow-xl shadow-red-500/40 cursor-pointer no-underline">
                        <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/30 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone text-2xl text-white animate-bounce"></i>
                        </div>
                        <div class="flex-1">
                            <p class="text-[11px] font-black text-red-200 uppercase tracking-widest">Tap to Call Now</p>
                            <p class="text-xl font-black text-white mt-0.5">{{ $student->emergency_phone }}</p>
                        </div>
                        <i class="fa-solid fa-chevron-right text-white/60 text-lg"></i>
                    </a>
                @else
                    <div class="flex items-center gap-4 bg-slate-100 p-4 rounded-2xl border border-slate-200">
                        <div class="w-12 h-12 rounded-2xl bg-slate-200 text-slate-400 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-phone-slash text-lg"></i>
                        </div>
                        <p class="text-sm font-bold text-slate-500">Emergency phone not provided.</p>
                    </div>
                @endif

            </div>
        </div>

        <!-- Medical + Address Card -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-4 fade-up delay-3">
            <div class="bg-slate-50 border-b border-slate-100 px-5 py-3 flex items-center gap-2">
                <i class="fa-solid fa-notes-medical text-indigo-500"></i>
                <h2 class="text-xs font-black text-slate-500 uppercase tracking-widest">Medical & Location Info</h2>
            </div>

            <div class="p-5 grid grid-cols-2 gap-4">
                <!-- Blood Group -->
                <div class="bg-rose-50 p-4 rounded-2xl border border-rose-100 text-center">
                    <p class="text-[10px] font-black text-rose-400 uppercase tracking-wider">Blood Group</p>
                    <div class="flex items-center justify-center gap-1.5 mt-2">
                        <i class="fa-solid fa-droplet text-rose-500"></i>
                        <span class="text-2xl font-black text-rose-600">{{ $student->blood_group ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Roll Number -->
                <div class="bg-indigo-50 p-4 rounded-2xl border border-indigo-100 text-center">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-wider">Roll Number</p>
                    <p class="text-xl font-black text-indigo-700 mt-2">{{ $student->roll_number ?? 'N/A' }}</p>
                </div>

                <!-- Home Address -->
                @if($student->home_address)
                    <div class="col-span-2 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-wider mb-1.5">
                            <i class="fa-solid fa-house mr-1"></i> Home Address
                        </p>
                        <p class="text-xs font-semibold text-slate-700 leading-relaxed">{{ $student->home_address }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center px-4 fade-up delay-3">
            <div class="flex items-center justify-center gap-2 mb-2">
                <div class="w-6 h-6 bg-indigo-600 rounded-md flex items-center justify-center">
                    <i class="fa-solid fa-graduation-cap text-white text-xs"></i>
                </div>
                <span class="font-black text-slate-700">EdFlow<span class="text-indigo-500">.</span></span>
            </div>
            <p class="text-xs font-medium text-slate-400 leading-relaxed max-w-xs mx-auto">
                This is an officially generated verified profile. If this student is found in an emergency, please tap the red button above to call the guardian immediately.
            </p>
            <p class="text-[10px] font-bold text-slate-300 mt-3 uppercase tracking-widest" id="scan-time">
                Scanned at —
            </p>
        </div>

    </div>

    <script>
        // Render the exact local time the QR page was opened on the scanner's device
        const now = new Date();
        const options = { day: '2-digit', month: 'short', year: 'numeric', hour: '2-digit', minute: '2-digit', hour12: true };
        document.getElementById('scan-time').textContent =
            'Scanned at ' + now.toLocaleString('en-IN', options).replace(',', '');
    </script>

</body>
</html>