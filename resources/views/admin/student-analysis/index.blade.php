@extends('layouts.admin')

@section('title', 'Student Analysis Dashboard')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
    .stagger-3 { animation-delay: 0.3s; }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
        font-weight: 600;
        border-radius: 9999px;
    }
    
    .status-active { background-color: #d1fae5; color: #065f46; }
    .status-dropped { background-color: #fee2e2; color: #991b1b; }
    .status-completed { background-color: #dbeafe; color: #1e40af; }
</style>

<div class="max-w-7xl mx-auto space-y-6">

    <!-- Header Section -->
    <div class="flex items-center justify-between animate-enter">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Student Analysis & Retention</h1>
            <p class="text-gray-500 mt-1">Monitor engagement, course continuation, and direct contact metrics.</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 animate-enter stagger-1">
        <!-- Total Students -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-6 border-l-4 border-gray-400 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Students</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($totalStudents) }}</h3>
                </div>
                <div class="p-3 bg-gray-50 rounded-lg text-gray-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Active Students -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-6 border-l-4 border-green-500 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Active Students</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($activeStudents) }}</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Dropped Students -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-6 border-l-4 border-red-500 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Dropped Students</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($droppedStudents) }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Completed Students -->
        <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-6 border-l-4 border-blue-500 hover:-translate-y-1 transition-transform duration-300">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Completed Students</p>
                    <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ number_format($completedStudents) }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-500">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Course Wise Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 animate-enter stagger-2">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Overall Distribution</h3>
            <div class="h-64 flex justify-center">
                <canvas id="overallChart"></canvas>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Course Wise Tracking</h3>
            <div class="h-64 flex justify-center">
                <canvas id="courseChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Filter & Table Section -->
    <div class="bg-white rounded-xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.3)] p-6 animate-enter stagger-3">
        
        <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
            <h3 class="text-xl font-bold text-gray-800">Student Profiles & Direct Contact</h3>
            <form method="GET" action="{{ route('admin.student-analysis.index') }}" class="flex flex-wrap gap-3">
                <select name="course_id" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 text-sm">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                    @endforeach
                </select>

                <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 text-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="dropped" {{ request('status') == 'dropped' ? 'selected' : '' }}>Dropped</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>

                <select name="risk_level" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 text-sm">
                    <option value="">Any Risk Level</option>
                    <option value="inactive_30_days" {{ request('risk_level') == 'inactive_30_days' ? 'selected' : '' }}>Inactive (>30 Days)</option>
                </select>

                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-medium text-sm">
                    Filter Results
                </button>
                <a href="{{ route('admin.student-analysis.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-medium text-sm">
                    Reset
                </a>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Student</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Course</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Parent Details</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($students as $student)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $student->user->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $student->user->email }}</div>
                                    <div class="text-xs text-gray-400 mt-1">Roll: {{ $student->roll_number }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ $student->course->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="status-badge status-{{ $student->status }}">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($student->parents->count() > 0)
                                @php $parent = $student->parents->first(); @endphp
                                <div class="text-sm text-gray-900 font-medium">{{ $parent->name }}</div>
                                <div class="text-sm text-gray-500">{{ $parent->email }}</div>
                                @if($student->parent_phone || $student->emergency_phone)
                                    <div class="text-xs text-indigo-600 mt-1">Has Phone Details</div>
                                @endif
                            @else
                                <span class="text-xs text-gray-400 italic">No Parent Attached</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end gap-2">
                            <!-- Change Status Form -->
                            <form action="{{ route('admin.student-analysis.update-status', $student) }}" method="POST" class="inline">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="text-xs py-1 px-2 border border-gray-300 rounded shadow-sm">
                                    <option value="active" {{ $student->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="dropped" {{ $student->status == 'dropped' ? 'selected' : '' }}>Dropped</option>
                                    <option value="completed" {{ $student->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                            </form>
                            
                            <!-- Contact Actions -->
                            <div class="flex items-center gap-2 border-l border-gray-200 pl-3">
                                <a href="mailto:{{ $student->user->email }}" class="p-1.5 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 tooltip" title="Email Student">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                                </a>
                                @if($student->phone)
                                <a href="tel:{{ $student->phone }}" class="p-1.5 bg-green-50 text-green-600 rounded hover:bg-green-100 tooltip" title="Call Student">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5l1.664-1.664a2.25 2.25 0 013.182 0l1.414 1.414c.878.878.878 2.304 0 3.182l-1.02 1.02a11.968 11.968 0 005.656 5.656l1.02-1.02c.878-.878 2.304-.878 3.182 0l1.414 1.414a2.25 2.25 0 010 3.182L19 21a2.25 2.25 0 01-3.182 0A16.953 16.953 0 013 5z"></path></svg>
                                </a>
                                @endif
                                
                                @if($student->parents->count() > 0)
                                    @php $parent = $student->parents->first(); @endphp
                                    <a href="mailto:{{ $parent->email }}" class="p-1.5 bg-purple-50 text-purple-600 rounded hover:bg-purple-100 tooltip" title="Email Parent">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span>No students found matching current filters.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4">
            {{ $students->links() }}
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        // Overall Chart 
        const overallCtx = document.getElementById('overallChart').getContext('2d');
        new Chart(overallCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Dropped', 'Completed'],
                datasets: [{
                    data: [{{ $activeStudents }}, {{ $droppedStudents }}, {{ $completedStudents }}],
                    backgroundColor: ['#10b981', '#ef4444', '#3b82f6'],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                cutout: '70%'
            }
        });

        // Course Wise Chart
        const courseLabels = {!! json_encode($courseStats->pluck('course.name')) !!};
        const activeData = {!! json_encode($courseStats->pluck('active')) !!};
        const droppedData = {!! json_encode($courseStats->pluck('dropped')) !!};
        const completedData = {!! json_encode($courseStats->pluck('completed')) !!};

        const courseCtx = document.getElementById('courseChart').getContext('2d');
        new Chart(courseCtx, {
            type: 'bar',
            data: {
                labels: courseLabels,
                datasets: [
                    {
                        label: 'Active',
                        data: activeData,
                        backgroundColor: '#10b981',
                        borderRadius: 4
                    },
                    {
                        label: 'Dropped',
                        data: droppedData,
                        backgroundColor: '#ef4444',
                        borderRadius: 4
                    },
                    {
                        label: 'Completed',
                        data: completedData,
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: { stacked: true },
                    y: { stacked: true, beginAtZero: true }
                },
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>

@endsection
