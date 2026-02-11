@extends('layouts.student')

@section('title', 'My Attendance')

@section('content')

<h1 class="text-2xl font-semibold mb-6">My Attendance</h1>

<div class="bg-white rounded shadow p-6">
    <table class="w-full border-collapse">
        <thead>
            <tr class="bg-gray-100 text-left">
                <th class="p-3">Date</th>
                <th class="p-3">Subject</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($attendances as $attendance)
                <tr class="border-t">
                    <td class="p-3">
                        {{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}
                    </td>
                    <td class="p-3">
                        {{ $attendance->subject->name }}
                    </td>
                    <td class="p-3">
                        @if($attendance->present)
                            <span class="text-green-600 font-semibold">Present</span>
                        @else
                            <span class="text-red-600 font-semibold">Absent</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No attendance records found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
