@extends('layouts.student')

@section('title', 'Notice Details')

@section('content')
<div class="max-w-4xl mx-auto p-4 sm:p-6">
    <a href="{{ route('student.dashboard') }}" class="inline-flex items-center gap-2 text-sm font-bold text-indigo-600 hover:text-indigo-800 mb-6 transition-colors">
        <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>

    <div class="bg-white rounded-2xl shadow-md border border-slate-200 overflow-hidden">
        <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        
        <div class="p-8 md:p-10">
            <div class="flex items-center gap-3 mb-6">
                @php
                    $badgeColors = [
                        'Urgent' => 'bg-rose-100 text-rose-700 border-rose-200',
                        'Exam' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                        'Holiday' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                        'General' => 'bg-blue-100 text-blue-700 border-blue-200',
                    ];
                    $colorClass = $badgeColors[$notice->category] ?? $badgeColors['General'];
                @endphp
                <span class="px-3 py-1 rounded-md text-xs font-black uppercase tracking-wider border {{ $colorClass }}">
                    {{ $notice->category }}
                </span>
                <span class="text-sm font-bold text-slate-400 flex items-center gap-1.5">
                    <i class="fa-regular fa-clock"></i> {{ $notice->created_at->format('l, jS F Y \a\t h:i A') }}
                </span>
            </div>

            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-6 tracking-tight leading-tight">{{ $notice->title }}</h1>
            
            <div class="prose prose-slate max-w-none text-slate-700 leading-relaxed whitespace-pre-wrap font-medium">
                {{ $notice->content }}
            </div>

            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold">
                    {{ substr($notice->author->name ?? 'A', 0, 1) }}
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-900">Posted by {{ $notice->author->name ?? 'Administration' }}</p>
                    <p class="text-xs text-slate-500 font-medium">Official Campus Communication</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection