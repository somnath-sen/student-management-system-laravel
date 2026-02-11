@extends('layouts.student')

@section('title', 'My Details')

@section('content')

<h1 class="text-2xl font-semibold mb-6">My Details</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Personal Info --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold mb-3">Personal Information</h2>

        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Roll Number:</strong> {{ $student->roll_number }}</p>
    </div>

    {{-- Course Info --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold mb-3">Course Information</h2>

        @if($course)
            <p><strong>Course:</strong> {{ $course->name }}</p>
            <p class="text-gray-600">{{ $course->description }}</p>
        @else
            <p class="text-gray-500">No course assigned.</p>
        @endif
    </div>

</div>

{{-- Subjects --}}
<div class="bg-white p-6 rounded shadow mt-6">
    <h2 class="font-semibold mb-3">My Subjects</h2>

    @if($subjects->count())
        <ul class="list-disc ml-5">
            @foreach($subjects as $subject)
                <li>{{ $subject->name }}</li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">No subjects found.</p>
    @endif
</div>

@endsection
