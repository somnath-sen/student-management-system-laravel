<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Submitted | EdFlow</title>
    <meta name="description" content="Your EdFlow application has been received and is under review.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        @keyframes successPop {
            0%   { transform: scale(0) rotate(-10deg); opacity: 0; }
            60%  { transform: scale(1.15) rotate(3deg); opacity: 1; }
            100% { transform: scale(1) rotate(0deg); opacity: 1; }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes floatDot {
            0%, 100% { transform: translateY(0); }
            50%       { transform: translateY(-12px); }
        }
        .success-icon  { animation: successPop 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .fade-up       { animation: fadeUp 0.7s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; }
        .fade-up-d1    { animation-delay: 0.2s; }
        .fade-up-d2    { animation-delay: 0.4s; }
        .fade-up-d3    { animation-delay: 0.6s; }
        .dot-1 { animation: floatDot 3s ease-in-out infinite; }
        .dot-2 { animation: floatDot 3s ease-in-out infinite 0.5s; }
        .dot-3 { animation: floatDot 3s ease-in-out infinite 1s; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 flex items-center justify-center px-4 py-16">

    {{-- Background blobs --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-5%] w-[40vw] h-[40vw] rounded-full bg-indigo-600/20 blur-3xl"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-[35vw] h-[35vw] rounded-full bg-orange-500/10 blur-3xl"></div>
    </div>

    <div class="relative z-10 max-w-lg w-full text-center">

        {{-- Success Icon --}}
        <div class="success-icon flex items-center justify-center mx-auto mb-8">
            <div class="w-28 h-28 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center shadow-2xl shadow-emerald-500/40">
                <i class="fa-solid fa-check text-5xl text-white"></i>
            </div>
        </div>

        {{-- Headline --}}
        <div class="fade-up fade-up-d1">
            <div class="inline-flex items-center gap-2 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm font-semibold px-4 py-1.5 rounded-full mb-4">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Application Received
            </div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight mb-3">
                You're in the Queue!
            </h1>
            <p class="text-slate-400 text-lg font-medium leading-relaxed">
                Your <span class="text-white font-semibold">{{ $type }}</span> application has been successfully submitted to EdFlow.
            </p>
        </div>

        {{-- Application Number Card --}}
        @if($appNo)
        <div class="fade-up fade-up-d2 mt-8">
            <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6">
                <p class="text-slate-400 text-sm font-semibold uppercase tracking-widest mb-2">Application Number</p>
                <p class="text-3xl font-black text-white tracking-wider font-mono">{{ $appNo }}</p>
                <p class="text-slate-500 text-xs mt-2">Save this number for future reference</p>
            </div>
        </div>
        @endif

        {{-- What Happens Next --}}
        <div class="fade-up fade-up-d2 mt-8 text-left">
            <div class="bg-white/5 backdrop-blur border border-white/10 rounded-2xl p-6 space-y-4">
                <h3 class="text-white font-bold text-base mb-4">What happens next?</h3>

                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-indigo-500/20 border border-indigo-500/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-magnifying-glass text-indigo-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Application Review</p>
                        <p class="text-slate-400 text-xs leading-relaxed">Our admin team will review your application and documents within 2–5 business days.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-amber-500/20 border border-amber-500/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-envelope text-amber-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Email Notification</p>
                        <p class="text-slate-400 text-xs leading-relaxed">You'll receive an email with your login credentials once approved, or a note if more information is needed.</p>
                    </div>
                </div>

                <div class="flex items-start gap-4">
                    <div class="w-9 h-9 rounded-xl bg-emerald-500/20 border border-emerald-500/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <i class="fa-solid fa-graduation-cap text-emerald-400 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-white font-semibold text-sm">Get Started</p>
                        <p class="text-slate-400 text-xs leading-relaxed">Once approved, log in to your EdFlow dashboard to access all features.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="fade-up fade-up-d3 mt-8 flex flex-col sm:flex-row gap-3 justify-center">
            <a href="/"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-slate-900 font-bold rounded-xl hover:bg-slate-100 transition-all shadow-lg">
                <i class="fa-solid fa-house"></i> Back to Home
            </a>
            @if($type === 'Student')
            <a href="{{ route('register.faculty.store') }}"
               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white/10 border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all">
                Apply as Faculty <i class="fa-solid fa-arrow-right"></i>
            </a>
            @endif
        </div>

        <p class="fade-up fade-up-d3 mt-8 text-slate-600 text-xs">
            For queries, contact your institution's admission office.
        </p>

    </div>
</body>
</html>
