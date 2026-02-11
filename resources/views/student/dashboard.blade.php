@extends('layouts.student')

@section('title', 'Student Dashboard')

@section('content')

<h1 class="text-2xl font-semibold mb-6">
    Welcome, {{ $student->user->name }}
</h1>

<!-- My Course -->
<div class="bg-white p-6 rounded shadow mb-8">
    <h2 class="text-lg font-semibold mb-2">My Course</h2>

    <p><strong>Course:</strong> {{ $course->name }}</p>

    @if($course->description)
        <p class="text-gray-600 mt-1">{{ $course->description }}</p>
    @endif

    <p class="text-sm text-gray-500 mt-2">
        Total Subjects: {{ $subjects->count() }}
    </p>
</div>

<!-- My Subjects -->
<div class="bg-white p-6 rounded shadow mb-8">
    <h2 class="text-lg font-semibold mb-4">My Subjects</h2>

    <ul class="list-disc ml-6">
        @forelse($subjects as $subject)
            <li>{{ $subject->name }}</li>
        @empty
            <li class="text-gray-500">No subjects found.</li>
        @endforelse
    </ul>
</div>

<!-- Attendance Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Attendance %</p>
        <p class="text-3xl font-bold text-green-600">{{ $attendancePercentage }}%</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Total Classes</p>
        <p class="text-3xl font-bold">{{ $totalClasses }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Present</p>
        <p class="text-3xl font-bold text-blue-600">{{ $presentCount }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Absent</p>
        <p class="text-3xl font-bold text-red-600">{{ $absentCount }}</p>
    </div>
</div>

<!-- Subject-wise Attendance -->
<div class="bg-white p-6 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Subject-wise Attendance</h2>

    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 text-left">Subject</th>
                <th class="p-3">Total</th>
                <th class="p-3">Present</th>
                <th class="p-3">%</th>
            </tr>
        </thead>
        <tbody>
            @forelse($subjectAttendance as $row)
                <tr class="border-t">
                    <td class="p-3">{{ $row->subject->name }}</td>
                    <td class="p-3">{{ $row->total_classes }}</td>
                    <td class="p-3">{{ $row->present_count }}</td>
                    <td class="p-3">
                        {{ round(($row->present_count / $row->total_classes) * 100, 2) }}%
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">
                        No attendance data found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
