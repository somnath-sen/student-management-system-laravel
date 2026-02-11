@extends('layouts.teacher')

@section('title', 'My Details')

@section('content')

<h1 class="text-2xl font-semibold mb-6">My Details</h1>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    {{-- Personal Info --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold mb-3">Personal Information</h2>

        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Employee ID:</strong> {{ $teacher->employee_id }}</p>
    </div>

    {{-- Academic Info --}}
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-semibold mb-3">Academic Information</h2>

        <p><strong>Total Subjects:</strong> {{ $subjects->count() }}</p>

        @if($subjects->count())
            <ul class="list-disc ml-5 mt-2">
                @foreach($subjects as $subject)
                    <li>{{ $subject->name }}</li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">No subjects assigned.</p>
        @endif
    </div>

</div>

@endsection
