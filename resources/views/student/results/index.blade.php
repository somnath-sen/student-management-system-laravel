@extends('layouts.student')

@section('title', 'My Results')

@section('content')

<h1 class="text-2xl font-semibold mb-6">My Results</h1>

<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Total Marks</p>
        <p class="text-xl font-bold">{{ $totalObtained }} / {{ $totalMarks }}</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Percentage</p>
        <p class="text-xl font-bold text-blue-600">{{ $percentage }}%</p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-gray-500">Grade</p>
        <p class="text-xl font-bold">
            @if($percentage >= 90) A+
            @elseif($percentage >= 80) A
            @elseif($percentage >= 70) B
            @elseif($percentage >= 60) C
            @else D
            @endif
        </p>
    </div>
</div>

<div class="bg-white rounded shadow overflow-x-auto">
    <table class="w-full">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="p-3">Subject</th>
                <th class="p-3">Marks</th>
                <th class="p-3">Teacher</th>
            </tr>
        </thead>
        <tbody>
            @forelse($marks as $mark)
                <tr class="border-t">
                    <td class="p-3">{{ $mark->subject->name }}</td>
                    <td class="p-3">
                        {{ $mark->marks_obtained }} / {{ $mark->total_marks }}
                    </td>
                    <td class="p-3">
                        {{ $mark->teacher->user->name }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="p-4 text-center text-gray-500">
                        No results published yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
