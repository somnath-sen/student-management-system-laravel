@extends('layouts.teacher')

@section('title', 'Marks')

@section('content')

<h1 class="text-2xl font-semibold mb-6">Marks</h1>

<div class="bg-white rounded shadow">
    <ul>
        @foreach($subjects as $subject)
            <li class="border-b p-4 flex justify-between">
                <span>{{ $subject->name }}</span>

                <a href="{{ route('teacher.marks.edit', $subject) }}"
                   class="text-blue-600 hover:underline">
                    Edit Marks
                </a>
            </li>
        @endforeach
    </ul>
</div>

@endsection
