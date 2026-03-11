@extends('layouts.teacher')

@section('title', 'My Teaching Schedule')

@section('content')

<style>
    .animate-enter { animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; opacity: 0; transform: translateY(20px); }
    @keyframes fadeUp { to { opacity: 1; transform: translateY(0); } }
    .stagger-1 { animation-delay: 0.1s; }
</style>

<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Teaching Routine</h1>
            <p class="text-slate-500 mt-1 font-medium">Your personalized lecture schedule across all courses.</p>
        </div>
        <div class="mt-4 md:mt-0 flex items-center gap-3">
            <span class="px-4 py-2 bg-indigo-50 border border-indigo-100 rounded-xl shadow-sm text-sm font-bold text-indigo-700">
                <i class="fa-solid fa-user-tie mr-2"></i> {{ $teacherName }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 animate-enter stagger-1">
        
        @foreach($days as $day)
            <div class="flex flex-col h-full bg-white/50 rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                
                <div class="p-4 text-center border-b border-slate-200 bg-white shadow-sm z-10">
                    <h3 class="font-black text-slate-800 uppercase tracking-wider text-sm">{{ $day }}</h3>
                </div>

                <div class="p-4 space-y-4 flex-1 bg-slate-50/50">
                    @if(isset($timetables[$day]) && count($timetables[$day]) > 0)
                        @foreach($timetables[$day] as $class)
                            @php
                                $colors = [
                                    'indigo' => 'bg-indigo-50 border-indigo-200 text-indigo-700',
                                    'rose' => 'bg-rose-50 border-rose-200 text-rose-700',
                                    'emerald' => 'bg-emerald-50 border-emerald-200 text-emerald-700',
                                    'amber' => 'bg-amber-50 border-amber-200 text-amber-700',
                                    'purple' => 'bg-purple-50 border-purple-200 text-purple-700',
                                    'blue' => 'bg-blue-50 border-blue-200 text-blue-700',
                                ];
                                $badgeColors = [
                                    'indigo' => 'bg-indigo-100 text-indigo-800',
                                    'rose' => 'bg-rose-100 text-rose-800',
                                    'emerald' => 'bg-emerald-100 text-emerald-800',
                                    'amber' => 'bg-amber-100 text-amber-800',
                                    'purple' => 'bg-purple-100 text-purple-800',
                                    'blue' => 'bg-blue-100 text-blue-800',
                                ];
                                
                                $theme = $colors[$class->color_theme] ?? $colors['indigo'];
                                $badgeTheme = $badgeColors[$class->color_theme] ?? $badgeColors['indigo'];
                            @endphp

                            <div class="p-4 rounded-2xl border hover:shadow-md transition-all duration-300 hover:-translate-y-1 relative overflow-hidden {{ $theme }}">
                                <div class="absolute -right-4 -top-4 opacity-10">
                                    <i class="fa-solid fa-chalkboard-user text-6xl"></i>
                                </div>

                                <div class="relative z-10">
                                    <div class="flex justify-between items-start mb-2">
                                        <span class="text-[10px] font-black uppercase tracking-wider px-2 py-1 rounded-md {{ $badgeTheme }}">
                                            {{ $class->start_time->format('h:i A') }}
                                        </span>
                                    </div>
                                    
                                    <h4 class="font-black text-lg leading-tight mb-1">{{ $class->subject_name }}</h4>
                                    <p class="text-xs font-bold uppercase tracking-wider opacity-75 mb-4 border-b border-current/10 pb-2 inline-block">
                                        <i class="fa-solid fa-graduation-cap"></i> {{ $class->course->name ?? 'General' }}
                                    </p>
                                    
                                    <div class="flex items-center gap-4 text-xs font-bold mt-auto pt-1">
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-regular fa-clock opacity-70"></i> 
                                            {{ $class->start_time->diffInMinutes($class->end_time) }} Mins
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <i class="fa-solid fa-door-open opacity-70"></i>
                                            {{ $class->room_number }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="h-full flex flex-col items-center justify-center p-4 text-center opacity-50 py-10">
                            <i class="fa-solid fa-mug-hot text-3xl text-slate-400 mb-2"></i>
                            <p class="text-xs font-bold text-slate-500">No Lectures</p>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

    </div>
</div>

@endsection