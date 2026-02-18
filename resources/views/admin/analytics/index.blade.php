@extends('layouts.admin')

@section('title', 'Institutional Analytics')

@section('content')

<style>
    /* ================= ANIMATIONS ================= */
    .animate-enter {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    .stagger-1 { animation-delay: 0.1s; }
    .stagger-2 { animation-delay: 0.2s; }

    /* Progress Bar Animation */
    .progress-bar-fill {
        width: 0;
        animation: fillBar 1.5s cubic-bezier(0.65, 0, 0.35, 1) forwards;
        animation-delay: 0.5s;
    }

    @keyframes fillBar {
        from { width: 0; }
    }
</style>

<div class="max-w-7xl mx-auto">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Institutional Performance</h1>
            <p class="text-gray-500 mt-1">Real-time analytics and academic health monitoring.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('admin.analytics.export') }}" 
               class="px-4 py-2 bg-white border border-gray-200 text-gray-700 rounded-lg hover:bg-gray-50 hover:text-indigo-600 shadow-sm flex items-center gap-2 text-sm font-medium transition-all duration-200 transform hover:-translate-y-0.5">
                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Download Excel Report
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8 animate-enter stagger-1">

        {{-- 1. Overall Average --}}
        <div class="bg-white p-6 rounded-xl border border-blue-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            </div>
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Overall Average</h3>
            <div class="mt-4 flex items-baseline gap-2">
                <p class="text-3xl font-extrabold text-gray-900">{{ $averageScore }}%</p>
            </div>
            <div class="w-full bg-gray-100 h-1.5 rounded-full mt-4">
                <div class="bg-blue-600 h-1.5 rounded-full progress-bar-fill" style="width: {{ $averageScore }}%;"></div>
            </div>
        </div>

        {{-- 2. Pass Rate --}}
        <div class="bg-white p-6 rounded-xl border border-green-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Pass Rate</h3>
            <div class="mt-4 flex items-baseline gap-2">
                <p class="text-3xl font-extrabold text-gray-900">{{ $passRate }}%</p>
            </div>
            <p class="text-xs text-green-600 mt-2 font-medium">Successful Completions</p>
        </div>

        {{-- 3. At Risk --}}
        <div class="bg-white p-6 rounded-xl border border-red-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">At Risk Students</h3>
            <div class="mt-4 flex items-baseline gap-2">
                <p class="text-3xl font-extrabold text-red-600">{{ $atRisk }}</p>
            </div>
            <p class="text-xs text-red-500 mt-2 font-medium">Critical Attention Needed</p>
        </div>

        {{-- 4. Top Course --}}
        <div class="bg-white p-6 rounded-xl border border-purple-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all duration-300">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg class="w-16 h-16 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
            </div>
            <h3 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Top Performer</h3>
            <div class="mt-4">
                <p class="text-xl font-bold text-purple-700 leading-tight line-clamp-2">
                    {{ $topCourse ?? 'N/A' }}
                </p>
            </div>
            <p class="text-xs text-purple-500 mt-2 font-medium">Highest Average Score</p>
        </div>

    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden animate-enter stagger-2">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="font-bold text-gray-800">Course Breakdown</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-white text-left text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-100">
                        <th class="px-6 py-4">Course Name</th>
                        <th class="px-6 py-4 w-1/2">Performance Indicator</th>
                        <th class="px-6 py-4 text-right">Avg. Score</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($courseAverages as $course => $score)
                        @php
                            if($score >= 80) {
                                $barColor = 'bg-emerald-500';
                                $textColor = 'text-emerald-600';
                            } elseif($score >= 50) {
                                $barColor = 'bg-blue-500';
                                $textColor = 'text-blue-600';
                            } else {
                                $barColor = 'bg-red-500';
                                $textColor = 'text-red-600';
                            }
                        @endphp

                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center font-bold text-xs text-gray-500">
                                        {{ substr($course, 0, 1) }}
                                    </div>
                                    <span class="font-medium text-gray-800">{{ $course }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 align-middle">
                                <div class="w-full bg-gray-100 rounded-full h-2">
                                    <div class="{{ $barColor }} h-2 rounded-full progress-bar-fill" 
                                         style="width: {{ $score }}%;"></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-sm font-bold {{ $textColor }}">
                                    {{ $score }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection