@extends('layouts.teacher')

@section('title', 'Enter Marks')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Enter Marks</h1>

<form method="POST" action="{{ route('teacher.marks.store') }}">
    @csrf

    <!-- Subject -->
    <div class="mb-4">
        <label class="block mb-1 font-medium">Subject</label>
        <select name="subject_id"
                class="w-full border rounded px-3 py-2"
                required>
            <option value="">-- Select Subject --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
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

                <input type="number"
                       name="marks[{{ $student->id }}]"
                       class="border rounded px-2 py-1 w-24"
                       min="0"
                       max="100"
                       required>
            </div>
        @endforeach
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Save Marks
    </button>
</form>

@endsection
