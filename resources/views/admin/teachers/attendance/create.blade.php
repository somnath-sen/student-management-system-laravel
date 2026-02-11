@extends('layouts.teacher')

@section('title', 'Take Attendance')

@section('content')
<h2 class="text-xl font-semibold mb-4">
    Attendance — {{ $subject->name }} ({{ $date }})
</h2>

<form method="POST" action="{{ route('teacher.attendance.store') }}">
    @csrf

    <input type="hidden" name="subject_id" value="{{ $subject->id }}">
    <input type="hidden" name="date" value="{{ $date }}">

    <div class="bg-white shadow rounded overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">#</th>
                    <th class="p-3 text-left">Student</th>
                    <th class="p-3 text-left">Present</th>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $student)
                    <tr class="border-t">
                        <td class="p-3">{{ $loop->iteration }}</td>
                        <td class="p-3">{{ $student->user->name }}</td>
                        <td class="p-3">
                            <input type="checkbox"
                                   name="attendance[{{ $student->id }}]"
                                   value="1"
                                   checked>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Save Attendance
    </button>
</form>
@endsection
