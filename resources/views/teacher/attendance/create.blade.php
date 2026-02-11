@extends('layouts.teacher')

@section('title', 'Mark Attendance')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Attendance</h1>

<form method="POST" action="{{ route('teacher.attendance.store') }}">
    @csrf

    <!-- Subject -->
    <div class="mb-4">
        <label class="block mb-1 font-medium">Subject</label>
        <select name="subject_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Select Subject --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Date -->
    <div class="mb-6">
        <label class="block mb-1 font-medium">Date</label>
        <input type="date" name="date"
               class="w-full border rounded px-3 py-2"
               required>
    </div>

    <!-- Students -->
    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="font-semibold mb-3">Students</h2>

        @php
            $students = \App\Models\Student::all();
        @endphp

        @foreach($students as $student)
            <div class="flex items-center gap-4 mb-2">
                <span class="w-48">
                    {{ $student->user->name }}
                </span>

                <label class="flex items-center gap-1">
                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="1"
                           required>
                    Present
                </label>

                <label class="flex items-center gap-1">
                    <input type="radio"
                           name="attendance[{{ $student->id }}]"
                           value="0"
                           required>
                    Absent
                </label>
            </div>
        @endforeach
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Save Attendance
    </button>
</form>

@endsection
