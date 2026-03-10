<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verified Student | EdFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-panel { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="antialiased flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-md">
        
        <div class="text-center mb-4">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 border border-emerald-200 shadow-sm">
                <i class="fa-solid fa-shield-check"></i> Verified Student Profile
            </span>
        </div>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-200">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-700 px-6 py-8 text-center relative">
                <div class="w-24 h-24 bg-white rounded-full mx-auto flex items-center justify-center text-4xl font-black text-indigo-600 shadow-lg border-4 border-white/20">
                    {{ substr($student->user->name, 0, 1) }}
                </div>
                <h1 class="text-2xl font-black text-white mt-4">{{ $student->user->name }}</h1>
                <p class="text-indigo-100 font-medium text-sm mt-1">{{ $student->course->name ?? 'Enrolled Student' }}</p>
                <p class="text-indigo-200 text-xs font-bold mt-1 uppercase tracking-wider">Roll No: {{ $student->roll_number }}</p>
            </div>

            <div class="p-6 space-y-4">
                <h2 class="text-xs font-black text-rose-500 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">
                    <i class="fa-solid fa-truck-medical mr-1"></i> Emergency Contact Info
                </h2>

                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-100">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase">Guardian Name</p>
                        <p class="text-sm font-bold text-slate-900">{{ $student->parent_name ?? 'Not Provided' }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-rose-50 p-4 rounded-2xl border border-rose-100">
                    <div class="w-10 h-10 rounded-full bg-rose-200 text-rose-700 flex items-center justify-center">
                        <i class="fa-solid fa-phone-volume"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-bold text-rose-400 uppercase">Emergency Phone</p>
                        <p class="text-lg font-black text-rose-700">{{ $student->emergency_phone ?? 'Not Provided' }}</p>
                    </div>
                    @if($student->emergency_phone)
                        <a href="tel:{{ $student->emergency_phone }}" class="w-10 h-10 rounded-full bg-rose-600 text-white flex items-center justify-center shadow-md hover:bg-rose-700 transition-colors">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 text-center">
                        <p class="text-xs font-bold text-slate-400 uppercase">Blood Group</p>
                        <p class="text-2xl font-black text-rose-600 mt-1 flex justify-center items-center gap-1">
                            <i class="fa-solid fa-droplet text-sm"></i> {{ $student->blood_group ?? 'N/A' }}
                        </p>
                    </div>
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col justify-center">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-1">Home Address</p>
                        <p class="text-xs font-medium text-slate-700 leading-tight line-clamp-3">{{ $student->home_address ?? 'Not Provided' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 px-6 py-4 text-center border-t border-slate-100">
                <p class="text-xs font-medium text-slate-400">
                    This is an officially generated profile by EdFlow Academy. If this student is found in an emergency, please contact the guardian immediately.
                </p>
            </div>
        </div>

    </div>

</body>
</html>