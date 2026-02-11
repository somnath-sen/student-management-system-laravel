@extends('layouts.teacher')

@section('title', 'Edit Marks')

@section('content')

<h1 class="text-2xl font-semibold mb-4">
    Edit Marks — {{ $subject->name }}
</h1>

{{-- 🔒 Lock Result Button (Top, before form) --}}
@if(! $isLocked)
<form method="POST"
      action="{{ route('teacher.marks.lock', $subject) }}"
      onsubmit="return confirm('Lock result? This cannot be undone.')"
      class="mb-4">
    @csrf
    <button class="bg-red-600 text-white px-4 py-2 rounded">
        🔒 Lock Result
    </button>
</form>
@else
<div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
    🔒 This result is locked. Marks can no longer be edited.
</div>
@endif

<form method="POST"
      action="{{ route('teacher.marks.update', $subject) }}">
    @csrf
    @method('PUT')

    <div class="bg-white p-4 rounded shadow">
        @foreach($students as $student)
            <div class="flex items-center gap-4 mb-3">
                <span class="w-48 font-medium">
                    {{ $student->user->name }}
                </span>

                <input type="number"
                       name="marks[{{ $student->id }}]"
                       value="{{ $marks[$student->id]->marks_obtained ?? '' }}"
                       class="border rounded px-2 py-1 w-24
                              {{ $isLocked ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                       min="0"
                       max="100"
                       {{ $isLocked ? 'disabled' : '' }}>
            </div>
        @endforeach
    </div>

    {{-- Update button only if not locked --}}
    @if(! $isLocked)
    <button class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
        Update Marks
    </button>
    @endif
</form>

@endsection
