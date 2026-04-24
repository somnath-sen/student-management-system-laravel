@extends('layouts.admin')

@section('title', 'Manage Routine Builder')

@section('content')

<div class="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">

    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Routine Builder</h1>
            <p class="text-slate-500 font-medium mt-1">Schedule classes, assign teachers, and manage rooms.</p>
        </div>
        
        <div class="mt-4 md:mt-0">
            <form method="GET" action="{{ route('admin.timetable.index') }}" class="flex items-center gap-3">
                <label class="text-sm font-bold text-slate-500 uppercase tracking-wider">Select Course:</label>
                <select name="course_id" onchange="this.form.submit()" class="bg-white border border-slate-200 text-slate-700 rounded-xl px-4 py-2 font-bold shadow-sm focus:ring-2 focus:ring-indigo-500 outline-none">
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $selectedCourse && $selectedCourse->id == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 flex items-center gap-3 font-bold shadow-sm">
            <i class="fa-solid fa-circle-check text-xl"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-6 sticky top-24">
                <h2 class="text-lg font-extrabold text-slate-800 mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-calendar-plus text-indigo-500"></i> Add New Class
                </h2>

                <form action="{{ route('admin.timetable.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $selectedCourse->id ?? '' }}">

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Day of Week</label>
                        <select name="day_of_week" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                            @foreach($days as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Start Time</label>
                            <input type="time" name="start_time" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">End Time</label>
                            <input type="time" name="end_time" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Subject Name</label>
                        <input type="text" name="subject_name" required placeholder="e.g. Data Structures" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Teacher (Optional)</label>
                        <input type="text" name="teacher_name" placeholder="e.g. Prof. Alan Turing" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Room No. (Optional)</label>
                        <input type="text" name="room_number" placeholder="e.g. Lab 401" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Color Theme</label>
                        <select name="color_theme" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 font-medium">
                            <option value="indigo">Indigo (Default)</option>
                            <option value="emerald">Emerald Green</option>
                            <option value="rose">Rose Red</option>
                            <option value="amber">Amber Yellow</option>
                            <option value="purple">Royal Purple</option>
                            <option value="blue">Ocean Blue</option>
                        </select>
                    </div>

                    <button type="submit" class="w-full py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-md transition-all mt-4 flex justify-center items-center gap-2">
                        <i class="fa-solid fa-plus"></i> Add to Routine
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-6">
            @if(!$selectedCourse)
                <div class="bg-amber-50 text-amber-700 p-6 rounded-2xl border border-amber-200 text-center font-bold">
                    Please create a Course first before building a routine.
                </div>
            @else
                @foreach($days as $day)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-3">
                            <h3 class="font-extrabold text-slate-800 uppercase tracking-wider">{{ $day }}</h3>
                        </div>
                        
                        <div class="p-4 flex flex-col gap-3">
                            @if(isset($timetables[$day]) && count($timetables[$day]) > 0)
                                @foreach($timetables[$day] as $class)
                                    @php
                                        // Simple Color Mapping for Admin side
                                        $colors = [
                                            'indigo' => 'border-indigo-200 bg-indigo-50 text-indigo-900',
                                            'rose' => 'border-rose-200 bg-rose-50 text-rose-900',
                                            'emerald' => 'border-emerald-200 bg-emerald-50 text-emerald-900',
                                            'amber' => 'border-amber-200 bg-amber-50 text-amber-900',
                                            'purple' => 'border-purple-200 bg-purple-50 text-purple-900',
                                            'blue' => 'border-blue-200 bg-blue-50 text-blue-900',
                                        ];
                                        $theme = $colors[$class->color_theme] ?? $colors['indigo'];
                                    @endphp

                                    <div class="flex items-center justify-between p-4 rounded-xl border {{ $theme }}">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-1">
                                                <span class="text-xs font-black bg-white/50 px-2 py-1 rounded-md shadow-sm">
                                                    {{ $class->start_time->format('h:i A') }} - {{ $class->end_time->format('h:i A') }}
                                                </span>
                                                <span class="text-sm font-bold opacity-75"><i class="fa-solid fa-door-open"></i> {{ $class->room_number ?? 'TBA' }}</span>
                                            </div>
                                            <h4 class="font-black text-lg">{{ $class->subject_name }}</h4>
                                            <p class="text-sm font-medium opacity-80">{{ $class->teacher_name ?? 'Instructor TBA' }}</p>
                                        </div>
                                        
                                        <form action="{{ route('admin.timetable.destroy', $class) }}" method="POST" data-confirm="Are you sure you want to remove this class from the routine?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-10 h-10 rounded-full bg-white text-rose-500 hover:bg-rose-500 hover:text-white transition-colors shadow-sm flex items-center justify-center">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-6 text-slate-400">
                                    <p class="font-bold text-sm">No classes scheduled for {{ $day }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    </div>
</div>

@endsection