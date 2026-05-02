<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>EdFlow | Parent Dashboard</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f8fafc; }
        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.5);
            box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
        }
        .text-gradient-emerald {
            background: linear-gradient(135deg, #10b981, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .blur-blob {
            position: absolute; border-radius: 50%; filter: blur(100px); z-index: -1; animation: pulseBlob 8s infinite alternate;
        }
        @keyframes pulseBlob {
            0% { transform: scale(1) translateY(0); opacity: 0.3; }
            100% { transform: scale(1.1) translateY(-20px); opacity: 0.5; }
        }
        @keyframes sosFlash {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.85; transform: scale(1.005); }
        }
        .sos-banner { animation: sosFlash 1.5s ease-in-out infinite; }
        @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="antialiased text-gray-800 relative overflow-x-hidden min-h-screen flex flex-col">

    <!-- Ambient Background -->
    <div class="fixed inset-0 pointer-events-none z-[-1]">
        <div class="blur-blob bg-emerald-300 w-[500px] h-[500px] top-[-200px] left-[-100px]"></div>
        <div class="blur-blob bg-blue-200 w-[600px] h-[600px] bottom-[-200px] right-[-100px]" style="animation-delay: 2s; animation-direction: alternate-reverse;"></div>
    </div>

    <!-- Navigation -->
    <nav class="glass-card sticky top-0 z-50 border-b border-gray-100/50 px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-400 to-blue-500 flex items-center justify-center text-white shadow-lg shadow-emerald-500/30">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
                <span class="text-xl font-black tracking-tight text-gray-900">EdFlow<span class="text-emerald-500">.</span></span>
            </div>

            <div class="flex items-center gap-6">
                <span class="text-sm font-bold text-gray-600 hidden md:block">Role: <span class="text-emerald-500">Parent Explorer</span></span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-5 py-2.5 rounded-full bg-gray-900 text-white text-sm font-bold hover:bg-gray-800 transition-all hover:scale-105 shadow-md flex items-center gap-2">
                        <span>Sign Out</span> <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 w-full pb-24 lg:pb-0">

        {{-- ════════════ GLOBAL SOS EMERGENCY BANNER ════════════ --}}
        @php $anyPanicking = $childrenData->contains('is_panicking', true); @endphp
        @if($anyPanicking)
            <div class="sos-banner w-full bg-red-600 text-white px-6 py-6 border-b-4 border-red-800 shadow-[0_8px_40px_rgba(220,38,38,0.6)]">
                <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div class="flex items-start gap-5">
                        <div class="flex-shrink-0 w-16 h-16 bg-white/20 border-2 border-white/40 rounded-2xl flex items-center justify-center shadow-inner">
                            <i class="fa-solid fa-triangle-exclamation text-3xl animate-bounce"></i>
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-[0.3em] text-red-100 mb-1">⚠ EMERGENCY S.O.S SIGNAL RECEIVED</p>
                            @foreach($childrenData as $d)
                                @if($d['is_panicking'] && $d['panic_data'])
                                    <h2 class="text-2xl md:text-3xl font-black leading-tight">
                                        {{ $d['student']->user->name ?? 'Your child' }} has triggered a Panic Alert!
                                    </h2>
                                    <p class="text-red-100 font-bold mt-1 text-sm">
                                        <i class="fa-regular fa-clock"></i> Triggered {{ $d['panic_data']['time_ago'] }} — {{ $d['panic_data']['triggered_at'] }}
                                    </p>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col gap-3 w-full md:w-auto">
                        @foreach($childrenData as $d)
                            @if($d['is_panicking'] && $d['panic_data'] && $d['panic_data']['map_link'])
                                <a href="{{ $d['panic_data']['map_link'] }}" target="_blank"
                                   class="flex items-center justify-center gap-3 px-8 py-4 bg-white text-red-700 font-black rounded-2xl shadow-xl hover:bg-red-50 transition-all hover:scale-105 text-base border-2 border-white">
                                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                                    Open Emergency Location in Maps
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            @endif
                        @endforeach
                        <p class="text-[10px] text-red-200 text-center font-bold">The student's live GPS coordinates are directly embedded in this link.</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-12">
        
        @if(session('error'))
            <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg flex-shrink-0"></i>
                <p class="text-rose-700 font-semibold text-sm">{{ session('error') }}</p>
            </div>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-xl flex items-center gap-3 shadow-sm">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg flex-shrink-0"></i>
                <p class="text-emerald-700 font-semibold text-sm">{{ session('success') }}</p>
            </div>
        @endif

        <header class="mb-12" style="animation: fadeUp 0.5s ease-out forwards; opacity: 0; transform: translateY(20px);">
            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-black uppercase tracking-widest border border-emerald-100 shadow-sm mb-4 inline-block">Family Overview</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight text-gray-900 leading-tight">
                Welcome back, <br />
                <span class="text-gradient-emerald">{{ Auth::user()->name }}</span>
            </h1>
            <p class="text-gray-500 font-medium mt-3 text-lg">Monitor attendance, results, and real-time alerts across your connected student profiles.</p>
        </header>

        @forelse($childrenData as $index => $data)
            @php
                $child = $data['student'];
                // Staggered fade in delay
                $delay = $index * 0.15;
            @endphp
            <div class="glass-card rounded-[2.5rem] overflow-hidden mb-12 border border-white relative group" style="animation: fadeUp 0.6s ease-out forwards; animation-delay: {{ $delay }}s; opacity: 0; transform: translateY(20px);">
                
                <style>
                    @keyframes fadeUp {
                        to { opacity: 1; transform: translateY(0); }
                    }
                </style>

                <!-- Student Header Strip -->
                <div class="bg-gray-900 p-8 flex flex-col md:flex-row justify-between items-start md:items-center text-white relative overflow-hidden">
                    <!-- Subtle background glow -->
                    <div class="absolute inset-0 opacity-20 pointer-events-none">
                        <div class="absolute right-0 top-0 w-64 h-64 bg-emerald-500 rounded-full blur-[80px]"></div>
                    </div>
                    
                    <div class="flex items-center gap-5 relative z-10 w-full md:w-auto mb-6 md:mb-0">
                        <div class="w-20 h-20 bg-white/10 rounded-[1.5rem] flex items-center justify-center text-3xl font-black shadow-inner border border-white/20 backdrop-blur-md relative">
                            {{ substr($child->user->name ?? '?', 0, 1) }}
                            <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-emerald-500 border-2 border-gray-900 rounded-full flex items-center justify-center">
                                <i class="fa-solid fa-check text-[10px]"></i>
                            </div>
                        </div>
                        <div>
                            <h2 class="text-3xl font-black tracking-tight">{{ $child->user->name ?? 'Unknown Student' }}</h2>
                            <div class="flex flex-wrap items-center gap-3 mt-2">
                                <span class="bg-white/10 px-3 py-1 rounded-full text-xs font-bold">{{ $child->course->name ?? 'No Course' }}</span>
                                <span class="text-emerald-400 text-xs font-black uppercase tracking-widest">Roll #{{ $child->roll_number ?? 'N/A' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 w-full md:w-auto text-left md:text-right flex flex-col gap-3">
                         @if($data['unread_broadcasts'] > 0)
                            <div class="inline-flex items-center gap-2 px-5 py-2.5 bg-red-500/20 border border-red-500 text-red-100 rounded-xl text-sm font-black tracking-wide cursor-pointer hover:bg-red-500/30 transition-colors shadow-[0_0_20px_rgba(239,68,68,0.3)]">
                                <span class="relative flex h-3 w-3">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500"></span>
                                </span>
                                {{ $data['unread_broadcasts'] }} Unread Alerts
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 border border-white/10 text-gray-300 rounded-xl text-xs font-bold uppercase tracking-widest">
                                <i class="fa-solid fa-bell-slash text-gray-500"></i> No New Alerts
                            </div>
                        @endif

                        {{-- Report Card Download Button --}}
                        @if($data['is_results_published'])
                            <a href="{{ route('parent.report-card.download', $child->id) }}"
                               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white rounded-xl text-sm font-black tracking-wide transition-all hover:scale-105 shadow-[0_0_20px_rgba(251,191,36,0.4)] border border-amber-400/30">
                                <i class="fa-solid fa-file-pdf"></i>
                                Download Report Card
                            </a>
                        @else
                            <div class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white/5 border border-white/10 text-gray-500 rounded-xl text-sm font-bold tracking-wide cursor-not-allowed">
                                <i class="fa-solid fa-clock"></i>
                                Report Card Not Published
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Internal Analytics Grid -->
                <div class="p-8 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 bg-white/50">
                    
                    <!-- Analytics 1: ATTENDANCE -->
                    @php
                        $attColor = $data['attendance_status'] === 'green' ? 'emerald' : 
                                   ($data['attendance_status'] === 'yellow' ? 'amber' : 
                                   ($data['attendance_status'] === 'red' ? 'rose' : 'gray'));
                    @endphp
                    <div class="col-span-1 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                        <!-- BG accent -->
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-{{ $attColor }}-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                        
                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div class="w-14 h-14 rounded-2xl bg-{{ $attColor }}-50 text-{{ $attColor }}-500 flex items-center justify-center shadow-inner border border-{{ $attColor }}-100 group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-calendar-check text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full bg-white">Attendance</span>
                        </div>
                        <div class="relative z-10 flex-1 flex flex-col justify-end">
                            <h3 class="text-6xl font-black text-gray-800 tracking-tighter">{{ $data['attendance_percentage'] }}<span class="text-3xl text-gray-300">%</span></h3>
                            <p class="text-sm font-bold text-gray-500 mt-2 mb-6">Cumulative class presence</p>
                            
                            <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $attColor }}-500 rounded-full shadow-[inset_0_-2px_4px_rgba(0,0,0,0.1)] relative overflow-hidden" style="width: {{ $data['attendance_percentage'] }}%">
                                    <div class="absolute inset-0 bg-white/20 animate-[marquee_2s_linear_infinite] w-[200%]"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics 2: ACADEMICS -->
                    <div class="col-span-1 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-indigo-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                        
                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-500 flex items-center justify-center shadow-inner border border-indigo-100 group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-chart-pie text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full bg-white">Results</span>
                        </div>
                        <div class="relative z-10">
                            <h3 class="text-6xl font-black text-gray-800 tracking-tighter">{{ $data['overall_performance'] }}<span class="text-3xl text-gray-300">%</span></h3>
                            <p class="text-sm font-bold text-gray-500 mt-2 mb-4">Overall aggregate score</p>
                            
                            <div class="mt-4 max-h-[100px] overflow-y-auto custom-scroll pr-2 divide-y divide-gray-50">
                                @forelse($data['subject_scores'] as $score)
                                    <div class="py-2 flex justify-between items-center group/item hover:bg-indigo-50/50 px-2 rounded-lg transition-colors">
                                        <span class="text-xs font-bold text-gray-700 truncate mr-2">{{ $score['name'] }}</span>
                                        <span class="text-xs font-black {{ $score['percentage'] < 50 ? 'text-rose-500' : 'text-indigo-600' }} bg-white border border-gray-100 px-2 py-0.5 rounded-md shadow-sm">
                                            {{ $score['percentage'] }}%
                                        </span>
                                    </div>
                                @empty
                                    <span class="text-xs text-gray-400 italic block mt-2 p-2 bg-gray-50 rounded-lg">No examination marks mapped yet.</span>
                                @endforelse
                            </div>
                            <!-- Custom scrollbar style inline for this block -->
                            <style>
                                .custom-scroll::-webkit-scrollbar { width: 4px; }
                                .custom-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 4px; }
                                .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
                            </style>
                        </div>
                    </div>

                    <!-- Analytics 3: EMERGENCY TRACKER -->
                    @if($data['is_panicking'])
                    <div class="col-span-1 bg-red-600 p-8 rounded-[2rem] shadow-2xl shadow-red-600/50 flex flex-col justify-between transition-all duration-300 relative overflow-hidden border-2 border-red-400" style="animation: sosFlash 1.5s ease-in-out infinite;">
                        <div class="absolute -right-4 -bottom-4 opacity-20 pointer-events-none">
                            <i class="fa-solid fa-triangle-exclamation text-9xl text-white"></i>
                        </div>
                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div class="w-14 h-14 rounded-2xl bg-white/20 border border-white/30 text-white flex items-center justify-center shadow-inner">
                                <i class="fa-solid fa-triangle-exclamation text-2xl animate-bounce"></i>
                            </div>
                            <span class="text-[10px] font-black text-white uppercase tracking-widest border border-white/30 px-3 py-1 rounded-full bg-white/20">🚨 SOS ACTIVE</span>
                        </div>
                        <div class="relative z-10 flex-1 flex flex-col justify-end">
                            <h3 class="text-xl font-black text-white mb-1">PANIC ALERT TRIGGERED</h3>
                            <p class="text-red-100 text-xs font-bold mb-1"><i class="fa-regular fa-clock"></i> {{ $data['panic_data']['time_ago'] }}</p>
                            <p class="text-red-200 text-[10px] font-semibold mb-4">{{ $data['panic_data']['triggered_at'] }}</p>
                            @if($data['panic_data']['map_link'])
                                <a href="{{ $data['panic_data']['map_link'] }}" target="_blank"
                                   class="block w-full py-4 text-center bg-white text-red-700 font-black text-sm rounded-xl transition-all hover:bg-red-50 hover:-translate-y-0.5 shadow-xl">
                                    <i class="fa-solid fa-map-location-dot mr-2"></i> Open Emergency Location
                                </a>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="col-span-1 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute right-[-10%] bottom-[-10%] opacity-5 group-hover:opacity-10 transition-opacity duration-500 pointer-events-none">
                            <i class="fa-solid fa-map-location-dot text-9xl text-rose-500"></i>
                        </div>
                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div class="w-14 h-14 rounded-2xl bg-rose-50 text-rose-500 flex items-center justify-center shadow-inner border border-rose-100 group-hover:rotate-12 transition-transform duration-300">
                                <i class="fa-solid fa-satellite-dish text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black text-rose-500 uppercase tracking-widest border border-rose-100 px-3 py-1 rounded-full bg-rose-50">Live Tracker</span>
                        </div>
                        <div class="relative z-10 flex-1 flex flex-col justify-end">
                            @if($data['emergency_data'])
                                <div class="bg-gray-50 p-4 rounded-2xl mb-4 border border-gray-100">
                                    <h3 class="text-base font-black text-gray-800 mb-1 flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> GPS Linked
                                    </h3>
                                    <p class="text-xs font-bold text-gray-500"><i class="fa-regular fa-clock"></i> {{ $data['emergency_data']['updated_at'] }}</p>
                                </div>
                                <a href="{{ $data['emergency_data']['map_link'] }}" target="_blank" class="block w-full py-3.5 text-center bg-gray-900 hover:bg-black text-white font-black text-sm rounded-xl transition-all hover:-translate-y-0.5 shadow-[0_10px_20px_rgba(0,0,0,0.15)]">
                                    Track Live on Maps <i class="fa-solid fa-arrow-up-right-from-square ml-1"></i>
                                </a>
                            @else
                                <div class="bg-gray-50 p-4 rounded-2xl mb-4 border border-gray-100 flex flex-col items-center justify-center text-center">
                                    <i class="fa-solid fa-location-crosshairs text-3xl text-gray-300 mb-2"></i>
                                    <h3 class="text-sm font-black text-gray-600 mb-1">Signal Offline</h3>
                                    <p class="text-xs font-medium text-gray-400">Device has not pinged location.</p>
                                </div>
                                <button disabled class="w-full py-3 text-center bg-gray-100 text-gray-400 font-black text-sm rounded-xl cursor-not-allowed border border-gray-200">Location Unavailable</button>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Analytics 4: FEES TRACK -->
                    <div class="col-span-1 bg-white p-8 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-xl hover:-translate-y-1 transition-all duration-300 relative overflow-hidden group">
                        <div class="absolute -right-8 -top-8 w-32 h-32 bg-amber-50 rounded-full group-hover:scale-150 transition-transform duration-700 ease-out z-0"></div>
                        
                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div class="w-14 h-14 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center shadow-inner border border-amber-100 group-hover:scale-110 transition-transform duration-300">
                                <i class="fa-solid fa-indian-rupee-sign text-2xl"></i>
                            </div>
                            <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest border border-gray-100 px-3 py-1 rounded-full bg-white">Fees Track</span>
                        </div>
                        <div class="relative z-10 flex-1 flex flex-col justify-end">
                            <h3 class="text-3xl font-black text-gray-800 tracking-tighter truncate" title="₹{{ number_format($data['total_paid']) }} / ₹{{ number_format($data['total_fees']) }}">
                                ₹{{ number_format($data['total_paid']) }}<span class="text-lg text-gray-400 font-bold"> / ₹{{ number_format($data['total_fees']) }}</span>
                            </h3>
                            
                            @if($data['total_due'] > 0)
                                <p class="text-sm font-bold text-rose-500 mt-2 mb-6"><i class="fa-solid fa-circle-exclamation mr-1"></i> Due: ₹{{ number_format($data['total_due']) }}</p>
                            @else
                                <p class="text-sm font-bold text-emerald-500 mt-2 mb-6"><i class="fa-regular fa-circle-check mr-1"></i> Fully Paid</p>
                            @endif
                            
                            @php
                                $feePercentage = $data['total_fees'] > 0 ? min(100, round(($data['total_paid'] / $data['total_fees']) * 100)) : 100;
                                $feeColor = $feePercentage == 100 ? 'emerald' : 'amber';
                                if ($data['total_fees'] == 0 && $data['total_paid'] == 0) {
                                    $feePercentage = 0;
                                    $feeColor = 'gray';
                                }
                            @endphp
                            
                            <div class="w-full bg-gray-100 h-3 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $feeColor }}-500 rounded-full shadow-[inset_0_-2px_4px_rgba(0,0,0,0.1)] relative overflow-hidden transition-all duration-1000" style="width: {{ $feePercentage }}%">
                                    @if($feePercentage > 0 && $feePercentage < 100)
                                    <div class="absolute inset-0 bg-white/20 animate-[marquee_2s_linear_infinite] w-[200%]"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="glass-card p-16 rounded-[3rem] text-center border border-gray-200 mt-12 overflow-hidden relative">
                <!-- Decorative orbit lines behind empty state -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[300px] h-[300px] border border-dashed border-gray-200 rounded-full animate-[spin_30s_linear_infinite] opacity-50 z-0"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[200px] h-[200px] border border-gray-100 rounded-full animate-[spin_20s_linear_infinite_reverse] opacity-50 z-0"></div>

                <div class="relative z-10 w-28 h-28 bg-white rounded-3xl shadow-xl flex items-center justify-center text-5xl text-gray-300 mx-auto mb-8 border border-gray-50">
                    <i class="fa-solid fa-children"></i>
                </div>
                <h2 class="relative z-10 text-3xl font-black text-gray-900 tracking-tight">No Enrolled Children Found</h2>
                <p class="relative z-10 text-gray-500 font-medium text-lg mt-4 max-w-lg mx-auto leading-relaxed">Your portal account does not currently have any student profiles linked to it. If this is an error, please coordinate with school administration.</p>
                <div class="relative z-10 mt-8">
                    <button class="px-6 py-3 bg-gray-900 text-white rounded-full font-bold shadow-lg hover:scale-105 transition-transform" onclick="location.reload()">
                        Refresh Portal
                    </button>
                </div>
            </div>
        @endforelse

        {{-- ─── Telegram Connect Widget ────────────────────────────────── --}}
        @php
            $parentUser             = auth()->user();
            $isParentTelegramLinked = $parentUser->hasTelegramConnected();
            $lastParentAlert        = $isParentTelegramLinked
                ? \App\Models\NotificationLog::where('recipient_id', $parentUser->id)
                    ->where('status', 'sent')
                    ->latest('sent_at')
                    ->first()
                : null;
        @endphp
        <div class="glass-card rounded-[2.5rem] overflow-hidden mt-10 border border-white"
             style="animation: fadeUp 0.6s ease-out forwards; animation-delay: 0.3s; opacity: 0; transform: translateY(20px);">
            {{-- Blue gradient header --}}
            <div class="p-8 relative overflow-hidden"
                 style="background: {{ $isParentTelegramLinked ? 'linear-gradient(135deg, #2AABEE 0%, #229ED9 100%)' : 'linear-gradient(135deg, #475569, #334155)' }}">
                <div class="absolute -right-6 -top-6 opacity-10">
                    <i class="fa-brands fa-telegram text-[10rem] text-white"></i>
                </div>
                <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
                    <div class="w-16 h-16 rounded-2xl bg-white/20 flex items-center justify-center backdrop-blur-sm border border-white/30 flex-shrink-0">
                        <i class="fa-brands fa-telegram text-white text-3xl"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-[10px] font-black uppercase tracking-widest text-white/70 mb-1">Instant Alerts</p>
                        <h2 class="text-2xl font-black text-white leading-tight">Telegram Notifications</h2>
                        <p class="text-white/70 text-sm font-medium mt-1">
                            {{ $isParentTelegramLinked
                                ? 'Your account is connected. You will receive instant alerts for your child\'s attendance, results, fees, and emergency SOS.'
                                : 'Connect your Telegram to receive real-time alerts about attendance, results, fees, and emergency SOS events.' }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        @if($isParentTelegramLinked)
                            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 rounded-2xl text-sm font-black text-white border border-white/30">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Connected ✅
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/20 rounded-2xl text-sm font-black text-white border border-white/30">
                                <span class="w-2.5 h-2.5 rounded-full bg-white/50"></span>
                                Not Connected
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Body --}}
            <div class="p-8 bg-white grid md:grid-cols-2 gap-6">
                @if($isParentTelegramLinked)
                    {{-- Connected State --}}
                    <div>
                        <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-bell text-blue-500"></i> Active Alert Types
                        </h3>
                        <div class="space-y-2">
                            @foreach([
                                ['📊', 'Attendance Marked', 'Every time your child\'s attendance is recorded'],
                                ['⚠️', 'Low Attendance Warning', 'When attendance drops below 75%'],
                                ['🎉', 'Results Published', 'When exam results are released'],
                                ['💰', 'Fee Reminders', 'When fees are due or added'],
                                ['📢', 'Admin Notices', 'When administration posts a notice'],
                                ['🚨', 'Emergency SOS', 'Instant alert when child triggers panic button'],
                            ] as [$icon, $title, $desc])
                            <div class="flex items-start gap-3 p-3 bg-slate-50 rounded-xl hover:bg-blue-50 transition-colors">
                                <span class="text-base">{{ $icon }}</span>
                                <div>
                                    <p class="text-xs font-black text-slate-700">{{ $title }}</p>
                                    <p class="text-[10px] text-slate-400">{{ $desc }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col gap-4">
                        @if($lastParentAlert)
                        <div class="p-4 bg-blue-50 rounded-2xl border border-blue-100">
                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-wider mb-1">Last Alert</p>
                            <p class="text-sm font-bold text-slate-700">{{ $lastParentAlert->sent_at?->diffForHumans() }}</p>
                            <p class="text-[10px] text-slate-400 mt-1 line-clamp-2">{{ Str::limit($lastParentAlert->message, 80) }}</p>
                        </div>
                        @endif
                        <div class="p-4 bg-emerald-50 rounded-2xl border border-emerald-100 flex items-start gap-3">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-xl mt-0.5"></i>
                            <div>
                                <p class="text-sm font-black text-emerald-700">Telegram is Active</p>
                                <p class="text-[10px] text-emerald-600 mt-0.5">All notifications are being sent to your Telegram account.</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('parent.telegram.disconnect') }}">
                            @csrf
                            <button type="submit"
                                    onclick="return confirm('Disconnect Telegram? You will stop receiving notifications.')"
                                    class="w-full py-3 rounded-2xl text-sm font-black text-red-500 border-2 border-red-100 hover:bg-red-50 transition-colors">
                                <i class="fa-solid fa-link-slash mr-2"></i> Disconnect Telegram
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Not Connected State --}}
                    <div>
                        <h3 class="text-sm font-black text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-bell text-amber-500"></i> You will receive alerts for:
                        </h3>
                        <div class="space-y-2">
                            @foreach([
                                ['📊', 'Attendance Updates'],
                                ['⚠️', 'Low Attendance Warnings'],
                                ['🎉', 'Exam Results Published'],
                                ['💰', 'Fee Payment Reminders'],
                                ['📢', 'Admin Notices'],
                                ['🚨', 'Emergency SOS (Instant!)'],
                            ] as [$icon, $title])
                            <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-xl">
                                <span>{{ $icon }}</span>
                                <p class="text-xs font-bold text-slate-600">{{ $title }}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-col justify-center gap-5">
                        <div class="p-5 bg-amber-50 rounded-2xl border border-amber-100">
                            <p class="text-sm font-black text-amber-700 flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-triangle-exclamation"></i> Not Connected
                            </p>
                            <p class="text-xs text-amber-600 leading-relaxed">
                                Connect your Telegram account to receive real-time notifications directly on your phone, even when you're offline from EdFlow.
                            </p>
                        </div>
                        <div class="space-y-2 text-[10px] text-slate-500 font-bold bg-slate-50 rounded-xl p-4">
                            <p class="font-black text-slate-600 text-xs mb-2">How it works:</p>
                            <p>1️⃣ Click "Connect Telegram" below</p>
                            <p>2️⃣ Telegram opens with our bot</p>
                            <p>3️⃣ Click "Start" in the bot</p>
                            <p>4️⃣ You're connected! ✅</p>
                        </div>
                        <a href="{{ route('parent.telegram.connect') }}"
                           id="btn-parent-connect-telegram"
                           class="flex items-center justify-center gap-3 py-4 rounded-2xl font-black text-base text-white shadow-xl hover:shadow-2xl hover:-translate-y-1 active:scale-95 transition-all"
                           style="background: linear-gradient(135deg, #2AABEE, #229ED9); box-shadow: 0 15px 30px -8px rgba(42,171,238,0.5);">
                            <i class="fa-brands fa-telegram text-2xl"></i>
                            Connect Parent Telegram
                        </a>
                        <p class="text-[9px] text-center text-slate-400">No phone number required. Works with Telegram account only.</p>
                    </div>
                @endif
            </div>
        </div>

        </div>{{-- /max-w-7xl --}}
    </main>


    {{-- Auto-refresh every 30s if any panic is active --}}
    @if($anyPanicking ?? false)
    <script>
        // Poll every 10 seconds to update the panic state in real-time
        setTimeout(() => window.location.reload(), 10000);
    </script>
    @endif

    <!-- Mobile Bottom Navigation (Parent) -->
    <div x-data="{ moreDrawerOpen: false }" class="lg:hidden">
        <!-- Bottom Nav Bar -->
        <div class="fixed bottom-6 left-1/2 -translate-x-1/2 w-[calc(100%-2.5rem)] max-w-md bg-white/80 backdrop-blur-3xl border border-white/60 rounded-[2rem] z-[60] shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] overflow-hidden">
            <div class="flex justify-around items-center px-2 py-2">
                <a href="#" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 text-blue-500">
                    <i class="fa-solid fa-chart-pie text-xl mb-1 transition-transform scale-110 drop-shadow-md"></i>
                    <span class="text-[10px] font-bold">Dashboard</span>
                </a>
                
                <a href="#" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 text-slate-400 hover:text-emerald-500">
                    <i class="fa-solid fa-calendar-check text-xl mb-1 transition-transform"></i>
                    <span class="text-[10px] font-bold">Attendance</span>
                </a>

                <a href="#" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 text-slate-400 hover:text-amber-500">
                    <i class="fa-solid fa-chart-line text-xl mb-1 transition-transform"></i>
                    <span class="text-[10px] font-bold">Marks</span>
                </a>

                <a href="#" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] transition-all active:scale-95 text-slate-400 hover:text-rose-500">
                    <div class="relative">
                        <i class="fa-solid fa-bell text-xl mb-1 transition-transform"></i>
                        @if($childrenData->contains('unread_broadcasts', '>', 0))
                            <span class="absolute -top-1 -right-2 w-2 h-2 bg-rose-500 rounded-full animate-pulse border border-white"></span>
                        @endif
                    </div>
                    <span class="text-[10px] font-bold">Alerts</span>
                </a>

                <button type="button" @click="moreDrawerOpen = true" class="flex flex-col items-center p-2 rounded-xl min-w-[64px] text-slate-400 hover:text-purple-500 transition-all active:scale-90 active:opacity-70">
                    <i class="fa-solid fa-layer-group text-xl mb-1"></i>
                    <span class="text-[10px] font-bold">More</span>
                </button>
            </div>
        </div>

        <!-- Slide-up Drawer Overlay -->
        <div x-show="moreDrawerOpen" style="display: none;" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="moreDrawerOpen = false"
             class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-[70]"></div>

        <!-- Slide-up Drawer Content -->
        <div x-show="moreDrawerOpen" style="display: none;"
             x-transition:enter="transition transform ease-[cubic-bezier(0.2,0.8,0.2,1)] duration-500"
             x-transition:enter-start="translate-y-full"
             x-transition:enter-end="translate-y-0"
             x-transition:leave="transition transform ease-in duration-300"
             x-transition:leave-start="translate-y-0"
             x-transition:leave-end="translate-y-full"
             class="fixed bottom-0 inset-x-0 bg-white/95 backdrop-blur-3xl rounded-t-[2.5rem] z-[80] shadow-[0_-20px_40px_-20px_rgba(0,0,0,0.1)] overflow-hidden flex flex-col max-h-[85vh] border-t border-white/50">
            
            <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center sticky top-0 z-10 bg-white/50 backdrop-blur-xl">
                <div class="absolute top-2.5 left-1/2 -translate-x-1/2 w-12 h-1.5 bg-slate-200 rounded-full"></div>
                <h3 class="font-bold text-slate-800 text-lg mt-3">More Options</h3>
                <button type="button" @click="moreDrawerOpen = false" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 transition-colors active:scale-90">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            
            <div class="overflow-y-auto flex-1 px-4 py-4 space-y-2 pb-8">
                <p class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-2">Academics</p>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-purple-50 text-slate-700 hover:text-purple-700 transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-purple-500"><i class="fa-solid fa-arrow-trend-up"></i></div>
                    <span class="font-bold text-sm flex-1">Performance Analytics</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-indigo-50 text-slate-700 hover:text-indigo-700 transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-indigo-500"><i class="fa-solid fa-calendar-days"></i></div>
                    <span class="font-bold text-sm flex-1">Exam Schedule</span>
                </a>
                @php
                    $publishedChild = $childrenData->first(fn($d) => $d['is_results_published'] ?? false);
                @endphp
                @if($publishedChild)
                <a href="{{ route('parent.report-card.download', $publishedChild['student']->id) }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-700 transition-all active:scale-95 border border-amber-100">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-amber-500"><i class="fa-solid fa-file-pdf"></i></div>
                    <span class="font-bold text-sm flex-1">Download Report Card</span>
                    <span class="text-[9px] text-amber-500 px-2 py-0.5 rounded border border-amber-500/30 font-black tracking-wider uppercase">PDF</span>
                </a>
                @else
                <div class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 opacity-40 cursor-not-allowed">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-400"><i class="fa-solid fa-file-pdf"></i></div>
                    <span class="font-bold text-sm flex-1 text-slate-400">Report Card</span>
                    <span class="text-[9px] text-slate-400 px-2 py-0.5 rounded border border-slate-400/30 font-black tracking-wider uppercase">Not Yet</span>
                </div>
                @endif

                <p class="px-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-2 mt-4">Security & Account</p>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-rose-50 hover:bg-rose-100 text-rose-700 transition-all active:scale-95 border border-rose-100">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-rose-500"><i class="fa-solid fa-triangle-exclamation"></i></div>
                    <span class="font-bold text-sm flex-1">Emergency Alerts</span>
                </a>
                <a href="#" class="flex items-center gap-4 px-4 py-3 rounded-2xl bg-slate-50 hover:bg-slate-100 text-slate-700 transition-all active:scale-95">
                    <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-500"><i class="fa-solid fa-gear"></i></div>
                    <span class="font-bold text-sm flex-1">Settings</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="mt-4 mb-4">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-4 rounded-2xl bg-gray-900 text-white font-bold text-sm hover:bg-gray-800 transition-all active:scale-95 shadow-lg">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Sign Out
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
