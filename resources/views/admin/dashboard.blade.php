@extends('layouts.admin')

@section('title', 'Dashboard Overview')

@section('content')

<style>
    /* ================= PREMIUM ANIMATIONS ================= */
    .animate-fade-up {
        animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
        transform: translateY(20px);
    }

    @keyframes fadeUp {
        to { opacity: 1; transform: translateY(0); }
    }

    /* Staggered Delays */
    .delay-100 { animation-delay: 100ms; }
    .delay-200 { animation-delay: 200ms; }
    .delay-300 { animation-delay: 300ms; }
    .delay-400 { animation-delay: 400ms; }
    .delay-500 { animation-delay: 500ms; }
    .delay-600 { animation-delay: 600ms; }

    /* Interactive Stat Cards */
    .stat-card {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }
</style>

<div class="flex flex-col md:flex-row md:items-end justify-between mb-8 animate-fade-up">
    <div>
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">System Overview</h1>
        <p class="text-slate-500 mt-1 text-sm font-medium">Welcome back! Here is the current status of your institution.</p>
    </div>
    <div class="mt-4 md:mt-0 flex items-center gap-3">
        <button onclick="window.location.reload()" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl shadow-sm hover:bg-slate-50 transition-colors font-bold text-sm flex items-center gap-2">
            <i class="fa-solid fa-rotate-right"></i> Refresh
        </button>
        <a href="{{ route('admin.analytics.export') }}" class="inline-flex items-center px-5 py-2.5 bg-slate-900 hover:bg-slate-800 rounded-xl text-sm font-bold text-white transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Report
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">

    {{-- 1. Total Revenue (Financial) --}}
    <a href="{{ route('admin.fees.index') }}" class="stat-card block bg-white p-6 rounded-2xl border border-slate-100 shadow-sm animate-fade-up delay-100 group relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-emerald-50 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-xs font-bold tracking-wider text-slate-500 uppercase">Total Revenue</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">₹{{ number_format($totalRevenue ?? 0, 0) }}</h3>
                <p class="text-xs text-emerald-600 mt-2 flex items-center font-bold">
                    <i class="fa-solid fa-arrow-trend-up mr-1.5"></i> Vault Active
                </p>
            </div>
            <div class="w-12 h-12 bg-emerald-100 rounded-xl text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                <i class="fa-solid fa-indian-rupee-sign text-xl"></i>
            </div>
        </div>
    </a>

    {{-- 2. Total Students --}}
    <a href="{{ route('admin.students.index') }}" class="stat-card block bg-white p-6 rounded-2xl border border-slate-100 shadow-sm animate-fade-up delay-200 group relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-xs font-bold tracking-wider text-slate-500 uppercase">Total Students</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalStudents ?? 0 }}</h3>
                <p class="text-xs text-blue-600 mt-2 flex items-center font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-blue-600 mr-1.5"></span> Enrolled
                </p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-xl text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
    </a>

    {{-- 3. Total Teachers --}}
    <a href="{{ route('admin.teachers.index') }}" class="stat-card block bg-white p-6 rounded-2xl border border-slate-100 shadow-sm animate-fade-up delay-300 group relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-purple-50 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-xs font-bold tracking-wider text-slate-500 uppercase">Total Teachers</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalTeachers ?? 0 }}</h3>
                <p class="text-xs text-purple-600 mt-2 flex items-center font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-purple-600 mr-1.5"></span> Active Staff
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-xl text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </div>
        </div>
    </a>

    {{-- 4. Total Courses --}}
    <a href="{{ route('admin.courses.index') }}" class="stat-card block bg-white p-6 rounded-2xl border border-slate-100 shadow-sm animate-fade-up delay-400 group relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-violet-50 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-xs font-bold tracking-wider text-slate-500 uppercase">Courses Offered</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalCourses ?? 0 }}</h3>
                <p class="text-xs text-violet-600 mt-2 flex items-center font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-violet-600 mr-1.5"></span> Academic
                </p>
            </div>
            <div class="w-12 h-12 bg-violet-100 rounded-xl text-violet-600 flex items-center justify-center group-hover:bg-violet-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            </div>
        </div>
    </a>

    {{-- 5. Total Subjects --}}
    <a href="{{ route('admin.subjects.index') }}" class="stat-card block bg-white p-6 rounded-2xl border border-slate-100 shadow-sm animate-fade-up delay-500 group relative overflow-hidden">
        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-amber-50 rounded-full z-0 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-xs font-bold tracking-wider text-slate-500 uppercase">Total Subjects</p>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalSubjects ?? 0 }}</h3>
                <p class="text-xs text-amber-600 mt-2 flex items-center font-bold">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-600 mr-1.5"></span> Curriculum
                </p>
            </div>
            <div class="w-12 h-12 bg-amber-100 rounded-xl text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-colors duration-300 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
        </div>
    </a>

</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 animate-fade-up delay-600">
    
    <div class="lg:col-span-1">
        <div class="bg-gradient-to-br from-indigo-600 to-purple-700 rounded-2xl p-8 text-white shadow-lg h-full relative overflow-hidden group">
            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-5 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <h3 class="font-extrabold text-2xl mb-2">Quick Actions</h3>
                <p class="text-indigo-100 text-sm mb-6 leading-relaxed">Direct links to manage your campus operations and user data.</p>
                
                <div class="flex flex-col gap-3">
                    <a href="{{ route('admin.students.create') }}" class="px-4 py-3 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold backdrop-blur-sm transition-all border border-white/10 hover:border-white/30 flex justify-between items-center group/btn">
                        <span>Add New Student</span>
                        <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('admin.teachers.create') }}" class="px-4 py-3 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold backdrop-blur-sm transition-all border border-white/10 hover:border-white/30 flex justify-between items-center group/btn">
                        <span>Add New Teacher</span>
                        <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                    <a href="{{ route('admin.courses.create') }}" class="px-4 py-3 bg-white/10 hover:bg-white/20 rounded-xl text-sm font-bold backdrop-blur-sm transition-all border border-white/10 hover:border-white/30 flex justify-between items-center group/btn">
                        <span>Create Course</span>
                        <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm h-full flex flex-col">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="font-bold text-slate-900 text-lg">System Directory</h3>
                <span class="text-xs font-semibold px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full border border-emerald-100">System Active</span>
            </div>
            
            <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('admin.students.index') }}" class="flex items-center p-4 rounded-xl border border-slate-100 hover:border-blue-500 hover:shadow-md transition-all group bg-slate-50/50">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-4 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Manage Students</h4>
                        <p class="text-xs text-slate-500 mt-0.5">View and edit student records</p>
                    </div>
                </a>

                <a href="{{ route('admin.teachers.index') }}" class="flex items-center p-4 rounded-xl border border-slate-100 hover:border-purple-500 hover:shadow-md transition-all group bg-slate-50/50">
                    <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-4 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Manage Teachers</h4>
                        <p class="text-xs text-slate-500 mt-0.5">View and edit faculty profiles</p>
                    </div>
                </a>

                <a href="{{ route('admin.courses.index') }}" class="flex items-center p-4 rounded-xl border border-slate-100 hover:border-violet-500 hover:shadow-md transition-all group bg-slate-50/50">
                    <div class="w-10 h-10 rounded-full bg-violet-100 text-violet-600 flex items-center justify-center mr-4 group-hover:bg-violet-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Manage Courses</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Update academic programs</p>
                    </div>
                </a>

                <a href="{{ route('admin.subjects.index') }}" class="flex items-center p-4 rounded-xl border border-slate-100 hover:border-amber-500 hover:shadow-md transition-all group bg-slate-50/50">
                    <div class="w-10 h-10 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mr-4 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900 text-sm">Manage Subjects</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Assign subjects to courses</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-up delay-600">
    
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-bold text-slate-800"><i class="fa-solid fa-chart-area text-indigo-500 mr-2"></i> Revenue Overview ({{ date('Y') }})</h2>
            <button class="text-slate-400 hover:text-indigo-600 transition-colors"><i class="fa-solid fa-ellipsis-vertical"></i></button>
        </div>
        <div class="relative h-80 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h2 class="text-lg font-bold text-slate-800 mb-6"><i class="fa-solid fa-bolt text-amber-500 mr-2"></i> Recent Payments</h2>
        
        <div class="space-y-6 relative before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
            
            @forelse($recentPayments as $payment)
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white bg-emerald-100 text-emerald-600 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 z-10">
                        <i class="fa-solid fa-indian-rupee-sign text-sm"></i>
                    </div>
                    <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] bg-slate-50 p-4 rounded-xl border border-slate-100 shadow-sm group-hover:border-emerald-200 transition-colors">
                        <div class="flex items-center justify-between mb-1">
                            <div class="font-bold text-slate-900 text-sm truncate">{{ $payment->student->name ?? 'Unknown Student' }}</div>
                            <div class="text-xs font-bold text-emerald-600">+₹{{ number_format($payment->amount_paid) }}</div>
                        </div>
                        <div class="text-xs text-slate-500 truncate">{{ $payment->fee->title ?? 'General Fee' }}</div>
                        <div class="text-[10px] font-bold text-slate-400 mt-2">{{ $payment->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10">
                    <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                        <i class="fa-solid fa-ghost"></i>
                    </div>
                    <p class="text-sm font-medium text-slate-500">No recent activity.</p>
                </div>
            @endforelse

        </div>
        
        @if($recentPayments->count() > 0)
            <div class="mt-6 text-center">
                <a href="{{ route('admin.fees.index') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">View All Transactions <i class="fa-solid fa-arrow-right text-xs ml-1"></i></a>
            </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const canvas = document.getElementById('revenueChart');
        if(!canvas) return; // Prevent error if canvas isn't loaded

        const ctx = canvas.getContext('2d');
        
        // Pass PHP Array to JavaScript safely
        const revenueData = @json($revenueChartData ?? array_fill(0, 12, 0));

        // Create a beautiful gradient fill for the chart line
        let gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(99, 102, 241, 0.5)'); // Indigo-500 at top
        gradient.addColorStop(1, 'rgba(99, 102, 241, 0.0)'); // Transparent at bottom

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Revenue Collected (₹)',
                    data: revenueData,
                    borderColor: '#6366f1', // Indigo-500
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#6366f1',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.4 // Makes the line smooth and curvy
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide default legend for a cleaner look
                    },
                    tooltip: {
                        backgroundColor: '#1e293b',
                        padding: 12,
                        titleFont: { size: 13, family: "'Plus Jakarta Sans', sans-serif" },
                        bodyFont: { size: 14, weight: 'bold', family: "'Plus Jakarta Sans', sans-serif" },
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '₹ ' + context.parsed.y.toLocaleString();
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                            color: '#94a3b8'
                        }
                    },
                    y: {
                        grid: {
                            color: '#f1f5f9',
                            borderDash: [5, 5],
                            drawBorder: false
                        },
                        ticks: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", size: 12 },
                            color: '#94a3b8',
                            callback: function(value) {
                                if (value >= 1000) {
                                    return '₹' + (value / 1000) + 'k'; 
                                }
                                return '₹' + value;
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endsection