@extends('layouts.teacher')

@section('title', 'Mark Attendance')

@section('content')
<h2 class="text-xl font-semibold mb-4">Mark Attendance</h2>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('teacher.attendance.create') }}"
      class="bg-white p-6 rounded shadow max-w-lg">
    @csrf

    <div class="mb-4">
        <label class="block mb-1 font-medium">Subject</label>
        <select name="subject_id" class="w-full border rounded px-3 py-2" required>
            <option value="">-- Select Subject --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-4">
        <label class="block mb-1 font-medium">Date</label>
        <input type="date" name="date"
               class="w-full border rounded px-3 py-2"
               required>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Load Students
    </button>
</form>
@endsection
