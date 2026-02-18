@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

<style>
    /* ================= ANIMATIONS ================= */
    .animate-card {
        animation: fadeUp 0.6s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Stagger Delays */
    .delay-1 { animation-delay: 0.1s; }
    .delay-2 { animation-delay: 0.2s; }
    .delay-3 { animation-delay: 0.3s; }
    .delay-4 { animation-delay: 0.4s; }

    /* Hover Lift Effect */
    .stat-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    }
</style>

<div class="mb-8 animate-card">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Overview</h1>
    <p class="text-gray-500 mt-1">Welcome back, Admin. Here's what's happening in your school today.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

    {{-- 1. Total Students --}}
    <div class="stat-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-start justify-between animate-card delay-1 group">
        <div>
            <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Total Students</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalStudents }}</h3>
            <p class="text-xs text-green-600 mt-2 flex items-center font-medium">
                <span class="bg-green-100 px-1.5 py-0.5 rounded text-green-700 mr-1">Active</span>
                Enrolled
            </p>
        </div>
        <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        </div>
    </div>

    {{-- 2. Total Teachers --}}
    <div class="stat-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-start justify-between animate-card delay-2 group">
        <div>
            <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Total Teachers</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTeachers }}</h3>
            <p class="text-xs text-blue-600 mt-2 flex items-center font-medium">
                <span class="bg-blue-100 px-1.5 py-0.5 rounded text-blue-700 mr-1">Staff</span>
                Members
            </p>
        </div>
        <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
    </div>

    {{-- 3. Total Courses --}}
    <div class="stat-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-start justify-between animate-card delay-3 group">
        <div>
            <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Courses Offered</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalCourses }}</h3>
            <p class="text-xs text-gray-400 mt-2">All semesters</p>
        </div>
        <div class="p-3 bg-violet-50 rounded-lg text-violet-600 group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
        </div>
    </div>

    {{-- 4. Total Subjects --}}
    <div class="stat-card bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-start justify-between animate-card delay-4 group">
        <div>
            <p class="text-xs font-semibold tracking-wide text-gray-500 uppercase">Total Subjects</p>
            <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSubjects ?? $totalStudents }}</h3>
            <p class="text-xs text-gray-400 mt-2">Curriculum</p>
        </div>
        <div class="p-3 bg-amber-50 rounded-lg text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
    </div>

</div>

<div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6 animate-card delay-4">
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-xl p-6 text-white shadow-lg">
        <h3 class="font-bold text-lg mb-2">Quick Actions</h3>
        <p class="text-indigo-100 text-sm mb-4">Manage your institution efficiently.</p>
        <div class="flex gap-3">
            <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm backdrop-blur-sm transition">Add Student</button>
            <button class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-lg text-sm backdrop-blur-sm transition">View Reports</button>
        </div>
    </div>
</div>

@endsection